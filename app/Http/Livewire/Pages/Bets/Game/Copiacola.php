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
    public $exibirBotao = true;
    public $loading = false; // propriedade para controlar o estado de carregamento
    public $valorTextArea = '';



    public function updated($field)
    {
        
    }

    public function mount($typeGame, $clients)
    {
        $this->dezena = [];
        //array_push($this->dezena, 1);
        if (!empty($typeGame)) {
            $this->typeGame = $typeGame;
            $this->clients = $clients;
        }

        $this->dispatchBrowserEvent('customEvent', []);

    }
    protected $listeners = ['dezenas' => 'dezenas'];

    
    
    
    public function dezenas()
    {   
        $this->reset('msg');
        $this->reset('values');
    
        $this->loading = true; // ativar o indicador de carregamento
    
        $this->dezena = preg_replace("/[,. _-]/", " ", $this->dezena);
    
        if (is_string($this->dezena)) {
            $this->dezena = explode("\n", $this->dezena);
        } else {
            // Se $this->dezena não for uma string, defina como uma array vazia
            $this->dezena = [];
        }
    
        foreach ($this->dezena as &$linha) {
            $linha = rtrim($linha);
        }
    
        $tmp = array_filter($this->dezena);
        $str = implode("\n", $tmp);
        $this->dezena = explode("\n", $str);
    
        $typeGameValue;
        $result;
        $this->contadorJogos = 0;
        $this->exibirBotao = false;
    
        $typeGame = TypeGame::find($this->typeGame->id);
        $maxNumbers = $typeGame->numbers;
        
        foreach ($this->dezena as $linhaIndex => $dezenaConvert) {
            $linhaIndex++;
            $this->contadorJogos++;
            
            $string = $dezenaConvert;
            if (!empty($string)) {
                $string = preg_replace('/^\h*\v+/m', '', $string);
                $words = explode(" ", $string);
                $result = count($words);
            } else {
                continue; // Pule esta iteração se $string estiver vazio
            }
    
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
                
                if (!empty($dezenasForaDoLimite) && $this->typeGame->id != 11) {
                    $this->msg = "Dezenas fora do intervalo permitido (1 a $maxNumbers): " . implode(", ", $dezenasForaDoLimite); 
                }  else if(!empty($dezenasForaDoLimite)&& $this->typeGame->id == 11 && min($dezenasForaDoLimite) != 0){ // se for loto mania fica de 0 a 99
                    $this->msg = "Dezenas fora do intervalo permitido (0 a $maxNumbers): " . implode(", ", $dezenasForaDoLimite); 
                }
                else{
                    $this->podeCriar = true;
                }
    
                $allowedDezenas = $typeGame->typeGameValues()->pluck('numbers')->toArray();
                
                if (!in_array($result, $allowedDezenas)) {
                    $totalDezenasNaLinha = count($words);
                    $this->msg = "A quantidade  de dezenas na linha $linhaIndex não é permitida para este tipo de jogo. Total de dezenas na linha: $totalDezenasNaLinha.";
                    $this->controle = 0;
                }
            }
        }
     
        $this->loading = false;
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
        $this->emit('atualizacao-dezena');


        $User = Auth::user();
        $FiltroUser = client::where('email', $User['email'])->first();
        $this->FiltroUser = $FiltroUser;

        $busca = TypeGameValue::select('numbers')->where('type_game_id', $this->typeGame->id)->orderBy('numbers', 'asc')->get();
        $this->busca = $busca;

        return view('livewire.pages.bets.game.copiacola', compact('User', 'FiltroUser', 'busca'));
    }
}