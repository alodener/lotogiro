<?php

namespace App\Http\Livewire\Pages\Dashboards\User;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class IndicatedByLevel extends Component
{
    use WithPagination;

    public $userId;
    protected $paginationTheme = 'bootstrap';

    public function redirectToRoute($userId)
    {
        return redirect()->route('admin.settings.users.indicatedByLevel', ['userId' => $userId]);
    }

    public function getIndicateds(int $userId)
    {
        return User::where('indicador', $userId)->paginate(12);
    }

    public function mount()
    {
        $this->userId = request('userId');

        if ($this->userId <= 0 || $this->userId == auth()->id()) {
            abort(403);
        }
    }

    public function render()
    {
        $indicatedsArray = $this->getIndicateds($this->userId);

        return view('livewire.pages.dashboards.user.indicatedByLevel', compact('indicatedsArray'));
    }
}
