<?php

namespace App\Helper;

use App\Models\RechargeOrder;
use App\Models\User;
use App\Models\TransactBalance;
use App\Helper\Configs;
use App\Helper\ApiWallet;
use App\Helper\MensagemTelegram;
use App\Notifications\RechargeProcessedNotification;

class Wallet
{
    public function updateStatusPayment($request)
    {
        $ACTIVE_GATEWAY = env('ACTIVE_GATEWAY');
        
        if($ACTIVE_GATEWAY == "doBank"){
            $typeStatus = [
                'pending' => 0,
                'Pago' => 1,
                'failure' => 3
            ];

        } elseif ($ACTIVE_GATEWAY == "MutualPay") {
            $typeStatus = [
                'pending' => 0,
                'approved' => 1,
                'failure' => 3
            ];

        } elseif ($ACTIVE_GATEWAY == "SuitPay") {
            $typeStatus = [
                'pending' => 0,
                'approved' => 1,
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
                return response()->json(['status' => 200]);
                \Log::info('$Segunda passada: ' . $reference);
            }

            if($typeStatus[$request->status] === 0){
                return response()->json(['status' => 200]);
            }

            if($typeStatus[$request->status] !== 0){
                $newRechargeOrder = $rechargeOrder->first()->replicate();
                $newRechargeOrder->status = $typeStatus[$request->status];
                $newRechargeOrder->save();
                sleep(1);
                $rechargeOrderAgain = RechargeOrder::where('reference', $reference)->get();
                $contador = 0;
                foreach ($rechargeOrderAgain as $recharge) {
                    \Log::info('$rechargeOrderAgain: ' . $reference);
                        if($recharge->status == 1){
                            $contador++;
                            \Log::info('reference: ' . $reference);
                            \Log::info('Contador: ' . $contador);
                        }
                        if($contador > 1){
                            \Log::info('caiu no if: ' . $contador);
                        $totalRecharge = $newRechargeOrder->value;
                        \Log::info('INICIO SCRIPT: ' . $reference);
                    \Log::info('FIM DO SCRiP: ' . $reference);

                             return response()->json(['status' => 200]);
                        }
                }

                if($contador == 2){
                    return response()->json(['status' => 200]);
                }
                $commission = 0;
                $totalRecharge = $newRechargeOrder->value;
                $msgCommission = "";
                if($user->commission > 0){
                    $commission = $newRechargeOrder->value * ($user->commission/100);
                    $totalRecharge = $newRechargeOrder->value;
                    $msgCommission = "Mais {$user->commission}% de comissao.";
                }


                if($typeStatus[$request->status] === 1){
                    TransactBalance::create([
                        'user_id_sender' => 759,
                        'user_id' => $user->id,
                        'value' => $totalRecharge,
                        'old_value' => $user->balance,
                        'value_a' => $user->balance + $totalRecharge,
                        'type' => "Recarga efetuada por meio da plataforma"
                    ]);

                   
                    
                   /* if($user->commission > 0){ 
                        TransactBalance::create([
                            'user_id_sender' => 4,
                            'user_id' => $user->id,
                            'value' => $commission,
                            'old_value' => $user->balance,
                            'value_a' => $user->balance + $totalRecharge + $commission,
                            'type' => 'Bonus de recarga efetuada por meio da plataforma',
                            'wallet' => 'bonus'
                        ]);
                    }*/
                    
                    $user->balance += $newRechargeOrder->value;
                    $user->save();
                    $alteraUsuarioApi = ApiWallet::updateUsuario($user);
                    $rechargeOrderNotification = RechargeOrder::where('reference', $reference)->where('status', 1)->first();
                    if($rechargeOrderNotification != null){
                    $user = User::where('id', $rechargeOrderNotification->user_id )->first();
                    $user->notify(new RechargeProcessedNotification($user, $rechargeOrderNotification));
                }


               /* $telegrambot = Configs::getTelegramUrlBot();                
                $telegramchatid = Configs::getTelegramChatId();
                if(!empty($telegrambot)) {
                $menssagemtelegran = MensagemTelegram::enviarMensagemTelegram($telegramchatid, $totalRecharge, $telegrambot);
                }*/
                
                \Log::info('RISCOU NO FINAL 1:');
              //  return response()->json(['status' => 200]);

            }
        }
        return response()->json(['status' => 403]);
    }
}
}
