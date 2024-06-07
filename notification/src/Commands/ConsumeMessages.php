<?php

namespace MService\Notification\Commands;

use Carbon\Exceptions\Exception;
use Illuminate\Console\Command;
use Junges\Kafka\Exceptions\ConsumerException;
use Junges\Kafka\Facades\Kafka;
use MService\Notification\Handlers\KafkaMessageHandler;

class ConsumeMessages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:consume-messages';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Consume Kafka Messages';

    /**
     * Execute the console command.
     *
     * @throws ConsumerException
     * @throws Exception
     */
    public function handle(): void
    {
        $this->info("Listening kafka messages...");

        // TODO: add parallelism or use minimal worker
        Kafka::consumer()
            ->subscribe('user.created')
            ->withHandler(new KafkaMessageHandler)
            ->build()
            ->consume();
    }
}
