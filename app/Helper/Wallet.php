<?php

namespace App\Helper;

use App\Models\RechargeOrder;
use App\Models\User;
use App\Models\TransactBalance;

class Wallet
{
    public function updateStatusPayment($request)
    {
        $ACTIVE_GATEWAY = env('ACTIVE_GATEWAY');
        
        if($ACTIVE_GATEWAY == "doBank"){
            $typeStatus = [
                'pending' => 0,
                'Recebido' => 1,
                'failure' => 3
            ];
        }else{
            $typeStatus = [
                'pending' => 0,
                'approved' => 1,
                'failure' => 3
            ];
        }
        
        if(empty($request->status)){
            return response()->json(['status' => 403]);
        }

        if($request->status !== 'null'){
            $reference = $request->external_reference;
            $rechargeOrder = RechargeOrder::where('reference', $reference)->get();
            $user = User::find($rechargeOrder->first()->user_id);

            if($rechargeOrder->contains('status', 1) || $rechargeOrder->contains('status', 2)){
                return response()->json(['status' => 403]);
            }

            if($typeStatus[$request->status] === 0){
                return response()->json(['status' => 200]);
            }

            if($typeStatus[$request->status] !== 0){
                $newRechargeOrder = $rechargeOrder->first()->replicate();
                $newRechargeOrder->status = $typeStatus[$request->status];
                $newRechargeOrder->push();

                $commission = 0;
                $totalRecharge = $newRechargeOrder->value;
                $msgCommission = "";
                if($user->commission > 0){
                    $commission = $newRechargeOrder->value * ($user->commission/100);
                    $totalRecharge = $newRechargeOrder->value + $commission;
                    $msgCommission = "Mais {$user->commission}% de comissão.";
                }

                if($typeStatus[$request->status] === 1){
                    TransactBalance::create([
                        'user_id_sender' => 759,
                        'user_id' => $user->id,
                        'value' => $totalRecharge,
                        'old_value' => $user->balance,
                        'type' => "Recarga efetuada por meio da plataforma. {$msgCommission}"
                    ]);

                    $user->balance += $newRechargeOrder->value + $commission;
                    $user->save();
                }

                return response()->json(['status' => 201]);
            }
        }
        return response()->json(['status' => 403]);
    }
}