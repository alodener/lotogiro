<?php

namespace App\Http\Controllers\Api\v2;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\GatewayPayment\GatewayPaymentService;

class WebhookController extends Controller
{
    public function __invoke(Request $request)
    {
        return (new GatewayPaymentService)
            ->gateway()
            ->webhook()
            ->get($request);
    }
}
