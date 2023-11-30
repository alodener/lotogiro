<?php

namespace App\Services\GatewayPayment\Gateways\OpenPix;

use App\Services\GatewayPayment\Contracts\CustomerInterface;

class Customer implements CustomerInterface
{
    public function create(array $customer) : array
    {
        return [];
    }

    public function edit(string | int $id) : bool
    {
        return true;
    }

    public function delete(string | int $id) : bool
    {
        return true;
    }

}
