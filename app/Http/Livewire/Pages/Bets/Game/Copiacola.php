<?php

namespace App\Http\Livewire\Pages\Bets\Game;

use Livewire\Component;

use App\Models\TypeGame;
use App\Models\TypeGameValue;
use App\Models\Client;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


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
    public $auth;
    public $podeCriar = false;


    public function mount($typeGame, $clients)
    {
        $this->dezena = [];
        //array_push($this->dezena, 1);
        if (!empty($typeGame)) {
            $this->typeGame = $typeGame;
            $this->clients = $clients;
        }

    }
    
    public function dezenas()
    {
        $this->reset('msg');
        $this->reset('values');
        $this->dezena = preg_replace("/[,. _-]/", " ", $this->dezena);
        $this->dezena = explode("\n", $this->dezena);
        $tmp = array_filter($this->dezena);
        $str = implode("\n", $tmp);
        $this->dezena = explode("\n", $str);
        $typeGameValue;
        $result;
        $this->contadorJogos = 0;

        $typeGame = TypeGame::find($this->typeGame->id);
        $maxNumbers = $typeGame->numbers;
        
        foreach ($this->dezena as $dezenaConvert) {
            $this->contadorJogos++;
            $string = preg_replace('/^\h*\v+/m', '', $dezenaConvert);
            $words = explode(" ", $string);
            $result = count($words);
            

            if ($this->msg == null) {
                $typeGameValue = TypeGameValue::where([
                    ['type_game_id', $this->typeGame->id],
                    ['numbers', $result],
                ])->get();

                if (!empty($typeGameValue)) {
                    $this->values = $typeGameValue;
                    $this->qtdDezena = $result;
                    $this->controle = 1;
                } else {
                    $this->msg = "Não existe valores para essa quantidade de Dezenas";
                }
                
                $dezenas = explode(" ", $string);
                $dezenasForaDoLimite = array_filter($dezenas, function ($dezena) use ($maxNumbers) {
                return ($dezena < 1 || $dezena > $maxNumbers);
                });

                if (!empty($dezenasForaDoLimite)) {
                    $this->msg = "Dezenas fora do intervalo permitido (1 a $maxNumbers): " . implode(", ", $dezenasForaDoLimite); 
                }  else {
                    $this->podeCriar = true;
                }
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

    public function clearUser()
    {
        $user = Auth::user();

        if ($user && $user->hasPermissionTo('read_all_gains')) {
            $this->reset(['search']);
            $this->updatedSearch('Admin');
        }
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
