<?php

namespace MService\FileManagement\Actions;

use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;
use MService\FileManagement\Models\File;
use MService\FileManagement\Resources\FileResource;

final class GetFiles
{
    use AsAction;

    public function __construct (
        private readonly File $fileModel,
    ) { }

    public function handle(int $userId): Jsonable
    {
        return $this->fileModel->newQuery()->ofUser($userId)->latest()->paginate(20);
    }

    public function asController(ActionRequest $request): AnonymousResourceCollection
    {
        $files = $this->handle($request->input('user_id'));

        return FileResource::collection($files);
    }
}
