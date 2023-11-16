<?php

namespace App\Http\Controllers\Webhook;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Helper\Wallet;
use MercadoPago\SDK;
use MercadoPago\Payment;
use App\Helper\Configs;

class MercadoPagoController extends Controller
{
    public function processTransaction(Request $request)
    {
        $tokenMP = Configs::getTokenMercadoPago();
        SDK::setAccessToken($tokenMP);

        $data = $request->all();

        if (isset($request['data'])) {
            $payment = Payment::find_by_id($request['data']['id']);
    
            if ($payment->status == 'approved') {
                $data = new \stdClass;
                $data->status = 'approved';
                $data->external_reference = $payment->external_reference;
                $walletHelper = new Wallet;
                $walletHelper->updateStatusPayment($data);
            }
        }

        return response()->json([], 200);
    }
}