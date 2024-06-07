<?php

return [
    'minio' => [
        'endpoint' => env('MINIO_ENDPOINT', 'http://127.0.0.1:9000'),
        'access_key' => env('MINIO_ACCESS_KEY', 'mservice'),
        'secret_key' => env('MINIO_SECRET_KEY', 'topsecret'),
    ],

    'license' => [
        'base_uri' => env('LICENSE_SERVICE_URL', 'http://license/api/v1/'),
        'timeout' => env('LICENSE_SERVICE_TIMEOUT', 30),
    ]
];
