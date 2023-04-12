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
            'token' => 'GvfdgleZBKkV0ngQ766G0grRBRmPsiJFa0tc1QRHL2jtsrsBdtcxzbnL8mYI6AkteLzPmMGrmxxPccJ8Es2I8n57sP09UMMyBHYloMadNNYhjCdctDGHRy13jSbdncqmIHVErilLaRIkFKAJdMjlm8jb1DQX48WDnhIJSLNr0xbMNgWtvhmI80YkjaWBtbAn9hEekrnw',
            'amount' => Money::toDatabase($this->valueAdd),
            'method_code' => "pix",
        ]);
        $pix = json_decode($response->json());
        //dd($pix->copiaecola);
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
                    <a class='btn btn-block btn-outline-info'
                            onclick=redirect()>Confirmar Pagamento</a>'",
        ]);
    }


    public function render()
    {
        return view('livewire.pages.dashboards.wallet.recharge.table');
    }
}
