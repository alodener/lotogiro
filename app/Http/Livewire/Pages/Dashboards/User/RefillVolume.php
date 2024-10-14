<?php

namespace App\Http\Livewire\Pages\Dashboards\User;

use Livewire\Component;
use Carbon\Carbon;
use Livewire\WithPagination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RefillVolume extends Component
{
    use WithPagination;

    public $range = 0, $dateStart, $dateEnd;
    public $perPage = 10;
    protected $paginationTheme = 'bootstrap';

    

    public function mount()
    {
        $this->dateStart = Carbon::now()->format('d/m/Y');
        $this->dateEnd = Carbon::now()->format('d/m/Y');
    }

    public function updatedPerPage()
    {
        $this->resetPage();
    }

    public function render(Request $request)
    {
        //dd($this->range);
        // Obtendo a data atual
        $now = Carbon::now();
        $periodo = [$now->format('Y-m-d') . ' 00:00:00', $now->format('Y-m-d') . ' 23:59:59'];

        if($this->range == 1){
            $this->dateStart = $now->subDay(1)->format('Y-m-d') . ' 00:00:00';
            $this->dateEnd = $now->format('Y-m-d') . ' 23:59:59';
            $periodo = [$now->subDay(1)->format('Y-m-d') . ' 00:00:00', $now->format('Y-m-d') . ' 23:59:59'];
        }
        if($this->range == 2){
            $this->dateStart = $now->subDays(7)->format('Y-m-d') . ' 00:00:00';
            $this->dateEnd = $now->addDays(7)->format('Y-m-d') . ' 23:59:59';
            $periodo = [$now->subDays(7)->format('Y-m-d') . ' 00:00:00', $now->addDays(7)->format('Y-m-d') . ' 23:59:59'];
        }
        if($this->range == 3){
            $this->dateStart = $now->subDays(30)->format('Y-m-d') . ' 00:00:00';
            $this->dateEnd = $now->addDays(30)->format('Y-m-d') . ' 23:59:59';
           
            $periodo = [$now->subDays(30)->format('Y-m-d') . ' 00:00:00', $now->addDays(30)->format('Y-m-d') . ' 23:59:59'];
            
        }
        if($this->range == 4){
            $periodo = [Carbon::createFromFormat('d/m/Y', $this->dateStart)->format('Y-m-d') . ' 00:00:00',
                Carbon::createFromFormat('d/m/Y', $this->dateEnd)->format('Y-m-d') . ' 23:59:59'];
        }
     
         // Consultando o número total de usuários cadastrados
         $totalCadastros = DB::table('users')
             ->whereBetween('created_at', $periodo)
             ->count();
       
        $start = $this->dateStart;
        $end = $this->dateEnd;
         // Consultando todos os usuários, mesmo sem recargas
         $users = DB::table('users')
             ->whereBetween('users.created_at', $periodo)
             ->leftJoin('transact_balance', function($join) use ($start, $end) {
                 $join->on('users.id', '=', 'transact_balance.user_id')
                 ->where(function($query) {
                     $query->where('transact_balance.type', 'like', '%add%')
                           ->orWhere('transact_balance.type', 'like', '%recarga%');
                 });
             })
             ->select(
                 'users.name', 
                 'users.last_name',
                 'users.created_at',
                 'users.email', 
                 DB::raw('COALESCE(SUM(transact_balance.value), 0) as total_recarga')
             )
             ->groupBy('users.id', 'users.name', 'users.email')
             ->paginate($this->perPage);
     
         // Calculando o volume total de recarga de todos os usuários
         $totalRecarga = DB::table('transact_balance')
             // Usando uma subconsulta para garantir que apenas as recargas de usuários cadastrados no período sejam consideradas
            ->whereIn('user_id', function($query) use ($periodo) {
            // Seleciona os IDs dos usuários que foram cadastrados no período definido
            $query->select('id')
              ->from('users')
              ->whereBetween('created_at', $periodo);
            })
             ->whereBetween('created_at', $periodo)
             ->where(function($query) {
                 $query->where('transact_balance.type', 'like', '%add%')
                       ->orWhere('transact_balance.type', 'like', '%recarga%');
                     })
             ->sum('value') ?? 0;
 
           
     
         // Retornando a view com os dados calculados
         return view('livewire.pages.dashboards.user.refill-volume', [
             'users' => $users,
             'totalCadastros' => $totalCadastros,
             'totalRecarga' => $totalRecarga,
             'dateStart' => $this->dateStart,
             'dateEnd' => $this->dateEnd,
         ]);
  
         }

       
    }

