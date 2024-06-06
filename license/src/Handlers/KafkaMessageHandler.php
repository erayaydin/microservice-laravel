<?php

namespace MService\License\Handlers;

use Junges\Kafka\Contracts\ConsumerMessage;
use Junges\Kafka\Contracts\MessageConsumer;
use MService\License\Models\License;
use MService\License\Models\LicenseType;

class KafkaMessageHandler
{
    public function __invoke(ConsumerMessage $message, MessageConsumer $consumer): void
    {
        $body = collect($message->getBody());

        if (License::query()->forUser($body->get('user_id'))->notExpired()->count() > 0)
            return;

        $demoLicense = LicenseType::DEMO;

        License::query()->create([
            'user_id' => $body->get('user_id'),
            'email' => $body->get('email'),
            'started_at' => now(),
            'expired_at' => now()->addDays(30),
            'license_type' => $demoLicense,
            'max_file_size' => $demoLicense->getMaxFileSize(),
            'daily_object_limit' => $demoLicense->getDailyObjectLimit(),
            'quota' => $demoLicense->getQuota(),
        ]);

        logger()->info(LicenseType::DEMO->name . " license created for user: " . $body->get('user_id'));
    }
}
