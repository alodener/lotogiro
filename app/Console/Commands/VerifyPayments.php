<?php

namespace App\Console\Commands;

use App\Models\RechargeOrder;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class VerifyPayments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lotoverify:payments';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verify payments.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $paymentReference = RechargeOrder::where('status', 0)->get();
        $url = env("APP_URL");
        $paymentReference->each(function($item, $key) use ($paymentReference) {
            $verify = RechargeOrder::where('status', '<>', 0)
                ->where('reference', $item->reference)
                ->get();
            if($verify->count() > 0){
                $paymentReference->forget($key);
            }
        });
        $info = 'Nenhum pagamento a validar.';
        $ACTIVE_GATEWAY = env('ACTIVE_GATEWAY');
        if($ACTIVE_GATEWAY == "MP"){
        if($paymentReference->count() > 0) {
            foreach($paymentReference as $payment) {
                $request = Http::withHeaders([
                    'authorization' => 'Bearer APP_USR-2909617305972251-012203-1eb52e7fbfc50a7355b5beb6d5abbe79-1011031176'
                ])->get("https://api.mercadopago.com/v1/payments/search?external_reference={$payment->reference}#json");
                
                if (count($request->json()['results']) > 0) {
                  $rota ="{$url}/updateStatusPaymentCron/2de1ce3ddcb20dda6e6ea9fba8031de4/?status={$request->json()['results'][0]['status']}&external_reference={$payment->reference}";

                    Http::get("{$url}/updateStatusPaymentCron/2de1ce3ddcb20dda6e6ea9fba8031de4/?status={$request->json()['results'][0]['status']}&external_reference={$payment->reference}");
                }
  
                echo "Pagamento #{$payment->reference} atualizado.\n";
            }
            $info = "Todos os pagamentos atualizados.";
        }
    }
    if($ACTIVE_GATEWAY == "doBank"){
        $txid;
        
        if($paymentReference->count() > 0) {
            foreach($paymentReference as $payment) {
            $txid = $payment->txid;
            
            $response = Http::post('https://dobank.com.br/api/consulta_recebimentos', [
                'token' => 'GvfdgleZBKkV0ngQ766G0grRBRmPsiJFa0tc1QRHL2jtsrsBdtcxzbnL8mYI6AkteLzPmMGrmxxPccJ8Es2I8n57sP09UMMyBHYloMadNNYhjCdctDGHRy13jSbdncqmIHVErilLaRIkFKAJdMjlm8jb1DQX48WDnhIJSLNr0xbMNgWtvhmI80YkjaWBtbAn9hEekrnw',
                'txid' => $txid,
                'days' => 0,
            ]);
            $pix = json_decode($response->json());
            $pixId;
            $pixStatus;
            foreach($pix as $item){
                $pixId = $item->trxid;
                $pixStatus = $item->status;
            }
            Http::get("{$url}/updateStatusPaymentCron/2de1ce3ddcb20dda6e6ea9fba8031de4/?status={$pixStatus}&external_reference={$pixId}");
        }
            $info = "Todos os pagamentos atualizados. DoBANK";
        }
    }

        $this->info($info);
    }
}
