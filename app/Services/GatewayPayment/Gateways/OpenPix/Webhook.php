<?php

namespace App\Services\GatewayPayment\Gateways\OpenPix;

use App\Helper\Wallet;
use App\Services\GatewayPayment\Contracts\StatusTransactionInterface;
use App\Services\GatewayPayment\Contracts\WebhookInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use OpenPix\PhpSdk\ApiErrorException;
use OpenPix\PhpSdk\Client;
use stdClass;

class Webhook implements WebhookInterface
{
    protected Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function create(array $config, StatusTransactionInterface $event = null, bool $active = true)
    {
        $config['url'] = config('payment.webhook.endpoint');
        $config['isActive'] = $active;
        $config['event'] = $event ?? 'OPENPIX:CHARGE_COMPLETED';
        $config['authorization'] = 'openpix-php-sdk';

        try {
            $this->client
                ->webhooks()
                ->create(['webhook' => $config]);

        } catch (ApiErrorException $exception) {
            Log::error($exception);
            return $exception->getMessage();
        }
    }

    public function all()
    {
        try {
            return $this->client
                ->webhooks()
                ->list();
        } catch (ApiErrorException $exception) {
            Log::error($exception);
            return $exception->getMessage();
        }
    }

    public function remove(string $id)
    {
        try {
            return $this->client
                ->webhooks()
                ->delete($id);

        } catch (ApiErrorException $exception) {
            Log::error($exception);
            return $exception->getMessage();
        }
    }

    public function get(Request $request)
    {
        $isWebhookValid = $this->client
            ->webhooks()
            ->isWebhookValid($request->getContent(), $request->header('x-webhook-signature'));

        if (!$isWebhookValid) {
            return response('Assinatura inválida', 400);
        }

        switch ($request->event) {
            case StatusTransaction::TRANSACTION_RECEIVED:
                $this->transactionReceived($request->charge['correlationID']);
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
