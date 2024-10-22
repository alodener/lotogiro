<?php

namespace App\Http\Livewire\Pages\Dashboards\Salebichao;

use App\Models\BichaoGames;
use App\Models\BichaoHorarios; 
use App\Models\User;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Collection;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class Table extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $auth;
    public $users = [];
    public $showList = false;
    public $search;
    public $userId;
    public $perPage = 10;
    public $range = 1;
    public $status = null;
    public $value;
    public $dateStart;
    public $dateEnd;
    public $i;
    public $sorts = [];
    public $filters = [
        "search" => null
    ];
    public $horario; // Nova propriedade para o filtro de horário
    public $horarios = []; // Para armazenar os horários
    public $valor;


    public function mount()
    {
        $this->auth = auth()->user();
        $this->range = 3; // Inicia com 'diário' por padrão
    
        if ($this->auth->hasPermissionTo('read_all_sales')) {
            $this->updatedSearch('Admin');
        }
    
        $this->perPage = session()->get('perPage', 10);
    
        $this->horarios = BichaoHorarios::select('horario')
                            ->distinct()
                            ->orderBy('horario', 'asc')
                            ->get();
    }
    


    public function updatedSearch($value)
    {
    if ($this->auth->hasPermissionTo('read_all_gains')) {
        $this->users = User::where(function($query) {
            $query->where(DB::raw("CONCAT(name, ' ', last_name)"), 'like', "%{$this->search}%");
        })
        ->take(10)
        ->get();
    }
    $this->showList = true;
    }
    public function setId($user)
    {
        if ($this->auth->hasPermissionTo('read_all_sales')) {
            $this->userId = $user["id"];
            $this->search = $user["name"] . ' ' . $user["last_name"] . ' - ' . $user["email"];
            $this->showList = false;
        }
    }

    public function clearUser()
    {
        if ($this->auth->hasPermissionTo('read_all_sales')) {
            $this->reset(['search', 'userId']);
            $this->updatedSearch('Admin');
        }
    }

    public function clearFilters()
    {
        $this->reset('filters');
    }

    public function sortBy($column)
    {
        if (!isset($this->sorts[$column])) return $this->sorts[$column] = 'desc';
        if ($this->sorts[$column] === 'desc') return $this->sorts[$column] = 'asc';
        unset($this->sorts[$column]);
    }

    public function buscar()
{
    $query = BichaoGames::query();

    // Outros filtros já existentes
    if (!empty($this->valor)) {
        $query->where('premio_a_receber', '>=', $this->valor);
    }

    $this->registros = $query->get();
}


    public function applySorting($query)
    {
        foreach ($this->sorts as $column => $direction) {
            $query->orderBy($column, $direction);
        }
        return $query;
    }

    public function updatedFilters()
    {
        $this->resetPage();
    }
    public function applyFilters()
    {
        // Reseta a paginação para a primeira página
        $this->horarios = BichaoHorarios::select('horario')
        ->distinct()
        ->orderBy('horario', 'asc')
        ->get();

    // Reseta a página para a primeira
    $this->resetPage();
    }



    public function updatedRange($value)
    {
        $this->resetPage(); 
        //$this->applyFilters(); // Isso vai garantir que o filtro seja aplicado corretamente
    }
    

    public function updatedStatus($value)
    {
        $this->resetPage();
    }

    public function updatedPerPage($value)
    {
        $this->resetPage();
        session()->put('perPage', $value);
    }

    public function updatedUser($value)
    {
        dd($value);
    }

    public function submit()
    {
        $dataValidated = $this->validate([
            'dateStart' => 'required',
            'dateEnd' => 'required',
        ]);

    }

    public function filterRange()
{
    $now = Carbon::now();
    switch ($this->range) {
        case 1: // Mensal
            $dateStart = $now->startOfMonth()->toDateString();
            $dateEnd = $now->endOfMonth()->toDateString();
            break;
        case 2: // Últimos 7 dias
            $dateStart = $now->copy()->subDays(6)->startOfDay()->toDateString(); // 6 dias antes de hoje
            $dateEnd = $now->endOfDay()->toDateString(); // Final do dia atual
            break;
        case 3: // Diário
            $dateStart = $now->startOfDay()->toDateString();
            $dateEnd = $now->endOfDay()->toDateString();
            break;
        case 4: // Período customizado
            $dateStart = Carbon::parse(strtotime(str_replace('/', '-', $this->dateStart)))->toDateString();
            $dateEnd = Carbon::parse(strtotime(str_replace('/', '-', $this->dateEnd)))->toDateString();
            break;
    }

    return [
        'dateStart' => $dateStart,
        'dateEnd' => $dateEnd,
    ];
}


    public function filterUser($query)
    {

        $query
            ->when($this->userId, fn($query, $search) => $query->where('user_id', $this->userId));

        return $query;
    }

    public function filterStatus($query)
    {
        if (!empty($this->status)) {
            $status = $this->status == 1 ? false : true;
            $query->where('commission_payment', $status);
        }

        return $query;
    }

    public function sumValues($query, $id)
    {
         $value = 0;
        $row =  $query->where('user_id', $id)->count();
        if($row>0){
       
            $this->i = $query->where('user_id', $id)->count();

            $result = $query->where('user_id', $id)->get();
                foreach ($result as $item) {
            $value += $item->valor;
            
            
        }
            
        }else{
            $value = 0;
            $this->i = 0;
        }

        $this->value = $value;

        return $query;
    }
     public function sumValuesTodos($query)
    {       
            $this->i = $query->count();
            $value = 0;
            $result = $query->get();
            foreach ($result as $item) {
                $value += $item->valor;            
            }
            
        $this->value = $value;

        return $query;
    }
    public function sumValuesEscolhido($query, $id)
    {
         $value = 0;
        $row = $query->where('user_id', $id)->count();
        if($row>0){
            $this->i = $query->where('user_id', $id)->count();
            $result = $query->where('user_id', $id)->get();
                foreach ($result as $item) {
            $value += $item->valor;
            
            
        }
            
        }else{
            $value = 0;
            $this->i = 0;
        }

        $this->value = $value;

        return $query;
    }

    public function filterHorario($query)
    {
        if (!empty($this->horario)) {
            $query->whereHas('horario', function ($query) {
                $query->where('horario', $this->horario);
            });
        }
    
        return $query;
    }

    public function updatedHorario($value)
    {
       $this->resetPage();
    }

    public function reloadHorarios()
{
    // Recarrega os horários do banco de dados
    $this->horarios = BichaoHorarios::select('horario')
        ->distinct()
        ->orderBy('horario', 'asc')
        ->get();

    // Reseta a seleção atual
    $this->reset('horario');
}


    public function runQueryBuilder()
{
    // Inicializa a consulta com o join entre bichao_games e bichao_horarios
    $query = BichaoGames::query()
        ->join('bichao_horarios', 'bichao_games.horario_id', '=', 'bichao_horarios.id')
        ->select(
            'bichao_games.*',
            'bichao_horarios.horario as horario_completo'
        );

    // Aplica o filtro de usuário
    if (!$this->auth->hasPermissionTo('read_all_sales')) {
        $query->where('bichao_games.user_id', $this->auth->id);
    }   

    // Aplica o filtro de período
    $filterRange = $this->filterRange();
    $query->whereDate('bichao_games.created_at', '>=', $filterRange['dateStart'])
          ->whereDate('bichao_games.created_at', '<=', $filterRange['dateEnd']);

    // Aplica o filtro de horário
    if (!empty($this->horario)) {
        $query->where('bichao_horarios.horario', $this->horario);
    }

    if (!empty($this->valor)) {
        // Remove pontos e converte para decimal tanto no banco quanto no input do usuário
        $query->where(DB::raw('CAST(REPLACE(REPLACE(premio_a_receber, \'.\', \'\'), \',\', \'\') AS DECIMAL(10, 2))'), '>=', floatval(str_replace([',', '.'], '', $this->valor)));
    }
   // dd($this->filterRange(), $this->horario, $this->valor);
    // Aplica o filtro de usuário, status e soma de valores
    $query = $this->filterUser($query);
    $query = $this->filterStatus($query);

    if (!$this->auth->hasPermissionTo('read_all_sales')) {
        $query = $this->sumValues($query, $this->auth->id);
    } else {
        if ($this->userId !== null) {
            $query = $this->sumValuesEscolhido($query, $this->userId);
        } else {
            $query = $this->sumValuesTodos($query);
        }
    }

    return $query;
}



    public function getReport()
    {
        $games = $this->runQueryBuilder()->with(['user', 'client', 'modalidade', 'horario'])->get();
        $collection = new Collection();
        foreach ($games as $game) {
            $collection = $collection->push($game->toArray());
        }
       $collection = $collection->sortByDesc('horario.horario')->groupBy('horario.banca');

        $data = [
            'dateFilter' => $this->filterRange(),
            'collection' => $collection,
            'subtotal' => 0,
            'total' => 0
        ];

        $pdf = PDF::loadView('admin.layouts.pdf.salesbichao', $data)->output();

        $fileName = 'Relat贸rio de Vendas - ' . Carbon::now()->format('d-m-Y h:i:s') . '.pdf';

        return response()->streamDownload(
            fn() => print($pdf),
            $fileName
        );
    }

    public function render()
    {
        return view('livewire.pages.dashboards.salebichao.table', [
            "games" => $this->runQueryBuilder()->paginate($this->perPage),
        ]);
    }
}
