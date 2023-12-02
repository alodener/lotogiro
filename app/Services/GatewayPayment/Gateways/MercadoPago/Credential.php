<?php

namespace App\Services\GatewayPayment\Gateways\MercadoPago;

use App\Services\GatewayPayment\Contracts\CredentialInterface;

class Credential implements CredentialInterface
{
    public static function get() : array
    {
        return [
            'token' => config('payment.mercadopago.credential.token')
        ];
    }
}
