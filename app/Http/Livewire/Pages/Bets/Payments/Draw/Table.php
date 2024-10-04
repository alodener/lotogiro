<?php

namespace App\Http\Livewire\Pages\Bets\Payments\Draw;

use App\Http\Controllers\Admin\Pages\Dashboards\ExtractController;
use Illuminate\Support\Facades\DB;
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

    public $dateStart, $dateEnd, $auth, $perPage, $value, $searchUser, $searchClient, $client_id, $user_id, $users, $clients;
    public $showList = false;
    public $showList2 = false;
    public $userId, $clientId;
    public $filters = [
        "searchUser" => null,
        "searchClient" => null,
    ];
    public $range = 3; 
    public $selectedUserId;


    public function setId($userId)
    {
        logger('User ID received: ', ['userId' => $userId]); // Loga o ID recebido
        $this->userId = $userId; // Define a variável de filtro
        $this->searchUser = ''; // Limpa o campo de pesquisa
        $this->showList = false; // Esconde a lista
        $this->updatedFilters(); // Atualiza os filtros e reseta a paginação
    }

    public function mount()
    {
        $this->auth = auth()->user();

        if (empty($this->dateStart) && empty($this->dateEnd)) {
            $this->dateStart = Carbon::now()->startOfMonth()->format('d/m/Y');
            $this->dateEnd = Carbon::now()->format('d/m/Y');
        }
        $this->perPage = session()->get('perPage', 10); // Inicializa com 10 registros
        $this->range = 3;
    }

    public function clearFilters()
    {
        $this->reset('filters');
    }

    public function updatedFilters()
    {
        $this->resetPage();
    }

    public function updatedPerPage($value)
    {
        $this->resetPage();
        session()->put('perPage', $value);
    }

   public function updatedSearchUser($value)
    {
        if ($this->auth->hasPermissionTo('read_all_sales')) {
            $this->users = User::select('id', 'name', 'last_name')
                ->where(DB::raw("CONCAT(name, ' ', last_name)"), 'like', "{$this->searchUser}%")
                ->limit(10) // Limita a quantidade de resultados para 10
                ->get();
        }

        $this->showList = true;
    }

    public function updatedSearchClient($value)
    {
        if ($this->auth->hasPermissionTo('read_all_sales')) {
            $this->clients = Client::where(function ($query) {
                $query->where(DB::raw("CONCAT(name, ' ', last_name)"), 'like', "%{$this->searchClient}%");
            })
            ->get();
        }
        
        $this->showList2 = true;
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
                    'client_id' => $game->client_id,
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
                
                ExtractController::store($extract);
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
            ->pluck('draws.games'); // Use pluck para obter apenas os jogos

        $array = [];
        foreach ($draws as $draw) {
            $games = explode(',', $draw);
            $array = array_merge($array, $games);
        }
        
        if (!empty($array)) {
            $query->whereIn('id', $array);
        } else {
            $query->where('id', '<', 0);
        }

        return $query;
    }

    public function filterUser($query)
    {
        if (!empty($this->userId)) {
            $query->where('user_id', $this->userId);
        }
        return $query;
    }

    public function filterClient($query)
    {
        $query->when($this->clientId, fn($query) => $query->where('client_id', $this->clientId));
        return $query;
    }

    public function sumValues($query)
    {
        return $query->sum('premio'); // Usar sum diretamente na query
    }

    public function filterRange()
    {
        if ($this->range == 3) { // Se o range for 'diário'
            $this->dateStart = Carbon::now()->startOfDay()->format('d/m/Y');
            $this->dateEnd = Carbon::now()->endOfDay()->format('d/m/Y');
        } elseif ($this->range == 2) { // Se o range for 'semanal'
            $this->dateStart = Carbon::now()->startOfWeek()->format('d/m/Y');
            $this->dateEnd = Carbon::now()->endOfWeek()->format('d/m/Y');
        } elseif ($this->range == 1) { // Se o range for 'mensal'
            $this->dateStart = Carbon::now()->startOfMonth()->format('d/m/Y');
            $this->dateEnd = Carbon::now()->endOfMonth()->format('d/m/Y');
        }
        
        return [
            'dateStart' => Carbon::createFromFormat('d/m/Y', $this->dateStart)->format('Y-m-d'),
            'dateEnd' => Carbon::createFromFormat('d/m/Y', $this->dateEnd)->format('Y-m-d'),
        ];
    }

    public function runQueryBuilder()
    {
        $query = Game::query();

        // Aplica todos os filtros
        $query = $this->filterUser($query);
        $query = $this->filterClient($query);
        $query = $this->filterStatus($query);

        $filterRange = $this->filterRange();
        $query = $this->filterDraws($query, $filterRange['dateStart'], $filterRange['dateEnd']);

        // Adiciona a ordenação do mais recente para o menos recente
        $query->orderBy('created_at', 'desc'); 

        $this->value = $this->sumValues($query->clone()); // Clone para não afetar a query original

        return $query;
    }


    public function render()
    {
        $filterRange = $this->filterRange();

        $games = $this->runQueryBuilder()->paginate($this->perPage); // Paginação

        return view('livewire.pages.bets.payments.draw.table', [
            "games" => $games,
        ]);
    }
}
