<?php

namespace App\Services\GatewayPayment\Contracts;

interface CustomerInterface
{
    public function create(array $customer) : array;
    public function edit(string | int $id) : bool;
    public function delete(string | int $id) : bool;
}
