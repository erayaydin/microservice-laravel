<?php

namespace MService\FileManagement\Handlers;

use Illuminate\Support\Facades\Bus;
use Junges\Kafka\Contracts\ConsumerMessage;
use Junges\Kafka\Contracts\MessageConsumer;
use MService\FileManagement\Jobs\CreateNewBucket;
use MService\FileManagement\Models\Limits;
use Psr\SimpleCache\InvalidArgumentException;

class KafkaMessageHandler
{
    /**
     * @throws InvalidArgumentException
     */
    public function __invoke(ConsumerMessage $message, MessageConsumer $consumer): void
    {
        $body = collect($message->getBody());

        $user = $body->get('user_id');
        $oldLicense = $body->get('old_license');

        $bucketName = "files-$user";

        if (is_null($oldLicense)) {
            Bus::dispatchChain([
                // TODO: generate bucket name with guid.
                new CreateNewBucket($user, $bucketName),
                // TODO: Add `SetBucketQuota` job to enforce quota.
            ]);

            return;
        }

        // TODO: implement job chain for "CheckQuotaApplicable" and "SetBucketQuota" with using old/new diff values
        cache()->set("{$user}_limits", new Limits(
            $body->get('new_quota'),
            $body->get('new_max_file_size'),
            $body->get('new_daily_object_limit'),
            false,
        ));
    }
}
