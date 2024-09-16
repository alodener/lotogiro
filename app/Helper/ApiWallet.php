<?php

namespace App\Helper;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Helper\Configs;
use Illuminate\Support\Facades\DB;
use App\Models\TransactBalance;
use App\Models\User;
use App\Models\System;

class ApiWallet
{
    public static function criaUsuario(User $user)
    {

        $data = [
            'banca_codigo' => env('banca_codigo'),
            'people_id' => $user->id ,         
            'name' => $user->name,
            'email' => $user->email,
            'balance' => $user->balance == null ? 0 : $user->balance ,
            'bonus' => $user->bonus == null ? 0 : $user->bonus,
            'available_withdraw' => $user->available_withdraw == null ? 0 : $user->available_withdraw,
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

        $response = curl_exec($curl);
        curl_close($curl);
        
        $response = json_decode($response);

    if (isset($response->error)) {
        echo '<pre>';
        print_r($response);
        echo '</pre>';
        exit;
    }
    return true;
    }

    public static function updateUsuario(User $user)
    {
        $data = [
            'people_id' => $user->id ,         
            'name' => $user->name,
            'email' => $user->email,
            'balance' => $user->balance == null ? 0 : $user->balance ,
            'bonus' => $user->bonus == null ? 0 : $user->bonus,
            'available_withdraw' => $user->available_withdraw == null ? 0 : $user->available_withdraw,
        ];
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://app.loteriabr.com/api/people/' . env('banca_codigo'),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'PUT',
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
            CURLOPT_SSL_VERIFYPEER => false,
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        
        $response = json_decode($response);

    if (isset($response->error)) {
        echo '<pre>';
        print_r($response);
        echo '</pre>';
        exit;
    }
    return true;
    }

    public static function getUsuario($id)
    {

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://app.loteriabr.com/api/people/' . $id .'/' . env('banca_codigo'),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
            CURLOPT_SSL_VERIFYPEER => false,
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        
        $response = json_decode($response);

    if (isset($response->error)) {
        echo '<pre>';
        print_r($response);
        echo '</pre>';
        exit;
    }
    return $response;
    }

}