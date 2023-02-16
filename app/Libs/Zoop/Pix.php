<?php

namespace App\Libs\Zoop;

class Pix implements \JsonSerializable
{
    protected $amount;
    protected $currency;
    protected $description;
    protected $on_behalf_of;
    protected $customer;
    protected $payment_type;
    protected $pix_expiration_date_time;

    public function toJSON()
    {
        return json_encode($this->jsonSerialize(), JSON_PRETTY_PRINT);
    }

    public function jsonSerialize()
    {
        try {
            $obj        = array(
                'amount'         => $this->getAmount(),
                'currency'       => $this->getCurrency(),
                'description'    => $this->getDescription(),
                'on_behalf_of'   => $this->getOnBehalfOf(),
                'customer'       => $this->getCustomer(),
                'payment_type'   => $this->getPaymentType(),
                'pix_expiration_date_time' => $this->getPixExpirationDateTime()
            );
            $vars_clear = array_filter($obj, function ($value) {
                if (is_array($value)) {
                    foreach ($value as $value2) {
                        return null !== $value2;
                    }
                } else {
                    return null !== $value;
                }
            });

            return $vars_clear;
        } catch (\Exception $e) {
            return false;
        }

    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param mixed $amount
     *
     * @return Boleto
     */
    public function setAmount($amount)
    {
        $this->amount = (string)$amount;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @param mixed $currency
     *
     * @return Boleto
     */
    public function setCurrency($currency)
    {
        $this->currency = (string)$currency;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     *
     * @return Boleto
     */
    public function setDescription($description)
    {
        $this->description = (string)$description;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getOnBehalfOf()
    {
        return $this->on_behalf_of;
    }

    /**
     * @param mixed $on_behalf_of
     *
     * @return Boleto
     */
    public function setOnBehalfOf($on_behalf_of)
    {
        $this->on_behalf_of = (string)$on_behalf_of;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * @param mixed $customer
     *
     * @return Boleto
     */
    public function setCustomer($customer)
    {
        $this->customer = (string)$customer;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPaymentType()
    {
        return $this->payment_type;
    }

    /**
     * @param mixed $payment_type
     *
     * @return Boleto
     */
    public function setPaymentType($payment_type)
    {
        $this->payment_type = (string)$payment_type;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPixExpirationDateTime()
    {
        return $this->pix_expiration_date_time;
    }

    /**
     * @param mixed $pix_expiration_date_time
     *
     * @return Boleto
     */
    public function setPixExpirationDateTime($pix_expiration_date_time)
    {
        $this->pix_expiration_date_time = (string)$pix_expiration_date_time;

        return $this;
    }
}
