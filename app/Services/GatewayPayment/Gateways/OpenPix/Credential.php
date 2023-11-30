<?php

namespace App\Services\GatewayPayment\Gateways\OpenPix;

use App\Services\GatewayPayment\Contracts\CredentialInterface;

class Credential implements CredentialInterface
{
    public static function get() : array
    {
        return [
            'app_id' => config('payment.openpix.credential.app_id'),
            'client_id' => config('payment.openpix.credential.client_id'),
        ];
    }
}
