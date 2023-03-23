<?php

namespace App\Http\Controllers\Admin\Pages\Dashboards;

use App\Http\Controllers\Controller;
use App\Models\Draw;
use App\Models\Game;
use App\Models\TypeGame;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use PDFDOM;

class CustomeBalanceController extends Controller
{
    public function index(Request $request)
    {
        if (!auth()->user()->hasPermissionTo('read_extract')) {
            abort(403);
        }
        $users_total_premios = [];
        $intervalo = $request->has('intervalo') ? $request->input('intervalo') : 30;
        $buscaIntervalo = now()->subDays($intervalo)->endOfDay();
        $perPage = $request->has('perPage') ? $request->input('perPage') : 10;
        $userType = $request->has('userType') ? $request->input('userType') : 'consultor';

        $userTypeDb = $userType === 'cliente' ? 'client_id' : 'user_id';

        $users = User::query();
        if ($request->has('user')) $users->where('id', $request->input('user'));

        $users = $users->orderBy('name')->paginate($perPage);
        foreach ($users as $index => $user) {
            $total_jogos = Game::where($userTypeDb, $user->id)->whereDate('created_at','>=', $buscaIntervalo)->count('value');
            $total_apostado = Game::where($userTypeDb, $user->id)->whereDate('created_at','>=', $buscaIntervalo)->sum('value');

            $total_soma_premios = 0;
            foreach ($this->return_user_games($user, $userTypeDb, $buscaIntervalo) as $games) {
                $total_premio = floatval($games->premio);
                $total_soma_premios += $total_premio;
            }

            $users[$index]->total_jogos = $total_jogos;
            $users[$index]->total_apostado = $total_apostado;
            $users[$index]->total_soma_premios = $total_soma_premios;
            $users[$index]->lucro_prejuizo = $total_soma_premios - $total_apostado;
        }

        return view('admin.pages.dashboards.customer.index', [
            'users' => $users,
            'perPage' => $perPage,
            'userType' => $userType,
            'intervalo' => $intervalo,
        ]);
    }

    private function return_user_games($user, $user_type, $buscaStart = null, $buscaEnd = null) {
        $games = [];
        $result = [];

        $gamesQuery = Game::query();
        if ($buscaStart !== null) $gamesQuery->whereDate('games.created_at','>=', $buscaStart);
        if ($buscaEnd !== null) $gamesQuery->whereDate('games.created_at','<=', $buscaEnd);

        $draws = Draw::query();
        foreach ($gamesQuery->select('games.*', 'users.name as client_name', 'users.last_name as client_last_name')->leftJoin('users', 'users.id', '=', 'games.client_id')->where($user_type, $user->id)->get() as $game) {
            $id = $game->id;
            $games[$id] = $game;
            $draws->orWhereRaw("games LIKE '%$id%'");
        }
        $draws = $draws->get();
        foreach ($draws as $draw) {
            $values = explode(',', $draw->games);
            $check = array_intersect(explode(',', $draw->games), array_keys($games));
            while (sizeof($check) > 0) {
                array_push($result, $games[array_shift($check)]);
            }
        }
        return $result;
    }

    public function lock_account($id)
    {
        if (!auth()->user()->hasPermissionTo('read_extract')) {
            abort(403);
        }

        $user = User::where('id', $id)->first();

        $user['is_active'] = 0;

        $user->save();

        return redirect()->route('admin.dashboards.customer.balance');
    }

    public function unlock_account($id)
    {
        if (!auth()->user()->hasPermissionTo('read_extract')) {
            abort(403);
        }

        $user = User::where('id', $id)->first();

        $user['is_active'] = 1;

        $user->save();

        return redirect()->route('admin.dashboards.customer.balance');
    }

