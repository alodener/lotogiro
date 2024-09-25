<?php

namespace App\Http\Livewire\Pages\Dashboards\User;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;

class ConsultoresIndicados extends Component
{
    use WithPagination;

    public $perPage = 10;
    public $search = '';

    protected $paginationTheme = 'bootstrap';

    public function updatedPerPage()
    {
        $this->resetPage();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $consultorRoles = [2, 4, 5];

        $consultores = User::whereIn('id', function ($query) use ($consultorRoles) {
            $query->select('model_id')
                ->from('model_has_roles')
                ->whereIn('role_id', $consultorRoles);
        })
        ->select('users.*', \DB::raw('(SELECT COUNT(*) FROM users u2 WHERE u2.indicador = users.id) as indicados_count'))
        ->where(function ($query) {
            $query->where('name', 'like', '%' . $this->search . '%')
                ->orWhere('last_name', 'like', '%' . $this->search . '%');
        })
        ->where(function ($query) {
            $query->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('last_name', 'like', '%' . $this->search . '%');
        })
        ->with(['roles' => function ($query) use ($consultorRoles) {
            $query->whereIn('id', $consultorRoles);
        }])
        ->paginate($this->perPage);

        return view('livewire.pages.dashboards.user.consultores-indicados', compact('consultores'));
    }
}
