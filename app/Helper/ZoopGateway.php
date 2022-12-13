<?php

namespace App\Helper;

use App\Libs\Zoop\Credentials;
use App\Libs\Zoop\Pix;
use App\Libs\Zoop\Customer;
use App\Libs\Zoop\Zoop;
use App\Libs\Zoop\Webhook;
use Carbon\Carbon;

class ZoopGateway
{
    /**
     * @var Zoop\Credentials $credentials
     */
    private $credentials;

    /**
     * @var string $sellerId
     */
    private $sellerId;

    public function __construct()
    {
        $marketplaceId = config('services.zoop.marketplaceId');
        $sellerId = config('services.zoop.sellerId');
        $publishableKey = config('services.zoop.publishableKey');
        $mode = config('services.zoop.mode');

        $this->credentials = new Credentials($marketplaceId, $publishableKey, $sellerId, $mode);

        $this->sellerId = $sellerId;
    }

    public function mapCustomer($user)
    {
        $customer = new Customer();
        $customer->setFirstName("Cesar Damascena");
        $customer->setTaxpayerId("15307003706");
        $customer->setEmail("cesardamascena10@hotmail.com");
        $customer->setAddressLine1("ruas de testes");
        $customer->setAddressLine2("bairro teste");
        $customer->setAddressNeighborhood("centro");
        $customer->setAddressCity("Sao paulo");
        $customer->setAddressState("SP");
        $customer->setAddressPostalCode("04742350");
        $customer->setAddressCountryCode("BR");

        return $customer;
    }

    public function createCharge($rechargeOrder)
    {
        // Get User From Recharge Order
        // $customer = $this->createCustomer();
        // var_dump($customer);

        $expirationDate = Carbon::now()->addDay(1);
        $value = bcmul($rechargeOrder->value, 100);

        $transaction = new Pix();
        $transaction->setAmount($value);
        $transaction->setCurrency("BRL");
        $transaction->setDescription("RechargeOrder:" . $rechargeOrder->id);
        $transaction->setPaymentType("pix");
        $transaction->setOnBehalfOf($this->sellerId);
        $transaction->getPixExpirationDateTime($expirationDate->format('Y-m-d H:i:s'));

        $zoop = new Zoop($this->credentials);

        $authorize = $zoop->Pix($transaction);

        return $authorize;
    }

    public function createWebhook($data)
    {
        $webhook = new Webhook();
        
        $webhook->setMethod($data['method']);
        $webhook->setUrl($data['url']);
        // $webhook->setDescription($data['description'] ?? '');
        $webhook->setEvent($data['event']);
        // $webhook->setAuthorization($data['authorization'] ?? null);

        $zoop = new Zoop($this->credentials);

        $response = $zoop->createWebhook($webhook);

        return $response;
    }

    public function deleteWebhook($id)
    {
        $zoop = new Zoop($this->credentials);

        $response = $zoop->deleteWebhook($id);

        return $response;
    }
}
