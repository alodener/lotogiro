<?php

namespace App\Http\Controllers\Webhook;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Helper\Wallet;
use App\Helper\Configs;


class SuitPayController extends Controller
{

    public function processTransaction(Request $request)
    {
        //$SuitPay = Configs::getTokenSuitPay();
       
        $data = $request->all();

        if (isset($data['idTransaction']) && isset($data['statusTransaction'])) {
           
            $paymentData = new \stdClass;
            $paymentData->status = $data['statusTransaction'] == 'PAID_OUT' ? 'approved' : 'failure';
            $paymentData->external_reference = $data['requestNumber'];
        
          
            $walletHelper = new Wallet;
            $walletHelper->updateStatusPayment($paymentData);

            return response()->json([], 200);
        }

        return response()->json(['error' => 'Dados inválidos'], 400);
    }
}
    
