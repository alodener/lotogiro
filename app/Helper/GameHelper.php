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
    public static function duplicateGame($game , $competitionA, $request, $numbers, $OpcaoJogo, $valor, $resultado) {
        
        if($OpcaoJogo == 1){
            $requestAx = $request->all();
        }

        
        $typeGameValue = TypeGameValue::where([
            ['type_game_id', $request['type_game']],
            ['numbers', count(explode(",", $numbers))],
        ])->first();
    
        $maxreais = $typeGameValue ? $typeGameValue->maxreais : 0;
    
        if ($maxreais >= $valor) {
            $resultado = $valor * $typeGameValue->multiplicador;
        } else {
            $resultado = $maxreais * $typeGameValue->multiplicador;
            $valor = $maxreais;
        }
        
        
    $copiaGame = new Game();
    
    $copiaGame->client_id = $game->client_id;
    $copiaGame->user_id = $game->user_id;
    $copiaGame->type_game_id = $request['type_game'];
    $copiaGame->type_game_value_id = $request['valueId'];
    $copiaGame->value = $request['value'];
    $copiaGame->premio = $resultado;
    $copiaGame->numbers = $numbers;
    $copiaGame->competition_id = $competitionA->id;
    if($game->bet_id != null){
        $copiaGame->bet_id = $game->bet_id;
    }
    $copiaGame->checked = 1;
    $copiaGame->commission_value = 0;
    $copiaGame->commision_value_pai = 0;
    $copiaGame->commission_percentage = 0;

    $copiaGame->save();


    


    return $copiaGame;
}
}


?>
