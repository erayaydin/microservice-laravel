<?php

namespace MService\FileManagement\Clients;

use GuzzleHttp\Client;
use Illuminate\Support\Traits\ForwardsCalls;

/**
 * @mixin Client
 */
final readonly class LicenseClient
{
    use ForwardsCalls;

    private Client $client;

    public function __construct () {
        $this->client = new Client([
            'base_uri' => config('services.license.base_uri'),
            'timeout' => config('services.license.timeout', 30),
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
