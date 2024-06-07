<?php

namespace MService\FileManagement\Models;

use GuzzleHttp\Exception\GuzzleException;
use MService\FileManagement\Clients\LicenseClient;
use RuntimeException;

final readonly class Limits
{
    public function __construct (
        public int $quota,
        public int $maxFileSize,
        public int $dailyLimit,
        public bool $isExpired,
    ) { }

    /**
     * @throws GuzzleException
     * @throws RuntimeException
     */
    public static function forUser(int $userId): Limits
    {
        $client = new LicenseClient;
        $response = $client->get("users/$userId");

        if ($response->getStatusCode() != 200) {
            throw new RuntimeException('User license information could not retrieve!');
        }

        $license = collect(json_decode($response->getBody())->data);

        return new Limits(
            $license->get('quota'),
            $license->get('max_file_size'),
            $license->get('daily_object_limit'),
            now()->gte($license->get('expired_at')),
        );
    }
}
