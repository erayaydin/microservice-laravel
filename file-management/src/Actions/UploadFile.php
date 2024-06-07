<?php

namespace MService\FileManagement\Actions;

use DailyLimitException;
use EntityTooLargeException;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use LicenseExpiredException;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;
use MService\FileManagement\Clients\S3Client;
use MService\FileManagement\Models\File;
use MService\FileManagement\Models\Limits;
use MService\FileManagement\Resources\FileResource;
use Psr\SimpleCache\InvalidArgumentException;
use QuotaReachedException;

final readonly class UploadFile
{
    use AsAction;

    public function __construct (
        private File $fileModel,
        private S3Client $s3Client,
    ) { }

    /**
     * @throws GuzzleException
     * @throws EntityTooLargeException
     * @throws DailyLimitException
     * @throws QuotaReachedException
     * @throws InvalidArgumentException
     * @throws LicenseExpiredException
     */
    public function handle (
        int $userId,
        string $bucketName,
        UploadedFile $file,
        ?string $description = null,
        bool $isPublic = false
    ): File
    {
        // TODO: use DI to retrieve Cache object
        /** @var Limits $limits */
        $limits = cache()->remember("{$userId}_limits", 15 * 60, fn() => Limits::forUser($userId));

        if ($limits->isExpired) {
            throw new LicenseExpiredException;
        }

        if ($file->getSize() > $limits->maxFileSize) {
            throw new EntityTooLargeException;
        }

        if ($this->fileModel->ofUser($userId)->in24h()->count() > $limits->dailyLimit) {
            throw new DailyLimitException;
        }

        /** @var int $balance */
        $balance = cache()->rememberForever(
            "{$userId}_balance",
            fn() => $this->fileModel->ofUser($userId)->sum('size')
        );

        if ($balance + $file->getSize() > $limits->quota) {
            throw new QuotaReachedException;
        }

        $key = Str::uuid() . "." . $file->extension();

        $uploadResult = $this->s3Client->putObject([
            'Bucket' => $bucketName,
            'Key' => $key,
            'Body' => fopen($file->getPathname(), 'r'),
            'ContentType' => $file->getMimeType(),
        ]);

        /** @var File $record */
        $record = $this->fileModel->query()->create([
            'user_id' => $userId,
            'bucket' => $bucketName,
            'key' => $key,
            'object_url' => $uploadResult['ObjectURL'],
            'filename' => $file->getClientOriginalName(),
            'description' => $description,
            'is_public' => $isPublic,
            'checksum' => hash('md5', $file->getContent()),
            'mimetype' => $file->getMimeType(),
            'size' => $file->getSize(),
        ]);

        cache()->set("{$userId}_balance", $balance + $file->getSize());

        return $record;
    }

    /**
     * @param ActionRequest $request
     * @return JsonResponse|FileResource
     * @throws DailyLimitException
     * @throws EntityTooLargeException
     * @throws GuzzleException
     * @throws QuotaReachedException
     * @throws LicenseExpiredException|InvalidArgumentException
     */
    public function asController(ActionRequest $request): JsonResponse|FileResource
    {
        $userId = $request->input('user_id');

        $file = $this->handle(
            $userId,
            "files-$userId",
            $request->file('file'),
            $request->validated('description'),
            $request->validated('is_public') ?: false,
        );

        return new FileResource($file);
    }

    public function rules(): array
    {
        return [
            'file' => ['required', 'file'],
            'description' => ['string', 'max:1000'],
            'is_public' => ['bool'],
        ];
    }
}
