<?php

namespace App\Http\Livewire\Utils\Clientautocomplete;

use App\Models\Client;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $users = [];
    public $showList = false;
    public $search;
    public $userId;
    public $value;

    public function updatedSearch($value)
    {
        $this->users = Client::where("name", "like", "%{$this->search}%")->get();
        $this->showList = true;
    }

    public function setId($user)
    {
        $this->userId = $user["id"];
        $this->search = $user["name"] . ' ' . $user["last_name"] . ' - ' . $user["email"];
        $this->showList = false;
    }

    public function clearUser()
    {
        $this->reset(['search', 'userId']);
        $this->updatedSearch('Admin');
    }

    public function render()
    {
        return view('livewire.utils.clientautocomplete.table');
    }
}
