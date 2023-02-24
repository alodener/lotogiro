<?php

namespace App\Http\Controllers\Admin\Pages\Dashboards;

use App\Http\Controllers\Controller;
use App\Models\Draw;
use App\Models\Game;
use App\Models\User;
use Illuminate\Http\Request;

class CustomeBalanceController extends Controller
{
    public function index()
    {
        if (!auth()->user()->hasPermissionTo('read_extract')) {
            abort(403);
        }

        $users = User::all();


        return view('admin.pages.dashboards.customer.index', [
            'users' => $users,
            'array_official' => $this->return_array_users_game()
        ]);
    }

    public function lock_account($id)
    {
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
}
