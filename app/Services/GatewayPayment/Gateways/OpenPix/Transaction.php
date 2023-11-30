<?php

namespace App\Services\GatewayPayment\Gateways\OpenPix;

use App\Services\GatewayPayment\Contracts\TransactionInterface;
use Illuminate\Support\Facades\Log;
use OpenPix\PhpSdk\ApiErrorException;
use OpenPix\PhpSdk\Client;

class Transaction implements TransactionInterface
{
    protected Client $client;
    protected string $correlationID = '';

    public function __construct($client, $correlationID = null)
    {
        $this->client = $client;
        $this->correlationID = $correlationID;
    }

    public function create(array $payment)
    {
        try {
            return $this->client
                ->charges()
                ->create(array_merge($payment, ['correlationID' => $this->correlationID]));

        } catch (ApiErrorException $e) {
            Log::error($e);
            return $e->getMessage();
        }
    }

    public function get()
    {
        try {
            return $this->client
                ->charges()
                ->getOne($this->correlationID);

        } catch (ApiErrorException $e) {
            Log::error($e);
            return $e->getMessage();
        }
    }

    public function all($start = null, $end = null, $status = null)
    {
        try {
            return $this->client
                ->charges()
                ->list([
                    'start' => $start,
                    'end' => $end,
                    'status' => $status
                ]);

        } catch (ApiErrorException $e) {
            Log::error($e);
            return $e->getMessage();
        }
    }

    public function reverse()
    {

    }
}
