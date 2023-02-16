<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Helper\ZoopGateway;

class CreateZoopWebhook extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'zoop:create-transaction-success-webhook';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create zoop transaction success webhook';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $zoopGateway = new ZoopGateway;

        $data = [
            'method' => 'POST',
            'url' => route('zoop.webhook.process.success'),
            'event' => [
                'transaction.succeeded'
            ],
            'description' => 'transaction:success:handler'
        ];

        $response = $zoopGateway->createWebhook($data);

        $this->info(print_r($response));
    }
}
