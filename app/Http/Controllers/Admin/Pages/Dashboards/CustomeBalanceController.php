<?php

namespace App\Http\Controllers\Admin\Pages\Dashboards;

use App\Http\Controllers\Controller;
use App\Models\Draw;
use App\Models\Game;
use App\Models\TypeGame;
use App\Models\User;
use Illuminate\Http\Request;

class CustomeBalanceController extends Controller
{
    public function index()
    {
        if (!auth()->user()->hasPermissionTo('read_extract')) {
            abort(403);
        }

        $users = User::orderBy('name')->paginate(10);


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
            array_push($only_ids,$game_user[0]);
        }

        $distinct = array_unique($only_ids);

        foreach($distinct as $d){
            $game = Game::where('id',$d)->first();
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
        $array_ids_games_winners = [];
        $array_games_user_win = [];
        $data_to_view = [];

        foreach ($winners_games as $key => $value) {
            $array_ids_games_winners[$key] = $value[0];
        }

        if($data['initial_date'] == NULL && $data['final_date'] == NULL){
            foreach ($winners_games as $key => $value) {
                if($data['id_user']== $value[1]){
                    $games_user_win = Game::where('id',$value[0])->first();
                    $type_game = TypeGame::where('id',$games_user_win['type_game_id'])->first();
                    array_push($data_to_view,[
                        'competition_id' => $games_user_win['competition_id'],
                        'type_game' => $type_game['name'],
                        'value_game' => $games_user_win['value'],
                        'award_game' => $games_user_win['premio'],
                        'date_game' => $games_user_win['created_at'],
                    ]);
                }
            }
        }else if($data['initial_date'] != NULL && $data['final_date'] != NULL){
            foreach ($winners_games as $key => $value) {
                if($data['id_user']== $value[1]){
                    $games_user_win = Game::where('id',$value[0])
                    ->whereDate('created_at','>=',$data['initial_date'])
                    ->whereDate('created_at','<',$data['final_date'])
                    ->get();

                    foreach($games_user_win as $games){
                        $type_game = TypeGame::where('id',$games['type_game_id'])->first();
                        array_push($data_to_view,[
                            'competition_id' => $games['competition_id'],
                            'type_game' => $type_game['name'],
                            'value_game' => $games['value'],
                            'award_game' => $games['premio'],
                            'date_game' => $games['created_at'],
                        ]);
                    }
                }
            }
        }else{
            return view('admin.pages.dashboards.customer.dashboard-winners');
        }

        return view('admin.pages.dashboards.customer.detailed-view-user',[
            'data' => $data_to_view
        ]);
    }
}
