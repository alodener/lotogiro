<?php

namespace App\Helper;
use App\Models\User;
use App\Models\TransactBalance;

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
        
        if ($game_type === 'bichao') {
            $commission_individual = json_decode($user->commission_individual_bichao);
        }
    
        if ($lvl === 1) {
            $percentage = $user->commission_lv_1;
            $commission_individual = json_decode($user->commission_individual_lv_1);
            
            if ($game_type === 'bichao') {
                $commission_individual = json_decode($user->commission_individual_bichao_lv_1);
            }
        }
    
        if ($lvl === 2) {
            $percentage = $user->commission_lv_2;
            $commission_individual = json_decode($user->commission_individual_lv_2);
            
            if ($game_type === 'bichao') {
                $commission_individual = json_decode($user->commission_individual_bichao_lv_2);
            }
        }
    
        if ($lvl === 3) {
            $percentage = $user->commission_lvl_3;
            $commission_individual = json_decode($user->commission_individual_lvl_3);
            
            if ($game_type === 'bichao') {
                $commission_individual = json_decode($user->commission_individual_bichao_lvl_3);
            }
        }
    
        if ($lvl === 4) {
            $percentage = $user->commission_lvl_4;
            $commission_individual = json_decode($user->commission_individual_lvl_4);
            
            if ($game_type === 'bichao') {
                $commission_individual = json_decode($user->commission_individual_bichao_lvl_4);
            }
        }
    
        // Adicionado para lidar com o nível 5
        if ($lvl === 5) {
            $percentage = $user->commission_lvl_5;
            $commission_individual = json_decode($user->commission_individual_lvl_5);
            
            if ($game_type === 'bichao') {
                $commission_individual = json_decode($user->commission_individual_bichao_lvl_5);
            }
        }

        if ($lvl === 6) {
            $percentage = $user->commission_lvl_6;
            $commission_individual = json_decode($user->commission_individual_lvl_6);
            
            if ($game_type === 'bichao') {
                $commission_individual = json_decode($user->commission_individual_bichao_lvl_6);
            }
        }
    
        if (is_array($commission_individual)) {
            $check = array_filter($commission_individual, fn ($value) => $value->type_id == $type_id);
            
            if (sizeof($check) > 0) {
                $percentage = $check[0]->commission;
            }
        }
    
        return $percentage;
    }


     public static function calculationNew($value, $user_id, $game_type, $type_id, $game)
    {
        $user = User::find($user_id);
        if (!$user) return 0;
    
        $percentage = static::getCommission($user, $type_id, $game_type);
        $commission = (($value / 100) * $percentage);
        $commission_pai = 0;
        $commission_avo = 0;
    
        if ($user->type_client != 1) {
            $user->bonus = $user->bonus + $commission;
            $user->save();
    
            if ($commission > 0) {
                TransactBalance::create([
                    'user_id_sender' => $user->id,
                    'user_id' => $user->id,
                    'value' => $commission,
                    'old_value' => $user->bonus - $commission, 
                    'value_a' => $user->bonus, 
                    'type' => 'Bônus de jogo: ' . $game->id,
                    'wallet' => 'bonus'
                ]);
            }
        }
    
        $userLv1 = User::find($user->indicador);
        if ($userLv1) {
            $commission_pai = (($value / 100) * static::getCommission($userLv1, $type_id, $game_type, 1));
            
            if ($user->type_client === 1) {
                $commission_pai = (($value / 100) * static::getCommission($userLv1, $type_id, $game_type));
            }
            
            $userLv1->bonus = $userLv1->bonus + $commission_pai;
            $userLv1->save();
            
            if ($commission_pai > 0) {
                TransactBalance::create([
                    'user_id_sender' => $user->id,
                    'user_id' => $userLv1->id, //  pai
                    'value' => $commission_pai,
                    'old_value' => $userLv1->bonus - $commission_pai,
                    'value_a' => $userLv1->bonus,
                    'type' => 'Bônus, jogo de id: ' . $game->id ,
                    'wallet' => 'bonus'
                ]);
            }
            
    
            $userLv2 = User::find($userLv1->indicador);
            if ($userLv2) {
                $commission_avo = (($value / 100) * static::getCommission($userLv2, $type_id, $game_type, 2));
                $userLv2->bonus = $userLv2->bonus + $commission_avo;
                $userLv2->save();
    
                if ($commission_avo > 0) {
                    TransactBalance::create([
                        'user_id_sender' => $user->id,
                        'user_id' => $userLv2->id, //  avô
                        'value' => $commission_avo,
                        'old_value' => $userLv2->bonus - $commission_avo,
                        'value_a' => $userLv2->bonus,
                        'type' => 'Bônus, jogo de id: ' . $game->id ,
                        'wallet' => 'bonus'
                    ]);
                }
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

    public static function calculationNewEstorno($value, $user_id, $game_type, $type_id)
    {
        $user = User::find($user_id);
        if (!$user) return 0;

        $percentage = static::getCommission($user, $type_id, $game_type);
        $commission = (($value / 100) * $percentage);
        $commission_pai = 0;
        $commission_avo = 0;

        if ($user->type_client != 1) {
            $user->bonus = $user->bonus - $commission;
            $user->save();
        }

        $userLv1 = User::find($user->indicador);
        if ($userLv1) {
            $commission_pai = (($value / 100) * static::getCommission($userLv1, $type_id, $game_type, 1));
            
            if ($user->type_client === 1) {
                $commission_pai = (($value / 100) * static::getCommission($userLv1, $type_id, $game_type));
            }
            
            $userLv1->bonus = $userLv1->bonus - $commission_pai;
            $userLv1->save();

            $userLv2 = User::find($userLv1->indicador);
            if ($userLv2) {
                $commission_avo = (($value / 100) * static::getCommission($userLv2, $type_id, $game_type, 2));
                $userLv2->bonus = $userLv2->bonus - $commission_avo;
                $userLv2->save();
            }
        }

        return ['percentage' => $percentage, 'commission' => $commission, 'commission_pai' => $commission_pai, 'commission_avo' => $commission_avo];
    }
}
