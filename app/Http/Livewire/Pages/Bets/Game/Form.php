<?php

namespace App\Http\Livewire\Pages\Bets\Game;

use App\Models\TypeGame;
use App\Models\TypeGameValue;
use Livewire\Component;
use App\Models\Client;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\Role;
class Form extends Component
{
    public $showList = false;
    public $clientId;
    public $typeGame;
    public $clients;
    public $numbers;
    public $matriz;
    public $selectedNumbers;
    public $values;
    public $selecionado = 0;
    public $search;
    public $message;

    public function sendMessage()
    {
        $this->emitUp('messageSent', $this->numbers);
    }

    public function mount($typeGame, $clients)
    {

        $this->selectedNumbers = [];
        if (!empty($typeGame)) {
            $this->typeGame = $typeGame;
            $this->clients = $clients;

            $this->numbers = $typeGame->numbers;
            $this->matriz($typeGame->numbers, $typeGame->columns);
        }

    }
    public function selecionaTudo(){
         $startnumberselected = 0;

        if($this->selecionado == 0){
         foreach ($this->selectedNumbers as $value) {
            array_pop($this->selectedNumbers);
        }
        for($i = 1;$i <= $this->typeGame->numbers; $i++){
        $startnumberselected = $i;
        array_push($this->selectedNumbers, $startnumberselected);
        }
        $this->selecionado = 1;
        $this->verifyValue();
         }

    }
    public function setId($client)
    {
        $this->clientId = $client["id"];

        $this->search = $client["name"] . ' ' . $client["last_name"] . ' - ' . $client["email"];

        if (isset($client["ddd"])) {
            $this->search .= ' - ' . $client["ddd"];
        }

        if (isset($client["phone"])) {
            $this->search .= ' - ' . $client["phone"];
        }

        $this->showList = false;
    }

    public function updatedSearch($value)
    {

        $userlogado = Auth::user();

        if (auth()->user()->hasRole('Administrador')) {

            $this->clients = Client::where(function($query) {
                $query->where(DB::raw("CONCAT(name, ' ', last_name)"), 'like', "%{$this->search}%");
            })
            ->get();

        } else {

            $this->clients = User::where('indicador', $userlogado->id)
                ->where(function($query) {
                $query->where(DB::raw("CONCAT(name, ' ', last_name)"), 'like', "%{$this->search}%");
            })
            ->get();
        }

        $this->showList = true;
    }

    public function selectNumber($number)
    {
        if(in_array($number, $this->selectedNumbers)){
            $key = array_search($number, $this->selectedNumbers);
            if($key!==false){
                unset($this->selectedNumbers[$key]);
            }
        }else{
            array_push($this->selectedNumbers, $number);
        }

        $this->verifyValue();

    }

    public function completeGame($quantidadeTotal) {
        $numerosSelecionados = $this->selectedNumbers;
        $numerosPreselecionados = $this->selectedNumbers; // Salva os números pré-selecionados
        $quantidadeSelecionados = count($numerosSelecionados);
        $numerosRestantes = $quantidadeTotal - $quantidadeSelecionados;
    
        // Gera números aleatórios para completar o jogo
        $numerosCompletos = [];
        $rangeMax = $this->typeGame->numbers;
        $numInicial = 1;
    
        if ($this->typeGame->category == 'loto_mania') {
            $rangeMax = $this->typeGame->numbers - 1;
            $numInicial = 0;
        }
    
        for ($i = 0; $i < $numerosRestantes; $i++) {
            $addNumeroAleatorio = rand($numInicial, $rangeMax);
    
            // Verifica se o número já está na lista de números selecionados
            while (in_array($addNumeroAleatorio, $numerosSelecionados) || in_array($addNumeroAleatorio, $numerosCompletos)) {
                $addNumeroAleatorio = rand($numInicial, $rangeMax);
            }
    
            // Adiciona o número aleatório à lista de números completos
            $numerosCompletos[] = $addNumeroAleatorio;
        }
    
        // Combina os números pré-selecionados com os números completos
        $jogoCompleto = array_merge($numerosPreselecionados, $numerosCompletos);
    
        // Atualiza os números selecionados
        $this->selectedNumbers = $jogoCompleto;
        $this->verifyValue(); // Você precisará ajustar esta função conforme necessário
    }
    
    

    public function randomNumbers($quantidadeAletorizar){
        $selectedNumbers = 0;
        $numerosAletatorios = array();
        $loopVezes = $quantidadeAletorizar;
        $rangeMax = $this->typeGame->numbers;
        $numInicial = 1;

        if($this->typeGame->category == 'loto_mania'){
            $rangeMax = $this->typeGame->numbers - 1;
            $numInicial = 0;

        }

        for($i = 0; $i != $loopVezes ; $i++){

            $addNumeroAleatorio =  rand($numInicial, $rangeMax);

            // condição pra checar se o número já existe na lista
            while (in_array($addNumeroAleatorio, $numerosAletatorios)){
                $addNumeroAleatorio =  rand($numInicial, $rangeMax);
            }

            array_push($numerosAletatorios, $addNumeroAleatorio);

        }
        // $selectedNumbers = array();
        // $numerosAletatorios = json_decode($numerosAletatorios);
        $selectedNumbers = $numerosAletatorios;

        $this->selectedNumbers = $numerosAletatorios;
        $this->verifyValue();
    }

    public function verifyValue()
    {
        $numbers = count($this->selectedNumbers);

        $typeGameValue = TypeGameValue::where([
            ['type_game_id', $this->typeGame->id],
            ['numbers', $numbers],
        ])->get();

        if( !empty($typeGameValue)){
            $this->values = $typeGameValue;
        }

    }

    public function matriz($numbers, $columns)
    {
        $matriz = [];
        $line = [];
        $index = 0;
        $i = 0;
        $numInicial = 1;

        //if - se for lotomania, variavel ficar com 0
        if ($this->typeGame->category == "loto_mania") {
            $numInicial = 0;
        }

        $upperLimit = ($this->typeGame->category == 'loto_mania') ? $numbers - 1 : $numbers; //se for lotomania o limite fica number-1 (99) / se nao for, fica so number

        foreach (range($numInicial, $upperLimit) as $number) {
            if ($i < $columns) {
                $i++;
            } else {
                $index++;
                $i = 1;
            }
            $matriz[$index][] = $number;
        }

        $this->matriz = $matriz;
    }

    public function render()
    {
        $User = Auth::user();
        $FiltroUser = Client::where('email', $User['email'])->first();
        $this->FiltroUser = $FiltroUser;

        $busca = TypeGameValue::select('numbers')->where('type_game_id', $this->typeGame->id)->orderBy('numbers', 'asc')->get();
        $this->busca = $busca;

        return view('livewire.pages.bets.game.form', compact('busca', 'FiltroUser', 'User'));
    }
}
