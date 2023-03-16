<?php

namespace App\Http\Controllers\Admin\Pages\Dashboards;

use App\Http\Controllers\Controller;
use App\Models\Draw;
use App\Models\Game;
use App\Models\TypeGame;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use PDFDOM;

class CustomeBalanceController extends Controller
{
    public function index()
    {
        if (!auth()->user()->hasPermissionTo('read_extract')) {
            abort(403);
        }
        $users_total_premios = [];

        //$users = User::orderBy('name')->paginate(10);
        $users = User::all();


        return view('admin.pages.dashboards.customer.index', [
            'users' => $users,
            'array_official' => $this->return_array_users_game()
        ]);
    }

    public function lock_account($id)
    {
        if (!auth()->user()->hasPermissionTo('read_extract')) {
            abort(403);
        }

        $user = User::where('id', $id)->first();

        $user['is_active'] = 0;

        $user->save();

        $users = User::all();

        return view('admin.pages.dashboards.customer.index', [
            'users' => $users,
            'array_official' => $this->return_array_users_game()
        ]);
    }

    public function unlock_account($id)
    {
        if (!auth()->user()->hasPermissionTo('read_extract')) {
            abort(403);
        }

        $user = User::where('id', $id)->first();

        $user['is_active'] = 1;

        $user->save();

        $users = User::all();

        return view('admin.pages.dashboards.customer.index', [
            'users' => $users,
            'array_official' => $this->return_array_users_game()
        ]);
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

        $users = User::all();

        return view('admin.pages.dashboards.customer.index', [
            'users' => $users,
            'array_official' => $this->return_array_users_game()
        ]);
    }

    public function contact_made($id)
    {
        if (!auth()->user()->hasPermissionTo('read_extract')) {
            abort(403);
        }

        $user = User::where('id', $id)->first();

        $user['contact_made'] = 1;

        $user->save();

        $users = User::all();

        return view('admin.pages.dashboards.customer.index', [
            'users' => $users,
            'array_official' => $this->return_array_users_game()
        ]);
    }

    public function contact_not_made($id)
    {
        if (!auth()->user()->hasPermissionTo('read_extract')) {
            abort(403);
        }

        $user = User::where('id', $id)->first();

        $user['contact_made'] = 0;

        $user->save();

        $users = User::all();


        return view('admin.pages.dashboards.customer.index', [
            'users' => $users,
            'array_official' => $this->return_array_users_game()
        ]);
    }

    private function return_array_users_game(){
        $draws = Draw::all();

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
            $game = Game::where('id',intval($d))->first();
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

        $users_winners = $this->return_array_users_game();
        $array_users_winners = [];


        foreach ($users_winners as $key => $value) {
            $user = User::where('id', $value[1])->first();
            $array_users_winners[$key] = $user;
        }

        $array_unique_name = array_unique($array_users_winners);

        return view('admin.pages.dashboards.customer.dashboard-winners',[
            'users' => $array_unique_name
        ]);
    }

