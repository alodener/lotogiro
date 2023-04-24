<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Helper\ZoopGateway;

class DeleteZoopWebhook extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'zoop:delete-webhook {id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deletar um webhook da zoop';

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

        $id = $this->argument('id');

        if(empty($id)) {
            $this->info('O id do webhook é obrigatório');

            return;
        }

        $response = $zoopGateway->deleteWebhook($id);

        $this->info(print_r($response, true));

        return 0;
    }
}
