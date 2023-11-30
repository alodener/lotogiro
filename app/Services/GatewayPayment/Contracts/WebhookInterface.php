<?php

namespace App\Services\GatewayPayment\Contracts;

use Illuminate\Http\Request;

interface WebhookInterface
{
    public function create(array $config, StatusTransactionInterface $event);
    public function all();
    public function remove(string $id);
    public function get(Request $request);
    public function setting(string $command);
}
