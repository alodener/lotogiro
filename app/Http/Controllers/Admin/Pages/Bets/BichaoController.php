<?php

namespace App\Http\Controllers\Admin\Pages\Bets;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\Pages\Dashboards\ExtractController;
use App\Models\TransactBalance;
use App\Helper\Commision;
use App\Models\Commission;
use App\Helper\Balance;
use App\Models\Client;
use App\Models\BichaoAnimals;
use App\Models\BichaoEstados;
use App\Models\BichaoModalidades;
use App\Models\BichaoHorarios;
use App\Models\BichaoGames;
use App\Models\BichaoGamesVencedores;
use App\Models\BichaoResultados;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Cotacao;
use App\Models\TypeGame;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use PDF;
use SnappyImage;

class BichaoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!auth()->user()->hasPermissionTo('create_game')) {
            abort(403);
        }

        $user_auth = Auth::user();
        $clientId = $user_auth['id'];
        $showList = false;

        $chart = is_array(session('@loteriasbr/chart')) ? session('@loteriasbr/chart') : [];
        $clients = Client::orderBy('name', 'ASC')->get();
        $modalidade = BichaoModalidades::where('nome', 'Milhar')->first();
        $estados = BichaoEstados::where('active', 1)->get();

        $totalCarrinho = array_reduce($chart, fn ($acc, $item) => $acc + $item['value'], 0);
        return view('admin.pages.bets.game.bichao.index', compact('clients','clientId','showList','totalCarrinho', 'modalidade', 'chart', 'estados'));
    }

    public function centena()
    {
        if (!auth()->user()->hasPermissionTo('create_game')) {
            abort(403);
        }
        $chart = is_array(session('@loteriasbr/chart')) ? session('@loteriasbr/chart') : [];
        $clients = Client::orderBy('name', 'ASC')->get();
        $modalidade = BichaoModalidades::where('nome', 'Centena')->first();
        $estados = BichaoEstados::where('active', 1)->get();
        
        $totalCarrinho = array_reduce($chart, fn ($acc, $item) => $acc + $item['value'], 0);
        return view('admin.pages.bets.game.bichao.centena', compact('clients', 'modalidade', 'chart', 'totalCarrinho', 'estados'));
    }

    public function dezena()
    {
        if (!auth()->user()->hasPermissionTo('create_game')) {
            abort(403);
        }
        $chart = is_array(session('@loteriasbr/chart')) ? session('@loteriasbr/chart') : [];
        $clients = Client::orderBy('name', 'ASC')->get();
        $modalidade = BichaoModalidades::where('nome', 'Dezena')->first();
        $estados = BichaoEstados::where('active', 1)->get();

        $totalCarrinho = array_reduce($chart, fn ($acc, $item) => $acc + $item['value'], 0);
        return view('admin.pages.bets.game.bichao.dezena', compact('clients', 'modalidade', 'chart', 'totalCarrinho', 'estados'));
    }

    public function group()
    {
        if (!auth()->user()->hasPermissionTo('create_game')) {
            abort(403);
        }
        $chart = is_array(session('@loteriasbr/chart')) ? session('@loteriasbr/chart') : [];
        $clients = Client::orderBy('name', 'ASC')->get();
        $modalidade = BichaoModalidades::where('nome', 'Grupo')->first();
        $estados = BichaoEstados::where('active', 1)->get();

        $totalCarrinho = array_reduce($chart, fn ($acc, $item) => $acc + $item['value'], 0);
        return view('admin.pages.bets.game.bichao.group', compact('clients', 'modalidade', 'chart', 'totalCarrinho', 'estados'));
    }

    public function milhar_centena()
    {
        if (!auth()->user()->hasPermissionTo('create_game')) {
            abort(403);
        }
        $chart = is_array(session('@loteriasbr/chart')) ? session('@loteriasbr/chart') : [];
        $clients = Client::orderBy('name', 'ASC')->get();
        $modalidade = BichaoModalidades::where('nome', 'Milhar/Centena')->first();
        $estados = BichaoEstados::where('active', 1)->get();

        $totalCarrinho = array_reduce($chart, fn ($acc, $item) => $acc + $item['value'], 0);
        return view('admin.pages.bets.game.bichao.milhar_centena', compact('clients', 'modalidade', 'chart', 'totalCarrinho', 'estados'));
    }

    public function terno_dezena()
    {
        if (!auth()->user()->hasPermissionTo('create_game')) {
            abort(403);
        }
        $chart = is_array(session('@loteriasbr/chart')) ? session('@loteriasbr/chart') : [];
        $clients = Client::orderBy('name', 'ASC')->get();
        $modalidade = BichaoModalidades::where('nome', 'Terno de Dezena')->first();
        $estados = BichaoEstados::where('active', 1)->get();

        $totalCarrinho = array_reduce($chart, fn ($acc, $item) => $acc + $item['value'], 0);
        return view('admin.pages.bets.game.bichao.terno_dezena', compact('clients', 'modalidade', 'chart', 'totalCarrinho', 'estados'));
    }

    public function terno_grupo()
    {
        if (!auth()->user()->hasPermissionTo('create_game')) {
            abort(403);
        }
        $chart = is_array(session('@loteriasbr/chart')) ? session('@loteriasbr/chart') : [];
        $clients = Client::orderBy('name', 'ASC')->get();
        $modalidade = BichaoModalidades::where('nome', 'Terno de Grupos')->first();
        $estados = BichaoEstados::where('active', 1)->get();

        $totalCarrinho = array_reduce($chart, fn ($acc, $item) => $acc + $item['value'], 0);
        return view('admin.pages.bets.game.bichao.terno_grupo', compact('clients', 'modalidade', 'chart', 'totalCarrinho', 'estados'));
    }

    public function duque_dezena()
    {
        if (!auth()->user()->hasPermissionTo('create_game')) {
            abort(403);
        }
        $chart = is_array(session('@loteriasbr/chart')) ? session('@loteriasbr/chart') : [];
        $clients = Client::orderBy('name', 'ASC')->get();
        $modalidade = BichaoModalidades::where('nome', 'Duque de Dezena')->first();
        $estados = BichaoEstados::where('active', 1)->get();

        $totalCarrinho = array_reduce($chart, fn ($acc, $item) => $acc + $item['value'], 0);
        return view('admin.pages.bets.game.bichao.duque_dezena', compact('clients', 'modalidade', 'chart', 'totalCarrinho', 'estados'));
    }

    public function duque_grupo()
    {
        if (!auth()->user()->hasPermissionTo('create_game')) {
            abort(403);
        }
        $chart = is_array(session('@loteriasbr/chart')) ? session('@loteriasbr/chart') : [];
        $clients = Client::orderBy('name', 'ASC')->get();
        $modalidade = BichaoModalidades::where('nome', 'Duque de Grupo')->first();
        $estados = BichaoEstados::where('active', 1)->get();

        $totalCarrinho = array_reduce($chart, fn ($acc, $item) => $acc + $item['value'], 0);
        return view('admin.pages.bets.game.bichao.duque_grupo', compact('clients', 'modalidade', 'chart', 'totalCarrinho', 'estados'));
    }

    public function cotacao(Response $response)
    {
        if (!auth()->user()->hasPermissionTo('create_game')) {
            abort(403);
        }
        $cotacoes = BichaoModalidades::orderBy('multiplicador', 'DESC')->get();

        return view('admin.pages.bets.game.bichao.cotacao',compact('cotacoes'));
    }

    public function settings(Response $response)
    {
        if (!auth()->user()->hasPermissionTo('read_user')) {
            abort(403);
        }
        $cotacoes = BichaoModalidades::where('id', '!=', 5)->get();
        $estados = BichaoEstados::get();

        return view('admin.pages.bets.game.bichao.settings', compact('cotacoes', 'estados'));
    }

    public function save_settings(Request $request)
    {
        if (!auth()->user()->hasPermissionTo('read_user')) {
            abort(403);
        }
        $data = $request->all();

        $estados = $data['estados'];
        $cotacoes = $data['cotacoes'];

        foreach ($estados as $estado) {
            BichaoEstados::where('id', $estado['id'])->update(['active' => $estado['active']]);
        }

        foreach ($cotacoes as $cotacao) {
            BichaoModalidades::where('id', $cotacao['id'])->update(['multiplicador' => $cotacao['value']]);
        }

        return json_encode(['status' => 'ok']);
    }

    public function my_bets(Request $request) {
        if (!auth()->user()->hasPermissionTo('create_game')) {
            abort(403);
        }
        $perPage = $request->has('perPage') ? $request->input('perPage') : 10;
        $intervalo = $request->has('intervalo') ? $request->input('intervalo') : 30;
        $buscaIntervalo = now()->subDays($intervalo)->endOfDay();

        $apostas = BichaoGames::select('bichao_games.*', 'bh.horario', 'bh.banca', 'bm.nome as modalidade_nome', 'c.name as cliente_nome', 'c.last_name as cliente_sobrenome')
            ->join('clients as c', 'c.id', 'bichao_games.client_id')
            ->join('bichao_modalidades as bm', 'bm.id', 'bichao_games.modalidade_id')
            ->join('bichao_horarios as bh', 'bh.id', 'bichao_games.horario_id')
            ->where('bichao_games.user_id', Auth()->user()->id)
            ->whereDate('bichao_games.created_at','>=', $buscaIntervalo)
            ->orderBy('bichao_games.created_at', 'DESC')
            ->paginate($perPage);

        return view('admin.pages.bets.game.bichao.minhas_apostas', [
            'apostas' => $apostas,
            'perPage' => $perPage,
            'intervalo' => $intervalo,
        ]);
    }

    public function comissions(Request $request) {
        if (!auth()->user()->hasPermissionTo('create_game')) {
            abort(403);
        }
        $perPage = $request->has('perPage') ? $request->input('perPage') : 10;
        $intervalo = $request->has('intervalo') ? $request->input('intervalo') : 30;
        $buscaIntervalo = now()->subDays($intervalo)->endOfDay();

        $apostas = BichaoGames::select('bichao_games.*', 'bh.horario', 'bh.banca', 'bm.nome as modalidade_nome', 'u.name as usuario_nome', 'u.last_name as usuario_sobrenome')
            ->join('users as u', 'u.id', 'bichao_games.user_id')
            ->join('bichao_modalidades as bm', 'bm.id', 'bichao_games.modalidade_id')
            ->join('bichao_horarios as bh', 'bh.id', 'bichao_games.horario_id')
            ->where('bichao_games.comission_value','>',0)
            ->whereDate('bichao_games.created_at','>=', $buscaIntervalo)
            ->orderBy('bichao_games.created_at', 'DESC')
            ->paginate($perPage);

        return view('admin.pages.bets.game.bichao.comissions', [
            'apostas' => $apostas,
            'perPage' => $perPage,
            'intervalo' => $intervalo,
        ]);
    }

    public function draws(Request $request) {
        if (!auth()->user()->hasPermissionTo('create_game')) {
            abort(403);
        }
        $perPage = $request->has('perPage') ? $request->input('perPage') : 10;
        $intervalo = $request->has('intervalo') ? $request->input('intervalo') : 30;
        $buscaIntervalo = now()->subDays($intervalo)->endOfDay();

        $apostas = BichaoGames::select('bichao_games.*', 'bgv.valor_premio', 'bh.horario', 'bh.banca', 'bm.nome as modalidade_nome', 'c.name as cliente_nome', 'c.last_name as cliente_sobrenome', 'c.pix')
            ->join('bichao_games_vencedores as bgv', 'bgv.game_id', 'bichao_games.id')
            ->join('clients as c', 'c.id', 'bichao_games.client_id')
            ->join('bichao_modalidades as bm', 'bm.id', 'bichao_games.modalidade_id')
            ->join('bichao_horarios as bh', 'bh.id', 'bichao_games.horario_id')
            ->whereDate('bichao_games.created_at','>=', $buscaIntervalo)
            ->orderBy('bichao_games.created_at', 'DESC')
            ->paginate($perPage);

        return view('admin.pages.bets.game.bichao.draws', [
            'apostas' => $apostas,
            'perPage' => $perPage,
            'intervalo' => $intervalo,
        ]);
    }

    public function results(){
        if (!auth()->user()->hasPermissionTo('create_game')) {
            abort(403);
        }
        return view('admin.pages.bets.game.bichao.resultados');
    }

    public function add_in_chart(Request $request) {
        if (!auth()->user()->hasPermissionTo('create_game')) {
            abort(403);
        }
        $data = $request->all();

        $chart = is_array(session('@loteriasbr/chart')) ? session('@loteriasbr/chart') : [];

        if ($data['item']['modality'] === 'Milhar/Centena') {
            $data['item']['value'] = floatval($data['item']['value']) / 2;
            
            $data['item']['modality'] = 'Milhar';
            $chart[] = $data['item'];

            $data['item']['modality'] = 'Centena';
            $data['item']['game'] = substr($data['item']['game'], 1);
            $chart[] = $data['item'];
        } else {
            $chart[] = $data['item'];
        }

        session(['@loteriasbr/chart' => $chart]);

        echo json_encode(['status' => 200]);
    }

    public function remove_chart($index) {
        if (!auth()->user()->hasPermissionTo('create_game')) {
            abort(403);
        }
        $chart = is_array(session('@loteriasbr/chart')) ? session('@loteriasbr/chart') : [];

        if (sizeof($chart) >= $index + 1) {
            unset($chart[$index]);
            session(['@loteriasbr/chart' => array_values($chart)]);
        }

        echo json_encode(['status' => 200]);
    }

    public function checkout(Request $request) {
        if (!auth()->user()->hasPermissionTo('create_game')) {
            abort(403);
        }
        $data = $request->all();
        $chart = is_array(session('@loteriasbr/chart')) ? session('@loteriasbr/chart') : [];
        $checkout = [];
        $modalidades = [];

        if (sizeof($chart) == 0) return json_encode(['status' => false, 'message' => 'Faça pelo menos um jogo.']);

        foreach($chart as $chart) {
            $games = explode('-', $chart['game']);
            $modalidade = BichaoModalidades::where('nome', $chart['modality'])->first();

            if ($modalidade) {
                $modalidades[$modalidade->id] = $modalidade->nome;
                $checkout[] = [
                    'modalidade_id' => $modalidade->id,
                    'client_id' => $chart['client_id'],
                    'user_id' => Auth()->user()->id,
                    'horario_id' => $data['horario_id'],
                    'valor' => floatval($chart['value']),
                    'comission_percentage' => auth()->user()->commission,
                    'comission_payment' => 0,
                    'game_1' => isset($games[0]) ? $games[0] : null,
                    'game_2' => isset($games[1]) ? $games[1] : null,
                    'game_3' => isset($games[2]) ? $games[2] : null,
                    'premio_1' => in_array(1, $chart['award_type']),
                    'premio_2' => in_array(2, $chart['award_type']),
                    'premio_3' => in_array(3, $chart['award_type']),
                    'premio_4' => in_array(4, $chart['award_type']),
                    'premio_5' => in_array(5, $chart['award_type']),
                    'created_at' => date('Y-m-d H:i:s'),
                ];
            }
        }

        $oldBalance = auth()->user()->balance;

        $balance = Balance::calculation(array_reduce($checkout, fn ($acc, $item) => $acc + $item['valor'], 0));
        if (!$balance) return json_encode(['status' => false, 'message' => 'Saldo insuficiente.']);

        foreach ($checkout as $index => $checkoutDto) {
            $checkout[$index]['id'] = BichaoGames::insertGetId($checkoutDto);
        }

        foreach ($checkout as $checkout) {

            $transact_balance = new TransactBalance;
            $transact_balance->user_id_sender = auth()->id();
            $transact_balance->user_id = auth()->id();
            $transact_balance->value = $checkout['valor'];
            $transact_balance->old_value = $oldBalance;
            $transact_balance->type = 'Compra Bichão - Jogo de id: ' . $checkout['id'] . ' do tipo: ' . $modalidades[$checkout['modalidade_id']];
            $transact_balance->save();

            $extract = [
                'type' => 10, // 1 para jogos gerais, 10 para bichao
                'value' => $checkout['valor'],
                'type_game_id' => $checkout['modalidade_id'],
                'description' => 'Venda - Jogo de id: ' . $checkout['id'],
                'user_id' => $checkout['user_id'],
                'client_id' => $checkout['client_id']
            ];

            $ID_VALUE = auth()->user()->indicador;
            $storeExtact = ExtractController::store($extract);
            $commissionCalculationPai = Commision::calculationPai($checkout['comission_percentage'], $checkout['valor'], $ID_VALUE);
            $commissionCalculation = Commision::calculation($checkout['comission_percentage'], $checkout['valor']);

            BichaoGames::where('id', $checkout['id'])->update(['comission_value' => $commissionCalculation, 'comission_value_pai' => $commissionCalculationPai]);
        }

        session(['@loteriasbr/chart' => []]);

        echo json_encode(['status' => true, 'chart' => $checkout]);
    }

    public function getReceipt($id, $tipo = 'txt')
    {
        if (!auth()->user()->hasPermissionTo('create_game')) {
            abort(403);
        }
        $game = BichaoGames::select('bichao_games.*', 'bgv.id as vencedor_id', 'bh.horario', 'bh.banca', 'bm.nome as modalidade_nome', 'bm.multiplicador', 'c.name as cliente_nome', 'c.last_name as cliente_sobrenome', 'c.cpf as cliente_cpf')
            ->join('clients as c', 'c.id', 'bichao_games.client_id')
            ->join('bichao_modalidades as bm', 'bm.id', 'bichao_games.modalidade_id')
            ->join('bichao_horarios as bh', 'bh.id', 'bichao_games.horario_id')
            ->leftJoin('bichao_games_vencedores as bgv', 'bgv.game_id', 'bichao_games.id')
            ->where('bichao_games.id', $id)
            ->first();

        $apostas = [];
        $premios = [];

        if (strval($game['game_1']) > 0) $apostas[] = $game['game_1'];
        if (strval($game['game_2']) > 0) $apostas[] = $game['game_2'];
        if (strval($game['game_3']) > 0) $apostas[] = $game['game_3'];

        if ($game['premio_1'] == 1) $premios[] = 1;
        if ($game['premio_2'] == 1) $premios[] = 2;
        if ($game['premio_3'] == 1) $premios[] = 3;
        if ($game['premio_4'] == 1) $premios[] = 4;
        if ($game['premio_5'] == 1) $premios[] = 5;

        global $data;
        $data = [
            'game' => $game,
            'prize' => $game->vencedor_id > 0 ? 1 : 0,
            'aposta' => str_pad(join(' - ', $apostas), 2, 0, STR_PAD_LEFT),
            'premios' => join('°, ', $premios),
        ];

        if ($tipo == "pdf") {

            global $fileName;
            global $pdf;
            $fileName = 'Recibo ' . $game->id . ' - ' . $game->cliente_nome . '.jpeg';

            $pdf = SnappyImage::loadView('admin.layouts.pdf.receiptBichao', $data);
            return $pdf->download($fileName);
        } elseif ($tipo == "txt") {
            $fileName = 'Recibo ' . $game->id . ' - ' . $game->cliente_nome . '.txt';
            $content = view()->make('admin.layouts.txt.receiptBichao')->with($data);
            $headers = array(
                'Content-Type' => 'plain/txt',
                'Content-Disposition' => sprintf('attachment; filename="%s"', $fileName),
            );

            return response()->make($content, 200, $headers);
        }
    }

    public function get_horarios(Request $request) {
        if (!auth()->user()->hasPermissionTo('create_game')) {
            abort(403);
        }
        $data = $request->all();

        $horarios = BichaoHorarios::where('estado_id', $data['estado_id'])->where('horario', '>', date('H:i:s', strtotime("+20 minutes")))->orderBy('horario', 'asc')->get();

        echo json_encode(['horarios' => $horarios]);
    }

    private static function get_winners($resultados) {
        if (!auth()->user()->hasPermissionTo('create_game')) {
            abort(403);
        }
        $dataAtual = date('Y-m-d');
        $horaAtual = date('H:i:s');
        $dataAnterior = date('Y-m-d', strtotime('-24 hours'));
        $dataSeguinte = date('Y-m-d', strtotime('+24 hours'));

        $games = BichaoGames::select('bichao_games.*', 'bichao_horarios.horario', 'bichao_modalidades.multiplicador', 'bichao_modalidades.multiplicador_2')
            ->join('bichao_horarios', 'bichao_horarios.id', '=', 'bichao_games.horario_id')
            ->join('bichao_modalidades', 'bichao_modalidades.id', '=', 'bichao_games.modalidade_id')
            ->where('created_at', '>=', $dataAnterior. '00:00:00')
            ->where('created_at', '<=', $dataAtual.' 23:59:59')
            ->get()
            ->toArray();
        $animais = BichaoAnimals::get()->toArray();
        $gamesWinners = [];

        foreach ($games as $game) {
            $resultado = array_values(array_filter($resultados, fn ($resultado) => $resultado['horario_id'] == $game['horario_id']));
            if (sizeof($resultado) == 0) continue;
            $resultado = $resultado[0];
            $horaGame = date('H:i:s', strtotime($game['created_at']));

            if ($horaGame > $game['horario']) {
                $resultadoPeriodoInicio = $dataAnterior.' '.$resultado['horario'];
                $resultadoPeriodoFim = $dataAtual.' '.$resultado['horario'];
                if ($game['created_at'] <= $resultadoPeriodoInicio || $game['created_at'] >= $resultadoPeriodoFim) continue;
            } else {
                $resultadoPeriodoInicio = $dataAnterior.' '.$resultado['horario'];
                $resultadoPeriodoFim = $dataSeguinte.' '.$resultado['horario'];
                if ($game['created_at'] <= $resultadoPeriodoInicio || $game['created_at'] >= $resultadoPeriodoFim) continue;
            }

            $premios_quantia = 0;
            if ($game['premio_1'] == 1) $premios_quantia = $premios_quantia  + 1;
            if ($game['premio_2'] == 1) $premios_quantia = $premios_quantia  + 1;
            if ($game['premio_3'] == 1) $premios_quantia = $premios_quantia  + 1;
            if ($game['premio_4'] == 1) $premios_quantia = $premios_quantia  + 1;
            if ($game['premio_5'] == 1) $premios_quantia = $premios_quantia  + 1;

            $valor_premio = $game['valor'] * $game['multiplicador'] / $premios_quantia;
            $game_winner = false;

            // Milhar, Centena e Dezena
            if ($game['modalidade_id'] == 1) {
                $winner = false;
                if ($game['premio_1'] == 1 && $resultado['premio_1'] === $game['game_1']) $winner = true;
                if ($game['premio_2'] == 1 && $resultado['premio_2'] === $game['game_1']) $winner = true;
                if ($game['premio_3'] == 1 && $resultado['premio_3'] === $game['game_1']) $winner = true;
                if ($game['premio_4'] == 1 && $resultado['premio_4'] === $game['game_1']) $winner = true;
                if ($game['premio_5'] == 1 && $resultado['premio_5'] === $game['game_1']) $winner = true;
                if ($winner) $game_winner = true;
            }

            // Centena
            if ($game['modalidade_id'] == 2) {
                $winner = false;
                if ($game['premio_1'] == 1 && substr($resultado['premio_1'], 1) === $game['game_1']) $winner = true;
                if ($game['premio_2'] == 1 && substr($resultado['premio_2'], 1) === $game['game_1']) $winner = true;
                if ($game['premio_3'] == 1 && substr($resultado['premio_3'], 1) === $game['game_1']) $winner = true;
                if ($game['premio_4'] == 1 && substr($resultado['premio_4'], 1) === $game['game_1']) $winner = true;
                if ($game['premio_5'] == 1 && substr($resultado['premio_5'], 1) === $game['game_1']) $winner = true;
                if ($winner) $game_winner = true;
            }

            // Dezena
            if ($game['modalidade_id'] == 3) {
                $winner = false;
                if ($game['premio_1'] == 1 && substr($resultado['premio_1'], 2) === $game['game_1']) $winner = true;
                if ($game['premio_2'] == 1 && substr($resultado['premio_2'], 2) === $game['game_1']) $winner = true;
                if ($game['premio_3'] == 1 && substr($resultado['premio_3'], 2) === $game['game_1']) $winner = true;
                if ($game['premio_4'] == 1 && substr($resultado['premio_4'], 2) === $game['game_1']) $winner = true;
                if ($game['premio_5'] == 1 && substr($resultado['premio_5'], 2) === $game['game_1']) $winner = true;
                if ($winner) $game_winner = true;
            }

            // Grupo
            if ($game['modalidade_id'] == 4) {
                $animal = array_values(array_filter($animais, fn ($animal) => $animal['id'] == $game['game_1']));
                if (sizeof($animal) == 0) continue;
                $animal = $animal[0];
                
                $winner = false;
                if ($game['premio_1'] == 1 && substr($resultado['premio_1'], 2) >= $animal['value_1'] && substr($resultado['premio_1'], 2) <= $animal['value_4']) $winner = true;
                if ($game['premio_2'] == 1 && substr($resultado['premio_2'], 2) >= $animal['value_1'] && substr($resultado['premio_2'], 2) <= $animal['value_4']) $winner = true;
                if ($game['premio_3'] == 1 && substr($resultado['premio_3'], 2) >= $animal['value_1'] && substr($resultado['premio_3'], 2) <= $animal['value_4']) $winner = true;
                if ($game['premio_4'] == 1 && substr($resultado['premio_4'], 2) >= $animal['value_1'] && substr($resultado['premio_4'], 2) <= $animal['value_4']) $winner = true;
                if ($game['premio_5'] == 1 && substr($resultado['premio_5'], 2) >= $animal['value_1'] && substr($resultado['premio_5'], 2) <= $animal['value_4']) $winner = true;
                if ($winner) $game_winner = true;
            }

            // Terno de Dezena
            if ($game['modalidade_id'] == 6) {
                $valor_premio = $game['valor'] * $game['multiplicador'];
                $winner = 0;
                $gameResults = [$game['game_1'], $game['game_2'], $game['game_3']];
                if (in_array(substr($resultado['premio_1'], 2), $gameResults)) $winner = $winner + 1;
                if (in_array(substr($resultado['premio_2'], 2), $gameResults)) $winner = $winner + 1;
                if (in_array(substr($resultado['premio_3'], 2), $gameResults)) $winner = $winner + 1;
                if (in_array(substr($resultado['premio_4'], 2), $gameResults)) $winner = $winner + 1;
                if (in_array(substr($resultado['premio_5'], 2), $gameResults)) $winner = $winner + 1;
                if ($winner >= 3) $game_winner = true;
            }

            // Terno de Grupo
            if ($game['modalidade_id'] == 7) {
                $animals = array_values(array_filter($animais, fn ($animal) => in_array($animal['id'], [$game['game_1'], $game['game_2'], $game['game_3']])));
                if (sizeof($animals) == 0) continue;

                $multiplicador = $premios_quantia == 3 ? $game['multiplicador'] : $game['multiplicador_2'];
                $valor_premio = $game['valor'] * $multiplicador;
                
                $winner = 0;
                foreach ($animals as $animal) {
                    $subWinner = false;
                    if ($game['premio_1'] == 1 && substr($resultado['premio_1'], 2) >= $animal['value_1'] && substr($resultado['premio_1'], 2) <= $animal['value_4']) $subWinner = true;
                    if ($game['premio_2'] == 1 && substr($resultado['premio_2'], 2) >= $animal['value_1'] && substr($resultado['premio_2'], 2) <= $animal['value_4']) $subWinner = true;
                    if ($game['premio_3'] == 1 && substr($resultado['premio_3'], 2) >= $animal['value_1'] && substr($resultado['premio_3'], 2) <= $animal['value_4']) $subWinner = true;
                    if ($game['premio_4'] == 1 && substr($resultado['premio_4'], 2) >= $animal['value_1'] && substr($resultado['premio_4'], 2) <= $animal['value_4']) $subWinner = true;
                    if ($game['premio_5'] == 1 && substr($resultado['premio_5'], 2) >= $animal['value_1'] && substr($resultado['premio_5'], 2) <= $animal['value_4']) $subWinner = true;
                    if ($subWinner) $winner = $winner + 1;
                }
                
                if ($winner === 3) $game_winner = true;
            }

            // Duque de Dezena
            if ($game['modalidade_id'] == 8) {
                $valor_premio = $game['valor'] * $game['multiplicador'];
                $winner = 0;
                $gameResults = [$game['game_1'], $game['game_2']];
                if (in_array(substr($resultado['premio_1'], 2), $gameResults)) $winner = $winner + 1;
                if (in_array(substr($resultado['premio_2'], 2), $gameResults)) $winner = $winner + 1;
                if (in_array(substr($resultado['premio_3'], 2), $gameResults)) $winner = $winner + 1;
                if (in_array(substr($resultado['premio_4'], 2), $gameResults)) $winner = $winner + 1;
                if (in_array(substr($resultado['premio_5'], 2), $gameResults)) $winner = $winner + 1;
                if ($winner >= 2) $game_winner = true;
            }

            // Duque de Grupo
            if ($game['modalidade_id'] == 9) {
                $animals = array_values(array_filter($animais, fn ($animal) => in_array($animal['id'], [$game['game_1'], $game['game_2']])));
                if (sizeof($animals) == 0) continue;
                $valor_premio = $game['valor'] * $game['multiplicador'];
                
                $winner = 0;
                foreach ($animals as $animal) {
                    $subWinner = false;
                    if ($game['premio_1'] == 1 && substr($resultado['premio_1'], 2) >= $animal['value_1'] && substr($resultado['premio_1'], 2) <= $animal['value_4']) $subWinner = true;
                    if ($game['premio_2'] == 1 && substr($resultado['premio_2'], 2) >= $animal['value_1'] && substr($resultado['premio_2'], 2) <= $animal['value_4']) $subWinner = true;
                    if ($game['premio_3'] == 1 && substr($resultado['premio_3'], 2) >= $animal['value_1'] && substr($resultado['premio_3'], 2) <= $animal['value_4']) $subWinner = true;
                    if ($game['premio_4'] == 1 && substr($resultado['premio_4'], 2) >= $animal['value_1'] && substr($resultado['premio_4'], 2) <= $animal['value_4']) $subWinner = true;
                    if ($game['premio_5'] == 1 && substr($resultado['premio_5'], 2) >= $animal['value_1'] && substr($resultado['premio_5'], 2) <= $animal['value_4']) $subWinner = true;
                    if ($subWinner) $winner = $winner + 1;
                }
                
                if ($winner === 2) $game_winner = true;
            }

            if ($game_winner) $gamesWinners[] = ['game_id' => $game['id'], 'resultado_id' => $resultado['id'], 'valor_premio' => $valor_premio];
        }

        BichaoGamesVencedores::insert($gamesWinners);
    }

    public function get_results_json(Request $request) {
        if (!auth()->user()->hasPermissionTo('create_game')) {
            abort(403);
        }
        $data = $request->all();
        $dia = $data['data'][2];
        $mes = $data['data'][1];
        $ano = $data['data'][0];
        $estado_uf = $data['estado'];
        $resultadosDto = [];

        $url = "https://api.pontodobicho.com/results?date=$dia%2F$mes%2F$ano&state=$estado_uf";
        $resultados = json_decode(file_get_contents($url));

        if (!$resultados) return json_encode([]);
        usort($resultados, fn ($a, $b) => $a->time - $b->time);

        foreach ($resultados as $resultado) {
            $timeRaw = explode('.', $resultado->time);
            $hora = str_pad($timeRaw[0], 2, '0', STR_PAD_LEFT);
            $minuto = isset($timeRaw[1]) ? str_pad($timeRaw[1], 2, '0', STR_PAD_RIGHT) : '00';

            $resultadoDto = [
                'date' => $resultado->date,
                'lottery' => $resultado->lottery,
                'time' => $hora.'h'.$minuto,
                'placement' => [],
            ];

            foreach ($resultado->placement as $key => $placement) {
                if ($key > 4) continue;
                $dezena = substr($placement, 2);
                $animal = BichaoAnimals::where('value_1', $dezena)->orWhere('value_2', $dezena)->orWhere('value_3', $dezena)->orWhere('value_4', $dezena)->first();
                if (!$animal) continue;

                $resultadoDto['placement'][] = [
                    'milhar' => $placement,
                    'grupo' => str_pad($animal->id, 2, '0', STR_PAD_LEFT),
                    'bicho' => $animal->name,
                ];
            }

            $resultadosDto[] = $resultadoDto;
        }

        echo json_encode($resultadosDto);
    }

    private function request_api_results($estados, $searchData) {
        if (!auth()->user()->hasPermissionTo('create_game')) {
            abort(403);
        }
        $result = [];

        $mh = curl_multi_init();
        $curl_handles = [];
        foreach ($estados as $estado) {
            $estado_uf = $estado->uf;
            $dia = $searchData[0];
            $mes = $searchData[1];
            $ano = $searchData[2];

            $url = "https://api.pontodobicho.com/results?date=$dia%2F$mes%2F$ano&state=$estado_uf";
            $curl_handles[$estado->id] = curl_init();
            curl_setopt($curl_handles[$estado->id], CURLOPT_URL, $url);
            curl_setopt($curl_handles[$estado->id], CURLOPT_HEADER,0);
            curl_setopt($curl_handles[$estado->id], CURLOPT_RETURNTRANSFER,1);
            curl_multi_add_handle($mh, $curl_handles[$estado->id]);
        }

        $index = null;
        do {
            curl_multi_exec($mh, $index);
        } while($index > 0);

        foreach($curl_handles as $k => $ch) {
            $result[$k] = curl_multi_getcontent($ch);
            curl_multi_remove_handle($mh, $ch);
        }
        curl_multi_close($mh);

        return $result;
    }

    public function get_resultados(Request $request) {
        if (!auth()->user()->hasPermissionTo('create_game')) {
            abort(403);
        }
        $estados = BichaoEstados::get();
        $searchData = explode('-', date('d-m-Y'));
        $resultadosDto = [];
        
        $horariosApi = self::request_api_results($estados, $searchData);

        foreach ($horariosApi as $estado_id => $horarioApi) {
            $result = json_decode($horarioApi);

            if ($result) {
                $horarios = BichaoHorarios::where('estado_id', $estado_id)->get();

                foreach ($result as $game) {
                    $timeRaw = explode('.', $game->time);
                    $hora = str_pad($timeRaw[0], 2, '0', STR_PAD_LEFT);
                    $minuto = isset($timeRaw[1]) ? str_pad($timeRaw[1], 2, '0', STR_PAD_RIGHT) : '00';
                    $searchTime = "$hora:$minuto:00";
                    
                    $horario = array_values(array_filter($horarios->toArray(), fn ($item) => $item['horario'] == $searchTime));
    
                    if (sizeof($horario) > 0 && $horario[0]['banca'] == $game->lottery) {
                        $checkResultExist = BichaoResultados::where('horario_id', $horario[0]['id'])->where('data', date('Y-m-d'))->first();
    
                        if (!$checkResultExist) {
                            $resultadosDto[] = [
                                'horario_id' => $horario[0]['id'],
                                'horario' => $horario[0]['horario'],
                                'premio_1' => $game->placement[0],
                                'premio_2' => $game->placement[1],
                                'premio_3' => $game->placement[2],
                                'premio_4' => $game->placement[3],
                                'premio_5' => $game->placement[4],
                                'data' => date('Y-m-d'),
                            ];
                        }
                    }
                }
            }
        }

        foreach ($resultadosDto as $index => $resultadoDto) {
            unset($resultadoDto['horario']);
            $resultadosDto[$index]['id'] = BichaoResultados::insertGetId($resultadoDto);
        }

        if (sizeof($resultadosDto) > 0) {
            self::get_winners($resultadosDto);
        }
    }
}
