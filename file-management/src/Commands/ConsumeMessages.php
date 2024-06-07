<?php

namespace MService\FileManagement\Commands;

use Carbon\Exceptions\Exception;
use Illuminate\Console\Command;
use Junges\Kafka\Exceptions\ConsumerException;
use Junges\Kafka\Facades\Kafka;
use MService\FileManagement\Handlers\KafkaMessageHandler;

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
     * @throws Exception
     * @throws ConsumerException
     */
    public function handle(): void
    {
        // TODO: add parallelism or use minimal worker

        Kafka::consumer()
            ->subscribe('license.updated')
            ->withHandler(new KafkaMessageHandler)
            ->build()
            ->consume();
    }
}
