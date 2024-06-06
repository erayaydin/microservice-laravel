<?php

namespace MService\Security\Actions;

use Exception;
use Junges\Kafka\Facades\Kafka;
use Lorisleiva\Actions\Concerns\AsAction;
use MService\Security\Models\User;

class PublishUserCreatedMessage
{
    use AsAction;

    /**
     * @throws Exception
     */
    public function handle(int $userId, string $email): void
    {
        Kafka::publish()
            ->onTopic('user.created')
            ->withHeaders([
                'user_id' => $userId,
            ])
            ->withBodyKey('user_id', $userId)
            ->withBodyKey('email', $email)
            ->send();
    }

    /**
     * @throws Exception
     */
    public function asJob(User $user): void
    {
        $this->handle($user->getKey(), $user->getAttribute('email'));
    }
}
