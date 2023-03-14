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
}