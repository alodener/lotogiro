<?php

namespace App\Http\Livewire\Pages\Dashboards\Extract;

use App\Models\WinningTicket as Model;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class WinningTicket extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $range = 0, $dateStart, $dateEnd, $value, $dados;

    public function mount()
    {
        $this->dateStart = Carbon::now()->format('d/m/Y');
        $this->dateEnd = Carbon::now()->format('d/m/Y');
    }

    public function render()
    {
        $tickets = [];
        $now = Carbon::now();
        $periodo = [$now->format('Y-m-d') . ' 00:00:00', $now->format('Y-m-d') . ' 23:59:59'];

        if($this->range == 1){
            $periodo = [$now->subDay(1)->format('Y-m-d') . ' 00:00:00', $now->format('Y-m-d') . ' 23:59:59'];
        }
        if($this->range == 2){
            $periodo = [$now->subDays(7)->format('Y-m-d') . ' 00:00:00', $now->addDays(7)->format('Y-m-d') . ' 23:59:59'];
        }
        if($this->range == 3){
            $periodo = [$now->subDays(30)->format('Y-m-d') . ' 00:00:00', $now->addDays(30)->format('Y-m-d') . ' 23:59:59'];
        }
        if($this->range == 4){
            $periodo = [Carbon::createFromFormat('d/m/Y', $this->dateStart)->format('Y-m-d') . ' 00:00:00',
                Carbon::createFromFormat('d/m/Y', $this->dateEnd)->format('Y-m-d') . ' 23:59:59'];
        }

        $draws = Model::with('user', 'game', 'draw.competition')
            ->whereBetween('drawed_at', $periodo)->get();

        $draws->each(function($item, $key) use (&$tickets) {
            $tickets[] = ['asdkjashd' => 'çsldkf'];
        });

        $this->dados = $draws;
        return view('livewire.pages.dashboards.extract.winning-ticket');
    }
}
