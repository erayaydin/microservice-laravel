<?php

namespace MService\FileManagement\Actions;

use Aws\Result;
use Illuminate\Http\Response;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;
use MService\FileManagement\Clients\S3Client;
use MService\FileManagement\Models\File;

final readonly class DownloadFile
{
    use AsAction;

    public function __construct (
        private S3Client $s3Client,
    ) { }

    public function handle(string $bucket, string $fileKey): Result
    {
        return $this->s3Client->getObject([
            'Bucket' => $bucket,
            'Key' => $fileKey,
        ]);
    }

    public function asController(ActionRequest $request, File $file): Response
    {
        $userId = $request->input('user_id');
        if ($file->getAttribute('user_id') != $userId)
            abort(403);

        $key = $file->getAttribute('key');
        $object = $this->handle("files-$userId", $key);

        return response($object['Body'], 200)
            ->header('Content-Type', $object['ContentType'])
            ->header(
                'Content-Disposition',
                'attachment; filename="' . ($file->getAttribute('filename') ?: $key) . '"'
            );
    }
}
