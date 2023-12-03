<?php

namespace App\Services\GatewayPayment\Gateways\OpenPix;

use App\Models\System;
use OpenPix\PhpSdk\Client;
use Illuminate\Support\Str;
use App\Services\GatewayPayment\Contracts\CustomerInterface;
use App\Services\GatewayPayment\Contracts\TransactionInterface;
use App\Services\GatewayPayment\Contracts\GatewayServiceInterface;
use App\Services\GatewayPayment\Contracts\WebhookInterface;

class OpenPixGatewayService implements GatewayServiceInterface
{
    protected Client $client;
    protected string $correlationID = '';

    public function __construct($correlationID = null)
    {
        $this->client = Client::create(System::config('Accesstoken OpenPix')->first()->value);


        is_null($correlationID)
            ? $this->setCorrelationID()
            : $this->correlationID = $correlationID;
    }

    public function customer() : CustomerInterface
    {
        return new Customer;
    }

    public function transaction() : TransactionInterface
    {
        return new Transaction($this->client, $this->correlationID);
    }

    public function webhook() : WebhookInterface
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
