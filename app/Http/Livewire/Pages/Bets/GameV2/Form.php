<?php

namespace App\Http\Livewire\Pages\Bets\GameV2;

use App\Models\TypeGame;
use App\Models\TypeGameValue;
use Livewire\Component;
use App\Models\Client;
use Illuminate\Support\Facades\Auth;

class Form extends Component
{
    public $typeGame;
    public $selectedNumbers;
    public $matriz;
    public $clientId;
    public $showList = false;
    public $search;

    public function mount($typeGame, $clients)
    {        $this->selectedNumbers = [];
        if (!empty($typeGame)) {
            $this->typeGame = $typeGame;
            $this->clients = $clients;

            $this->numbers = $typeGame->numbers;
            $this->matriz($typeGame->numbers, $typeGame->columns);
        }
    }

    public function setId($client)
    {
        $this->clientId = $client["id"];
        $this->search = $client["name"] . ' - ' . $client["cpf"]. ' - ' . $client["email"]. ' - ' . $client["ddd"].' - ' . $client["phone"];
        $this->showList = false;

    }

    public function updatedSearch($value)
    {
        $this->clients = Client::where("name", "like", "%{$this->search}%")->get();
        $this->showList = true;
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

    public function render()
    {
        $FiltroUser = client::where('email', auth()->user()->email)->first();
        $this->FiltroUser = $FiltroUser;

        $busca = TypeGameValue::select('id', 'numbers', 'multiplicador', 'maxreais')
            ->where('type_game_id', $this->typeGame->id)
            ->orderBy('numbers', 'asc')->get();
        $this->busca = $busca;

        return view('livewire.pages.bets.game-v2.form', compact('busca', 'FiltroUser'));
    }
}
