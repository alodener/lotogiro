<?php

namespace App\Http\Livewire\Pages\Dashboards\Wallet\Recharge;

use App\Helper\Money;
use App\Models\RechargeOrder;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use MercadoPago\Item;
use MercadoPago\Preference;
use MercadoPago\SDK;
use App\Helper\ZoopGateway;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use App\Helper\Configs;
use App\Models\System;
use Faker\Extension\Helper;


class Table extends Component
{
    use LivewireAlert;

    public $valueAdd;

    public function mount()
    {
        $this->valueAdd = 0; // Defina o valor inicial conforme necessário
    }

    public function increment($amount)
    {
        $this->valueAdd += $amount;
    }

    public function callMP()
    {
        $tokenMP = Configs::getTokenMercadoPago();

        SDK::setAccessToken($tokenMP); // Either Production or SandBox AccessToken
        
        $preference = new Preference(); 
        $item = new Item();

        $item->title = "Recarga " . ENV("nome_sistema");
        $item->quantity = 1;
        $item->unit_price = Money::toDatabase($this->valueAdd);

        $order = new RechargeOrder([
            'user_id' => auth()->id(),
            'value' => Money::toDatabase($this->valueAdd),
            'status' => 0
        ]);
        $order->save();

        $preference->items = array($item);
        $preference->back_urls = [
            "success" => env("APP_URL") . "/admin/dashboards/wallet/thanks/",
            "failure" => env("APP_URL") . "/dashboards/wallet/thanks/",
            "pending" => env("APP_URL") . "/dashboards/wallet/thanks/"
        ];
        $preference->auto_return = "approved";
        $preference->notification_url = env("APP_URL") . "/dashboards/wallet/updateStatusPayment/2de1ce3ddcb20dda6e6ea9fba8031de4/";
        $preference->external_reference = $order->reference;
        $preference->save();

        $order->update(['link' => $preference->init_point]);

        $this->alert('info', 'Pronto!!', [
            'position' => 'center',
            'timer' => null,
            'toast' => false,
            'html' => "Seu link para pagamento está pronto, gostaria de pagar agora?<br><br>
                        <a class='btn btn-block btn-outline-info'
                            onclick=redirect('{$preference->init_point}')>Sim</a>",
        ]);
    }
   
    public function callMPPix()
    {
        $tokenMP = Configs::getTokenMercadoPago();

        $order = new RechargeOrder([
            'user_id' => auth()->id(),
            'value' => Money::toDatabase($this->valueAdd),
            'status' => 0
        ]);
        $order->save();

        $payment = [
            'transaction_amount' => floatval($order->value),
            'description' => "Recarga " . ENV("nome_sistema"),
            'payment_method_id' => 'pix',
            'payer' => ['email' => auth()->user()->email],
            'external_reference' => $order->reference,
            'notification_url' => env("APP_URL") . "/api/mp/webhook/process/transaction"
        ];

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.mercadopago.com/v1/payments',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($payment),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                "X-Idempotency-Key: {$order->reference}",
                "Authorization: Bearer $tokenMP"
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        $response = json_decode($response);

        if (!isset($response->point_of_interaction)) {
            echo json_encode([$response, $payment]);exit;
        }

        $copyPast = $response->point_of_interaction->transaction_data->qr_code;
        $base64 = $response->point_of_interaction->transaction_data->qr_code_base64;

        $this->alert('info', 'Pronto!!', [
            'position' => 'center',
            'timer' => null,
            'toast' => false,
            'html' => "Seu código Copia e Cola está pronto, gostaria de pagar agora?<br><br>
                    <div class='input-group mb-3'>
                        <input type='text' value='{$copyPast}' readonly class='form-control' placeholder='qrCodeMP' aria-label='qrCodeMP' aria-describedby='button-addon2' id='input_output'>
                        <button class='btn btn-outline-secondary'  onclick='copyText()'  type='button' id='copyPix'>Copiar</button>
                    </div>
                    <div class='input-group mb-3'>
                        <img src='data:image/gif;base64,$base64' style='max-width:250px;margin:auto'>
                    </div>'
                    <div><button class='btn btn-info btn-md' onclick='redirectPix()'>Concluído</button></div>",

        ]);
    }

