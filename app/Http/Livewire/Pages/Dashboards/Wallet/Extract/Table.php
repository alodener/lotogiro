<?php

namespace App\Http\Livewire\Pages\Dashboards\Wallet\Extract;

use App\Helper\Money;
use App\Models\TransactBalance;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;

    public $description = '';
    public $dateFrom = null;
    public $dateTo = null;
    public $filteredSum = 0;
    public $filtersApplied = false;
    public $perPage = 10;

    protected $paginationTheme = 'bootstrap';

    public function mount()
    {
        $this->loadTransacts();
    }

    public function loadTransacts()
    {
        $query = TransactBalance::with('user', 'userSender')
            ->where('user_id', auth()->id())
            ->orderBy('updated_at', 'desc');

        if ($this->description) {
            $query->where('type', 'LIKE', '%' . $this->description . '%');
        }

        if ($this->dateFrom && $this->dateTo) {
            $query->whereDate('updated_at', '>=', Carbon::parse($this->dateFrom))
                ->whereDate('updated_at', '<=', Carbon::parse($this->dateTo));
        }

        $transacts = $query->paginate($this->perPage);

        if ($this->filtersApplied) {
            $this->calculateSum($query);
        }

        $this->trasacts = [];
        foreach ($transacts->items() as $h) {
            $this->trasacts[] = [
                'data' => Carbon::parse($h->updated_at)->format('d/m/y à\\s H:i'),
                'responsavel' => $h->userSender->name ?? '',
                'value' => Money::toReal($h->value),
                'old_value' => Money::toReal($h->old_value),
                'value_a' => Money::toReal($h->value_a),
                'obs' => $h->type
            ];
        }

        return $transacts;
    }

    public function calculateSum($query)
    {
        $this->filteredSum = $query->sum('value');
    }

    public function applyFilters()
    {
        $this->filtersApplied = true;
        $this->resetPage();
        $this->loadTransacts();
    }

    public function updatingPerPage($value)
    {
        $this->resetPage(); 
    }

    public function render()
    {
        $transacts = $this->loadTransacts();

        return view('livewire.pages.dashboards.wallet.extract.table', [
            'transacts' => $transacts,
        ]);
    }
}
