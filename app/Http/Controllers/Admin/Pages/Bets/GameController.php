<?php

namespace App\Http\Controllers\Admin\Pages\Bets;

use App\Exports\Receipt;
use App\Helper\Balance;
use App\Helper\Commision;
use App\Helper\Mask;
use App\Helper\ChaveAleatoria;
use App\Http\Controllers\Admin\Pages\Dashboards\ExtractController;
use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\TransactBalance;
use App\Models\Competition;
use App\Models\Commission;
use App\Models\Draw;
use App\Models\Game;
use App\Models\HashGame;
use App\Models\TypeGame;
use App\Models\Bet;
use App\Models\TypeGameValue;
use Illuminate\Support\Facades\Auth;
use App\Helper\GameHelper;

use App\Models\User;
use App\Models\UsersHasPoints;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use PDF;
use SnappyImage;

use App\Jobs\ProcessBetEntries;
use App\Helper\Configs;
use App\Helper\Money;

// lib de email
use Mail;

class GameController extends Controller
{
    protected $game;

    public function __construct(Game $game)
    {
        $this->game = $game;
    }

    public function index(Request $request, $typeGame)
    {
        if (!auth()->user()->hasPermissionTo('read_game')) {
            abort(403);
        }

        $clients = Client::get();
        $users = User::get();

        if ($request->ajax()) {
            $game = $this->game->whereRaw('type_game_id = ? and checked = 1', $typeGame);
            
            $params = array();
            parse_str($request->form, $params);    

            if(isset($params['client_id']) && !empty($params['client_id'])) {
                $game = $game->where('client_id', $params['client_id']);
            }

            if(isset($params['user_id']) && !empty($params['user_id'])) {
                $game = $game->where('user_id', $params['user_id']);
            }

            if(isset($params['startDate']) && !empty($params['startDate'])) {
                $game = $game->where('created_at', '>=', $params['startDate']);
            }

            if(isset($params['endDate']) && !empty($params['endDate'])) {
                $game = $game->where('created_at', '<=', $params['endDate'] . ' 23:59:59');
            }
            
            if (!auth()->user()->hasPermissionTo('read_all_games')) $game->where('user_id', auth()->id());
            $game->get();
            return DataTables::of($game)
                ->addIndexColumn()
                ->addColumn('mass_action', function ($game) {
                    return "<input type='checkbox' name='games[]' class='game-checkbox' value='{$game->id}' />";
                })
                ->addColumn('action', function ($game) {
                    $data = '';
                    if (auth()->user()->hasPermissionTo('update_game')) {
                        $data .= '<a href="' . route('admin.bets.games.edit', ['game' => $game->id]) . '">
                        <button class="btn btn-sm btn-warning" title="Editar"><i class="far fa-edit"></i></button>
                    </a>';
                    }
                    /*Botão de deletar jogo */
                    if (auth()->user()->hasPermissionTo('delete_game')) {
                        $data .= '<button class="btn btn-sm btn-danger" id="btn_delete_game" game="' . $game->id . '" title="Deletar" data-toggle="modal" data-target="#modal_delete_game"> <i class="far fa-trash-alt"></i></button>';
                    }
                    return $data;
                })
                ->addColumn('client_cpf', function ($game) {
                    return Mask::addMaskCpf($game->client->cpf);
                })
                ->addColumn('client', function ($game) {
                    return $game->client->name . ' ' . $game->client->last_name;
                })
                ->addColumn('user', function ($game) {
                    return $game->user->name . ' ' . $game->user->last_name;
                })
                ->addColumn('type', function ($game) {
                    return $game->typeGame->name;
                })
                ->editColumn('created_at', function ($game) {
                    return Carbon::parse($game->created_at)->format('d/m/Y');
                })
                ->rawColumns(['action', 'mass_action'])
                ->make(true);
        }

        return view('admin.pages.bets.game.index', compact('typeGame', 'clients', 'users'));
    }
    public function carregarJogo(TypeGame $typeGame)
    {
        $typeGames = TypeGame::get();
        $clients = Client::get();
        return view('admin.pages.bets.game.carregar', compact('typeGames', 'typeGame', 'clients'));
    }

