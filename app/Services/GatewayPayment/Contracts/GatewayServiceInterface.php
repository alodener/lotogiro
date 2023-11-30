<?php

namespace App\Services\GatewayPayment\Contracts;

interface GatewayServiceInterface
{
    public function customer() : CustomerInterface;
    public function transaction() : TransactionInterface;
    public function webhook() : WebhookInterface;
}
