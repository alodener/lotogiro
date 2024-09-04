<?php

namespace App\Http\Livewire\Pages\Dashboards\User;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use App\Models\TransactBalance;

class Nominees extends Component
{
    use WithPagination;

    public $consultorId;
    public $perPage = 10;
    public $search = '';

    protected $paginationTheme = 'bootstrap';

    public function mount($consultorId)
    {
        $this->consultorId = $consultorId;
    }

    public function updatedPerPage()
    {
        $this->resetPage();
    }

    public function render()
    {
        $consultorRoles = [2, 4, 5];
        $consultor = User::whereIn('id', function ($query) use ($consultorRoles) {
            $query->select('model_id')
                ->from('model_has_roles')
                ->whereIn('role_id', $consultorRoles);
        })->findOrFail($this->consultorId);

        // Total de recargas
        $totalRecargas = TransactBalance::where('user_id', $consultor->id)
            ->where('type', 'Recarga efetuada por meio da plataforma')
            ->sum('value');

        // Última recarga
        $ultimaRecarga = TransactBalance::where('user_id', $consultor->id)
            ->where('type', 'Recarga efetuada por meio da plataforma')
            ->orderBy('created_at', 'desc')
            ->value('created_at');

        // Total apostado no Bichão
        $totalJogosBichão = TransactBalance::where('user_id', $consultor->id)
            ->where('type', 'LIKE', '%Compra Bichão - Jogo de id:%')
            ->where('wallet', 'LIKE', '%balance%')
            ->sum('value');

        // Último jogo do Bichão
        $ultimoJogoBichão = TransactBalance::where('user_id', $consultor->id)
            ->where('type', 'LIKE', '%Compra Bichão - Jogo de id:%')
            ->where('wallet', 'LIKE', '%balance%')
            ->orderBy('created_at', 'desc')
            ->value('created_at');

        // Total apostado nas Loterias
        $totalJogosLoterias = TransactBalance::where('user_id', $consultor->id)
            ->where('type', 'LIKE', '%Compra - Jogo de id:%')
            ->where('wallet', 'LIKE', '%balance%')
            ->sum('value');

        // Último jogo das Loterias
        $ultimoJogoLoterias = TransactBalance::where('user_id', $consultor->id)
            ->where('type', 'LIKE', '%Compra Bichão - Jogo de id:%')
            ->where('wallet', 'LIKE', '%balance%')
            ->orderBy('created_at', 'desc')
            ->value('created_at');

        // Quantidade de consultores
        $quantidadeConsultores = User::where('indicador', $this->consultorId)
            ->whereIn('id', function($query) {
                $query->select('model_id')
                    ->from('model_has_roles')
                    ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
                    ->whereIn('roles.name', ['Consultor Jr', 'Consultor', 'Consultor Master', 'Consultor Senior']);
            })
            ->count();

        // Quantidade de clientes
        $quantidadeClientes = User::where('indicador', $this->consultorId)
            ->whereIn('id', function($query) {
                $query->select('model_id')
                    ->from('model_has_roles')
                    ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
                    ->where('roles.name', 'Cliente');
            })
            ->count();

        // Usuários indicados
        $indicados = User::where('indicador', $this->consultorId)
            ->select('id', 'name', 'last_name', 'indicador')
            ->paginate($this->perPage); // Usuários indicados com filtro de pesquisa
            $indicados = User::where('indicador', $this->consultorId)
                ->where(function($query) {
                    $query->where('name', 'like', '%' . $this->search . '%')
                          ->orWhere('last_name', 'like', '%' . $this->search . '%');
                })
                ->select('id', 'name', 'last_name', 'indicador')
                ->paginate($this->perPage);

        // Adiciona a classificação e nível
        foreach ($indicados as $indicado) {
            $indicado->nivel = $indicado->indicador == $this->consultorId ? 'Nível 1' : 'Nível 2';
            
            $roleId = \DB::table('model_has_roles')
                ->where('model_id', $indicado->id)
                ->value('role_id');

            $classificacao = \DB::table('roles')
                ->where('id', $roleId)
                ->value('name');
            
            $indicado->classificacao = $classificacao ?? 'Não classificado';
        }

        return view('livewire.pages.dashboards.user.nominees', [
            'totalRecargas' => $totalRecargas,
            'ultimaRecarga' => $ultimaRecarga,
            'totalJogosBichão' => $totalJogosBichão,
            'ultimoJogoBichão' => $ultimoJogoBichão,
            'totalJogosLoterias' => $totalJogosLoterias,
            'ultimoJogoLoterias' => $ultimoJogoLoterias,
            'quantidadeConsultores' => $quantidadeConsultores,
            'quantidadeClientes' => $quantidadeClientes,
            'indicados' => $indicados
        ]);
    }
}
