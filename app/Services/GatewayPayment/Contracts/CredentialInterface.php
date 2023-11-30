<?php

namespace App\Services\GatewayPayment\Contracts;

interface CredentialInterface
{
    public static function get() : array;
}
