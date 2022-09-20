<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use PDF;
use App\Models\Game;
use App\Models\UsersHasPoints;
use App\Helper\Commision;
use App\Http\Controllers\Admin\Pages\Dashboards\ExtractController;
use App\Models\Competition;
use App\Models\TypeGame;
use App\Models\Client;

// lib de email
use Mail;

use App\Notifications\GameProcessedNotification;

class ProcessBetEntries implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $dezenas;

    public $request;

    public $bet;

    public $competition;

    public $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($dezenas, $request, $bet, $competition, $user)
    {
        $this->dezenas = $dezenas;

        $this->request = $request->all();

        $this->bet = $bet;

        $this->competition = $competition;

        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->dezenas as $dez) {
            //$dezenaconvertida = string.split(/,(?! )/);
            // $dezenaconvertida2 = explode(" ", $dez);
            // sort($dezenaconvertida2, SORT_NUMERIC);

            // $dezenaconvertida = implode(",", $dezenaconvertida2);
            
            $game = new Game;
            $game->client_id = $this->request['client'];
            $game->user_id = $this->user->id;
            $game->type_game_id = $this->request['type_game'];
            $game->type_game_value_id = $this->request['valueId'];
            $game->value = $this->request['value'];
            $game->premio = $this->request['premio'];
            $game->numbers = $dez;
            $game->competition_id = $this->competition->id;
            $game->checked = 1;
            $game->bet_id = $this->bet->id;
            $game->commission_percentage = $this->user->commission;
            $game->save();

            $extract = [
                'type' => 1,
                'value' => $game->value,
                'type_game_id' => $game->type_game_id,
                'description' => 'Venda - Jogo de id: ' . $game->id,
                'user_id' => $game->user_id,
                'client_id' => $game->client_id
            ];
            $ID_VALUE = $this->user->indicador;
            $storeExtact = ExtractController::store($extract);
            $commissionCalculationPai = Commision::calculationPai($game->commission_percentage, $game->value, $ID_VALUE, $this->user);
            $commissionCalculation = Commision::calculation($game->commission_percentage, $game->value);

            UsersHasPoints::generatePoints($this->user, $game->value, 'Venda - Jogo de id: ' . $game->id);

            $game->commission_value = $commissionCalculation;
            $game->commision_value_pai = $commissionCalculationPai;
            $game->save();
        }
        $this->bet->status_xml = 2;
        $this->bet->save();

        // PEGAR ID DO CLIENTE PARA BUSCAR APOSTAS DO MESMO

        $idAposta = $this->bet->id;

        // pegando jogos feitos
        $jogosCliente = Game::where('bet_id', $idAposta)->get();

        // informações para filename
        $InfoJogos =  $jogosCliente[0];

        // pegando informações de cliente
        $ClientInfo = Client::where('id', $InfoJogos["client_id"])->get();
        $ClienteJogo =  $ClientInfo[0];

        // pegando typegame
        $TipoJogo = TypeGame::where('id', $InfoJogos['type_game_id'])->get();
        $TipoJogo = $TipoJogo[0];

        // pegando datas do sorteio
        $Datas = Competition::where('id', $InfoJogos['competition_id'])->get();
        $Datas = $Datas[0];

        // nome cliente
        $Nome = $ClienteJogo['name'] . ' ' . $ClienteJogo['last_name'];

        global $data;
        $data = [
            'prize' => false,
            'jogosCliente' => $jogosCliente,
            'Nome' => $Nome,
            'Datas' => $Datas,
            'TipoJogo' => $TipoJogo
        ];

        global $fileName;
        $fileName = 'Recibo ' . $InfoJogos['bet_id']  . ' - ' . $Nome . '.pdf';

        // return view('admin.layouts.pdf.receiptTudo', $data);
        global $pdf;
        $pdf = PDF::loadView('admin.layouts.pdf.receiptTudo', $data);
        // return $pdf->download($fileName);

        // $arquivo = $pdf->output($fileName);
        Mail::send('email.jogo', ['idjogo' => $game->id], function ($m) {
            global $data;
            global $fileName;
            global $pdf;
            $m->from('admin@superlotogiro.com', 'SuperLotogiro');
            $m->subject('Seu Bilhete');
            $m->to($this->user->email);
            $m->attachData($pdf->output(), $fileName);
        });

        $this->user->notify(new GameProcessedNotification($this->user, $this->bet));
    }
}
