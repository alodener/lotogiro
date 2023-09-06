<?php

namespace App\Helper;

use App\Models\RechargeOrder;
use App\Models\User;
use App\Models\TransactBalance;
use App\Helper\Configs;
use App\Helper\MensagemTelegram;

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
                    $totalRecharge = $newRechargeOrder->value;
                    $msgCommission = "Mais {$user->commission}% de comiss茫o.";
                }


                if($typeStatus[$request->status] === 1){
                    TransactBalance::create([
                        'user_id_sender' => 4,
                        'user_id' => $user->id,
                        'value' => $totalRecharge,
                        'old_value' => $user->balance,
                        'value_a' => $user->balance + $totalRecharge,
                        'type' => "Recarga efetuada por meio da plataforma"
                    ]);

                   
                    
                    if($user->commission > 0){ 
                        TransactBalance::create([
                            'user_id_sender' => 4,
                            'user_id' => $user->id,
                            'value' => $commission,
                            'old_value' => $user->balance,
                            'value_a' => $user->balance + $totalRecharge + $commission,
                            'type' => 'Bonus de recarga efetuada por meio da plataforma',
                            'wallet' => 'bonus'
                        ]);
                    }
                    
                    $user->balance += $newRechargeOrder->value ;
                    $user->save();


                $telegrambot = Configs::getTelegramUrlBot();                
                $telegramchatid = Configs::getTelegramChatId();
                if(!empty($telegrambot)) {
                $menssagemtelegran = MensagemTelegram::enviarMensagemTelegram($telegramchatid, $totalRecharge, $telegrambot);
                }
                

                return response()->json(['status' => 201]);
            }
        }
        return response()->json(['status' => 403]);
    }
}
}