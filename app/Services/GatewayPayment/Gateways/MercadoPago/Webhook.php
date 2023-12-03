<?php

namespace App\Services\GatewayPayment\Gateways\MercadoPago;

use App\Helper\Wallet;
use App\Services\GatewayPayment\Contracts\StatusTransactionInterface;
use App\Services\GatewayPayment\Contracts\WebhookInterface;
use Illuminate\Http\Request;
use stdClass;

class Webhook implements WebhookInterface
{
    protected $client;

    public function __construct($client)
    {
        $this->client = $client;
    }

    public function create(array $config, StatusTransactionInterface $event = null, bool $active = true)
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
        if ($request->action != 'payment.updated') {
            return;
        }

        $transaction = (new MercadoPagoService($request->data['id']))
            ->transaction()
            ->get();

        switch ($transaction['status']) {
            case 'approved':
                $this->transactionReceived($transaction['external_reference']);
                break;
        }
    }

    public function setting(string $command)
    {
        // code
    }

    protected function transactionReceived($reference) : void
    {
        $data = new stdClass;
        $data->status = 'approved';
        $data->external_reference = $reference;

        $walletHelper = new Wallet;
        $walletHelper->updateStatusPayment($data);
    }
}
