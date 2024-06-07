<?php

namespace MService\FileManagement\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use MService\FileManagement\Clients\S3Client;

final class CreateNewBucket implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct (
        private readonly int $userId,
        private readonly string $bucketName
    ) { }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $s3Client = new S3Client;
        $s3Client->createBucket([
            'Bucket' => $this->bucketName,
        ]);

        logger()->info("Bucket $this->bucketName for user $this->userId created.");
    }
}
