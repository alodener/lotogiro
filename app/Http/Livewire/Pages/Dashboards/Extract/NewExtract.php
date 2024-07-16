<?php

namespace App\Http\Livewire\Pages\Dashboards\Extract;

use Livewire\Component;
use Carbon\Carbon;
use App\Models\TransactBalance;
use App\Models\User;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use App\Models\ModelHasRole;
use App\Models\Draw;
use App\Models\Game;
use App\Models\BichaoGamesVencedores;
class NewExtract extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $range = '0';
    public $dateStart, $dateEnd, $perPage = 50;
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
             
             if ($this->selectedUserId > 0 && !$this->isAdmin) {
                 $transactsQuery->where('user_id', $this->selectedUserId);
             } elseif ($this->adminFilter > 0 && $this->isAdmin) {
                 $transactsQuery->where('user_id_sender', $this->adminFilter);
             }            
             if ($this->range == 1) {
                $startOfMonth = now()->startOfMonth();
                $endOfToday = now()->endOfDay();
                $transactsQuery->whereBetween('created_at', [$startOfMonth, $endOfToday]);
             } elseif ($this->range == 2) {
                 $transactsQuery->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
             } elseif ($this->range == 3) {
                 $transactsQuery->whereDate('created_at', now()->today());
             } elseif ($this->range == 4 && $this->dateStart && $this->dateEnd) {
                 $start = Carbon::createFromFormat('d/m/Y', $this->dateStart)->startOfDay();
                 $end = Carbon::createFromFormat('d/m/Y', $this->dateEnd)->endOfDay();
                 $transactsQuery->whereBetween('created_at', [$start, $end]);
             }
             $transactsQuery->orderByDesc('id');
             $transacts = $transactsQuery->paginate(10);             
    
        // Recarga PIX
        $recargaPix = TransactBalance::where('type', 'LIKE', '%Recarga efetuada por meio da plataforma%')
        ->when($this->range > 0, function ($q) {
            $now = Carbon::now();
            if ($this->range == 1) {
                $startOfMonth = $now->copy()->startOfMonth();
                $endOfToday = $now->copy()->endOfDay();
                return $q->whereBetween('created_at', [$startOfMonth, $endOfToday]);
            }
            if ($this->range == 2) {
                $startOfWeek = $now->copy()->startOfWeek();
                $endOfWeek = $now->copy()->endOfWeek();
                return $q->whereBetween('created_at', [$startOfWeek, $endOfWeek]);
            }
            if ($this->range == 3) {
                return $q->whereDate('created_at', $now->copy()->today());
            }
            if ($this->range == 4 && $this->dateStart && $this->dateEnd) {
                $start = Carbon::createFromFormat('d/m/Y', $this->dateStart)->startOfDay();
                $end = Carbon::createFromFormat('d/m/Y', $this->dateEnd)->endOfDay();
                return $q->whereBetween('created_at', [$start, $end]);
            }
        })
        ->when($this->selectedUserId > 0 && !$this->isAdmin, function ($q) {
            return $q->where('user_id', '=', $this->selectedUserId);
        })
        ->when($this->adminFilter > 0 && $this->isAdmin, function ($q) {
            return $q->where('user_id_sender', $this->adminFilter);
        })
        ->sum('value');

    
        // Bônus
        $bonus = TransactBalance::where('wallet', 'LIKE', '%bonus%')
            ->when($this->range > 0, function ($q) {
                $now = Carbon::now();
                if ($this->range == 1) {
                    $startOfMonth = now()->startOfMonth();
                    $endOfToday = now()->endOfDay();
                    $q->whereBetween('created_at', [$startOfMonth, $endOfToday]);
                }
                if ($this->range == 2) {
                    $q->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                }
                if ($this->range == 3) {
                    return $q->whereDate('created_at', $now->today());
                }
                if ($this->range == 4 && $this->dateStart && $this->dateEnd) {
                    $start = Carbon::createFromFormat('d/m/Y', $this->dateStart)->startOfDay();
                    $end = Carbon::createFromFormat('d/m/Y', $this->dateEnd)->endOfDay();
                    return $q->whereBetween('created_at', [$start, $end]);
                }
            })
            ->when($this->selectedUserId > 0 && !$this->isAdmin, function($q) {
                return $q->where('user_id', '=', $this->selectedUserId);
            })
            ->when($this->adminFilter > 0 && $this->isAdmin, function($q) {
                return $q->where('user_id_sender', $this->adminFilter);
            })
            ->sum('value');


        $recargaManual = TransactBalance::where('type', 'LIKE', '%Add por Admin%')
            ->where('wallet', 'LIKE', '%balance%')
            ->when($this->range > 0, function ($q) {  
                $now = Carbon::now();              
                if ($this->range == 1) {
                    $startOfMonth = now()->startOfMonth();
                    $endOfToday = now()->endOfDay();
                    $q->whereBetween('created_at', [$startOfMonth, $endOfToday]);
                }
                if ($this->range == 2) {
                    $q->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                }
                if ($this->range == 3) {
                    return $q->whereDate('created_at', $now->today());
                }
                if ($this->range == 4 && $this->dateStart && $this->dateEnd) {
                    $start = Carbon::createFromFormat('d/m/Y', $this->dateStart)->startOfDay();
                    $end = Carbon::createFromFormat('d/m/Y', $this->dateEnd)->endOfDay();
                    return $q->whereBetween('created_at', [$start, $end]);
                }
            })
            ->when($this->selectedUserId > 0 && !$this->isAdmin, function($q) {
                return $q->where('user_id', '=', $this->selectedUserId);
            })
            ->when($this->adminFilter > 0 && $this->isAdmin, function($q) {
                return $q->where('user_id_sender', $this->adminFilter);
            })
            ->sum('value');

         // Jogos Realizados
        $jogosRealizados = TransactBalance::where('type', 'LIKE', '%Compra - Jogo de id:%')
            ->where('wallet', 'LIKE', '%balance%')
            ->when($this->range > 0, function ($q) {  
                $now = Carbon::now();              
                if ($this->range == 1) {
                    $startOfMonth = now()->startOfMonth();
                    $endOfToday = now()->endOfDay();
                    $q->whereBetween('created_at', [$startOfMonth, $endOfToday]);
                }
                if ($this->range == 2) {
                    $q->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                }
                if ($this->range == 3) {
                    return $q->whereDate('created_at', $now->today());
                }
                if ($this->range == 4 && $this->dateStart && $this->dateEnd) {
                    $start = Carbon::createFromFormat('d/m/Y', $this->dateStart)->startOfDay();
                    $end = Carbon::createFromFormat('d/m/Y', $this->dateEnd)->endOfDay();
                    return $q->whereBetween('created_at', [$start, $end]);
                }
            })
            ->when($this->selectedUserId > 0 && !$this->isAdmin, function($q) {
                return $q->where('user_id', '=', $this->selectedUserId);
            })
            ->when($this->adminFilter > 0 && $this->isAdmin, function($q) {
                return $q->where('user_id_sender', $this->adminFilter);
            })
            ->sum('value');


        // Conversão de bônus para saldo
        $conversaoBonusSaldo = TransactBalance::where('type', 'LIKE', '%Saldo recebido a partir de Bônus.%')
            ->where('wallet', 'LIKE', '%balance%')
            ->when($this->range > 0, function ($q) {  
                $now = Carbon::now();              
                if ($this->range == 1) {
                    $startOfMonth = now()->startOfMonth();
                    $endOfToday = now()->endOfDay();
                    $q->whereBetween('created_at', [$startOfMonth, $endOfToday]);
                }
                if ($this->range == 2) {
                    $q->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                }
                if ($this->range == 3) {
                    return $q->whereDate('created_at', $now->today());
                }
                if ($this->range == 4 && $this->dateStart && $this->dateEnd) {
                    $start = Carbon::createFromFormat('d/m/Y', $this->dateStart)->startOfDay();
                    $end = Carbon::createFromFormat('d/m/Y', $this->dateEnd)->endOfDay();
                    return $q->whereBetween('created_at', [$start, $end]);
                }
            })
            ->when($this->selectedUserId > 0 && !$this->isAdmin, function($q) {
                return $q->where('user_id', '=', $this->selectedUserId);
            })
            ->when($this->adminFilter > 0 && $this->isAdmin, function($q) {
                return $q->where('user_id_sender', $this->adminFilter);
            })
            ->sum('value');

         // Conversão de bônus para saque disponivel
        $conversaoBonusSaque = TransactBalance::where('type', 'LIKE', '%Saldo disponivel recebido atravez do bônus.%')
            ->where('wallet', 'LIKE', '%balance%')
            ->when($this->range > 0, function ($q) {  
                $now = Carbon::now();              
                if ($this->range == 1) {
                    $startOfMonth = now()->startOfMonth();
                    $endOfToday = now()->endOfDay();
                    $q->whereBetween('created_at', [$startOfMonth, $endOfToday]);
                }
                if ($this->range == 2) {
                    $q->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                }
                if ($this->range == 3) {
                    return $q->whereDate('created_at', $now->today());
                }
                if ($this->range == 4 && $this->dateStart && $this->dateEnd) {
                    $start = Carbon::createFromFormat('d/m/Y', $this->dateStart)->startOfDay();
                    $end = Carbon::createFromFormat('d/m/Y', $this->dateEnd)->endOfDay();
                    return $q->whereBetween('created_at', [$start, $end]);
                }
            })
            ->when($this->selectedUserId > 0 && !$this->isAdmin, function($q) {
                return $q->where('user_id', '=', $this->selectedUserId);
            })
            ->when($this->adminFilter > 0 && $this->isAdmin, function($q) {
                return $q->where('user_id_sender', $this->adminFilter);
            })
            ->sum('value');

         // Conversão de bônus para saque disponivel
        $conversaoSaqueSaldo = TransactBalance::where('type', 'LIKE', '%Saldo recebido a partir de Saque Disponível%')
            ->where('wallet', 'LIKE', '%balance%')
            ->when($this->range > 0, function ($q) {  
                $now = Carbon::now();              
                if ($this->range == 1) {
                    $startOfMonth = now()->startOfMonth();
                    $endOfToday = now()->endOfDay();
                    $q->whereBetween('created_at', [$startOfMonth, $endOfToday]);
                }
                if ($this->range == 2) {
                    $q->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                }
                if ($this->range == 3) {
                    return $q->whereDate('created_at', $now->today());
                }
                if ($this->range == 4 && $this->dateStart && $this->dateEnd) {
                    $start = Carbon::createFromFormat('d/m/Y', $this->dateStart)->startOfDay();
                    $end = Carbon::createFromFormat('d/m/Y', $this->dateEnd)->endOfDay();
                    return $q->whereBetween('created_at', [$start, $end]);
                }
            })
            ->when($this->selectedUserId > 0 && !$this->isAdmin, function($q) {
                return $q->where('user_id', '=', $this->selectedUserId);
            })
            ->when($this->adminFilter > 0 && $this->isAdmin, function($q) {
                return $q->where('user_id_sender', $this->adminFilter);
            })
            ->sum('value');

         // Total De Jogos Bichão
        $jogosBichao = TransactBalance::where('type', 'LIKE', '%Compra Bichão - Jogo de id:%')
            ->where('wallet', 'LIKE', '%balance%')
            ->when($this->range > 0, function ($q) {  
                $now = Carbon::now();              
                if ($this->range == 1) {
                    $startOfMonth = now()->startOfMonth();
                    $endOfToday = now()->endOfDay();
                    $q->whereBetween('created_at', [$startOfMonth, $endOfToday]);
                }
                if ($this->range == 2) {
                    $q->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                }
                if ($this->range == 3) {
                    return $q->whereDate('created_at', $now->today());
                }
                if ($this->range == 4 && $this->dateStart && $this->dateEnd) {
                    $start = Carbon::createFromFormat('d/m/Y', $this->dateStart)->startOfDay();
                    $end = Carbon::createFromFormat('d/m/Y', $this->dateEnd)->endOfDay();
                    return $q->whereBetween('created_at', [$start, $end]);
                }
            })
            ->when($this->selectedUserId > 0 && !$this->isAdmin, function($q) {
                return $q->where('user_id', '=', $this->selectedUserId);
            })
            ->when($this->adminFilter > 0 && $this->isAdmin, function($q) {
                return $q->where('user_id_sender', $this->adminFilter);
            })
            ->sum('value');

         //Total premio bichão

         $premiosBichao = DB::table('bichao_games_vencedores')
            ->join('bichao_games', 'bichao_games.id', '=', 'bichao_games_vencedores.game_id')
            ->whereNotNull('bichao_games_vencedores.valor_premio')
            ->when($this->range > 0, function ($q) {
                $now = Carbon::now();
                if ($this->range == 1) {
                    $startOfMonth = now()->startOfMonth();
                    $endOfToday = now()->endOfDay();
                    return $q->whereBetween('bichao_games_vencedores.created_at', [$startOfMonth, $endOfToday]);
                } elseif ($this->range == 2) {
                    return $q->whereBetween('bichao_games_vencedores.created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                } elseif ($this->range == 3) {
                    return $q->whereDate('bichao_games_vencedores.created_at', $now->today());
                } elseif ($this->range == 4 && $this->dateStart && $this->dateEnd) {
                    $start = Carbon::createFromFormat('d/m/Y', $this->dateStart)->startOfDay();
                    $end = Carbon::createFromFormat('d/m/Y', $this->dateEnd)->endOfDay();
                    return $q->whereBetween('bichao_games_vencedores.created_at', [$start, $end]);
                }
            })
            ->when($this->selectedUserId > 0 && !$this->isAdmin, function ($q) {
                return $q->where('bichao_games.user_id', '=', $this->selectedUserId);
            })
            ->when($this->adminFilter > 0 && $this->isAdmin, function ($q) {
                return $q->where('bichao_games.user_id', $this->adminFilter);
            })
            ->sum('bichao_games_vencedores.valor_premio');

       //total de premios loterias

       // Obetendo os IDs dos jogos premiados da tabela draws
        $idsJogosPremiados = DB::table('draws')
            ->whereNotNull('games')
            ->pluck('games')
            ->flatMap(function ($ids) {
                return explode(',', $ids);
            })
            ->unique()
            ->toArray();
        
        $premioTotalLoteria = DB::table('games')
            ->whereIn('id', $idsJogosPremiados)
            ->when($this->range > 0, function ($q) {
                $now = Carbon::now();
                if ($this->range == 1) {
                    $startOfMonth = now()->startOfMonth();
                    $endOfToday = now()->endOfDay();
                    return $q->whereBetween('created_at', [$startOfMonth, $endOfToday]);
                } elseif ($this->range == 2) {
                    return $q->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                } elseif ($this->range == 3) {
                    return $q->whereDate('created_at', $now->today());
                } elseif ($this->range == 4 && $this->dateStart && $this->dateEnd) {
                    $start = Carbon::createFromFormat('d/m/Y', $this->dateStart)->startOfDay();
                    $end = Carbon::createFromFormat('d/m/Y', $this->dateEnd)->endOfDay();
                    return $q->whereBetween('created_at', [$start, $end]);
                }
            })
            ->when($this->selectedUserId > 0 && !$this->isAdmin, function ($q) {
                return $q->where('user_id', '=', $this->selectedUserId);
            })
            ->when($this->adminFilter > 0 && $this->isAdmin, function ($q) {
                return $q->where('user_id', $this->adminFilter);
            })
            ->sum('premio');

        $totalPremio = $premioTotalLoteria ?? 0;
        
        
        // Cálculo do total das transações
        $totalTransacts = $recargaManual + $recargaPix - $premioTotalLoteria - $premiosBichao - $bonus ;
    
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
            'jogosRealizados' => $jogosRealizados,
            'conversaoBonusSaldo' => $conversaoBonusSaldo,
            'conversaoBonusSaque' =>  $conversaoBonusSaque,
            'conversaoSaqueSaldo' => $conversaoSaqueSaldo,
            'jogosBichao' => $jogosBichao,
            'premioTotalLoteria' => $premioTotalLoteria,
            'premiosBichao' => $premiosBichao,
        ]);
    }
}
