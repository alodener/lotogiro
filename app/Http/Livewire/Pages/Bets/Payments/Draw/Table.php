<?php

namespace App\Http\Livewire\Pages\Bets\Payments\Draw;

use App\Http\Controllers\Admin\Pages\Dashboards\ExtractController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use App\Models\Draw;
use App\Models\Game;
use App\Models\User;
use App\Models\Client;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';



    public $dateStart, $dateEnd, $auth, $perPage, $value, $searchUser, $searchClient, $client_id, $user_id, $startDate, $endDate, $users, $clients;
    public $showList = false;
    public $showList2 = false;
    public $userId, $clientId;
    public $range = 1;
    public $filters = [
        "searchUser" => null,
        "searchClient" => null,

    ];
   
    public function mount()
    {
        $this->auth = auth()->user();

        if (empty($this->dateStart) && empty($this->dateEnd)) {
            $this->dateStart = Carbon::now()->startOfMonth()->format('d/m/Y');
            $this->dateEnd = Carbon::now()->format('d/m/Y');
        }
        $this->updatedSearchUser('Admin');
        $this->updatedSearchClient('Admin');
        $this->perPage = session()->get('perPage', 10);
    }

    public function clearFilters()
    {
        $this->reset('filters');
    }

    public function updatedFilters()
    {
        $this->resetPage();
    }

    public function submit()
    {
        $dataValidated = $this->validate([
            'dateStart' => 'required',
            'dateEnd' => 'required',
        ]);
        
    } 
    
    
    public function updatedSearchUser($value)
    {
        if ($this->auth->hasPermissionTo('read_all_sales')) {
            $this->users = User::where(function($query) {
                $query->where(DB::raw("CONCAT(name, ' ', last_name)"), 'like', "%{$this->searchUser}%");
            })
            ->get();
        }
        
        $this->showList = true;
    }

    public function updatedSearchClient($value)
    {
        if ($this->auth->hasPermissionTo('read_all_sales')) {
            $this->clients = Client::where(function($query) {
                $query->where(DB::raw("CONCAT(name, ' ', last_name)"), 'like', "%{$this->searchClient}%");
            })
            ->get();
        }
        
        
        $this->showList2 = true;
    }


    public function updatedPerPage($value)
    {
        $this->resetPage();
        session()->put('perPage', $value);
    }

    public function pay()
    {
        $games = $this->runQueryBuilder()->get();

        if ($games->count() > 0) {
            foreach ($games as $game) {
                $game->prize_payment = true;
                $game->save();

                $extract = [
                    'type' => 2,
                    'value' => $game->premio,
                    'type_game_id' => $game->type_game_id,
                    'description' => 'Prêmio - Jogo de id: ' . $game->id,
                    'user_id' => $game->user_id,
                    'client_id' => $game->client_id
                ];

                
                $users = User::where([
                ['id', $game->user_id],
                ['type_client', 1],
                 ])->get();
                foreach ($users as $user) {
                $premio = $game->premio;
                $balance = $user->balance;
                $result = $balance + $premio;
                $user->balance = $result;
                $user->save();
                }
                $storeExtact = ExtractController::store($extract);
            }
            session()->flash('success', 'Pagamentos baixados com sucesso!');
        } else {
            session()->flash('error', 'Não foram encontrados pagamentos para baixar!');
        }

        return redirect()->route('admin.bets.payments.draws.index');
    }

    public function clearUser()
    {
        if ($this->auth->hasPermissionTo('read_all_sales')) {
            $this->reset(['searchUser', 'userId']);
            $this->updatedSearchUser('Admin');
        }
    }

    public function clearClient()
    {
        if ($this->auth->hasPermissionTo('read_all_sales')) {
            $this->reset(['searchClient', 'clientId']);
            $this->updatedSearchClient('Admin');
        }
    }


    public function getReport()
    {
    $games = $this->runQueryBuilder()->with(['user', 'typeGameValue'])->get();

    $collection = new Collection();
    $searchedNames = explode(' ', $this->searchUser);

    foreach ($games as $game) {
        $fullName = $game->user->name . ' ' . $game->user->last_name;
        $matchFound = false;



        foreach ($searchedNames as $searchedName) {
            if (stripos($fullName, $searchedName) !== false) {
                $matchFound = true;
                break; 
            }
        }

        if ($matchFound) {
            $collection = $collection->push($game->toArray());
        }
    }

    }


    public function filterStatus($query)
    {
        $query->where('prize_payment', false);

        return $query;
    }

    public function filterDraws($query, $dateStart, $dateEnd)
    {
        $startDate = Carbon::parse($dateStart)->startOfDay();
        $endDate = Carbon::parse($dateEnd)->endOfDay();
       
        
        $draws = Draw::join('competitions', 'competitions.id', '=', 'draws.competition_id')
        ->whereBetween('competitions.sort_date', [$startDate, $endDate])
        ->orderBy('draws.type_game_id')
        ->get();

        $array = [];

        if ($draws->count() > 0) {
            foreach ($draws as $draw) {
                $games = explode(',', $draw->games);
                foreach ($games as $game) {
                    array_push($array, $game);
                }
            }
                    
            $query->whereIn('id', $array);
        } else {
            $query->where('id', '<', 0);
        }


        return $query;
    }

    public function updatedRange($value)
    {
        $this->resetPage();
    }

    public function filterRange()
    {
        $now = Carbon::now();
        switch ($this->range) {
            case 1: 
                $dateStart = $now->startOfMonth()->toDateString();
                $dateEnd = $now->endOfMonth()->toDateString();
                break;
            case 2:
                $dateStart = $now->startOfWeek()->toDateString();
                $dateEnd = $now->endOfWeek()->toDateString();
                break;
            case 3:
                $dateStart = $now->startOfDay()->toDateString();
                $dateEnd = $now->endOfDay()->toDateString();
                break;
            case 4:
                $dateStart = Carbon::parse(strtotime(str_replace('/', '-', $this->dateStart)))->toDateString();
                $dateEnd = Carbon::parse(strtotime(str_replace('/', '-', $this->dateEnd)))->toDateString();
                break;
        }
  
    return [
        'dateStart' => $dateStart,
        'dateEnd' => $dateEnd,
        ];
    }


    public function setId($user)
    {
        if ($this->auth->hasPermissionTo('read_all_sales')) {
            $this->userId = $user["id"];
            $this->searchUser = $user["name"] . ' ' . $user["last_name"] . ' - ' . $user["email"];
            $this->showList = false;
        }
    }
    public function setIdClient($client)
    {
        if ($this->auth->hasPermissionTo('read_all_sales')) {
            $this->clientId = $client["id"];
            $this->searchClient = $client["name"] . ' ' . $client["last_name"] . ' - ' . $client["email"];
            $this->showList2 = false;
        }
    }

    public function filterUser($query)
    {
        $query->when($this->userId, fn($query, $searchUser) => $query->where('user_id', $this->userId));
        
        return $query;
    }

    public function filterClient($query)
    {
        $query->when($this->clientId, fn($query, $searchClient) => $query->where('client_id', $this->clientId));
        
        return $query;
    }

    public function sumValues($query)
    {
        $value = 0;

        foreach ($query->get() as $item) {
            $value += $item->premio;
        }

        $this->value = $value;

        return $query;
    }


    public function runQueryBuilder()
    {
        $query = Game::query();
        $filterRange = $this->filterRange();
        
                

        $query = $this->filterUser($query);
        $query = $this->filterClient($query);
        $query = $this->filterStatus($query);
        $query = $this->filterDraws($query, $filterRange['dateStart'], $filterRange['dateEnd']);
        $query = $this->sumValues($query);


       
        return $query;
    }


    public function render()
    {
        return view('livewire.pages.bets.payments.draw.table', [
            "games" => $this->runQueryBuilder()->paginate($this->perPage),
        ]);
    }
}
