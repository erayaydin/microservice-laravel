<?php

namespace MService\Notification\Handlers;

use Junges\Kafka\Contracts\ConsumerMessage;
use Junges\Kafka\Contracts\MessageConsumer;

class KafkaMessageHandler
{
    public function __invoke(ConsumerMessage $message, MessageConsumer $consumer): void
    {
        // TODO: Handle message
    }
}
