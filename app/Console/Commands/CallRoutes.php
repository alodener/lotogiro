<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\ScrapingController;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;


class CallRoutes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'call:routes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Call specific routes every 5 minutes';

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
        // Criar uma instância de Request com os dados necessários
        $dataAtual = now()->format('d-m-Y');
        $dataAtual2 = now()->format('Y-m-d');

        $request = Request::create('/scrapeAllStates', 'GET', ['estado' => '', 'data' => $dataAtual]);

        // Chamar o método do controlador passando a instância de Request
        $controller = new ScrapingController();
        $response = $controller->scrapeAllStates($request);
        $response2 = $controller->getWinners($dataAtual2);


        return 0;
    }
}
