<?php

namespace App\Services\GatewayPayment\Gateways\MercadoPago;

use App\Services\GatewayPayment\Contracts\TransactionInterface;
use Exception;
use Illuminate\Support\Facades\Log;

class Transaction implements TransactionInterface
{
    protected $client;
    protected $notification_url;
    protected $correlationID;

    public function __construct($client, $correlationID, $notification_url)
    {
        $this->client = $client;
        $this->notification_url = $notification_url;
        $this->correlationID = $correlationID;
    }

    public function create(array $payment)
    {
        $data = array_merge($payment, [
            'installments' => 1,
            'payment_method_id' => 'pix',
            'notification_url' => $this->notification_url,
            'external_reference' => $this->correlationID,
        ]);

        try {
            return  $this->client
                ->withHeaders(['X-Idempotency-Key' => $this->correlationID])
                ->post('/payments', $data)
                ->json()['point_of_interaction']['transaction_data']['qr_code'];

        } catch (Exception $e) {
            Log::error($e);
            return new Exception($e->getMessage(), $e->getCode());
        }

    }

    public function get()
    {
        try {
            return $this->client
                ->get("/payments/{$this->correlationID}")
                ->json();
        } catch (Exception $exception) {
            Log::error($exception);
            return $exception->getMessage();
        }
    }

    public function all(string $sort = null, string $criteria = null, string $external_reference = null, string $range = null)
    {
        $parameters = [
            'sort' => $sort,
            'criteria' => $criteria,
            'external_reference' => $external_reference,
            'range' => $range,
        ];

        try {
            return $this->client
                ->get('/payments/search', $parameters)
                ->json();
        } catch (Exception $exception) {
            Log::error($exception);
            return $exception->getMessage();
        }
    }

    public function reverse()
    {
        // code
    }
}
