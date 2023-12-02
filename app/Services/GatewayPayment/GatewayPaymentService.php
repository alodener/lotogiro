<?php

namespace App\Services\GatewayPayment;

use App\Models\System;
use App\Services\GatewayPayment\Contracts\GatewayServiceInterface;
use App\Services\GatewayPayment\Gateways\MercadoPago\MercadoPagoService;
use App\Services\GatewayPayment\Gateways\OpenPix\OpenPixGatewayService;

class GatewayPaymentService
{
    protected $path = 'app/Services/GatewayPayment/Gateways';
    protected $correlationID;
    protected $current_gateway;

    public function __construct(string $correlationID = null)
    {
        $this->correlationID = $correlationID;
        $this->current_gateway = System::config('Gateway de Pagamento')->first();
    }

    public function setDirectory() : array
    {
        return scandir(base_path($this->path));
    }

    public function sanatize(array $directory) : array
    {
        return array_slice($directory, 2);
    }

    public function gateways()
    {
        return array_map(
            fn ($gateways) => [
                'id' => strtolower($gateways),
                'label' => $gateways
            ],
            $this->sanatize($this->setDirectory())
        );
    }

    public function gateway () : GatewayServiceInterface
    {
        switch ($this->current_gateway->value) {
            case 'openpix':
                return new OpenPixGatewayService($this->correlationID);

            case 'mercadopago':
                return new MercadoPagoService($this->correlationID);
        }
    }
}