    public function save_changes(Request $request, $id)
    {
        if (!auth()->user()->hasPermissionTo('read_extract')) {
            abort(403);
        }

        $data = $request->all();
        $user = User::where('id', $id)->first();

        $user['commission'] = $data['commission'];
        $user->save();

        return redirect()->route('admin.dashboards.customer.balance');
    }

    public function contact_made($id)
    {
        if (!auth()->user()->hasPermissionTo('read_extract')) {
            abort(403);
        }

        $user = User::where('id', $id)->first();

        $user['contact_made'] = 1;

        $user->save();

        return redirect()->route('admin.dashboards.customer.balance');
    }

    public function contact_not_made($id)
    {
        if (!auth()->user()->hasPermissionTo('read_extract')) {
            abort(403);
        }

        $user = User::where('id', $id)->first();

        $user['contact_made'] = 0;

        $user->save();

        return redirect()->route('admin.dashboards.customer.balance');
    }

    private function return_array_users_game(){
        $draws = Draw::take(5)->get();

        $array_draw_games = [];
        $array_aux_games_id = [];
        $only_ids = [];
        $array_official = [];

        foreach ($draws as $draw) {
            if ($draw['games'] == null) {
                continue;
            }
            array_push($array_draw_games, $draw['games']);
        }

        foreach($array_draw_games as $draw_game) {
            array_push($array_aux_games_id,explode(',', $draw_game));
        }

        foreach($array_aux_games_id as $game_user){
            foreach($game_user as $g){
                array_push($only_ids,$g);
            }
        }

        foreach($only_ids as $d){
            $game = Game::where('id', intval($d))->first();
            if(!$game){
                continue;
            }
            array_push($array_official,[
                $game['id'],
                $game['user_id']
            ]);
        }

        return $array_official;
    }

    public function dashboard_winners(){
        if (!auth()->user()->hasPermissionTo('read_extract')) {
            abort(403);
        }

        return view('admin.pages.dashboards.customer.dashboard-winners');
    }

    public function filter(Request $request){
        if (!auth()->user()->hasPermissionTo('read_extract')) {
            abort(403);
        }
        $data = $request->all();

        $data_to_view = [];

        $user_id = $data['client_id'] > 0 ? $data['client_id'] : $data['user_id'];
        $user_type = $data['client_id'] > 0 ? 'client_id' : 'user_id';
        
        $user = User::where('id', $user_id)->first();
        $winners_games = $this->return_user_games($user, $user_type, $data['initial_date'], $data['final_date']);

        if($data['initial_date'] == NULL && $data['final_date'] == NULL){
            $total_bets_user = Game::where($user_type, $user['id'])->count();
            $total_apostado = Game::where($user_type, $user['id'])->sum('value');
            $total_soma_premios = 0;

            foreach ($winners_games as $game) {
                $type_game = TypeGame::where('id', $game['type_game_id'])->first();

                array_push($data_to_view, [
                    'id' => $game['id'],
                    'competition_id' => $game['competition_id'],
                    'type_game' => $type_game['name'],
                    'value_game' => $game['value'],
                    'award_game' => $game['premio'],
                    'client_name' => $game['client_name'] . ' ' . $game['client_last_name'],
                    'date_game' => $game['created_at'],
                ]);

                $total_soma_premios += $game['premio'];
            }

            $lucro_prejuizo =  $total_apostado - $total_soma_premios;

            return view('admin.pages.dashboards.customer.detailed-view-user',[
                'data' => $data_to_view,
                'id_user' => $user['id'],
                'user' => $user,
                'total_bets' => $total_bets_user,
                'total_apostado' => $total_apostado,
                'lucro_prejuizo' => abs($lucro_prejuizo),
                'date_initial' => 0,
                'date_final' => 0
            ]);
        }else if($data['initial_date'] != NULL && $data['final_date'] != NULL){
            $total_apostado = Game::where($user_type, $user['id'])
                ->whereDate('created_at','>=',$data['initial_date'])
                ->whereDate('created_at','<=',$data['final_date'])
                ->sum('value');

            $total_bets_user = Game::where($user_type, $user['id'])
                ->whereDate('created_at','>=',$data['initial_date'])
                ->whereDate('created_at','<=',$data['final_date'])
                ->count();
            $total_soma_premios = 0;

            foreach ($winners_games as $game) {
                $games_user_win = Game::select('games.*', 'type_games.name as type_name')
                    ->where('games.id', $game->id)
                    ->whereDate('games.created_at','>=',$data['initial_date'])
                    ->whereDate('games.created_at','<=',$data['final_date'])
                    ->join('type_games', 'type_games.id', '=', 'type_game_id')
                    ->first();

                if($games_user_win){
                    array_push($data_to_view,[
                        'id' => $games_user_win['id'],
                        'competition_id' => $games_user_win['competition_id'],
                        'type_game' => $games_user_win['type_name'],
                        'value_game' => $games_user_win['value'],
                        'award_game' => $games_user_win['premio'],
                        'client_name' => $game['client_name'] . ' ' . $game['client_last_name'],
                        'date_game' => $games_user_win['created_at'],
                    ]);
                    $total_soma_premios += $games_user_win['premio'];
                }
            }

            $lucro_prejuizo =  $total_apostado - $total_soma_premios;

            return view('admin.pages.dashboards.customer.detailed-view-user',[
                'data' => $data_to_view,
                'id_user' => $user['id'],
                'user' => $user,
                'total_bets' => $total_bets_user,
                'total_apostado' => $total_apostado,
                'lucro_prejuizo' => $lucro_prejuizo,
                'date_initial' => $data['initial_date'],
                'date_final' => $data['final_date'],
            ]);
        }else{
            return view('admin.pages.dashboards.customer.dashboard-winners');
        }
    }

