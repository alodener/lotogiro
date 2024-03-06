<?php

namespace App\Http\Livewire\Pages\Dashboards\Extract;

use App\Helper\Money;
use App\Models\ModelHasRole;
use App\Models\TransactBalance;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\RechargeOrder;
use Illuminate\Support\Facades\DB;


class ManualRecharge extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $range = 0, $dateStart, $dateEnd, $perPage = 10, $value, $admins = [], $adminSelected = 0;
    public function mount()
    {
        $this->dateStart = Carbon::now()->format('d/m/Y');
        $this->dateEnd = Carbon::now()->format('d/m/Y');
    }
    public function search()
    {
        if (is_null($this->dateStart) && is_null($this->dateEnd)) {
            $this->addError('dateFieldsFilled', 'Data missing');
            return;
        }
        $this->resetErrorBag('dateFieldsFilled');
    }


    public function render()
    {
        $admins = [];
        if($this->adminSelected != 0){
            $adms = null;
            $adms[] = $this->adminSelected;
        }

        if($this->adminSelected === 0){
            $adms = null;
            $roles = ModelHasRole::with('user')->where('role_id', 1)->get();

            $roles->each(function ($item, $key){
                $this->admins[] = [
                    'id' => $item->user->id,
                    'name' => $item->user->name . ' ' . $item->user->last_name
                ];
            });
            $adms = $roles->pluck('model_id')->toArray();
        }

        $transacts = TransactBalance::with('userSender', 'user')
            ->whereIn('user_id_sender', $adms)
            ->whereNotIn('user_id', $adms)
            ->when($this->range > 0, function ($q) {
                $now = Carbon::now();
                if($this->range === '1'){
                    return $q->whereMonth('created_at', '=', $now->month);
                }
                if($this->range === '2'){
                    $this->dateStart = Carbon::now()->addDay()->format('Y-m-d');
                    $this->dateEnd = Carbon::now()->subDays(7)->format('Y-m-d');
                    return $q->whereBetween('created_at', [$this->dateEnd, $this->dateStart]);
                }
                if($this->range === '3'){
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

            ->orderByDesc('id');
               
            //total recarga via plataforma

            $totalpix = TransactBalance::with('userSender', 'user')
            ->whereIn('user_id_sender', $adms)
            ->whereNotIn('user_id', $adms)
            ->where('type', 'LIKE', "%recarga%")
            ->where('wallet', '=', 'balance')
            ->when($this->range > 0, function ($q) {
                $now = Carbon::now();
                if ($this->range === '1') {
                    return $q->whereMonth('created_at', '=', $now->month);
                }
                if ($this->range === '2') {
                    $dateEnd = Carbon::now()->subDays(7);
                    return $q->whereBetween('created_at', [$dateEnd, $now]);
                }
                if ($this->range === '3') {
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
            ->sum('value');

            $totalpix = number_format($totalpix, 2, ',','.');

            
            //calculo do b么nus pix
            $totalbonus = TransactBalance::with('userSender', 'user')
            ->whereIn('user_id_sender', $adms)
            ->whereNotIn('user_id', $adms)
            ->where('wallet', 'bonus')
            ->when($this->range > 0, function ($q) {
                
                $now = Carbon::now();
                if ($this->range === '1') {
                    return $q->whereMonth('created_at', '=', $now->month);
                }
                if ($this->range === '2') {
                    $dateEnd = Carbon::now()->subDays(7);
                    return $q->whereBetween('created_at', [$dateEnd, $now]);
                }
                if ($this->range === '3') {
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
            ->sum('value');
            
            $totalbonus = number_format($totalbonus, 2, ',','.');
            
            //Calculo da recarga manual           
            $totalrecargamanual = TransactBalance::with('userSender', 'user')
            ->whereIn('user_id_sender', $adms)
            ->whereNotIn('user_id', $adms)
            ->where('type', 'Add por Admin')
            ->where('wallet', 'balance')
            ->when($this->range > 0, function ($q) {
            $now = Carbon::now();
            if ($this->range === '1') {
                return $q->whereMonth('created_at', '=', $now->month);
            }
            if ($this->range === '2') {
                $dateEnd = Carbon::now()->subDays(7);
                return $q->whereBetween('created_at', [$dateEnd, $now]);
            }
            if ($this->range === '3') {
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
        ->sum('value');

        $totalrecargamanual = number_format($totalrecargamanual, 2, ',','.');
     /*  $a = Money::toDatabase($totalrecargamanual);
       $b = Money::toDatabase($totalbonus);
       $c = Money::toDatabase($totalpix);
        

        $totalSoma = $a + $b + $c ;*/
        

        $total = Money::toReal($transacts->sum('value'));
        $transacts = $transacts->paginate(10);
        $transacts->valueTotal = $total;

        $transacts->each(function($item, $key) use ($total) {
            $item->data = Carbon::parse($item->created_at)->format('d/m/y 脿\\s H:i');
            $item->value = Money::toReal($item->value);

            $item->usuario = "{$item->user['name']} {$item->user['last_name']}";
            $item->responsavel = "{$item->userSender['name']} {$item->userSender['last_name']}";
        });

          return view('livewire.pages.dashboards.extract.manual-recharge', compact('transacts', 'totalpix','totalbonus','totalrecargamanual'));
    }
}
