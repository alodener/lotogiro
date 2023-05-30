<?php

namespace App\Http\Livewire\Pages\Bets\Game;

use Livewire\Component;

use App\Models\TypeGame;
use App\Models\TypeGameValue;
use App\Models\Client;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class Copiacola extends Component
{
    public $dezena = [];
    public $typeGame;
    public $clients;
    public $users;
    public $clientId;
    public $showList = false;
    public $search;
    public $values;
    public $qtdDezena;
    public $msg;
    public $controle;
    public $contadorJogos = 0;

    public function mount($typeGame, $clients)
    {
        $this->dezena = [];
        //array_push($this->dezena, 1);
        if (!empty($typeGame)) {
            $this->typeGame = $typeGame;
            $this->clients = $clients;
        }

    }
    
    public function dezenas(){
        $this->reset('msg');
        $this->reset('values');
        $this->dezena = explode("\n", $this->dezena);
        $tmp = array_filter($this->dezena);
        $str = implode("\n", $tmp);
        $this->dezena = explode("\n", $str);
        $typeGameValue;
        $result;
        $contadorLinhas;
        $contador = 0;
        $this->contadorJogos = 0;
        foreach($this->dezena as $dezenaConvert){
            $this->contadorJogos++;
            $string = preg_replace('/^\h*\v+/m', '', $dezenaConvert);
            //$string = preg_replace('/\s+/', ' ', trim($dezenaConvert));
            $words = explode(" ", $string);
            $result =  count($words);
            if($contador == 0){
                 $contadorLinhas = $result;
            }
            if($result != $contadorLinhas){
                $this->msg = "Existem linhas de dezenas diferentes";
                break 1;
            }
            $contador = 1;
            // $contadorLinhas = $result;
            
        }
        if($this->msg == null){
        $typeGameValue = TypeGameValue::where([
            ['type_game_id', $this->typeGame->id],
            ['numbers', $result],
        ])->get();

        if( !empty($typeGameValue)){
            $this->values = $typeGameValue;
            $this->qtdDezena = $result;
            $this->controle = 1;
        }else{
            $this->msg= "Não existe valores para essa quantidade de Dezenas";
        }
    }
 
    }
    public function setId($client)
    {
        $this->clientId = $client["id"];
        $this->search = $client["name"] . ' ' . $client["last_name"] . ' - ' . ($client["cpf"] ?? '') . ' ' . $client["email"] . ' - ' . $client["ddd"] . ' - ' . $client["phone"];
        $this->showList = false;
    }
    

    public function updatedSearch($value)
{
    $this->search = $value;

    $searchTerms = explode(' ', $this->search);
    $firstName = $searchTerms[0] ?? '';
    $lastName = $searchTerms[1] ?? '';

    $clientsFromClients = Client::query();
    $clientsFromUsers = User::query();

    if (!empty($firstName)) {
        $clientsFromClients->where('name', 'like', $firstName . '%');
        $clientsFromUsers->where('name', 'like', $firstName . '%');
    }

    if (!empty($lastName)) {
        $clientsFromClients->where('last_name', 'like', $lastName . '%');
        $clientsFromUsers->where('last_name', 'like', $lastName . '%');
    }

    $clientsFromClients->select('id', 'name', 'last_name', 'email', 'ddd', 'phone');
    $clientsFromUsers->select('id', 'name', 'last_name', 'email', \DB::raw('NULL as ddd'), \DB::raw('NULL as phone'));

    $clients = $clientsFromClients->union($clientsFromUsers)
        ->select('id', 'name', 'last_name', 'email', 'ddd', 'phone')
        ->get();

    $uniqueClients = $clients->unique(function ($client) {
        return $client['name'] . $client['last_name'] . $client['email'];
    });

    $this->clients = $uniqueClients->values();

    $this->showList = true;
}

    
    
    
    
    
    

    public function clearUser()
    {
            $this->reset(['search', 'clientId']);
           
    }

    public function render()
    {
        $User = Auth::user();
        $FiltroUser = client::where('email', $User['email'])->first();
        $this->FiltroUser = $FiltroUser;

        $busca = TypeGameValue::select('numbers')->where('type_game_id', $this->typeGame->id)->orderBy('numbers', 'asc')->get();
        $this->busca = $busca;

        return view('livewire.pages.bets.game.copiacola', compact('User', 'FiltroUser', 'busca'));
    }
}
