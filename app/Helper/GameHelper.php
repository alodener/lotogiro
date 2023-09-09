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
    public static function duplicateGame($game , $competitionA, $request, $numbers) {
    
    $copiaGame = new Game();
    if($request->type_client != 1){
        $userclient = User::where('id', $request->client)->first();
            if($userclient != null){
             $clientuser = Client::where('email', $userclient->email)->first();
            }else{
        $clientuser = $request->client;
            }
        if($userclient != null){
        $copiaGame->client_id = $clientuser->id;
        }else{
        $copiaGame->client_id = $request->client;
        }
        }else{
        $copiaGame->client_id = $request->client;
        }
    $copiaGame->user_id = Auth::id();
    $copiaGame->type_game_id = $request->type_game;
    $copiaGame->type_game_value_id = $request->valueId;
    $copiaGame->value = $request->value;
    $copiaGame->premio = $request->premio;
    $copiaGame->numbers = $numbers;
    $copiaGame->competition_id = $competitionA->id;
    $copiaGame->checked = 1;
    $copiaGame->commission_percentage = Auth::user()->commission;

    $copiaGame->save();

    $transact_balance = new TransactBalance;
    $transact_balance->user_id_sender = auth()->id();
    $transact_balance->user_id = auth()->id();
    $transact_balance->value = $request->value;
    $transact_balance->old_value = auth()->user()->balance;
    $transact_balance->value_a = auth()->user()->balance - $request->value;
    $transact_balance->type = 'Compra - Jogo de id: ' . $copiaGame->id . ' do tipo: ' . $copiaGame->type_game_id;
    $transact_balance->save();

    $extract = [
        'type' => 1,
        'value' => $request->value,
        'type_game_id' => $copiaGame->type_game_id,
        'description' => 'Venda - Jogo de id: ' . $copiaGame->id,
        'user_id' => $copiaGame->user_id,
        'client_id' => $copiaGame->client_id
    ];
    $ID_VALUE = auth()->user()->indicador;
    $storeExtact = ExtractController::store($extract);
    $commissionCalculationPai = Commision::calculationPai($copiaGame->commission_percentage, $request->value, $ID_VALUE);
    $commissionCalculation = Commision::calculation($copiaGame->commission_percentage, $request->value);

    $copiaGame->commission_value = $commissionCalculation;
    $copiaGame->commision_value_pai = $commissionCalculationPai;
    $copiaGame->save();


    return $copiaGame;
}
}


?>