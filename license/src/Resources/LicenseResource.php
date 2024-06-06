<?php

namespace MService\License\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use MService\License\Models\License;

class LicenseResource extends JsonResource
{
    /** @var License */
    public $resource;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'type' => $this->resource->getAttribute('license_type'),
            'started_at' => $this->resource->getAttribute('started_at'),
            'expired_at' => $this->resource->getAttribute('expired_at'),
            'max_file_size' => $this->resource->getAttribute('max_file_size'),
            'daily_object_limit' => $this->resource->getAttribute('daily_object_limit'),
            'quota' => $this->resource->getAttribute('quota'),
        ];
    }
}
