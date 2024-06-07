<?php

namespace MService\FileManagement\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use MService\FileManagement\Models\File;

class FileResource extends JsonResource
{
    /** @var File */
    public $resource;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->getKey(),
            'filename' => $this->resource->getAttribute('filename'),
            'description' => $this->resource->getAttribute('description'),
            'is_public' => $this->resource->getAttribute('is_public'),
            'checksum' => $this->resource->getAttribute('checksum'),
            'mimetype' => $this->resource->getAttribute('mimetype'),
            'size' => $this->resource->getAttribute('size'),
            'metadata' => $this->resource->getAttribute('metadata'),
            'expired_at' => $this->resource->getAttribute('expired_at'),
            'created_at' => $this->resource->getAttribute('created_at'),
        ];
    }
}
