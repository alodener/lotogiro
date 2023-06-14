<?php

namespace App\Http\Livewire\Pages\Bets\Game;

use App\Models\TypeGame;
use App\Models\TypeGameValue;
use Livewire\Component;
use App\Models\Client;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

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
    public $teste;


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
    $this->search = $value;

    $clients = Client::where(function ($query) {
        $query->where('name', 'like', "%{$this->search}%")
            ->orWhere('last_name', 'like', "%{$this->search}%")
            ->orWhere('email', 'like', "%{$this->search}%");
    })->orWhereRaw("CONCAT(name, ' ', last_name) like ?", ["%{$this->search}%"])
      ->get();

    $users = User::where(function ($query) {
        $query->where('name', 'like', "%{$this->search}%")
            ->orWhere('last_name', 'like', "%{$this->search}%")
            ->orWhere('email', 'like', "%{$this->search}%");
    })->orWhereRaw("CONCAT(name, ' ', last_name) like ?", ["%{$this->search}%"])
      ->get();

    // Selecionar registros mais completos para cada cliente presente em ambas as tabelas
    $combinedResults = collect([]);
    foreach ($clients as $client) {
        $user = $users->firstWhere('email', $client->email);
        if ($user) {
            // Comparar os registros e selecionar o mais completo
            $mostComplete = $this->compareRecords($client, $user);
            $combinedResults->push($mostComplete);
        } else {
            $combinedResults->push($client);
        }
    }

    // Adicionar os clientes apenas presentes na tabela users
    $usersOnly = $users->whereNotIn('email', $clients->pluck('email'));
    $combinedResults = $combinedResults->concat($usersOnly);

    $this->clients = $combinedResults;
    $this->showList = true;
}

private function compareRecords($client, $user)
{
    // Comparar as informações dos registros e selecionar o mais completo
    $clientScore = $this->calculateRecordScore($client);
    $userScore = $this->calculateRecordScore($user);

    return $clientScore >= $userScore ? $client : $user;
}

private function calculateRecordScore($record)
{
    $score = 0;

    if ($record->name) {
        $score += 1;
    }
    if ($record->last_name) {
        $score += 1;
    }
    if ($record->email) {
        $score += 1;
    }
    if ($record->ddd && $record->phone) {
        $score += 1;
    }

    return $score;
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

    public function randomNumbers($quantidadeAletorizar){
        $selectedNumbers = 0;
        $numerosAletatorios = array();
        $loopVezes = $quantidadeAletorizar;
        $rangeMax = $this->typeGame->numbers;

        for($i = 0; $i != $loopVezes ; $i++){

            $addNumeroAleatorio =  rand(1, $rangeMax);
            
            // condição pra checar se o número já existe na lista
            while (in_array($addNumeroAleatorio, $numerosAletatorios)){
                $addNumeroAleatorio =  rand(1, $rangeMax);
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

        foreach (range(1, $numbers) as $number) {
            if ($i < $columns) {
                $i++;
            } else {
                $index++;
                $i = 1;
            }
            $matriz[$index][] = array_push($line, $number);
        }

        $this->matriz = $matriz;
    }

    public function render()
    {
        $User = Auth::user();
        $FiltroUser = client::where('email', $User['email'])->first();
        $this->FiltroUser = $FiltroUser;

        $busca = TypeGameValue::select('numbers')->where('type_game_id', $this->typeGame->id)->orderBy('numbers', 'asc')->get();
        $this->busca = $busca;

        return view('livewire.pages.bets.game.form', compact('busca', 'FiltroUser', 'User'));
    }
}
