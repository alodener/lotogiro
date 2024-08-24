<?php

namespace App\Helper;
use App\Models\System;

class Configs
{
    public static function getConfigLogo()
    
    {
        $nameConfig = "Logo do Sistema";
        $system = System::Where('nome_config', $nameConfig)->first() ;

        if(empty($system)) return;
       
        if(empty($system->value)){
            return "";
        }
        $return = env("APP_URL") . "/storage/" . $system->value;

        return $return; ;
    }

    public static function getTokenMercadoPago(){
        $nameConfig = "Accesstoken MercadoPago";
        $system = System::Where('nome_config', $nameConfig)->first() ;

        if(empty($system)) return;
       
        if(empty($system->value)){
            return "";
        }

        return $system->value;
    }

    public static function getTokenSuitPay(){
        $nameConfig = "Accesstoken SuitPay";
        $system = System::Where('nome_config', $nameConfig)->first() ;

        if(empty($system)) return;
       
        if(empty($system->value)){
            return "";
        }

        return $system->value;
    }

    public static function getTokenZoop(){
        $nameConfig = "Accesstoken Zoop";
        $system = System::Where('nome_config', $nameConfig)->first() ;

        if(empty($system)) return;
       
        if(empty($system->value)){
            return "";
        }

        return $system->value;
    }

    public static function getPlanoDeCarreira(){
        $nameConfig = "Plano de Carreira";
        $system = System::Where('nome_config', $nameConfig)->first() ;

        if(empty($system)) return;
       
        if(empty($system->value)){
            return "";
        }   

        return $system->value;
    }

    public static function getBichao(){
        $nameConfig = "Bichao";
        $system = System::Where('nome_config', $nameConfig)->first() ;

        if(empty($system)) return;
       
        if(empty($system->value)){
            return "";
        }   

        return $system->value;
    }
    public static function getTelegramUrlBot(){
        $nameConfig = "TelegramUrlBot";
        $system = System::Where('nome_config', $nameConfig)->first() ;

        if(empty($system)) return;
       
        if(empty($system->value)){
            return "";
        }

        return $system->value;
    }
    public static function getTelegramChatId(){
        $nameConfig = "TelegramChatId";
        $system = System::Where('nome_config', $nameConfig)->first() ;

        if(empty($system)) return;
       
        if(empty($system->value)){
            return "";
        }

        return $system->value;
    }

}