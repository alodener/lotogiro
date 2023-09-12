<?php

namespace App\Helper;

use App\Models\Client;
use App\Models\Competition;
use App\Models\Game;
use App\Models\TypeGame;
use App\Models\TypeGameValue;
use App\Models\User;
use App\Models\TransactBalance;
use App\Http\Controllers\Admin\Pages\Dashboards\ExtractController;
use App\Helper\Commision;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class GameHelper
{
    public static function duplicateGame($game , $competitionA, $request, $numbers, $OpcaoJogo) {
        
        if($OpcaoJogo == 1){
            $requestAx = $request->all();
        }


    $copiaGame = new Game();
    if($request['type_client'] != 1){
        $userclient = User::where('id', $request['client'])->first();
            if($userclient != null){
             $clientuser = Client::where('email', $userclient->email)->first();
            }else{
        $clientuser = $request['client'];
            }
        if($userclient != null){
        $copiaGame->client_id = $clientuser->id;
        }else{
        $copiaGame->client_id = $request['client'];
        }
        }else{
        $copiaGame->client_id = $request['client'];
        }
    $copiaGame->user_id = Auth::id();
    $copiaGame->type_game_id = $request['type_game'];
    $copiaGame->type_game_value_id = $request['valueId'];
    $copiaGame->value = $request['value'];
    $copiaGame->premio = $request['premio'];
    $copiaGame->numbers = $numbers;
    $copiaGame->competition_id = $competitionA->id;
    if($game->bet_id != null){
        $copiaGame->bet_id = $game->bet_id;
    }
    $copiaGame->checked = 1;
    $copiaGame->commission_value = 0;
    $copiaGame->commision_value_pai = 0;
    $copiaGame->commission_percentage = Auth::user()->commission;

    $copiaGame->save();


    


    return $copiaGame;
}
}


?>