    public function callZoopPix()
    {
        $order = new RechargeOrder([
            'user_id' => auth()->id(),
            'value' => Money::toDatabase($this->valueAdd),
            'status' => 0,
            'gateway' => 'zoop'
        ]);
        $order->save();

        $zoopGateway = new ZoopGateway;

        $authorize = $zoopGateway->createCharge($order);
        $response = $authorize->getResponse();

        echo json_encode($response);exit;

        $order->update(['link' => $response['payment_method']['qr_code']['emv'], 'reference' => $response['id']]);

        $this->alert('info', 'Pronto!!', [
            'position' => 'center',
            'timer' => null,
            'toast' => false,
            'html' => "Seu código Copia e Cola está pronto, gostaria de pagar agora?<br><br>
                    <div class='input-group mb-3'>
                        <input type='text' value='{$order->link}' readonly class='form-control' placeholder='qrCodeZoop' aria-label='qrCodeZoop' aria-describedby='button-addon2' id='input_output'>
                        <button class='btn btn-outline-secondary'  onclick='copyText()'  type='button' id='copyPix'>Copiar</button>
                    </div>'",
        ]);
    }

    public function callZoop()
    {
        $order = new RechargeOrder([
            'user_id' => auth()->id(),
            'value' => Money::toDatabase($this->valueAdd),
            'status' => 0,
            'gateway' => 'zoop'
        ]);
        $order->save();

        $zoopGateway = new ZoopGateway;

        $authorize = $zoopGateway->createCharge($order);
        $response = $authorize->getResponse();

        $order->update(['link' => $response['payment_method']['qr_code']['emv'], 'reference' => $response['id']]);

        $this->alert('info', 'Pronto!!', [
            'position' => 'center',
            'timer' => null,
            'toast' => false,
            'html' => "Seu código Copia e Cola está pronto, gostaria de pagar agora?<br><br>
                    <div class='input-group mb-3'>
                        <input type='text' value='{$order->link}' readonly class='form-control' placeholder='qrCodeZoop' aria-label='qrCodeZoop' aria-describedby='button-addon2' id='input_output'>
                        <button class='btn btn-outline-secondary'  onclick='copyText()'  type='button' id='copyPix'>Copiar</button>
                    </div>'",
        ]);
    }

    public function callDoBank()
    {
        $order = new RechargeOrder([
            'user_id' => auth()->id(),
            'value' => Money::toDatabase($this->valueAdd),
            'status' => 0,
            'gateway' => 'doBank'
        ]);
        $order->save();

        $response = Http::post('https://dobank.com.br/api/recebimento', [
            'token' => env("TOKEN_RECEBIMENTO"),
            'amount' => Money::toDatabase($this->valueAdd),
            'method_code' => 'pix',
        ]);
        $pix_json = json_encode($response->json());
        $pix = json_decode($pix_json);
    
        $order->update(['link' => $pix->copiaecola, 'reference' =>$pix->txid]);
        $baseURL = env('APP_URL');
        $url = $baseURL . "/admin/dashboards/wallet/recharge-order";
        
        $this->alert('info', 'Pronto!!', [
            'position' => 'center',
            'timer' => null,
            'toast' => false,
            'html' => "Seu código Copia e Cola está pronto, gostaria de pagar agora?<br><br>
                    <div class='input-group mb-3'>
                        <input type='text' value='{$pix->copiaecola}' readonly class='form-control' placeholder='qrCodeZoop' aria-label='qrCodeZoop' aria-describedby='button-addon2' id='input_output'>
                        <button class='btn btn-outline-secondary'  onclick='copyText()'  type='button' id='copyPix'>Copiar</button>
                    </div>
                    <div class='input-group mb-3'>
                        <img src='data:image/gif;base64,{$pix->qrcode}' style='max-width:250px;margin:auto'>
                    </div>'
                    <a class='btn btn-block btn-outline-info'
                            onclick=redirectPix()>Confirmar Pagamento</a>'",
        ]);
    }


    public function render()
    {
        return view('livewire.pages.dashboards.wallet.recharge.table');
    }
}