    public function create(TypeGame $typeGame)
    {
        if (!auth()->user()->hasPermissionTo('create_game')) {
            abort(403);
        }

        $typeGames = TypeGame::find($typeGame)->first();
        $clients = collect([]);

        /*
        $typeGames = TypeGame::get();
        $clients = Client::get();
        */

        return view('admin.pages.bets.game.create', compact('typeGames', 'typeGame', 'clients'));
    }

    public function store(Request $request, Bet $validate_game, Game $game)
    {
        $date = Carbon::now();
        if ($date->hour >= 20 && $date->hour < 21) {
            return redirect()->route('admin.bets.games.create', ['type_game' => $request->type_game])->withErrors([
                'error' => 'Apostas Encerradas!'
            ]);
        } 
     
        if ($request->controle == 1) {
            if (!auth()->user()->hasPermissionTo('create_game')) {
                abort(403);
            }

            $validatedData = $request->validate([
                'type_game' => 'required',
                'client' => 'required',
                'value' => 'required',
            ]);

            try {

                $chaveregistro = ChaveAleatoria::generateKey(8);
                $user = Auth()->user()->id;
                $bet = new Bet();

                if(!auth()->user()->hasRole('Administrador') && ($request->type_client != 1 || $request->type_client == null) ){
                                    
                $userclient = User::where('id', $request->client)->first();

                    if($userclient != null){
                        $clientuser = Client::where('email', $userclient->email)->first();
                    }else{
                $clientuser = $request->client;
                }
                if($userclient != null){
                    $bet->client_id = $clientuser->id;
                }else{
                    $bet->client_id = $request->client;
                }
                }else{

                    $bet->client_id = $request->client;
                }
                
                $bet->user_id = Auth()->user()->id;
                $bet->status_xml = 1;
                $bet->key_reg = $chaveregistro;
                $bet->save();

                $bet = Bet::where('user_id', $user)->where('status_xml', 1)->where('key_reg', $chaveregistro)->first();

                $typeGameValue = TypeGameValue::where([
                    ['type_game_id', $request->type_game],
                    ['numbers', $request->qtdDezena],
                ])->get();
                $id_type_value = $request->valueId;
                $dezenas = explode(",", $request->dezena);
                $totaldeJogos = count($dezenas);
                $totaldeAposta = $totaldeJogos * $request->value;
                $dezenasSeparadas;
                $competition = TypeGame::find($request->type_game)->competitions->last();
                if (empty($competition)) {
                    $bet->status_xml = 3;
                    $bet->save();
                    return redirect()->route('admin.bets.games.create', ['type_game' => $request->type_game])->withErrors([
                        'error' => 'Não existe concurso cadastrado!'
                    ]);
                }

                $typeGameValue = TypeGameValue::find($request['valueId']);

                // Formatar dezenas
                foreach($dezenas as $key => $dezena) {
                    $dezena_arr = explode(' ', $dezena);
                    sort($dezena_arr, SORT_NUMERIC);

                    $dezenas[$key] = implode(',', $dezena_arr);
                }

                // Contar dezenas repetidas enviadas
                $countedDozens = array_count_values($dezenas);

                if(!empty($typeGameValue->max_repeated_games)) {
                    foreach($dezenas as $dezena) {

                        $foundGames = Game::where('numbers', $dezena)
                        ->where('competition_id', $competition->id)
                        ->where('type_game_value_id', $request['valueId'])
                        ->get();

                        if ($foundGames->count() >= $typeGameValue->max_repeated_games ||
                            $countedDozens[$dezena] >= $typeGameValue->max_repeated_games ) {
                            return redirect()->route('admin.bets.games.create', ['type_game' => $request->type_game])->withErrors([
                                'error' => "Essa dezena já atingiu o número máximo de apostas com esses números ({$dezena})!"
                            ]);
                        }
                    }
                }

                $hasDraws = Draw::where('competition_id', $competition->id)->count();

                if($hasDraws > 0) {
                    return redirect()->route('admin.bets.games.create', ['type_game' => $request->type_game])->withErrors([
                        'error' => 'Esse sorteio já foi finalizado!'
                    ]);
                }

                $balance = Balance::calculation($totaldeAposta);

                if (!$balance) {
                    $bet->status_xml = 3;
                    $bet->save();
                    return redirect()->route('admin.bets.games.create', ['type_game' => $request->type_game])->withErrors([
                        'error' => 'Saldo Insuficiente!'
                    ]);
                }

                ProcessBetEntries::dispatch($dezenas, $request, $bet, $competition, auth()->user())->onQueue('default');

                return redirect()->route('admin.bets.games.index', ['type_game' => $request->type_game])->withErrors([
                    'success' => 'O seu jogo está sendo processado, você será notificado assim que terminar.'
                ]);
            } catch (\Exception $exception) {

                $bet->status_xml = 3;
                $bet->save();
                return redirect()->route('admin.bets.games.create', ['type_game' => $request->type_game])->withErrors([
                    'error' => config('app.env') != 'production' ? $exception->getMessage() : 'Ocorreu um erro ao criar o jogo, tente novamente'
                ]);
            }
        } else {

            if (!auth()->user()->hasPermissionTo('create_game')) {
                abort(403);
            }

            $validatedData = $request->validate([
                'type_game' => 'required',
                'client' => 'required',
                'value' => 'required',
            ]);

            $request['sort_date'] = str_replace('/', '-', $request['sort_date']);
            $request['sort_date'] = Carbon::parse($request['sort_date'])->toDateTime();

            try {
                $date = Carbon::now();
                if ($date->hour >= 20 && $date->hour < 21) {
                    return redirect()->route('admin.bets.games.create', ['type_game' => $request->type_game])->withErrors([
                        'error' => 'Apostas Encerradas!'
                    ]);
                }

                $balance = Balance::calculation($request->value);

                if (!$balance) {
                    return redirect()->route('admin.bets.games.create', ['type_game' => $request->type_game])->withErrors([
                        'error' => 'Saldo Insuficiente!'
                    ]);
                }

                $competition = TypeGame::find($request->type_game)->competitions->last();
                if (empty($competition)) {
                    return redirect()->route('admin.bets.games.create', ['type_game' => $request->type_game])->withErrors([
                        'error' => 'Não existe concurso cadastrado!'
                    ]);
                }

                $numbers = explode(',', $request->numbers);
                //aqui

                sort($numbers, SORT_NUMERIC);
                $numbers = implode(',', $numbers);
                
                $typeGameValue = TypeGameValue::find($request['valueId']);

                if(!empty($typeGameValue->max_repeated_games)) {
                    $foundGames = Game::where('numbers', $numbers)
                    ->where('competition_id', $competition->id)
                    ->where('type_game_value_id', $request['valueId'])
                    ->get();

                    if ($foundGames->count() >= $typeGameValue->max_repeated_games) {
                        return redirect()->route('admin.bets.games.create', ['type_game' => $request->type_game])->withErrors([
                            'error' => 'Essa dezena já atingiu o número máximo de apostas com esses números!'
                        ]);
                    }
                }

                
                $hasDraws = Draw::where('competition_id', $competition->id)->count();
                
                if($hasDraws > 0) {
                    return redirect()->route('admin.bets.games.create', ['type_game' => $request->type_game])->withErrors([
                        'error' => 'Esse sorteio já foi finalizado!'
                    ]);
                }
                
                
                
                 $game = new $this->game;
                if($request->type_client != 1 && !auth()->user()->hasRole('Administrador')){
                $userclient = User::where('id', $request->client)->first();
                    if($userclient != null){
                        $clientuser = Client::where('email', $userclient->email)->first();
                    }else{
                $clientuser = $request->client;
                }
                if($userclient != null){
                $game->client_id = $clientuser->id;
                }else{
                    $game->client_id = $request->client;
                }
                }else{

                    $game->client_id = $request->client;
                }



                //salvar jogo
                $game->user_id = auth()->id();
                $game->type_game_id = $request->type_game;
                $game->type_game_value_id = $request->valueId;

                $game->value = $request->value;
                $game->premio = $request->premio;
                $game->numbers = $numbers;
                $game->competition_id = $competition->id;
                $game->checked = 1;
                
                $game->save();


                //verifica se é da dupla sena 
                if ($request->type_game == 10){
                    //encontrar o concurso com o final A na tabela
                    $competitionA = Competition::where('number', 'like', '%' . $competition->number . 'A')->first();
                    // Chamada do helper para duplicar o jogo - dener.gomes 28.08 - 18:02

                    $copiaGame = GameHelper::duplicateGame($game, $competitionA, $request, $request->valueId, $numbers, 1, $request->value, $request->premio);    

                }
                
               
                $transact_balance = new TransactBalance;
                $transact_balance->user_id_sender = auth()->id();
                $transact_balance->user_id = auth()->id();
                $transact_balance->value = $request->value;
                $transact_balance->old_value = auth()->user()->balance;
                $transact_balance->value_a = auth()->user()->balance - $request->value;
                $transact_balance->type = 'Compra - Jogo de id: ' . $game->id . ' do tipo: ' . $game->type_game_id;
                $transact_balance->save();

                $extract = [
                    'type' => 1,
                    'value' => $request->value,
                    'type_game_id' => $game->type_game_id,
                    'description' => 'Venda - Jogo de id: ' . $game->id,
                    'user_id' => $game->user_id,
                    'client_id' => $game->client_id
                ];
                $ID_VALUE = auth()->user()->indicador;
                $storeExtact = ExtractController::store($extract);
                $commissions = Commision::calculationNew($request->value, $game->user_id, '', $game->type_game_value_id);

                $game->commission_percentage = $commissions['percentage'];
                $game->commission_value = $commissions['commission'];
                $game->commision_value_pai = $commissions['commission_pai'];
                $game->commision_value_avo = $commissions['commission_avo'];
                $game->save();

                
                $planodecarreira = Configs::getPlanoDeCarreira();
                if($planodecarreira == "Ativado"){
                UsersHasPoints::generatePoints(auth()->user(), $game->value, 'Venda - Jogo de id: ' . $game->id);
                }
                // PEGAR ID DO CLIENTE PARA BUSCAR APOSTAS DO MESMO
                $idCliente = $game->id;

                // pegando jogos feitos
                $jogosCliente = Game::where('id', $idCliente)->get();

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
                    $m->to(auth()->user()->email);
                    $m->attachData($pdf->output(), $fileName);
                });

                return redirect()->route('admin.bets.games.edit', ['game' => $game->id])->withErrors([
                    'success' => 'Jogo cadastrado com sucesso2'
                ]);
            } catch (\Exception $exception) {
                return redirect()->route('admin.bets.games.create', ['type_game' => $request->type_game])->withErrors([
                    'error' => config('app.env') != 'production' ? $exception->getMessage() : 'Ocorreu um erro ao criar o jogo, tente novamente'
                ]);
            }
        }
    }

    public function createLink()
    {
        try {
            $makeHash = $this->makeHash();

            $hashGame = new HashGame();
            $hashGame->hash = $makeHash;
            $hashGame->user_id = auth()->id();
            $hashGame->save();

            return redirect()->route('admin.home')->withErrors([
                'messageHashGame' => 'Link criado com sucesso',
                'hash' => $hashGame->hash
            ]);
        } catch (\Exception $exception) {
            return redirect()->route('admin.home')->withErrors([
                'error' => config('app.env') != 'production' ? $exception->getMessage() : 'Ocorreu um erro ao criar o link para o jogo, tente novamente'
            ]);
        }
    }

    public function makeHash()
    {
        $length = 23;
        $hash = bin2hex(random_bytes($length));

        if (!$this->validHash($hash)) {
            $this->makeHash();
        }

        return $hash;
    }

    public function validHash($hash)
    {
        return empty(HashGame::where('hash', $hash)->first());
    }

    public function edit(Request $request, Game $game)
    {
        if (!auth()->user()->hasPermissionTo('update_game')) {
            abort(403);
        }

        if (!auth()->user()->hasPermissionTo('read_all_games') && $game->user_id != auth()->id()) {
            abort(403);
        }

        $typeGame = $game->typeGame;
        $typeGameValue = $game->typeGameValue;
        $client = $game->client;
        $selectedNumbers = explode(',', $game->numbers);

        $matriz = [];
        $line = [];
        $index = 0;
        $i = 0;

        foreach (range(1, $typeGame->numbers) as $number) {
            if ($i < $typeGame->columns) {
                $i++;
            } else {
                $index++;
                $i = 1;
            }
            $matriz[$index][] = array_push($line, $number);
        }
        $this->matriz = $matriz;

        return view('admin.pages.bets.game.edit', compact('game', 'matriz', 'selectedNumbers', 'typeGame', 'typeGameValue', 'client'));
    }

    public function destroy(Game $game)
    {

   

        if (!auth()->user()->hasPermissionTo('delete_game')) {
            abort(403);
        }

        if (!auth()->user()->hasPermissionTo('read_all_games') && $game->user_id != auth()->id()) {
            abort(403);
        }

        try {
            $typeGame = $game->type_game_id;

            $draws = Draw::get();

            foreach ($draws as $draw) {
                $draw->games = explode(',', $draw->games);
                $gameDraw = in_array($game->id, $draw->games);

                if ($gameDraw)
                    throw new \Exception('Jogo vinculado em um sorteio');         
              
            }

    
            if($game->delete()){

                $idUsuario = $game->user_id;
                $user = User::find($idUsuario);
                $CommissionPai = false;
                $Competition = Competition::find($game->competition_id);

                // Verifica se o jogo é do tipo "competitionA" 
                if (substr($Competition->number, -1) !== 'A') {  //pega uma string e retorna começando no ultimo caractere (-1) verificando se o ultimo caractere é diferente de A 
                // Devolvendo o valor do saldo para jogos que não são do tipo "concurso com final A"
                Balance::calculationEstorno($idUsuario, $game->value);
                Commision::calculationEstorno($idUsuario, $game->commission_value,  $game->commision_value_pai, $CommissionPai);
                Commision::calculationNewEstorno($game->value, $game->user_id, $game->game_type, $game->type_id);

                //Criando o Registro no Extrato da Carteira do Estorno.
                $transact_balance = new TransactBalance;
                $transact_balance->user_id_sender = $user->id;
                $transact_balance->user_id = $user->id;
                $transact_balance->value = $game->value;
                $transact_balance->old_value = $user->balance;
                $transact_balance->value_a = $user->balance + $game->value;
                $transact_balance->type = 'Estorno - Jogo de id: ' . $game->id . ' do tipo: ' . $game->type_game_id;
                $transact_balance->save();
            }
                }
    

            return redirect()->route('admin.bets.games.index', ['type_game' => $typeGame])->withErrors([
                'success' => 'Jogo deletado com sucesso'
            ]);
        } catch (\Exception $exception) {

            return redirect()->route('admin.bets.games.index', ['type_game' => $typeGame])->withErrors([
                'error' => config('app.env') != 'production' ? $exception->getMessage() : 'Ocorreu um erro ao deletar o jogo, tente novamente'
            ]);
        }
    }

    public function massDelete(Request $request)
    {
        if (!auth()->user()->hasPermissionTo('delete_game')) {
            throw new \Exception('Não autorizado.');
        }

        // if (!auth()->user()->hasPermissionTo('read_all_games') && $game->user_id != auth()->id()) {
        //     abort(403);
        // }

        try {
            $games = Game::whereIn('id', $request->ids)->get();

            if($games->count() > 0) {
                foreach($games->all() as $game) {
                    $typeGame = $game->type_game_id;

                    $draws = Draw::get();
        
                    foreach ($draws as $draw) {
                        $draw->games = explode(',', $draw->games);
                        $gameDraw = in_array($game->id, $draw->games);
        
                        if ($gameDraw)
                            throw new \Exception('Jogo #' . $game->id . ' vinculado em um sorteio');
                    }
                    
        
                  if($game->delete()){

                    $idUsuario = $game->user_id;
                    $user = User::find($idUsuario);
                    $CommissionPai = false;
                    $Competition = Competition::find($game->competition_id);
    
                    if(substr($Competition->number, -1) !== 'A') {  //pega uma string e retorna começando no ultimo caractere (-1) verificando se o ultimo caractere é diferente de A
                    //Devolvendo o valor do saldo.
                    Balance::calculationEstorno($idUsuario, $game->value);
                    if(!is_null($game->commision_value_pai )){
                        $CommissionPai = true;
                    }
                    //Devolvendo o valor do Bônus.
                    Commision::calculationEstorno($idUsuario, $game->commission_value,  $game->commission_value_pai, $CommissionPai);
                    Commision::calculationNewEstorno($game->value, $game->user_id, $game->game_type, $game->type_id);
                    
                    //Criando o Registro no Extrato da Carteira do Estorno.
                    $transact_balance = new TransactBalance;
                    $transact_balance->user_id_sender = $user->id;
                    $transact_balance->user_id = $user->id;
                    $transact_balance->value = $game->value;
                    $transact_balance->old_value = $user->balance;
                    $transact_balance->value_a = $user->balance + $game->value;
                    $transact_balance->type = 'Estorno - Jogo de id: ' . $game->id . ' do tipo: ' . $game->type_game_id;
                    $transact_balance->save();
                }
                  }

                }
            }

            return response()->json([
                'message' => 'Jogos deletados com sucesso',
                'success' => true
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 400);
        }
    }

    public function getReceipt(Game $game, $format, $prize = false)
    {
        if (!auth()->user()->hasPermissionTo('read_game')) {
            abort(403);
        }

        if (!auth()->user()->hasPermissionTo('read_all_games') && $game->user_id != auth()->id()) {
            abort(403);
        }

        $typeGame = $game->typeGame;
        $typeGameValue = $game->typeGameValue;
        $client = $game->client;
        $numbers = explode(',', $game->numbers);
        asort($numbers, SORT_NUMERIC);

        $matriz = [];
        $line = [];
        $index = 0;
        $count = 0;

        foreach ($numbers as $number) {
            if ($count < 10) {
                $count++;
            } else {
                $index++;
                $count = 1;
                $line = [];
            }
            array_push($line, $number);

            $matriz[$index] = $line;
        }

        global $data;
        $data = [
            'game' => $game,
            'client' => $client,
            'typeGame' => $typeGame,
            'numbers' => $numbers,
            'typeGameValue' => $typeGameValue,
            'matriz' => $matriz,
            'prize' => $prize,
        ];



        if ($format == "pdf") {

            global $fileName;
            global $pdf;
            $fileName = 'Recibo ' . $game->id . ' - ' . $client->name . '.jpeg';

            $pdf = SnappyImage::loadView('admin.layouts.pdf.receipt', $data);
            return $pdf->download($fileName);
        } elseif ($format == "txt") {
            $fileName = 'Recibo ' . $game->id . ' - ' . $client->name . '.txt';
            $content = view()->make('admin.layouts.txt.receipt')->with($data);
            $headers = array(
                'Content-Type' => 'plain/txt',
                'Content-Disposition' => sprintf('attachment; filename="%s"', $fileName),
            );

            return response()->make($content, 200, $headers);
        }
    }

    public function getReceiptTudo(Game $game, $idcliente, $prize = false, Bet $apostas)
    {

        // pegando jogos feitos
        $jogosCliente = game::where('bet_id', $idcliente)->get();

        $User = Auth::User();
        // $Nome = $User['name'] . ' ' . $User['last_name'];
        // $fileName = 'Recibo ' . $infoCliente['bet_id'] . ' - ' . $Nome . '.pdf';

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

        $data = [
            'prize' => $prize,
            'jogosCliente' => $jogosCliente,
            'Nome' => $Nome,
            'Datas' => $Datas,
            'TipoJogo' => $TipoJogo
        ];
        $fileName = 'Recibo ' . $InfoJogos['bet_id']  . ' - ' . $Nome . '.pdf';

        // return view('admin.layouts.pdf.receiptTudo', $data);
        $pdf = PDF::loadView('admin.layouts.pdf.receiptTudo', $data);
        return $pdf->download($fileName);
    }

    public function getReceiptTudoTxt(Game $game, $idcliente, $prize = false, Bet $apostas)
    {

        // pegando jogos feitos
        $jogosCliente = game::where('bet_id', $idcliente)->get();

        $User = Auth::User();
        // $Nome = $User['name'] . ' ' . $User['last_name'];
        // $fileName = 'Recibo ' . $infoCliente['bet_id'] . ' - ' . $Nome . '.pdf';

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

        // telefone cliente
        $telefone = $ClienteJogo['ddd'] . ' ' . $ClienteJogo['phone'];

        $data = [
            'prize' => $prize,
            'jogosCliente' => $jogosCliente,
            'Nome' => $Nome,
            'Datas' => $Datas,
            'TipoJogo' => $TipoJogo,
            'telefone' => $telefone
        ];


        $fileName = 'Recibo ' . $InfoJogos['bet_id']  . ' - ' . $Nome . '.txt';

        $content = view()->make('admin.layouts.txt.receiptAllTxt')->with($data);
        $headers = array(
            'Content-Type' => 'plain/txt',
            'Content-Disposition' => sprintf('attachment; filename="%s"', $fileName),
        );
        return response()->make($content, 200, $headers);
    }
}
