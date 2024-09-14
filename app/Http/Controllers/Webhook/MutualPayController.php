<?php

namespace App\Http\Controllers\Webhook;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Helper\Wallet;
use App\Helper\Configs;


class MutualPayController extends Controller
{

    public function processTransaction(Request $request)
    {
       
        $data = $request->all();
        sleep(2);
        \Log::info($request);
        //VARIAVEIS DE STATUS E ID DA TRANSAÇÃO
        if (isset($data['transactionid']) && isset($data['status_process'])) {
           
            $paymentData = new \stdClass;
            $paymentData->status = $data['status_process'] == '2' ? 'approved' : 'failure';
            $paymentData->external_reference = $data['transactionid'];
        
          
            $walletHelper = new Wallet;
            $walletHelper->updateStatusPayment($paymentData);
            \Log::info("RISCOU MUTUAL");
            return response()->json([], 200);
             
        }

        return response()->json(['error' => 'Dados inválidos'], 400);
    }
}
    
