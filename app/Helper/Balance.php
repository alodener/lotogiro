<?php

namespace App\Helper;

use App\Models\TypeGameValue;
use App\Models\User;
use Carbon\Carbon;
use App\Models\Competition;

class Balance
{
    public static function calculation($typeGameValue)
    {
        $response = false;
        //$typeGameValue = TypeGameValue::find($typeGameValue);

        $balance = auth()->user()->balance;

        //$result = $balance - $typeGameValue->value;
          $result = $balance - $typeGameValue;
        if($result >= 0){
           $user = User::find(auth()->id());
            $user->balance = $result;
            $user->save();

            $response = true;
        }

        return $response;

    }

    public static function calculationByHash($typeGameValue, $user)
    {
        $response = false;
        //$typeGameValue = TypeGameValue::find($typeGameValue);

        $balance = $user->balance;

        $result = $balance - $typeGameValue;

        if($result >= 0){
            /*
            $user = User::find($user->id);
            $user->balance = $result;
            $user->save();*/

            $response = true;
        }

        return $response;

    }
    
    public static function calculationValidation($typeGameValue)
    {
        $response = false;
        $balance = auth()->user()->balance;

        $result = $balance - $typeGameValue;

        if($result >= 0){
            $user = User::find(auth()->id());
            $user->balance = $result;
            $user->save();

            $response = true;
        }

        return $response;

    }
    public static function calculationEstorno($UsuarioEstorno, $typeGameValue)
    {
        $response = false;

        $user = User::find($UsuarioEstorno);

        $balance = $user->balance;
        
        $result = $balance + $typeGameValue;
        if($result >= 0){
           
            $user->balance = $result;
            $user->save();

            $response = true;
        }

        return $response;

    }
  /*  public static function debitBalanceBasedOnGame($game)
    {
        $competition = Competition::find($game->competition_id);
        $competA = substr($competition->number, -1);
       
        if ($competition->type_game_id == 10 && $competA == "A") {
            $valorZerado = 0;
            return static::calculationValidation($valorZerado);
        } 
        else {
            $balance = static::calculationValidation($game->value);
            return $balance;
        }
    }*/
}
