<?php

namespace MService\FileManagement\Commands;

use Illuminate\Console\Command;

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
     */
    public function handle(): void
    {
        // TODO: implement kafka message handler
    }
}
