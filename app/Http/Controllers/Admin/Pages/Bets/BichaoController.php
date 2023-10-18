<?php

namespace App\Http\Controllers\Admin\Pages\Bets;

use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;
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
use App\Helper\BichaoResultadosCrawler;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade as PDF;
use SnappyImage;

class BichaoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private static function getTotalCarrinho($chart)
    {
        return array_reduce($chart, fn ($acc, $item) => (isset($item['teimosinha']) && $item['teimosinha'] >= 1) ? $acc + ($item['value'] * ($item['teimosinha'] + 1)) : $acc + $item['value'], 0);
    }

    public function index()
    {
        if (!auth()->user()->hasPermissionTo('create_game')) {
            abort(403);
        }

        $user_auth = Auth::user();
        $clientId = $user_auth['id'];
        $showList = false;

        $chart = is_array(session('@loteriasbr/chart')) ? session('@loteriasbr/chart') : [];
        $modalidade = BichaoModalidades::where('nome', 'Milhar')->first();
        $estados = BichaoEstados::where('active', 1)->get();

        $totalCarrinho = static::getTotalCarrinho($chart);
        return view('admin.pages.bets.game.bichao.index', compact('clientId','showList','totalCarrinho', 'modalidade', 'chart', 'estados'));
    }

    public function centena()
    {
        if (!auth()->user()->hasPermissionTo('create_game')) {
            abort(403);
        }
        $chart = is_array(session('@loteriasbr/chart')) ? session('@loteriasbr/chart') : [];
        $modalidade = BichaoModalidades::where('nome', 'Centena')->first();
        $estados = BichaoEstados::where('active', 1)->get();
        
        $totalCarrinho = static::getTotalCarrinho($chart);
        return view('admin.pages.bets.game.bichao.centena', compact('modalidade','chart', 'totalCarrinho', 'estados'));
    }

    public function dezena()
    {
        if (!auth()->user()->hasPermissionTo('create_game')) {
            abort(403);
        }
        $chart = is_array(session('@loteriasbr/chart')) ? session('@loteriasbr/chart') : [];
        $modalidade = BichaoModalidades::where('nome', 'Dezena')->first();
        $estados = BichaoEstados::where('active', 1)->get();

        $totalCarrinho = static::getTotalCarrinho($chart);
        return view('admin.pages.bets.game.bichao.dezena', compact('modalidade','chart', 'totalCarrinho', 'estados'));
    }

    public function group()
    {
        if (!auth()->user()->hasPermissionTo('create_game')) {
            abort(403);
        }
        $chart = is_array(session('@loteriasbr/chart')) ? session('@loteriasbr/chart') : [];
        $modalidade = BichaoModalidades::where('nome', 'Grupo')->first();
        $estados = BichaoEstados::where('active', 1)->get();

        $totalCarrinho = static::getTotalCarrinho($chart);
        return view('admin.pages.bets.game.bichao.group', compact('modalidade','chart', 'totalCarrinho', 'estados'));
    }

    public function milhar_centena()
    {
        if (!auth()->user()->hasPermissionTo('create_game')) {
            abort(403);
        }
        $chart = is_array(session('@loteriasbr/chart')) ? session('@loteriasbr/chart') : [];
        $modalidade = BichaoModalidades::where('nome', 'Milhar/Centena')->first();
        $estados = BichaoEstados::where('active', 1)->get();

        $totalCarrinho = static::getTotalCarrinho($chart);
        return view('admin.pages.bets.game.bichao.milhar_centena', compact('modalidade','chart','totalCarrinho', 'estados'));
    }    

    public function quina_grupo()
    {
        if (!auth()->user()->hasPermissionTo('create_game')) {
            abort(403);
        }
        $chart = is_array(session('@loteriasbr/chart')) ? session('@loteriasbr/chart') : [];
        $modalidade = BichaoModalidades::where('nome', 'Quina de Grupos')->first();
        $estados = BichaoEstados::where('active', 1)->get();

        $totalCarrinho = static::getTotalCarrinho($chart);
        return view('admin.pages.bets.game.bichao.quina_grupo', compact('modalidade','chart', 'totalCarrinho', 'estados'));
    }

    public function quadra_grupo()
    {
        if (!auth()->user()->hasPermissionTo('create_game')) {
            abort(403);
        }
        $chart = is_array(session('@loteriasbr/chart')) ? session('@loteriasbr/chart') : [];
        $modalidade = BichaoModalidades::where('nome', 'Quadra de Grupos')->first();
        $estados = BichaoEstados::where('active', 1)->get();

        $totalCarrinho = static::getTotalCarrinho($chart);
        return view('admin.pages.bets.game.bichao.quadra_grupo', compact('modalidade','chart', 'totalCarrinho', 'estados'));
    }

    public function terno_grupo()
    {
        if (!auth()->user()->hasPermissionTo('create_game')) {
            abort(403);
        }
        $chart = is_array(session('@loteriasbr/chart')) ? session('@loteriasbr/chart') : [];
        $modalidade = BichaoModalidades::where('nome', 'Terno de Grupos')->first();
        $estados = BichaoEstados::where('active', 1)->get();

        $totalCarrinho = static::getTotalCarrinho($chart);
        return view('admin.pages.bets.game.bichao.terno_grupo', compact('modalidade','chart', 'totalCarrinho', 'estados'));
    }

    public function duque_grupo()
    {
        if (!auth()->user()->hasPermissionTo('create_game')) {
            abort(403);
        }
        $chart = is_array(session('@loteriasbr/chart')) ? session('@loteriasbr/chart') : [];
        $modalidade = BichaoModalidades::where('nome', 'Duque de Grupo')->first();
        $estados = BichaoEstados::where('active', 1)->get();

        $totalCarrinho = static::getTotalCarrinho($chart);
        return view('admin.pages.bets.game.bichao.duque_grupo', compact('modalidade','chart', 'totalCarrinho', 'estados'));
    }

    public function terno_dezena()
    {
        if (!auth()->user()->hasPermissionTo('create_game')) {
            abort(403);
        }
        $chart = is_array(session('@loteriasbr/chart')) ? session('@loteriasbr/chart') : [];
        $modalidade = BichaoModalidades::where('nome', 'Terno de Dezena')->first();
        $estados = BichaoEstados::where('active', 1)->get();

        $totalCarrinho = static::getTotalCarrinho($chart);
        return view('admin.pages.bets.game.bichao.terno_dezena', compact('modalidade','chart', 'totalCarrinho', 'estados'));
    }

    public function duque_dezena()
    {
        if (!auth()->user()->hasPermissionTo('create_game')) {
            abort(403);
        }
        $chart = is_array(session('@loteriasbr/chart')) ? session('@loteriasbr/chart') : [];
        $modalidade = BichaoModalidades::where('nome', 'Duque de Dezena')->first();
        $estados = BichaoEstados::where('active', 1)->get();

        $totalCarrinho = static::getTotalCarrinho($chart);
        return view('admin.pages.bets.game.bichao.duque_dezena', compact('modalidade','chart', 'totalCarrinho', 'estados'));
    }

    public function unidade()
    {
        if (!auth()->user()->hasPermissionTo('create_game')) {
            abort(403);
        }
        $chart = is_array(session('@loteriasbr/chart')) ? session('@loteriasbr/chart') : [];
        $modalidade = BichaoModalidades::where('nome', 'Unidade')->first();
        $estados = BichaoEstados::where('active', 1)->get();

        $totalCarrinho = static::getTotalCarrinho($chart);
        return view('admin.pages.bets.game.bichao.unidade', compact('modalidade','chart', 'totalCarrinho', 'estados'));
    }

    public function milhar_invertida()
    {
        if (!auth()->user()->hasPermissionTo('create_game')) {
            abort(403);
        }
        $chart = is_array(session('@loteriasbr/chart')) ? session('@loteriasbr/chart') : [];
        $modalidade = BichaoModalidades::where('nome', 'Milhar Invertida')->first();
        $estados = BichaoEstados::where('active', 1)->get();
        $game_limit = $modalidade->bet_limit;

        $totalCarrinho = static::getTotalCarrinho($chart);
        return view('admin.pages.bets.game.bichao.milhar_invertida', compact('modalidade','chart', 'totalCarrinho', 'estados', 'game_limit'));
    }

    public function centena_invertida()
    {
        if (!auth()->user()->hasPermissionTo('create_game')) {
            abort(403);
        }
        $chart = is_array(session('@loteriasbr/chart')) ? session('@loteriasbr/chart') : [];
        $modalidade = BichaoModalidades::where('nome', 'Centena Invertida')->first();
        $estados = BichaoEstados::where('active', 1)->get();
        $game_limit = $modalidade->bet_limit;

        $totalCarrinho = static::getTotalCarrinho($chart);
        return view('admin.pages.bets.game.bichao.centena_invertida', compact('modalidade','chart', 'totalCarrinho', 'estados', 'game_limit'));
    }

    public function cotacao(Response $response)
    {
        if (!auth()->user()->hasPermissionTo('create_game')) {
            abort(403);
        }
        $cotacoes = BichaoModalidades::orderBy('multiplicador', 'DESC')->get();
        $chart = is_array(session('@loteriasbr/chart')) ? session('@loteriasbr/chart') : [];
        $estados = BichaoEstados::where('active', 1)->get();

        $totalCarrinho = static::getTotalCarrinho($chart);

        return view('admin.pages.bets.game.bichao.cotacao',compact('cotacoes', 'chart', 'estados', 'totalCarrinho'));
    }

    public function settings(Response $response)
    {
        if (!auth()->user()->hasPermissionTo('read_user')) {
            abort(403);
        }
        $cotacoes = BichaoModalidades::get();
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
        $premio_maximo = $data['premio_maximo'];
        $bet_limit = $data['bet_limit'];

        foreach ($estados as $estado) {
            BichaoEstados::where('id', $estado['id'])->update(['active' => $estado['active']]);
        }

        foreach ($cotacoes as $cotacao) {
            if ($cotacao['id'] == '7b') {
                BichaoModalidades::where('id', 7)->update(['multiplicador_2' => $cotacao['value']]);
            } elseif ($cotacao['id'] == '6b') {
                BichaoModalidades::where('id', 6)->update(['multiplicador_2' => $cotacao['value']]);
            } elseif ($cotacao['id'] == '10b') {
                BichaoModalidades::where('id', 10)->update(['multiplicador_2' => $cotacao['value']]);
            } elseif ($cotacao['id'] == '11b') {
                BichaoModalidades::where('id', 11)->update(['multiplicador_2' => $cotacao['value']]);
            } else {
                BichaoModalidades::where('id', $cotacao['id'])->update(['multiplicador' => $cotacao['value']]);
            }
        }

        foreach ($premio_maximo as $premio) {
            BichaoModalidades::where('id', $premio['id'])->update(['premio_maximo' => $premio['value']]);
        }

        foreach ($bet_limit as $invertida_limit) {
            BichaoModalidades::where('id', $invertida_limit['id'])->update(['bet_limit' => $invertida_limit['value']]);
        }

        return json_encode(['status' => 'ok']);
    }

    public function my_bets(Request $request) {
        if (!auth()->user()->hasPermissionTo('create_game')) {
            abort(403);
        }

        $startAt = $request->has('startAt') ? $request->input('startAt') : date('Y-m-01');
        $endAt = $request->has('endAt') ? $request->input('endAt') : date('Y-m-d');
        $perPage = $request->has('perPage') ? $request->input('perPage') : 10;

        $chart = is_array(session('@loteriasbr/chart')) ? session('@loteriasbr/chart') : [];
        $estados = BichaoEstados::where('active', 1)->get();

        $totalCarrinho = static::getTotalCarrinho($chart);

        $apostas = BichaoGames::select('bichao_games.*', 'bh.horario', 'bh.banca', 'bm.nome as modalidade_nome', 'bm.multiplicador', 'bm.multiplicador_2', 'c.name as cliente_nome', 'c.last_name as cliente_sobrenome', 'c.ddd as cliente_ddd', 'c.phone as cliente_phone')
            ->join('clients as c', 'c.id', 'bichao_games.client_id')
            ->join('bichao_modalidades as bm', 'bm.id', 'bichao_games.modalidade_id')
            ->join('bichao_horarios as bh', 'bh.id', 'bichao_games.horario_id')
            ->where('bichao_games.user_id', Auth()->user()->id)
            ->whereDate('bichao_games.created_at','>=', $startAt)
            ->whereDate('bichao_games.created_at','<=', $endAt)
            ->orderBy('bichao_games.created_at', 'DESC')
            ->paginate($perPage);

        return view('admin.pages.bets.game.bichao.minhas_apostas', [
            'apostas' => $apostas,
            'perPage' => $perPage,
            'startAt' => $startAt,
            'endAt' => $endAt,
            'chart' => $chart,
            'estados' => $estados,
            'totalCarrinho' => $totalCarrinho
        ]);
    }

    public function bets_reports(Request $request) {
        if (!auth()->user()->hasPermissionTo('create_game')) {
            abort(403);
        }

        $startAt = $request->has('search_date_start') ? $request->input('search_date_start') : date('Y-m-01');
        $endAt = $request->has('search_date_end') ? $request->input('search_date_end') : date('Y-m-d');

        $apostas = BichaoGames::select('bichao_games.*', 'bh.horario', 'bh.banca', 'bm.nome as modalidade_nome', 'bm.multiplicador', 'bm.multiplicador_2', 'c.name as cliente_nome', 'c.last_name as cliente_sobrenome', 'c.ddd as cliente_ddd', 'c.phone as cliente_phone')
            ->join('clients as c', 'c.id', 'bichao_games.client_id')
            ->join('bichao_modalidades as bm', 'bm.id', 'bichao_games.modalidade_id')
            ->join('bichao_horarios as bh', 'bh.id', 'bichao_games.horario_id')
            ->where('bichao_games.user_id', Auth()->user()->id)
            ->whereDate('bichao_games.created_at','>=', $startAt)
            ->whereDate('bichao_games.created_at','<=', $endAt)
            ->orderBy('bichao_games.created_at', 'DESC')
            ->get();

        $data = [
            'startAt' => $startAt,
            'endAt' => $endAt,
            'apostas' => $apostas,
        ];

        $pdf = PDF::loadView('admin.layouts.pdf.betsBichao', $data)->output();

        $fileName = 'Relatório de Apostas Bichão ' . Carbon::parse($startAt)->format('d-m-Y') . ' ate '. Carbon::parse($endAt)->format('d-m-Y') . '.pdf';

        return response()->streamDownload(
            fn() => print($pdf),
            $fileName,
            ['Content-Disposition' => 'attachment; filename='. $fileName. ';', 'Content-Type'  => 'application/octet-stream']
        );
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
        $startAt = $request->has('startAt') ? $request->input('startAt') : date('Y-m-01');
        $endAt = $request->has('endAt') ? $request->input('endAt') : date('Y-m-d');
        $perPage = $request->has('perPage') ? $request->input('perPage') : 10;

        $apostas = BichaoGames::select('bichao_games.*', 'bgv.valor_premio', 'bgv.id as id_premio', 'bgv.payment', 'bh.horario', 'bh.banca', 'bm.nome as modalidade_nome', 'c.name as cliente_nome', 'c.last_name as cliente_sobrenome', 'c.pix')
            ->join('bichao_games_vencedores as bgv', 'bgv.game_id', 'bichao_games.id')
            ->join('clients as c', 'c.id', 'bichao_games.client_id')
            ->join('bichao_modalidades as bm', 'bm.id', 'bichao_games.modalidade_id')
            ->join('bichao_horarios as bh', 'bh.id', 'bichao_games.horario_id')
            ->whereDate('bichao_games.created_at','>=', $startAt)
            ->whereDate('bichao_games.created_at','<=', $endAt)
            ->orderBy('bichao_games.created_at', 'DESC')
            ->paginate($perPage);

        return view('admin.pages.bets.game.bichao.draws', [
            'apostas' => $apostas,
            'perPage' => $perPage,
            'startAt' => $startAt,
            'endAt' => $endAt,
        ]);
    }

    public function draws_reports(Request $request) {
        $data = $request->all();

        $startAt = $request->has('search_date_start') ? $request->input('search_date_start') : date('Y-m-d');
        $endAt = $request->has('search_date_end') ? $request->input('search_date_end') : date('Y-m-d');

        $games = BichaoGames::select('bichao_games.*', 'bgv.valor_premio', 'bgv.id as id_premio', 'bgv.payment', 'bh.horario', 'bh.banca', 'bm.nome as modalidade_nome')
            ->join('bichao_games_vencedores as bgv', 'bgv.game_id', 'bichao_games.id')
            ->join('bichao_modalidades as bm', 'bm.id', 'bichao_games.modalidade_id')
            ->join('bichao_horarios as bh', 'bh.id', 'bichao_games.horario_id')
            ->whereDate('bichao_games.created_at','>=', $startAt)
            ->whereDate('bichao_games.created_at','<=', $endAt)
            ->with(['user', 'client'])
            ->get();
        
        $collection = new Collection();
        foreach ($games as $game) {
            $collection = $collection->push($game->toArray());
        }
        $collection = $collection->sortByDesc('client.name')->groupBy('user.name');

        $data = [
            'startAt' => $startAt,
            'endAt' => $endAt,
            'collection' => $collection,
            'subtotal' => 0,
            'total' => 0
        ];

        $pdf = PDF::loadView('admin.layouts.pdf.drawsBichao', $data)->output();

        $fileName = 'Relatório de Prêmios Bichão ' . Carbon::parse($startAt)->format('d-m-Y') . ' ate '. Carbon::parse($endAt)->format('d-m-Y') . '.pdf';

        return response()->streamDownload(
            fn() => print($pdf),
            $fileName,
            ['Content-Disposition' => 'attachment; filename='. $fileName. ';', 'Content-Type'  => 'application/octet-stream']
        );
    }

    public function results(){
        if (!auth()->user()->hasPermissionTo('create_game')) {
            abort(403);
        }

        $chart = is_array(session('@loteriasbr/chart')) ? session('@loteriasbr/chart') : [];
        $estados = BichaoEstados::where('active', 1)->get();
        $totalCarrinho = static::getTotalCarrinho($chart);

        return view('admin.pages.bets.game.bichao.resultados', compact('chart', 'totalCarrinho', 'estados'));
    }

    public function get_premio_maximo_json(Request $request) {
        $data = $request->all();

        if (isset($data['modalidade_id']) && isset($data['game'])) {
            $modalidade = BichaoModalidades::where('id', $data['modalidade_id'])->first();
            $premio_maximo = $modalidade->premio_maximo;

            echo json_encode(['premio_maximo' => $premio_maximo > 0 ? $premio_maximo : 0]);
            exit;
        }

        echo json_encode(['premio_maximo' => 0]);
        exit;
    }

    private static function get_premio_maximo($modalidade_id, $horario_id, $game_value, $created_at = false) {
        $modalidade = BichaoModalidades::where('id', $modalidade_id)->first();
        $premio_maximo = $modalidade->premio_maximo;

        $dataAtual = date('Y-m-d');
        $horaAtual = date('H:i:s');

        if ($created_at) {
            $dataAtual = date('Y-m-d', strtotime($created_at));
        }

        $log = $premio_maximo;
        $game_log = $game_value;
        $teste = [];

        $games = BichaoGames::select('bichao_games.*', 'bichao_games_vencedores.valor_premio', 'bichao_horarios.horario', 'bichao_modalidades.multiplicador', 'bichao_modalidades.multiplicador_2')
            ->join('bichao_horarios', 'bichao_horarios.id', '=', 'bichao_games.horario_id')
            ->join('bichao_modalidades', 'bichao_modalidades.id', '=', 'bichao_games.modalidade_id')
            ->leftJoin('bichao_games_vencedores', 'bichao_games_vencedores.game_id', 'bichao_games.id')
            ->where('bichao_games.created_at', '>=', $dataAtual.' 00:00:00')
            ->where('bichao_games.created_at', '<=', $dataAtual.' 23:59:59')
            ->where('bichao_modalidades.id', $modalidade_id)
            ->where('bichao_games.horario_id', $horario_id)
            ->get()
            ->toArray();
        
        foreach ($games as $game) {
            $apostas = [];

            if (strval($game['game_1']) > 0) $apostas[] = $game['game_1'];
            if (strval($game['game_2']) > 0) $apostas[] = $game['game_2'];
            if (strval($game['game_3']) > 0) $apostas[] = $game['game_3'];
            if (strval($game['game_4']) > 0) $apostas[] = $game['game_4'];
            if (strval($game['game_5']) > 0) $apostas[] = $game['game_5'];
            sort($apostas);

            $game_value = explode('-', $game_value);
            sort($game_value);
            $game_value = str_pad(join('-', $game_value), 2, 0, STR_PAD_LEFT);

            $aposta = str_pad(join('-', $apostas), 2, 0, STR_PAD_LEFT);
            $teste[] = $aposta;

            if ($game_value != $aposta) continue;
            if ($game['valor_premio']) {
                $premio_maximo = $premio_maximo - $game['valor_premio'];
            } else {
                if ($horaAtual > $game['horario']) {
                    $resultado = BichaoResultados::where('created_at', '>=', $dataAtual.' 00:00:00')->where('horario_id', $game['horario_id']);
                    if ($resultado) continue;
                }

                $premios_quantia = 0;
                if ($game['premio_1'] == 1) $premios_quantia = $premios_quantia  + 1;
                if ($game['premio_2'] == 1) $premios_quantia = $premios_quantia  + 1;
                if ($game['premio_3'] == 1) $premios_quantia = $premios_quantia  + 1;
                if ($game['premio_4'] == 1) $premios_quantia = $premios_quantia  + 1;
                if ($game['premio_5'] == 1) $premios_quantia = $premios_quantia  + 1;
    
                $valor_premio = $game['valor'] * $game['multiplicador'] / $premios_quantia;
    
                if ($modalidade_id == 6 || $modalidade_id == 8 || $modalidade_id == 9) {
                    $valor_premio = $game['valor'] * $game['multiplicador'];
                }
    
                if ($modalidade_id == 7) {
                    $multiplicador = $premios_quantia == 3 ? $game['multiplicador'] : $game['multiplicador_2'];
                    $valor_premio = $game['valor'] * $multiplicador;
                }
    
                $premio_maximo = $premio_maximo - $valor_premio;
            }
        }
        return $premio_maximo;

    }

    public function add_in_chart(Request $request) {
        if (!auth()->user()->hasPermissionTo('create_game')) {
            abort(403);
        }
        $data = $request->all();

        $chart = is_array(session('@loteriasbr/chart')) ? session('@loteriasbr/chart') : [];

        if (auth()->user()->type_client == 1) {
            $client = Client::where('email', auth()->user()->email)->first();
            if (!$client) {
                echo json_encode(['status' => 400]);
                exit;
            }

            $data['item']['client_id'] = $client->id;
        }

        if (isset($data['item']['game_id'])) {
            $db_game = BichaoGames::where('id', $data['item']['game_id'])->first();
            $apostas = [];
            $premios = [];
            
            if (strval($db_game->game_1) > 0) $apostas[] = $db_game->game_1;
            if (strval($db_game->game_2) > 0) $apostas[] = $db_game->game_2;
            if (strval($db_game->game_3) > 0) $apostas[] = $db_game->game_3;
            if (strval($db_game->game_4) > 0) $apostas[] = $db_game->game_4;
            if (strval($db_game->game_5) > 0) $apostas[] = $db_game->game_5;

            if ($db_game->premio_1 == 1) $premios[] = 1;
            if ($db_game->premio_2 == 1) $premios[] = 2;
            if ($db_game->premio_3 == 1) $premios[] = 3;
            if ($db_game->premio_4 == 1) $premios[] = 4;
            if ($db_game->premio_5 == 1) $premios[] = 5;

            $modalidade = BichaoModalidades::where('id', $db_game->modalidade_id)->first();

            $data['item'] = [
                'award_type' => $premios,
                'client_id' => $db_game->client_id,
                'game' => str_pad(join('-', $apostas), 2, 0, STR_PAD_LEFT),
                'modality' => $modalidade->nome,
                'value' => $db_game->valor,
                'teimosinha' => isset($data['item']['teimosinha']) && $data['item']['teimosinha'] >=1 ? $data['item']['teimosinha'] : 0,
            ];
        }

        $games = explode(',', $data['item']['game']);
        if ($data['item']['modality'] === 'Milhar/Centena') {
            foreach ($games as $game) {
                $value = floatval($data['item']['value']) / 2;

                $chartDto = $data['item'];
                $chartDto['value'] = $value;
                $chartDto['modality'] ='Milhar';
                $chartDto['game'] = $game;
                $chart[] = $chartDto;

                $chartDto['modality'] ='Centena';
                $chartDto['game'] = substr($game, 1);
                $chart[] = $chartDto;
            }
        } else {
            foreach ($games as $game) {
                $data['item']['game'] = $game;
                $chart[] = $data['item'];
            }
        }
        
        session(['@loteriasbr/chart' => $chart]);
        
        session()->flash('success', 'Adicionado com sucesso.');

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

        session()->flash('success', 'Jogo removido com sucesso.');

        echo json_encode(['status' => 200]);
    }

    public function remove_all_chart() {
        if (!auth()->user()->hasPermissionTo('create_game')) {
            abort(403);
        }

        session(['@loteriasbr/chart' => []]);

        session()->flash('success', 'Carrinho limpo.');

        echo json_encode(['status' => 200]);
    }

    public function pay_prize(Request $request) {
        if (!auth()->user()->hasPermissionTo('create_game')) {
            abort(403);
        }
        $data = $request->all();

        BichaoGamesVencedores::where('id', $data['id'])->update(['payment' => 1]);

        session()->flash('success', 'Prêmio pago com sucesso');

        echo json_encode(['status' => 200]);
    }

    private static function getFatorialInvertidoMilhar($game) {
        $game = array_unique(str_split($game));
        if (count($game) === 1) return 1;
        if (count($game) === 2) return 4;
        if (count($game) === 3) return 12;
        if (count($game) === 4) return 24;
        if (count($game) === 5) return 120;
        if (count($game) === 6) return 360;
        if (count($game) === 7) return 840;
        return 1680;
    }

    private static function getFatorialInvertidoCentena($game) {
        $game = array_unique(str_split($game));
        if (count($game) === 1) return 1;
        if (count($game) === 2) return 3;
        if (count($game) === 3) return 6;
        if (count($game) === 4) return 24;
        if (count($game) === 5) return 60;
        if (count($game) === 6) return 120;
        return 210;
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
            $created_at = date('Y-m-d H:i:s');
            $weekDay = date('w', strtotime($created_at));

            if ($modalidade) {
                $modalidades[$modalidade->id] = $modalidade->nome;
                $checkout[] = [
                    'modalidade_id' => $modalidade->id,
                    'client_id' => $chart['client_id'],
                    'user_id' => Auth()->user()->id,
                    'horario_id' => $data['horario_id'],
                    'valor' => floatval($chart['value']),
                    'comission_payment' => 0,
                    'game_1' => isset($games[0]) ? $games[0] : null,
                    'game_2' => isset($games[1]) ? $games[1] : null,
                    'game_3' => isset($games[2]) ? $games[2] : null,
                    'game_4' => isset($games[3]) ? $games[3] : null,
                    'game_5' => isset($games[4]) ? $games[4] : null,
                    'premio_1' => in_array(1, $chart['award_type']),
                    'premio_2' => in_array(2, $chart['award_type']),
                    'premio_3' => in_array(3, $chart['award_type']),
                    'premio_4' => in_array(4, $chart['award_type']),
                    'premio_5' => in_array(5, $chart['award_type']),
                    'created_at' => $created_at,
                ];

                if (isset($chart['teimosinha']) && $chart['teimosinha'] >= 1) {
                    $horario = BichaoHorarios::where('id', $data['horario_id'])->first();

                    for ($i = 0; $i < $chart['teimosinha']; $i++) {
                        $date_check = false;
                        while (!$date_check) {
                            $created_at = date('Y-m-d H:i:s', strtotime("$created_at +1 day"));
                            $weekDay = date('w', strtotime($created_at));

                            if ($horario->banca === 'FEDERAL') {
                                if ($weekDay !== '3' && $weekDay !== '6') continue;
                            }

                            if ($horario->banca === 'PTN-RIO') {
                                if ($weekDay === '3' || $weekDay === '6') continue;
                            }

                            if ($horario->banca === 'LOOK' && $horario->horario === '18:20:00') {
                                if ($weekDay === '3' || $weekDay === '6') continue;
                            }
        
                            if ($horario->banca === 'BA' && $horario->horario === '19:00:00') {
                                if ($weekDay === '3' || $weekDay === '6') continue;
                            }

                            $date_check = true;
                            $checkout[] = [
                                'modalidade_id' => $modalidade->id,
                                'client_id' => $chart['client_id'],
                                'user_id' => Auth()->user()->id,
                                'horario_id' => $data['horario_id'],
                                'valor' => floatval($chart['value']),
                                'comission_payment' => 0,
                                'game_1' => isset($games[0]) ? $games[0] : null,
                                'game_2' => isset($games[1]) ? $games[1] : null,
                                'game_3' => isset($games[2]) ? $games[2] : null,
                                'game_4' => isset($games[3]) ? $games[3] : null,
                                'game_5' => isset($games[4]) ? $games[4] : null,
                                'premio_1' => in_array(1, $chart['award_type']),
                                'premio_2' => in_array(2, $chart['award_type']),
                                'premio_3' => in_array(3, $chart['award_type']),
                                'premio_4' => in_array(4, $chart['award_type']),
                                'premio_5' => in_array(5, $chart['award_type']),
                                'created_at' => $created_at,
                            ];
                        }

                    }
                }
            }
        }

        $oldBalance = auth()->user()->balance;

        $balance = Balance::calculation(array_reduce($checkout, fn ($acc, $item) => $acc + $item['valor'], 0));
        if (!$balance) return json_encode(['status' => false, 'message' => 'Saldo insuficiente.']);

        foreach ($checkout as $index => $checkoutDto) {
            $checkout[$index]['status'] = true;
            $apostas = [];
            $premios = [];
            
            if (strval($checkout[$index]['game_1']) > 0) $apostas[] = $checkout[$index]['game_1'];
            if (strval($checkout[$index]['game_2']) > 0) $apostas[] = $checkout[$index]['game_2'];
            if (strval($checkout[$index]['game_3']) > 0) $apostas[] = $checkout[$index]['game_3'];
            if (strval($checkout[$index]['game_4']) > 0) $apostas[] = $checkout[$index]['game_4'];
            if (strval($checkout[$index]['game_5']) > 0) $apostas[] = $checkout[$index]['game_5'];

            if ($checkout[$index]['premio_1'] == 1) $premios[] = 1;
            if ($checkout[$index]['premio_2'] == 1) $premios[] = 2;
            if ($checkout[$index]['premio_3'] == 1) $premios[] = 3;
            if ($checkout[$index]['premio_4'] == 1) $premios[] = 4;
            if ($checkout[$index]['premio_5'] == 1) $premios[] = 5;

            $checkout[$index]['modalidade'] = BichaoModalidades::where('id', $checkout[$index]['modalidade_id'])->first();

            $premioMaximo = $checkout[$index]['valor'] * $checkout[$index]['modalidade']->multiplicador / sizeof($premios);
            
            if ($checkout[$index]['modalidade_id'] == 8 || $checkout[$index]['modalidade_id'] == 9) {
                $premioMaximo = $checkout[$index]['valor'] * $checkout[$index]['modalidade']->multiplicador;
            }
            if ($checkout[$index]['modalidade_id'] == 6 || $checkout[$index]['modalidade_id'] == 7) {
                $premioMaximo = sizeof($premios) == 3 ? $checkout[$index]['valor'] * $checkout[$index]['modalidade']->multiplicador : $checkout[$index]['valor'] * $checkout[$index]['modalidade']->multiplicador_2;
            }
            if ($checkout[$index]['modalidade_id'] == 13) {
                $divider = static::getFatorialInvertidoMilhar($checkout[$index]['game_1']);
                $premioMaximo = ($checkout[$index]['valor'] / $divider) * $checkout[$index]['modalidade']->multiplicador;
            }
            if ($checkout[$index]['modalidade_id'] == 14) {
                $divider = static::getFatorialInvertidoCentena($checkout[$index]['game_1']);
                $premioMaximo = ($checkout[$index]['valor'] / $divider) * $checkout[$index]['modalidade']->multiplicador;
            }

            $checkout[$index]['aposta'] = str_pad(join(' - ', $apostas), 2, 0, STR_PAD_LEFT);
            $premio_maximo_db = self::get_premio_maximo($checkout[$index]['modalidade_id'], $checkout[$index]['horario_id'], str_pad(join('-', $apostas), 2, 0, STR_PAD_LEFT), $checkout[$index]['created_at']);
            if ($premio_maximo_db < $premioMaximo) {
                $checkout[$index]['status'] = false;
                $checkout[$index]['error'] = 'No momento, atingimos o limite de prêmios pra essa modalidade. Tente novamente mais tarde, ou no próximo sorteio.';
                if ($premio_maximo_db > 0) {
                    $premio_restante = number_format($premio_maximo_db, 2, ",", ".");
                    $checkout[$index]['error'] = "O prêmio máximo disponível para essa modalidade é de R$ $premio_restante. Ajuste o valor da sua aposta.";
                }
                continue;
            }

            $checkout[$index]['id'] = BichaoGames::insertGetId($checkoutDto);
            $checkout[$index]['aposta'] = str_pad(join(' - ', $apostas), 2, 0, STR_PAD_LEFT);
            $checkout[$index]['aposta'] = $checkout[$index]['modalidade_id'] !== 12 ? str_pad(join(' - ', $apostas), 2, 0, STR_PAD_LEFT) : $checkout[$index]['game_1'];
            $checkout[$index]['premio_maximo'] = $premioMaximo;
            $checkout[$index]['horario'] = BichaoHorarios::where('id', $checkout[$index]['horario_id'])->first();
            $checkout[$index]['client'] = Client::where('id', $checkout[$index]['client_id'])->first();
            $checkout[$index]['emitido_em'] = Carbon::parse($checkout[$index]['created_at'])->format('d/m/Y H:i:s');
        }

        foreach ($checkout as $checkoutItem) {
            if ($checkoutItem['status'] == false) continue;

            $transact_balance = new TransactBalance;
            $transact_balance->user_id_sender = auth()->id();
            $transact_balance->user_id = auth()->id();
            $transact_balance->value = $checkoutItem['valor'];
            $transact_balance->old_value = $oldBalance;
            $transact_balance->type = 'Compra Bichão - Jogo de id: ' . $checkoutItem['id'] . ' do tipo: ' . $modalidades[$checkoutItem['modalidade_id']];
            $transact_balance->save();

            $extract = [
                'type' => 10, // 1 para jogos gerais, 10 para bichao
                'value' => $checkoutItem['valor'],
                'type_game_id' => $checkoutItem['modalidade_id'],
                'description' => 'Venda - Jogo de id: ' . $checkoutItem['id'],
                'user_id' => $checkoutItem['user_id'],
                'client_id' => $checkoutItem['client_id']
            ];

            $ID_VALUE = auth()->user()->indicador;
            $storeExtact = ExtractController::store($extract);
            $commissions = Commision::calculationNew($checkoutItem['valor'], $checkoutItem['user_id'], 'bichao', $checkoutItem['modalidade_id']);

            BichaoGames::where('id', $checkoutItem['id'])->update(['commission_percentage' => $commissions['percentage'], 'comission_value' => $commissions['commission'], 'comission_value_pai' => $commissions['commission_pai'], 'comission_value_avo' => $commissions['commission_avo']]);
        }

        session(['@loteriasbr/chart' => []]);

        session()->flash('success', 'Jogos cadastrados com sucesso.');

        echo json_encode(['status' => true, 'chart' => $checkout]);
    }

    public function getReceipt($id, $tipo = 'txt')
    {
        if (!auth()->user()->hasPermissionTo('create_game')) {
            abort(403);
        }
        $game = BichaoGames::select('bichao_games.*', 'bgv.id as vencedor_id', 'bh.horario', 'bh.banca', 'bm.nome as modalidade_nome', 'bm.multiplicador', 'bm.multiplicador_2', 'c.name as cliente_nome', 'c.last_name as cliente_sobrenome', 'c.cpf as cliente_cpf', 'c.email as cliente_email')
            ->join('clients as c', 'c.id', 'bichao_games.client_id')
            ->join('bichao_modalidades as bm', 'bm.id', 'bichao_games.modalidade_id')
            ->join('bichao_horarios as bh', 'bh.id', 'bichao_games.horario_id')
            ->leftJoin('bichao_games_vencedores as bgv', 'bgv.game_id', 'bichao_games.id')
            ->where('bichao_games.id', $id)
            ->first();

        $apostas = [];
        $premios = [];

        if (strval($game->game_1) > 0) $apostas[] = $game->game_1;
        if (strval($game->game_2) > 0) $apostas[] = $game->game_2;
        if (strval($game->game_3) > 0) $apostas[] = $game->game_3;
        if (strval($game->game_4) > 0) $apostas[] = $game->game_4;
        if (strval($game->game_5) > 0) $apostas[] = $game->game_5;

        if ($game->premio_1 == 1) $premios[] = 1;
        if ($game->premio_2 == 1) $premios[] = 2;
        if ($game->premio_3 == 1) $premios[] = 3;
        if ($game->premio_4 == 1) $premios[] = 4;
        if ($game->premio_5 == 1) $premios[] = 5;

        $premioMaximo = $game->valor * $game->multiplicador / sizeof($premios);
        
        if ($game->modalidade_id == 8 || $game->modalidade_id == 9) {
            $premioMaximo = $game->valor * $game->multiplicador;
        }
        if ($game->modalidade_id == 6 || $game->modalidade_id == 7) {
            $premioMaximo = sizeof($premios) == 3 ? $game->valor * $game->multiplicador : $game->valor * $game->multiplicador_2;
        }
        
        global $data;
        $data = [
            'game' => $game,
            'prize' => $game->vencedor_id > 0 ? 1 : 0,
            'aposta' => str_pad(join(' - ', $apostas), 2, 0, STR_PAD_LEFT),
            'premios' => join('°, ', $premios),
            'premio_maximo' => $premioMaximo,
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

    private static function checkInvertidaWinner($game, $resultado) {
        $game = str_split($game);
        $resultado = str_split($resultado);
        foreach ($game as $game) {
            $key = array_search($game, $resultado);
            if ($key >= 0) unset($resultado[$key]);
        }
        return count($resultado) === 0;
    }

    private static function get_winners($resultados) {
        $dataAtual = date('Y-m-d');
        $horaAtual = date('H:i:s');
        $dataAnterior = date('Y-m-d', strtotime('-24 hours'));
        $dataSeguinte = date('Y-m-d', strtotime('+24 hours'));

        $games = BichaoGames::select('bichao_games.*', 'bichao_horarios.horario', 'bichao_modalidades.multiplicador', 'bichao_modalidades.multiplicador_2')
            ->join('bichao_horarios', 'bichao_horarios.id', '=', 'bichao_games.horario_id')
            ->join('bichao_modalidades', 'bichao_modalidades.id', '=', 'bichao_games.modalidade_id')
            ->where('bichao_games.created_at', '>=', $dataAnterior. ' 00:00:00')
            ->where('bichao_games.created_at', '<=', $dataAtual.' 23:59:59')
            ->get()
            ->toArray();
        $animais = BichaoAnimals::get()->toArray();
        $gamesWinners = [];

        foreach ($games as $game) {
            $resultado = array_values(array_filter($resultados, fn ($resultado) => $resultado['horario_id'] == $game['horario_id']));
            if (sizeof($resultado) == 0) continue;
            $resultado = $resultado[0];
            $horaGame = Date('H:i:s', strtotime($game['created_at']));
            $datetimeGame = Date('Y-m-d H:i:s', strtotime($game['created_at']));
            
            if ($horaGame > $game['horario']) {
                $resultadoPeriodoInicio = $dataAnterior.' '.$resultado['horario'];
                $resultadoPeriodoFim = $dataAtual.' '.$resultado['horario'];
                if ($datetimeGame <= $resultadoPeriodoInicio || $datetimeGame >= $resultadoPeriodoFim) continue;
            } else {
                $resultadoPeriodoInicio = $dataAnterior.' '.$resultado['horario'];
                $resultadoPeriodoFim = $dataSeguinte.' '.$resultado['horario'];
                if ($datetimeGame <= $resultadoPeriodoInicio || $datetimeGame >= $resultadoPeriodoFim) continue;
            }

            $premios_quantia = 0;
            if ($game['premio_1'] == 1) $premios_quantia = $premios_quantia  + 1;
            if ($game['premio_2'] == 1) $premios_quantia = $premios_quantia  + 1;
            if ($game['premio_3'] == 1) $premios_quantia = $premios_quantia  + 1;
            if ($game['premio_4'] == 1) $premios_quantia = $premios_quantia  + 1;
            if ($game['premio_5'] == 1) $premios_quantia = $premios_quantia  + 1;

            $valor_premio = $game['valor'] * $game['multiplicador'] / $premios_quantia;
            $game_winner = false;

            // Milhar
            if ($game['modalidade_id'] == 1) {
                $winner = false;
                if ($game['premio_1'] == 1 && $resultado['premio_1'] === $game['game_1']) $winner = true;
                if ($game['premio_2'] == 1 && $resultado['premio_2'] === $game['game_1']) $winner = true;
                if ($game['premio_3'] == 1 && $resultado['premio_3'] === $game['game_1']) $winner = true;
                if ($game['premio_4'] == 1 && $resultado['premio_4'] === $game['game_1']) $winner = true;
                if ($game['premio_5'] == 1 && $resultado['premio_5'] === $game['game_1']) $winner = true;
                if ($winner) $game_winner = true;
            }

            // Milhar Invertida
            if ($game['modalidade_id'] == 13) {
                $divider = static::getFatorialInvertidoMilhar($game['game_1']);
                $valor_premio = ($game['valor'] / $divider) * $game['multiplicador'] / $premios_quantia;

                $winner = 0;
                if ($game['premio_1'] == 1 && static::checkInvertidaWinner($game['game_1'], $resultado['premio_1'])) $winner += 1;
                if ($game['premio_2'] == 1 && static::checkInvertidaWinner($game['game_1'], $resultado['premio_2'])) $winner += 1;
                if ($game['premio_3'] == 1 && static::checkInvertidaWinner($game['game_1'], $resultado['premio_3'])) $winner += 1;
                if ($game['premio_4'] == 1 && static::checkInvertidaWinner($game['game_1'], $resultado['premio_4'])) $winner += 1;
                if ($game['premio_5'] == 1 && static::checkInvertidaWinner($game['game_1'], $resultado['premio_5'])) $winner += 1;
                if ($winner > 0) {
                    $game_winner = true;
                    $valor_premio = number_format($valor_premio * $game_winner, 2, ".", "");
                }
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

            // Centena Invertida
            if ($game['modalidade_id'] == 14) {
                $divider = static::getFatorialInvertidoCentena($game['game_1']);
                $valor_premio = ($game['valor'] / $divider) * $game['multiplicador'] / $premios_quantia;

                $winner = 0;
                if ($game['premio_1'] == 1 && static::checkInvertidaWinner($game['game_1'], substr($resultado['premio_1'], 1))) $winner += 1;
                if ($game['premio_2'] == 1 && static::checkInvertidaWinner($game['game_1'], substr($resultado['premio_2'], 1))) $winner += 1;
                if ($game['premio_3'] == 1 && static::checkInvertidaWinner($game['game_1'], substr($resultado['premio_3'], 1))) $winner += 1;
                if ($game['premio_4'] == 1 && static::checkInvertidaWinner($game['game_1'], substr($resultado['premio_4'], 1))) $winner += 1;
                if ($game['premio_5'] == 1 && static::checkInvertidaWinner($game['game_1'], substr($resultado['premio_5'], 1))) $winner += 1;
                if ($winner > 0) {
                    $game_winner = true;
                    $valor_premio = number_format($valor_premio * $game_winner, 2, ".", "");
                }
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

            // Unidade
            if ($game['modalidade_id'] == 12) {
                $winner = false;
                if ($game['premio_1'] == 1 && substr($resultado['premio_1'], 3) === $game['game_1']) $winner = true;
                if ($game['premio_2'] == 1 && substr($resultado['premio_2'], 3) === $game['game_1']) $winner = true;
                if ($game['premio_3'] == 1 && substr($resultado['premio_3'], 3) === $game['game_1']) $winner = true;
                if ($game['premio_4'] == 1 && substr($resultado['premio_4'], 3) === $game['game_1']) $winner = true;
                if ($game['premio_5'] == 1 && substr($resultado['premio_5'], 3) === $game['game_1']) $winner = true;
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
                $multiplicador = $premios_quantia == 3 ? $game['multiplicador'] : $game['multiplicador_2'];

                $valor_premio = $game['valor'] * $multiplicador;
                $winner = 0;
                $gameResults = [$game['game_1'], $game['game_2'], $game['game_3']];
                if (in_array(substr($resultado['premio_1'], 2), $gameResults)) $winner = $winner + 1;
                if (in_array(substr($resultado['premio_2'], 2), $gameResults)) $winner = $winner + 1;
                if (in_array(substr($resultado['premio_3'], 2), $gameResults)) $winner = $winner + 1;
                if (in_array(substr($resultado['premio_4'], 2), $gameResults)) $winner = $winner + 1;
                if (in_array(substr($resultado['premio_5'], 2), $gameResults)) $winner = $winner + 1;
                if ($winner >= 3) $game_winner = true;
            }

            // Quina de Grupo
            if ($game['modalidade_id'] == 11) {
                $animals = array_values(array_filter($animais, fn ($animal) => in_array($animal['id'], [$game['game_1'], $game['game_2'], $game['game_3'], $game['game_4'], $game['game_5']])));
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
                
                if ($winner === 5) $game_winner = true;
            }

            // Quadra de Grupo
            if ($game['modalidade_id'] == 10) {
                $animals = array_values(array_filter($animais, fn ($animal) => in_array($animal['id'], [$game['game_1'], $game['game_2'], $game['game_3'], $game['game_4']])));
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
                
                if ($winner === 4) $game_winner = true;
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

    private static function get_results_db($horarios, $dia, $mes, $ano) {
        $resultados = BichaoResultados::whereIn('horario_id', $horarios_id)->where('created_at', "$ano-$mes-$dia")->get();
        return $resultados;
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
            if ($estado_uf === 'PO' && $resultado->lottery === 'INSTANTANEA') continue;
            if ($estado_uf !== 'PO' && $resultado->lottery === 'FEDERAL') continue;
            $timeRaw = explode('.', $resultado->time);
            $hora = str_pad($timeRaw[0], 2, '0', STR_PAD_LEFT);
            $minuto = isset($timeRaw[1]) ? str_pad($timeRaw[1], 2, '0', STR_PAD_RIGHT) : '00';

            $resultadoDto = [
                'date' => $resultado->date,
                'lottery' => $resultado->lottery,
                'time' => $hora.'h'.$minuto,
                'placement' => []
            ];

            if (!isset($resultado->empty)) {
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
            }

            $resultadosDto[] = $resultadoDto;
        }

        echo json_encode($resultadosDto);
    }

    public function get_results_json_new(Request $request) {
        if (!auth()->user()->hasPermissionTo('create_game')) {
            abort(403);
        }
        $data = $request->all();
        $dia = $data['data'][2];
        $mes = $data['data'][1];
        $ano = $data['data'][0];
        $estado_uf = $data['estado'];
        $resultadosDto = [];

        $estado = BichaoEstados::where('uf', $estado_uf)->first();
        $horarios = BichaoHorarios::where('estado_id', $estado->id)->get()->toArray();

        // $horarios_id = array_map(fn ($horario) => $horario['id'], $horarios);

        // $resultados = BichaoResultadosCrawler::getResults($estado_uf, $dia, $mes, $ano);
        $resultados = static::get_results_db($horarios, $dia, $mes, $ano);
        echo json_encode($resultados);exit;

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
        $result = [];

        $mh = curl_multi_init();
        $curl_handles = [];
        foreach ($estados as $estado) {
            $estado_uf = $estado->uf;
            $dia = $searchData[0];
            $mes = $searchData[1];
            $ano = $searchData[2];

            $resultados = BichaoResultadosCrawler::getResults($estado_uf, $dia, $mes, $ano);
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
        $estados = BichaoEstados::where('uf', '!=', 'FED')->get();
        $searchData = explode('-', date('d-m-Y'));
        $resultadosDto = [];

        $horariosApi = self::request_api_results($estados, $searchData);
        foreach ($horariosApi as $estado_id => $horarioApi) {
            $result = json_decode($horarioApi);

            if ($result) {
                $horarios = BichaoHorarios::where('estado_id', $estado_id)->get();
                
                foreach ($result as $game) {
                    if ($estado_id == 1 && $game->lottery == 'FEDERAL') {
                        $estadoFed = BichaoEstados::where('uf', 'FED')->first();
                        $horarios = BichaoHorarios::where('estado_id', $estadoFed->id)->get();
                    }
                    $timeRaw = explode('.', $game->time);
                    $hora = str_pad($timeRaw[0], 2, '0', STR_PAD_LEFT);
                    $minuto = isset($timeRaw[1]) ? str_pad($timeRaw[1], 2, '0', STR_PAD_RIGHT) : '00';
                    $searchTime = "$hora:$minuto:00";
                    
                    $horario = array_values(array_filter($horarios->toArray(), fn ($item) => $item['horario'] == $searchTime));

                    if (sizeof($horario) > 0 && $horario[0]['banca'] == $game->lottery) {
                        $checkResultExist = BichaoResultados::where('horario_id', $horario[0]['id'])->where('created_at', date('Y-m-d'))->first();

                        if (!$checkResultExist && (!isset($game->empty) || $game->empty != 1)) {
                            $resultadosDto[] = [
                                'horario_id' => $horario[0]['id'],
                                'horario' => $horario[0]['horario'],
                                'premio_1' => $game->placement[0],
                                'premio_2' => $game->placement[1],
                                'premio_3' => $game->placement[2],
                                'premio_4' => $game->placement[3],
                                'premio_5' => $game->placement[4],
                                'created_at' => date('Y-m-d'),
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

        echo 'ok';
        exit;
    }

    public function get_resultados_new(Request $request) {
        $estados = BichaoEstados::get();
        $searchData = explode('-', date('d-m-Y'));
        $dia = $searchData[0];
        $mes = $searchData[1];
        $ano = $searchData[2];
        $resultadosDto = [];

        foreach ($estados as $estado) {
            $estado_id = $estado->id;
            $estado_uf = $estado->uf;
            if ($estado_uf === 'FED') $estado_uf = 'PO';
            $result = BichaoResultadosCrawler::getResults($estado_uf, $dia, $mes, $ano);

            if ($result) {
                $horarios = BichaoHorarios::where('estado_id', $estado_id)->get();
                
                foreach ($result as $game) {
                    $timeRaw = explode('.', $game->time);
                    $hora = str_pad($timeRaw[0], 2, '0', STR_PAD_LEFT);
                    $minuto = isset($timeRaw[1]) ? str_pad($timeRaw[1], 2, '0', STR_PAD_RIGHT) : '00';
                    $searchTime = "$hora:$minuto:00";
                    
                    $horario = array_values(array_filter($horarios->toArray(), fn ($item) => $item['horario'] == $searchTime));

                    if (sizeof($horario) > 0 && $horario[0]['banca'] == $game->lottery) {
                        $checkResultExist = BichaoResultados::where('horario_id', $horario[0]['id'])->where('created_at', date('Y-m-d'))->first();

                        if (!$checkResultExist && (!isset($game->empty) || $game->empty != 1)) {
                            $resultadosDto[] = [
                                'horario_id' => $horario[0]['id'],
                                'horario' => $horario[0]['horario'],
                                'premio_1' => $game->placement[0],
                                'premio_2' => $game->placement[1],
                                'premio_3' => $game->placement[2],
                                'premio_4' => $game->placement[3],
                                'premio_5' => $game->placement[4],
                                'created_at' => date('Y-m-d'),
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

        echo 'ok';
        exit;
    }
}
