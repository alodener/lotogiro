<?php

namespace App\Http\Livewire\Pages\Dashboards\Extract;

use Livewire\Component;
use Carbon\Carbon;
use App\Models\TransactBalance;
use App\Models\User;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use App\Models\ModelHasRole;

class NewExtract extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $range = 0, $dateStart, $dateEnd, $perPage = 10;
    public $dtS, $dtF;
    public $searchTerm = '';
    public $selectedUserId;
    private $transacts;
    public $userTransactions = [];
    public $searching = false;
    public $selectedUsers = [];
    public $isAdmin;
    public $adminFilter;

    public function mount()
    {
        $this->dateStart = Carbon::now()->format('d/m/Y');
        $this->dateEnd = Carbon::now()->format('d/m/Y');
    }

    public function search()
    {
        // Verifica se as datas foram fornecidas pelo usuário
        if (empty($this->dateStart) || empty($this->dateEnd)) {
            $this->addError('dateFieldsFilled', 'Por favor, forneça ambas as datas.');
            return;
        }
        $dataFromatadaInicial = Carbon::parse($this->dtS)->format('d/m/Y');
        $dataFromatadaFinal = Carbon::parse($this->dtF)->format('d/m/Y');
      
        $this->dateStart = $dataFromatadaInicial;
        $this->dateEnd = $dataFromatadaFinal;

    }

    public function getTransactsProperty()
    {
        return $this->transacts;
    }

    public function responsibleUser()
    {
        return $this->belongsTo(User::class, 'user_id_sender');
        
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function selectUser($userId, $userName)
    { 
        // transações do usuário selecionado
        $this->selectedUserId = $userId;
        $this->searchTerm = $userName;

        $this->isAdmin = $this->isAdminF($userId);

        $this->selectedUser = [
            'id' => $userId,
            'name' => $userName,
            'isAdmin' => $this->isAdmin,
        ];

         if (!$this->isAdmin) {
        $this->adminFilter = null;
    }
        
    }
    public function isAdminF($userId)
    {
        return in_array($userId, $this->getAdmins()->pluck('id')->toArray());
    }
    public function getAdmins()
    {
        
        return User::whereIn('id', ModelHasRole::where('role_id', 1)->pluck('model_id'))->get();
    }

    public function updateAdminFilter()
    {
        $this->isAdmin = true; 
        $this->selectedUserId = null; 
        $this->render(); 
    }
    
    public function render()
    {
        $admins = $this->getAdmins();
        $users = User::where(DB::raw("CONCAT(name, ' ', last_name)"), 'like', "%{$this->searchTerm}%")
             ->whereNotIn('id', $admins->pluck('id')) 
             ->get();
         
        
        
        $transactsQuery = TransactBalance::query();
        $transactsQuery->where(function ($query) {        
            $query->where('type', 'LIKE', '%Recarga efetuada por meio da plataforma%')
                ->orWhere('wallet', 'LIKE', '%bonus%')
                ->orWhere(function ($query) {
                    $query->where('type', 'LIKE', '%Add por Admin%')
                        ->where('wallet', 'LIKE', '%balance%');
                });
        });
         
      
        if($this->selectedUserId > 0  && !$this->isAdmin){ 

            $transactsQuery->where('user_id', $this->selectedUserId); 
      
        }else if($this->adminFilter > 0 && $this->isAdmin ){ 
  
            $transactsQuery->where('user_id_sender', $this->adminFilter); 
      
        }

        if ($this->range == 1) {
            $transactsQuery->whereMonth('created_at', now()->month);
        } elseif ($this->range == 2) {
            $transactsQuery->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
        } elseif ($this->range == 3) {
            $transactsQuery->whereDate('created_at', now()->today());
        } elseif ($this->range == 4 && $this->dateStart && $this->dateEnd) {
            $transactsQuery->whereBetween('created_at', [
                Carbon::createFromFormat('d/m/Y', $this->dateStart)->startOfDay(),
                Carbon::createFromFormat('d/m/Y', $this->dateEnd)->endOfDay(),
            ]);
        }

        $transactsQuery->orderByDesc('id');

        $transacts = $transactsQuery->paginate(10);

        // Recarga PIX
        $recargaPix = TransactBalance::where('type', 'LIKE', '%Recarga efetuada por meio da plataforma%')
            ->when($this->range > 0, function ($q) {
                $now = Carbon::now();
                if ($this->range == 1) {
                    return $q->whereMonth('created_at', '=', $now->month);
                }
                if ($this->range == 2) {
                    $dateEnd = Carbon::now()->subDays(7);
                    return $q->whereBetween('created_at', [$dateEnd, $now]);
                }
                if ($this->range == 3) {
                    $periodo = [$now->format('Y-m-d') . ' 00:00:00', $now->format('Y-m-d') . ' 23:59:59'];
                    return $q->whereBetween('created_at', $periodo);
                }
                if($this->range === '4'){
                    //  $dateStart = $this->dateStart;
                // $endStart = $this->dateEnd;
                $periodo =   [Carbon::createFromFormat('d/m/Y', $this->dateStart)->format('Y-m-d') . ' 00:00:00',
            Carbon::createFromFormat('d/m/Y', $this->dateEnd)->format('Y-m-d') . ' 23:59:59'];
                return $q->whereBetween('created_at', $periodo);
            }
                
            })
            ->when($this->selectedUserId > 0 && !$this->isAdmin, function($q) {
                return $q->where('user_id', '=', $this->selectedUserId);
            })
            ->when($this->adminFilter > 0 && $this->isAdmin, function($q) {
                return $q->where('user_id_sender', $this->adminFilter);
            })
            ->sum('value');

        // Bônus
        $bonus = TransactBalance::where('wallet', 'LIKE', '%bonus%')
            ->when($this->range > 0, function ($q) {
                $now = Carbon::now();
                if ($this->range == 1) {
                    return $q->whereMonth('created_at', '=', $now->month);
                }
                if ($this->range == 2) {
                    $dateEnd = Carbon::now()->subDays(7);
                    return $q->whereBetween('created_at', [$dateEnd, $now]);
                }
                if ($this->range == 3) {
                    $periodo = [$now->format('Y-m-d') . ' 00:00:00', $now->format('Y-m-d') . ' 23:59:59'];
                    return $q->whereBetween('created_at', $periodo);
                }
                if ($this->range === '4' && $this->dateStart && $this->dateEnd) {
                    return $q->whereBetween('created_at', [
                        Carbon::createFromFormat('d/m/Y', $this->dateStart),
                        Carbon::createFromFormat('d/m/Y', $this->dateEnd),
                    ]);
                }
            })
            ->when($this->selectedUserId > 0 && !$this->isAdmin, function($q) {
                return $q->where('user_id', '=', $this->selectedUserId);
            })
            ->when($this->adminFilter > 0 && $this->isAdmin, function($q) {
                return $q->where('user_id_sender', $this->adminFilter);
            })
            ->sum('value');

        // Recarga Manual
        $recargaManual = TransactBalance::where('type', 'LIKE', '%Add por Admin%')
            ->where('wallet', 'LIKE', '%balance%')
            ->when($this->range > 0, function ($q) {  
                $now = Carbon::now();              
                if ($this->range == 1) {
                    return $q->whereMonth('created_at', '=', $now->month);
                }
                if ($this->range == 2) {
                    $dateEnd = Carbon::now()->subDays(7);
                    return $q->whereBetween('created_at', [$dateEnd, $now]);
                }
                if ($this->range == 3) {
                    
                    $periodo = [$now->format('Y-m-d') . ' 00:00:00', $now->format('Y-m-d') . ' 23:59:59'];
                    return $q->whereBetween('created_at', $periodo);
                }
            if ($this->range === '4' && $this->dateStart && $this->dateEnd) {
                            return $q->whereBetween('created_at', [
                                Carbon::createFromFormat('d/m/Y', $this->dateStart),
                                Carbon::createFromFormat('d/m/Y', $this->dateEnd),
                            ]);
                        }
            })
            ->when($this->selectedUserId > 0 && !$this->isAdmin, function($q) {
                return $q->where('user_id', '=', $this->selectedUserId);
            })
            ->when($this->adminFilter > 0 && $this->isAdmin, function($q) {
                return $q->where('user_id_sender', $this->adminFilter);
            })
            ->sum('value');
            
        // Cálculo do total das transações
        $totalTransacts = $recargaManual + $bonus + $recargaPix;

        return view('livewire.pages.dashboards.extract.new-extract', [
            'transacts' => $transacts,
            'totalTransacts' => $totalTransacts,
            'users' => $users,
            'recargaPix' => $recargaPix,
            'bonus' => $bonus,
            'recargaManual' => $recargaManual,
            'totalTransacts' => $totalTransacts,
            'userTransactions' => $this->userTransactions,
            'admins' => $admins,
        ]);
    }   
}