    public function userswinnersAPI(Response $response, Request $request) {
        $users = Game::select('users.*')
            ->join('users', 'users.id', '=', 'games.user_id')
            ->where('users.name', 'LIKE', '%'.$request->input('busca').'%')
            ->orWhere('users.last_name', 'LIKE', '%'.$request->input('busca').'%')
            ->orWhere('users.email', 'LIKE', '%'.$request->input('busca').'%')
            ->orderBy('users.name')
            ->distinct()
            ->take(10)->get();

        return response()->json($users,200,['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8']);
    }

    public function userswinnersClientesAPI(Response $response, Request $request) {
        $users = Game::select('users.*')
            ->join('users', 'users.id', '=', 'games.client_id')
            ->where('games.user_id', $request->input('user_id'))
            ->where(function($q) use ($request) {
                $q->where('users.name', 'LIKE', '%'.$request->input('busca').'%')
                ->orWhere('users.last_name', 'LIKE', '%'.$request->input('busca').'%')
                ->orWhere('users.email', 'LIKE', '%'.$request->input('busca').'%');
            })
            ->orderBy('users.name')
            ->distinct()
            ->take(10)->get();

        return response()->json($users,200,['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8']);
    }

    public function get_pdf($id, $date_initial, $date_final){
        if (!auth()->user()->hasPermissionTo('read_extract')) {
            abort(403);
        }
        $winners_games = $this->return_array_users_game();
        $array_ids_games_winners = [];
        $array_games_user_win = [];
        $data_to_view = [];
        $games_win_flag = 0;

        $user = User::where('id', $id)->first();

        foreach ($winners_games as $key => $value) {
            $array_ids_games_winners[$key] = $value[0];
        }

        if($date_initial == 0 && $date_final == 0){
            $total_bets_user = Game::where('user_id', $user['id'])->count();
            $total_apostado = Game::where('user_id', $user['id'])->sum('value');
            $total_soma_premios = 0;

            foreach ($winners_games as $key => $value) {
                if($user['id']== $value[1]){
                    $games_user_win = Game::where('id',$value[0])->first();
                    $type_game = TypeGame::where('id',$games_user_win['type_game_id'])->first();

                    array_push($data_to_view,[
                        'competition_id' => $games_user_win['competition_id'],
                        'type_game' => $type_game['name'],
                        'value_game' => $games_user_win['value'],
                        'award_game' => $games_user_win['premio'],
                        'date_game' => $games_user_win['created_at'],
                    ]);
                    $total_soma_premios += $games_user_win['premio'];
                }
            }

            $all_games_user = Game::where('id','!=', $games_user_win['id'])
            ->where('user_id',$user['id'])
            ->get();

            foreach ($all_games_user as $games) {
                array_push($data_to_view,[
                    'competition_id' => $games['competition_id'],
                    'type_game' => $type_game['name'],
                    'value_game' => $games['value'],
                    'award_game' => NULL,
                    'date_game' => $games['created_at'],
                ]);
            }

            $lucro_prejuizo = $total_soma_premios - $total_apostado;
        }else{
            $total_apostado = Game::where('user_id', $user['id'])
            ->whereDate('created_at','>=',$date_initial)
            ->whereDate('created_at','<=',$date_final)
            ->sum('value');

            $total_soma_premios = 0;

            $total_bets_user = Game::where('user_id', $user['id'])
                ->whereDate('created_at','>=',$date_initial)
                ->whereDate('created_at','<=',$date_final)
                ->count();

            foreach ($winners_games as $key => $value) {
                if($user['id']== $value[1]){
                    try {
                        $games_user_win = Game::where('id',$value[0])
                        ->whereDate('created_at','>=',$date_initial)
                        ->whereDate('created_at','<=',$date_final)
                        ->first();

                    } catch (\Throwable $th) {
                        break;
                    }

                    if($games_user_win == NULL){
                        $games_win_flag = 0;
                        break;
                    }

                    $games_win_flag = 1;

                    $type_game = TypeGame::where('id',$games_user_win['type_game_id'])->first();

                    array_push($array_games_user_win,$games_user_win['id']);

                    array_push($data_to_view,[
                    'competition_id' => $games_user_win['competition_id'],
                    'type_game' => $type_game['name'],
                    'value_game' => $games_user_win['value'],
                    'award_game' => $games_user_win['premio'],
                    'date_game' => $games_user_win['created_at'],
                    ]);

                    $total_soma_premios += $games_user_win['premio'];
                }
            }

            if($games_win_flag == 0){
                $all_games_user = Game::where('user_id', $user['id'])
                    ->whereDate('created_at','>=',$date_initial)
                    ->whereDate('created_at','<=',$date_final)
                    ->get();

                foreach ($all_games_user as $games) {
                    array_push($data_to_view,[
                    'competition_id' => $games['competition_id'],
                    'type_game' => TypeGame::where('id',$games['type_game_id'])->first()['name'],
                    'value_game' => $games['value'],
                    'award_game' => NULL,
                    'date_game' => $games['created_at'],
                    ]);
                }
            }else{
                $all_games_user = Game::where('user_id', $user['id'])
                ->whereDate('created_at','>=',$date_initial)
                ->whereDate('created_at','<=',$date_final)
                ->whereNotIn('id',$array_games_user_win)
                ->get();

                foreach ($all_games_user as $games) {
                    array_push($data_to_view,[
                        'competition_id' => $games['competition_id'],
                        'type_game' => TypeGame::where('id',$games_user_win['type_game_id'])->first()['name'],
                        'value_game' => $games['value'],
                        'award_game' => NULL,
                        'date_game' => $games['created_at'],
                    ]);
                }
            }
            $lucro_prejuizo = $total_soma_premios - $total_apostado;
        }

        $pdf = PDFDOM::loadView('admin.pages.dashboards.customer.dashboard-user-pdf', compact('data_to_view'));

        return $pdf->setPaper('a4')->download('Relatório Análise_Detalhada.pdf');
    }
}
?>
