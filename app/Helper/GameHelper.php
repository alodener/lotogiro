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
use Illuminate\Http\Request;



class GameHelper
{
    public static function duplicateGame($game, $competitionA, $request, $typeGame, $numbers, $OpcaoJogo, $valor, $resultado){
        
        if($OpcaoJogo == 1 ||$OpcaoJogo == 2  ){

        $typeGameValue = TypeGameValue::where([
            ['type_game_id', $request['type_game']],
            ['numbers', count(explode(",", $numbers))],
        ])->first();
            
        $maxreais = $typeGameValue ? $typeGameValue->maxreais : 0;
    
        if ($maxreais >= $valor) {
            $resultado = $valor * $typeGameValue->multiplicador ;
        } else {
            $resultado = $maxreais * $typeGameValue->multiplicador;
            $valor = $maxreais;
        }
        
        
    $copiaGame = new Game();    
    $copiaGame->client_id = $game->client_id;
    $copiaGame->user_id = $game->user_id;
    $copiaGame->type_game_id = $request['type_game'];
    $copiaGame->type_game_value_id = $request['valueId'];
    $copiaGame->value = $request['value'] == 0;
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
    $copiaGame->random_game = $game->random_game ?? 0;
    $copiaGame->save();

} else {

        sort($numbers, SORT_NUMERIC);
    
        $numbers = implode(',', $numbers);

        $copiaGame = new Game();
        $copiaGame->client_id = $game->client->id;
        $copiaGame->user_id = $game->user_id;
        $copiaGame->type_game_id = $game->type_game_id;
        $copiaGame->type_game_value_id = $game->type_game_value_id;
        $copiaGame->value = $game->value == 0;
        $copiaGame->premio = $game->premio;
        $copiaGame->numbers = $game->numbers;
        $copiaGame->competition_id = $competitionA->id;
        if($game->bet_id != null){
            $copiaGame->bet_id = $game->bet_id;
        }
        $copiaGame->commission_value = 0;
        $copiaGame->commision_value_pai = 0;
        $copiaGame->commission_percentage = 0;
        $copiaGame->random_game = $game->random_game ?? 0;
        $copiaGame->save();

    }


    


    return $copiaGame;
}
}


?>
