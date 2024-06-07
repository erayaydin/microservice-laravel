<?php

namespace MService\License\Handlers;

use Junges\Kafka\Contracts\ConsumerMessage;
use Junges\Kafka\Contracts\MessageConsumer;
use MService\License\Actions\LicenseUpdated;
use MService\License\Models\License;
use MService\License\Models\LicenseType;

class KafkaMessageHandler
{
    public function __invoke(ConsumerMessage $message, MessageConsumer $consumer): void
    {
        $body = collect($message->getBody());
        $user = $body->get('user_id');

        if (License::query()->forUser($user)->notExpired()->count() > 0)
            return;

        $demoLicense = LicenseType::DEMO;

        $newLicense = License::query()->create([
            'user_id' => $user,
            'email' => $body->get('email'),
            'started_at' => now(),
            'expired_at' => now()->addDays(30),
            'license_type' => $demoLicense,
            'max_file_size' => $demoLicense->getMaxFileSize(),
            'daily_object_limit' => $demoLicense->getDailyObjectLimit(),
            'quota' => $demoLicense->getQuota(),
        ]);

        LicenseUpdated::dispatch($user, $newLicense);

        logger()->info(LicenseType::DEMO->name . " license created for user: " . $user);
    }
}
