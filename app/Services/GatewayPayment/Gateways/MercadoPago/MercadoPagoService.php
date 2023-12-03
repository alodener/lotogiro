<?php

namespace App\Services\GatewayPayment\Gateways\MercadoPago;

use App\Models\System;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use App\Services\GatewayPayment\Contracts\WebhookInterface;
use App\Services\GatewayPayment\Contracts\CustomerInterface;
use App\Services\GatewayPayment\Contracts\TransactionInterface;
use App\Services\GatewayPayment\Contracts\GatewayServiceInterface;

class MercadoPagoService implements GatewayServiceInterface
{
    protected $client;
    protected $baseurl = 'https://api.mercadopago.com/v1';
    protected string $correlationID;

    public function __construct(string $correlationID = null)
    {
        $this->client = Http::acceptJson()
            ->withToken(System::config('Accesstoken MercadoPago')->first()->value)
            ->baseUrl($this->baseurl);

        is_null($correlationID)
            ? $this->setCorrelationID()
            : $this->correlationID = $correlationID;
    }

    public function customer(): CustomerInterface
    {
        return new Customer;
    }

    public function transaction(): TransactionInterface
    {
        return new Transaction($this->client, $this->correlationID, config('payment.webhook.endpoint'));
    }

    public function webhook(): WebhookInterface
    {
        return new Webhook($this->client);
    }

    private function setCorrelationID() : void
    {
        config('payment.mode') == 'dev'
            ? $this->correlationID = 'test-php-sdk-charge-' . Str::uuid()
            : $this->correlationID = Str::uuid();
    }
}
