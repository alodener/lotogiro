<?php

namespace App\Http\Controllers\Webhook;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Helper\Wallet;
use Illuminate\Support\Facades\Log;

class DoBankController extends Controller
{
    public function processTransaction(Request $request)
    {

        Log::info($request);
        Log::info($request[0]['status']);
        

        if($request[0]['status'] == "Pago" && $request[0]['api_token'] == ENV("TOKEN_RECEBIMENTO")) {
            $payload = $request;
            $data = new \stdClass;

            $data->status = $payload[0]['status'] == 'Pago' ? 'Pago' : 'failure';
            $data->external_reference = $payload[0]['trxid'];

            $walletHelper = new Wallet;

           return $walletHelper->updateStatusPayment($data);

        }
                /*if($request->has('type') && $request->type == 'ping') {
            return response()->json([], 200);
        }

        return response()->json([
            'error' => 'Requisição inválida'
        ], 400);*/
    }
}
