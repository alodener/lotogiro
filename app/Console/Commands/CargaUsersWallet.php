<?php

namespace App\Console\Commands;

use App\Models\RechargeOrder;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Helper\Configs;
use Illuminate\Support\Facades\DB;
use App\Models\TransactBalance;
use App\Models\User;
use App\Notifications\RechargeProcessedNotification;

class CargaUsersWallet extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'carga:usuarios';

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
        $userBanca = User::limit(3)->get();
        
        foreach($userBanca as $users){
            echo $users->id ;
        $data = [
            'banca_codigo' => env('banca_codigo'),
            'people_id' => $users->id ,         
            'name' => $users->name,
            'email' => $users->email,
            'balance' => $users->balance == null ? 0 : $users->balance ,
            'bonus' => $users->bonus == null ? 0 : $users->bonus,
            'available_withdraw' => $users->available_withdraw == null ? 0 : $users->available_withdraw,
        ];

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://app.loteriabr.com/api/people',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
            CURLOPT_SSL_VERIFYPEER => false,
        ));
        echo $users->id ;
        $response = curl_exec($curl);
        echo $response;
        curl_close($curl);
        
        $response = json_decode($response);

    if (isset($response->error)) {
        echo '<pre>';
        print_r($response);
        echo '</pre>';
        exit;
    }
}  
    }
}
