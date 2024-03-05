<?php

namespace App\Libs\Matriz;

use Illuminate\Support\Facades\Http;

class Matriz{

    private $matriz;

    public function __construct(){
        $this->matriz = env('APP_MATRIZ');
    }

    public function loteriaLog(array $dados){
        Http::post($this->matriz.'/api/apostas-feitas', $dados);
    }

}