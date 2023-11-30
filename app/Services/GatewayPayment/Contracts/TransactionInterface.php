<?php

namespace App\Services\GatewayPayment\Contracts;

interface TransactionInterface
{
    public function create(array $value);
    public function get();
    public function all();
    public function reverse();
}
