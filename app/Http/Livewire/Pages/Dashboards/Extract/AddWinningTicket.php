<?php

namespace App\Http\Livewire\Pages\Dashboards\Extract;

use App\Models\Draw;
use App\Models\Game;
use Carbon\Carbon;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use \App\Models\WinningTicket as Model;
use Livewire\Component;
use Livewire\WithPagination;
use function view;

class AddWinningTicket extends Component
{
    use LivewireAlert, WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $range = 0, $dateStart, $dateEnd, $value, $dados, $arrDataConfirm;

    protected $listeners = [
        'confirmed'
    ];

    public function requestApprove($idGame, $idDraw): void
    {
        $text = 'Confirma a aprovação desse jogo para exibição pública?';
        $this->arrDataConfirm = [
            'idGame'    => $idGame,
            'idDraw'    => $idDraw,
        ];

        $this->alert('warning', $text, [
            'position' => 'center',
            'timer' => null,
            'toast' => false,
            'timerProgressBar' => false,
            'showConfirmButton' => true,
            'onConfirmed' => 'confirmed',
            'showCancelButton' => true,
            'allowOutsideClick' => false
        ]);
    }

    public function confirmed(): void
    {
        $draw = Draw::find($this->arrDataConfirm['idDraw']);
        $game = Game::find($this->arrDataConfirm['idGame']);
        $game->public = 1;
        $game->save();

        $winningTicket = Model::create([
            'user_id' => auth()->id(),
            'game_id' => $this->arrDataConfirm['idGame'],
            'draw_id' => $this->arrDataConfirm['idDraw'],
            'drawed_at' => $draw->created_at,
        ]);

        $this->alert('info', 'Jogo aprovado para listagem.', [
            'showConfirmButton' => false,
            'onConfirmed' => 'confirmed'
        ]);
    }

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

        $draws = Draw::with('typeGame')
            ->whereBetween('created_at', $periodo)
            ->orderBy('type_game_id')
            ->get();

        $draws->each(function($item, $key) {
            $games = explode(',', $item->games);
            $item->games = Game::with('user', 'typeGame', 'typeGameValue')
                ->whereIn('id', $games)
                ->where('public', 0)
                ->get();
        });

        $this->dados = $draws;
        return view('livewire.pages.dashboards.extract.add-winning-ticket');
    }
}
