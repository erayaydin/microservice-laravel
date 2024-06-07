<?php

namespace MService\Notification\Handlers;

use Junges\Kafka\Contracts\ConsumerMessage;
use Junges\Kafka\Contracts\MessageConsumer;
use MService\Notification\Jobs\SendWelcomeEmail;

class KafkaMessageHandler
{
    public function __invoke(ConsumerMessage $message, MessageConsumer $consumer): void
    {
        logger()->info("New Message!");
        $email = $message->getBody()['email'];

        SendWelcomeEmail::dispatch($email);
    }
}
