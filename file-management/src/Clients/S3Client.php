<?php

namespace MService\FileManagement\Clients;

use Aws\S3\S3Client as Client;
use Illuminate\Support\Traits\ForwardsCalls;

/**
 * S3 Client wrapper
 *
 * @mixin Client
 */
final class S3Client
{
    use ForwardsCalls;

    private readonly Client $client;

    public function __construct () {
        $this->client = new Client([
            'region' => 'us-east-1',
            'endpoint' => config('services.minio.endpoint'),
            'use_path_style_endpoint' => true,
            'credentials' => [
                'key' => config('services.minio.access_key'),
                'secret' => config('services.minio.secret_key'),
            ],
        ]);
    }

    /**
     * Pass dynamic methods onto the router instance.
     *
     * @param string $method
     * @param array $parameters
     * @return mixed
     */
    public function __call(string $method, array $parameters)
    {
        return $this->forwardCallTo(
            $this->client, $method, $parameters
        );
    }
}