    public function filter(Request $request){
        if (!auth()->user()->hasPermissionTo('read_extract')) {
            abort(403);
        }
        $data = $request->all();

        $winners_games = $this->return_array_users_game();
        $data_to_view = [];

        $user = User::where('name',$data['user_name'])->first();


        if($data['initial_date'] == NULL && $data['final_date'] == NULL){
            $total_bets_user = Game::where('user_id', $user['id'])->count();
            $total_apostado = Game::where('user_id', $user['id'])->sum('value');
            $total_soma_premios = 0;

            foreach ($winners_games as $key => $value) {
                if($user['id'] == $value[1]){
                    $games_user_win = Game::where('id',$value[0])->first();
                    $type_game = TypeGame::where('id',$games_user_win['type_game_id'])->first();

                    array_push($data_to_view,[
                        'id' => $games_user_win['id'],
                        'competition_id' => $games_user_win['competition_id'],
                        'type_game' => $type_game['name'],
                        'value_game' => $games_user_win['value'],
                        'award_game' => $games_user_win['premio'],
                        'date_game' => $games_user_win['created_at'],
                    ]);
                    $total_soma_premios += $games_user_win['premio'];
                }
            }

            $all_games_user = Game::where('user_id',$user['id'])->get();
            $i = 0;

            foreach($all_games_user as $game_user){
                if($data_to_view[$i] <= count($data_to_view)){
                    if($game_user['id'] != $data_to_view[$i]['id']){
                        $type_game = TypeGame::where('id',$games_user_win['type_game_id'])->first();

                        array_push($data_to_view,[
                            'id' => $game_user['id'],
                            'competition_id' => $game_user['competition_id'],
                            'type_game' => $type_game['name'],
                            'value_game' => $game_user['value'],
                            'award_game' => NULL,
                            'date_game' => $game_user['created_at'],
                        ]);
                    }
                    $i++;
                }

                if($game_user['id'] != $data_to_view[$i]['id']){
                    $type_game = TypeGame::where('id',$games_user_win['type_game_id'])->first();

                    array_push($data_to_view,[
                        'id' => $game_user['id'],
                        'competition_id' => $game_user['competition_id'],
                        'type_game' => $type_game['name'],
                        'value_game' => $game_user['value'],
                        'award_game' => NULL,
                        'date_game' => $game_user['created_at'],
                    ]);
                }
            }
            $lucro_prejuizo =  $total_apostado - $total_soma_premios;

            return view('admin.pages.dashboards.customer.detailed-view-user',[
                'data' => $data_to_view,
                'id_user' => $user['id'],
                'total_bets' => $total_bets_user,
                'total_apostado' => $total_apostado,
                'lucro_prejuizo' => abs($lucro_prejuizo),
                'date_initial' => 0,
                'date_final' => 0
            ]);
        }else if($data['initial_date'] != NULL && $data['final_date'] != NULL){
            $total_apostado = Game::where('user_id', $user['id'])
                ->whereDate('created_at','>=',$data['initial_date'])
                ->whereDate('created_at','<=',$data['final_date'])
                ->sum('value');

            $total_bets_user = Game::where('user_id', $user['id'])
                ->whereDate('created_at','>=',$data['initial_date'])
                ->whereDate('created_at','<=',$data['final_date'])
                ->count();
            $total_soma_premios = 0;

            foreach ($winners_games as $key => $value) {
                if($user['id'] == $value[1]){
                    $games_user_win = Game::where('id',$value[0])
                    ->whereDate('created_at','>=',$data['initial_date'])
                    ->whereDate('created_at','<=',$data['final_date'])
                    ->first();

                    if($games_user_win){
                        $type_game = TypeGame::where('id',$games_user_win['type_game_id'])->first();

                        array_push($data_to_view,[
                            'id' => $games_user_win['id'],
                            'competition_id' => $games_user_win['competition_id'],
                            'type_game' => $type_game['name'],
                            'value_game' => $games_user_win['value'],
                            'award_game' => $games_user_win['premio'],
                            'date_game' => $games_user_win['created_at'],
                        ]);
                        $total_soma_premios += $games_user_win['premio'];
                    }
                }
            }

            $all_games_user = Game::where('user_id',$user['id'])
                ->whereDate('created_at','>=',$data['initial_date'])
                ->whereDate('created_at','<=',$data['final_date'])
                ->get();

            $i = 0;

            foreach($all_games_user as $game_user){
                if($data_to_view[$i] <= count($data_to_view)){
                    if($game_user['id'] != $data_to_view[$i]['id']){
                        $type_game = TypeGame::where('id',$games_user_win['type_game_id'])->first();

                        array_push($data_to_view,[
                            'id' => $game_user['id'],
                            'competition_id' => $game_user['competition_id'],
                            'type_game' => $type_game['name'],
                            'value_game' => $game_user['value'],
                            'award_game' => NULL,
                            'date_game' => $game_user['created_at'],
                        ]);
                    }
                    $i++;
                }

                if($game_user['id'] != $data_to_view[$i]['id']){
                    $type_game = TypeGame::where('id',$games_user_win['type_game_id'])->first();

                    array_push($data_to_view,[
                        'id' => $game_user['id'],
                        'competition_id' => $game_user['competition_id'],
                        'type_game' => $type_game['name'],
                        'value_game' => $game_user['value'],
                        'award_game' => NULL,
                        'date_game' => $game_user['created_at'],
                    ]);
                }
            }

            $lucro_prejuizo =  $total_apostado - $total_soma_premios;

            return view('admin.pages.dashboards.customer.detailed-view-user',[
                'data' => $data_to_view,
                'id_user' => $user['id'],
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

    public function userswinnersAPI(Response $response){
        $users_winners = $this->return_array_users_game();
        $array_users_winners = [];


        foreach ($users_winners as $key => $value) {
            $user = User::where('id', $value[1])->first();
            $array_users_winners[$key] = $user;
        }

        $array_unique_name = array_unique($array_users_winners);

        return response()->json($array_unique_name,200,['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8']);
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
