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
    public $dateStart, $dateEnd;
    public $dtS, $dtF;
    public $searchTerm = '';
    public $selectedUserId;
    private $transacts;
    public $userTransactions = [];
    public $searching = false;
    public $selectedUsers = [];
    public $isAdmin;
    public $adminFilter;
    public $typeFilter = '';
    public $perPage = 10;
    public $selectedUser = null;
    public $selectedUserName;
    public $filteredUsers = [];

    public function mount()
    {
        $this->dateStart = Carbon::now()->format('d/m/Y');
        $this->dateEnd = Carbon::now()->format('d/m/Y');
    }

    public function search()
    {
        // Verifique se as datas estão preenchidas
        if (empty($this->dateStart) || empty($this->dateEnd)) {
            $this->addError('dateFieldsFilled', 'Por favor, forneça ambas as datas.');
            return;
        }

        // Validação das datas
        if (!$this->isValidDate($this->dateStart) || !$this->isValidDate($this->dateEnd)) {
            $this->addError('dateFormat', 'Formato de data inválido. Use dd/mm/YYYY.');
            return;
        }

        // Formatação das datas
        $dataFromatadaInicial = Carbon::createFromFormat('d/m/Y', $this->dateStart);
        $dataFromatadaFinal = Carbon::createFromFormat('d/m/Y', $this->dateEnd);

        
        if (!$dataFromatadaInicial || !$dataFromatadaFinal) {
            $this->addError('dateFormat', 'Erro ao processar as datas. Verifique o formato.');
            return;
        }

    
        $this->dateStart = $dataFromatadaInicial->format('Y-m-d');
        $this->dateEnd = $dataFromatadaFinal->format('Y-m-d');

        $query = TransactBalance::query(); 

        if ($this->typeFilter) {
            $query->where('type', $this->typeFilter);
        }

        if ($this->searchTerm) {
            $query->whereHas('user', function($q) {
                $q->where('name', 'like', '%' . $this->searchTerm . '%')
                ->orWhere('last_name', 'like', '%' . $this->searchTerm . '%');
            });
        }

        if ($this->adminFilter) {
            $query->where('admin_id', $this->adminFilter);
        }

        // Filtros de intervalo
        if ($this->range === '1') { // Mensal
            $query->whereMonth('created_at', date('m'))
                ->whereYear('created_at', date('Y'));
        } elseif ($this->range === '2') { // Semanal
            $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
        } elseif ($this->range === '3') { // Diário
            $query->whereDate('created_at', today());
        } elseif ($this->range === '4') { // Personalizado
            $query->whereBetween('created_at', [$this->dateStart, $this->dateEnd]);
        }

        // Paginando os resultados
        $this->transacts = $query->paginate($this->perPage);
    }

    private function isValidDate($date)
    {
        return preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $date);
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
        // Transações do usuário selecionado
        $this->selectedUserId = $userId;

        // Atualiza o searchTerm com o nome do usuário fornecido ou o nome encontrado no banco
        $this->searchTerm = $userName ?: User::find($userId)->name ?? '';

        // Verifica se o usuário é admin
        $this->isAdmin = $this->isAdminF($userId);

        // Atualiza os detalhes do usuário selecionado
        $this->selectedUser = [
            'id' => $userId,
            'name' => $this->searchTerm,
            'isAdmin' => $this->isAdmin,
        ];

        // Se não for admin, reseta o filtro de admin
        if (!$this->isAdmin) {
            $this->adminFilter = null;
        }

        // Renderiza os resultados atualizados
        $this->render();
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
        
            // Filtro baseado no tipo de transação
            if ($this->typeFilter) {
                $typeFilterPatterns = [
                    'pix' => '%Recarga efetuada por meio da plataforma%',
                    'manual_recharge' => '%Add por Admin%',
                    'bonus_balance' => '%bonus%',
                    'saquedisponivel_saldo' => '%Saldo recebido a partir de Saque Disponível%',
                    'bonus_saquedisponivel' => '%Saldo disponivel recebido atravez do bônus%',
                    'saldo_bonus' => '%Saldo recebido a partir de Bônus%',
                    'bonus_purchase' => '%Bônus de jogo%',
                    'bichao_purchase' => '%Compra Bichão - Jogo de id:%',
                    'game_purchase' => '%Compra - Jogo%',
                    'solicitacao_saque' => '%Solicitação de saque finalizada.%',
                ];
        
                $pattern = $typeFilterPatterns[$this->typeFilter] ?? null;
                if ($pattern) {
                    $transactsQuery->where('type', 'like', $pattern);
                }
            }

            if ($this->selectedUserId > 0 && !$this->isAdmin) {
                $transactsQuery->where('user_id', $this->selectedUserId);
            }
        
            if ($this->adminFilter > 0 && $this->isAdmin) {
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

            
            $transacts = $transactsQuery->paginate($this->perPage);

             $transactsQuery->where(function ($query) {
                 $query->where('type', 'LIKE', '%Recarga efetuada por meio da plataforma%')
                     ->orWhere('wallet', 'LIKE', '%bonus%')
                     ->orWhere(function ($query) {
                         $query->where('type', 'LIKE', '%Add por Admin%')
                             ->where('wallet', 'LIKE', '%balance%');
                     })
                     ->orWhere(function ($query) {
                         $query->where('type', 'LIKE', '%Saldo recebido%'); // Adiciona conversão aqui
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

       // Obtendo os IDs dos jogos premiados da tabela draws
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
