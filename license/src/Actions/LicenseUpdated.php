<?php

namespace MService\License\Actions;

use Exception;
use Junges\Kafka\Facades\Kafka;
use Lorisleiva\Actions\Concerns\AsAction;
use MService\License\Models\License;

class LicenseUpdated
{
    use AsAction;

    /**
     * @throws Exception
     */
    public function handle(int $userId, License $newLicense, ?License $oldLicense = null): void
    {
        Kafka::publish()
            ->onTopic('license.updated')
            ->withHeaders([
                'user_id' => $userId,
            ])
            ->withBodyKey('user_id', $userId)
            ->withBodyKey('old_license', $oldLicense?->getAttribute('license_type')->value)
            ->withBodyKey('new_license', $newLicense->getAttribute('license_type')->value)
            ->withBodyKey('old_max_file_size', $oldLicense?->getAttribute('max_file_size'))
            ->withBodyKey('new_max_file_size', $newLicense->getAttribute('max_file_size'))
            ->withBodyKey('old_daily_object_limit', $oldLicense?->getAttribute('daily_object_limit'))
            ->withBodyKey('new_daily_object_limit', $newLicense->getAttribute('daily_object_limit'))
            ->withBodyKey('old_quota', $oldLicense?->getAttribute('quota'))
            ->withBodyKey('new_quota', $newLicense->getAttribute('quota'))
            ->send();
    }

    /**
     * @throws Exception
     */
    public function asJob(int $userId, License $newLicense, ?License $oldLicense = null): void
    {
        $this->handle(
            $userId,
            $newLicense,
            $oldLicense
        );
    }
}
