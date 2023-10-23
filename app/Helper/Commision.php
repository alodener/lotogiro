<?php

namespace App\Helper;
use App\Models\User;
class Commision
{
    public static function calculation($percentage, $value)
    {
        $value = ($value / 100) * $percentage;

        return $value;
    }
    public static function Estornocalculation($percentage, $value)
    {
    $value = ($value / -100) *  $percentage;
 
        return $value;
        
    }

    private static function getCommission($user, $type_id, $game_type, $lvl = 0)
    {
        $percentage = $user->commission;
        $commission_individual = json_decode($user->commission_individual);
        if ($game_type === 'bichao') $commission_individual = json_decode($user->commission_individual_bichao);

        if ($lvl === 1) {
            $percentage = $user->commission_lv_1;
            $commission_individual = json_decode($user->commission_individual_lv_1);
            if ($game_type === 'bichao') $commission_individual = json_decode($user->commission_individual_bichao_lv_1);
        }

        if ($lvl === 2) {
            $percentage = $user->commission_lv_2;
            $commission_individual = json_decode($user->commission_individual_lv_2);
            if ($game_type === 'bichao') $commission_individual = json_decode($user->commission_individual_bichao_lv_2);
        }

        if (is_array($commission_individual)) {
            $check = array_filter($commission_individual, fn ($value) => $value->type_id == $type_id);
            if (sizeof($check) > 0) {
                $percentage = $check[0]->commission;
            }
        }

        return $percentage;
    }

    public static function calculationNew($value, $user_id, $game_type, $type_id)
    {
        $user = User::find($user_id);
        if (!$user) return 0;

        $percentage = static::getCommission($user, $type_id, $game_type);
        $commission = (($value / 100) * $percentage);
        $commission_pai = 0;
        $commission_avo = 0;

        $user->bonus = $user->bonus + $commission;
        $user->save();

        $userLv1 = User::find($user->indicador);
        if ($userLv1) {
            $commission_pai = (($value / 100) * static::getCommission($userLv1, $type_id, $game_type, 1));
            $userLv1->bonus = $userLv1->bonus + $commission_pai;
            $userLv1->save();

            $userLv2 = User::find($userLv1->indicador);
            if ($userLv2) {
                $commission_avo = (($value / 100) * static::getCommission($userLv2, $type_id, $game_type, 2));
                $userLv2->bonus = $userLv2->bonus + $commission_avo;
                $userLv2->save();
            }
        }

        return ['percentage' => $percentage, 'commission' => $commission, 'commission_pai' => $commission_pai, 'commission_avo' => $commission_avo];
    }

    public static function calculationPai($percentage, $value, $ID_VALUE, $user = false){

        $typeClient = $user ? $user->type_client : auth()->user()->type_client;
        $valorPai = 0;
        if($ID_VALUE != null){
            $userPai = User::find($ID_VALUE);
            $comPai = $userPai->commission;
            if ($typeClient == 1) {
                $commission = 10;
                $valor = ($value / 100) * $commission;
                $valorPai = $valor;
                $result = $userPai->bonus + $valor;
                $userPai->bonus = $result;
                $userPai->save();
            } else {
                if ($comPai = $userPai->commission == 15) {
                    $idAvo = $userPai->indicador; 
                    $userAvo = User::find($idAvo);
                    if($idAvo == 1) {
                        $perPai = 4.35;
                        $valorPai = ($value / 100) * $perPai;
                        $result = $userPai->bonus + $valorPai;
                        $userPai->bonus = $result;
                        $userPai->save();

                    } else {
                        $perAvo = 1.75;
                        $valorAvo = ($value / 100) * $perAvo;
                        $result = $userAvo->bonus + $valorAvo;
                        $userAvo->bonus = $result;
                        $userAvo->save();
                        $perPai = 4.35;
                        $valorPai = ($value / 100) * $perPai;
                        $result = $userPai->bonus + $valorPai;
                        $userPai->bonus = $result;
                        $userPai->save();
                    }
                }
            }
        }
    return $valorPai;
    }

    public static function calculationEstorno($idUsuario, $value, $commmission_pai, $CommissionPai)
    {


        $user = User::find($idUsuario);
        $result = $user->bonus - $value;
        $user->bonus = $result;
        $user->save();

        

        if($user->indicador > 0 && $CommissionPai == true){
            $userPai = User::find($user->indicador);
            $result = $userPai->bonus - $commmission_pai;
            $userPai->bonus = $result;
            $userPai->save();
        }

        return $user->bonus;
    }


}
