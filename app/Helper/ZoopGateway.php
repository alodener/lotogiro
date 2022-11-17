<?php

namespace App\Helper;

use Illuminate\Support\Facades\Http;

use App\Libs\Zoop\Credentials;
use App\Libs\Zoop\Pix;
use App\Libs\Zoop\Customer;
use App\Libs\Zoop\Zoop;

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

    public function createCustomer()
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



        $customer = $this->createCustomer();

        var_dump($customer);


        $transaction = new Boleto();
        $transaction->setAmount(300);
        $transaction->setCurrency("BRL");
        $transaction->setDescription("minhaloja");
        $transaction->setPaymentType("pix");
        $transaction->setOnBehalfOf($this->sellerId);
        $transaction->setExpirationDate("2022-11-20");
        $transaction->setPaymentLimitDate("2022-11-20");
        $transaction->setBodyInstructions("teste de instrucao");

        $zoop = new Zoop($this->credentials);

        $authorize = $zoop->Boleto($transaction, $customer);

        return $authorize;
    }
}
