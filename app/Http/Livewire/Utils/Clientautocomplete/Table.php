<?php

namespace App\Http\Livewire\Utils\Clientautocomplete;

use App\Models\Client;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;

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
        $this->search = $value;
    
        $clients = Client::select('id', 'name', 'last_name', 'email', 'ddd', 'phone')
            ->where(function ($query) {
                $query->where('name', 'like', "%{$this->search}%")
                    ->orWhere('last_name', 'like', "%{$this->search}%")
                    ->orWhere('email', 'like', "%{$this->search}%");
            })
            ->orWhereRaw("CONCAT(name, ' ', last_name) like ?", ["%{$this->search}%"]);
    
        $users = User::select('id', 'name', 'last_name', 'email', \DB::raw('null as ddd'), \DB::raw('null as phone'))
            ->where(function ($query) {
                $query->where('name', 'like', "%{$this->search}%")
                    ->orWhere('last_name', 'like', "%{$this->search}%")
                    ->orWhere('email', 'like', "%{$this->search}%");
            })
            ->orWhereRaw("CONCAT(name, ' ', last_name) like ?", ["%{$this->search}%"]);
    
        $results = $clients->unionAll($users)->get();
    
        $uniqueResults = collect($results)->unique('email')->values();
    
        $this->users = $uniqueResults;
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
