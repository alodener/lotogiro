<?php

namespace App\Http\Controllers\Webhook;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ZoopController extends Controller
{
    public function processTransactionSuccess(Request $request)
    {
        if($request->has('type') && $request->type == 'ping') {
            return response()->json([], 200);
        }

        if($request->has('id') && $request->has('type') && $request->type == 'transaction.succeeded') {
            $payload = $request->payload;

            $status = $payload['object']['status'] == 'succeeded' ? 'approved' : 'failure';
            $id = $request->id;

            $route = url("/updateStatusPaymentCron/2de1ce3ddcb20dda6e6ea9fba8031de4/?status={$status}&external_reference={$id}");

            return redirect($route);
        }

        return response()->json([
            'error' => 'Requisição inválida'
        ], 400);
    }
}