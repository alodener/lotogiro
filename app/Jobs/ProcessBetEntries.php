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
use App\Models\TypeGameValue;
use App\Models\Client;
use App\Models\TransactBalance;
use App\Helper\Configs;
use App\Models\User;
use App\Helper\GameHelper;

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
        
        if( !auth()->user()->hasRole('Administrador') && ($this->request['type_client'] != 1 || $this->request['type_client'] == null )){
            $userclient = User::where('id', $this->request['client'])->first();
                if($userclient != null){
                    $clientuser = Client::where('email', $userclient->email)->first();
                }else{
                    $clientuser = $request->client;
                }
        }

        $valor = $this->request['value'];
    
        foreach ($this->dezenas as $dez) {
            //$dezenaconvertida = string.split(/,(?! )/);
            // $dezenaconvertida2 = explode(" ", $dez);
            // sort($dezenaconvertida2, SORT_NUMERIC);

            // $dezenaconvertida = implode(",", $dezenaconvertida2);
            $teste = explode("\n", $dez);
            
            $str = implode("\n", $teste);
            $string = preg_replace('/^\h*\v+/m', '', $str);
            $words = explode(",", $string);
            $result = count($words);
            $typeGameValue = TypeGameValue::where([
                ['type_game_id', $this->request['type_game']],
                ['numbers', $result],
            ])->get();

            $valor = $this->request['value'];
            $multiplicador = $typeGameValue->isEmpty() ? 0 : $typeGameValue[0]->multiplicador;
            $maxreais = $typeGameValue->isEmpty() ? 0 : $typeGameValue[0]->maxreais;
            $contadorJogos = count($this->dezenas);
           

            if ($maxreais >= $valor) {
                $resultado = $valor * $multiplicador;
            } else {
                $resultado = $maxreais * $multiplicador;
                $valor = $maxreais;
            }
            
            $game = new Game;
             if( !auth()->user()->hasRole('Administrador') && ($this->request['type_client'] != 1 || $this->request['type_client'] == null )){
                $game->client_id = $clientuser->id;
                }else{
                   $game->client_id = $this->request['client'];
                }
            $game->user_id = $this->user->id;
            $game->type_game_id = $this->request['type_game'];
            $game->type_game_value_id =  $typeGameValue[0]->id;
            $game->value = $this->request['value'];
            $game->premio = $resultado;
            $game->numbers = $dez;
            $game->competition_id = $this->competition->id;
            $game->checked = 1;
            $game->bet_id = $this->bet->id;
            $game->commission_percentage = $this->user->commission;
            $game->save();

            
            //verifica se é da dupla sena 
                if ($this->request['type_game'] == 10){

                    //encontrar o concurso com o final A na tabela
                    $competitionA = Competition::where('number', 'like', '%' . $this->competition->number . 'A')->first();
                    // Chamada do helper para duplicar o jogo - dener.gomes 28.08 - 18:02
                    $copiaGame = GameHelper::duplicateGame($game, $competitionA, $this->request, $dez, 2, $valor, $resultado);
                    

                }
            $transact_balance = new TransactBalance;
            $transact_balance->user_id_sender = auth()->id();
            $transact_balance->user_id = auth()->id();
            $transact_balance->value = $game->value;
            $transact_balance->old_value = auth()->user()->balance;
            $transact_balance->value_a = auth()->user()->balance - $game->value;
            $transact_balance->type = 'Compra - Jogo de id: ' . $game->id . ' do tipo: ' . $game->type_game_id;
            $transact_balance->save();

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
            $planodecarreira = Configs::getPlanoDeCarreira();
            if( $planodecarreira == "Ativado"){
            UsersHasPoints::generatePoints($this->user, $game->value, 'Venda - Jogo de id: ' . $game->id);
            }
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