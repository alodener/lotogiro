<?php

namespace App\Services\GatewayPayment\Gateways\MercadoPago;

use App\Services\GatewayPayment\Contracts\StatusTransactionInterface;
use App\Services\GatewayPayment\Contracts\WebhookInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use OpenPix\PhpSdk\ApiErrorException;
use OpenPix\PhpSdk\Client;

class Webhook implements WebhookInterface
{
    protected $client;

    public function __construct($client)
    {
        $this->client = $client;
    }

    public function create(array $config, StatusTransactionInterface $event = 'payment.updated', bool $active = true)
    {
        // code
    }

    public function all()
    {
        // code
    }

    public function remove(string $id)
    {
        // code
    }

    public function get(Request $request)
    {
        return (new MercadoPagoService($request->data['id']))
            ->transaction()
            ->get();
    }

    public function setting(string $command)
    {
        // code
    }
}
