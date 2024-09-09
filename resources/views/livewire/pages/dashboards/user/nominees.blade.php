<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="card text-white bg-success mb-3">
                <div class="card-header">Quantidade de Consultores</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $quantidadeConsultores }}</h5>
                    <p class="card-text">Número total de consultores.</p>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card text-white bg-primary mb-3">
                <div class="card-header">Quantidade de Clientes</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $quantidadeClientes }}</h5>
                    <p class="card-text">Número total de clientes.</p>
                </div>
            </div>
        </div>

        <!-- Card para Total de Recargas -->
        <div class="col-md-6">
            <div class="card text-white bg-info mb-3">
                <div class="card-header">Total de Recargas</div>
                <div class="card-body">
                    <h5 class="card-title">R$ {{ number_format($totalRecargas, 2, ',', '.') }}</h5>
                    <p class="card-text">Total gasto em recargas</p>
                    @if ($ultimaRecarga)
                        <p class="card-text">Última Recarga: {{ \Carbon\Carbon::parse($ultimaRecarga)->format('d/m/Y H:i') }}</p>
                    @else
                        <p class="card-text">Nenhuma recarga registrada.</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Card para Total Apostado no Bichão -->
        <div class="col-md-6">
            <div class="card text-white bg-warning mb-3">
                <div class="card-header">Total Apostado no Bichão</div>
                <div class="card-body">
                    <h5 class="card-title">R$ {{ number_format($totalJogosBichão, 2, ',', '.') }}</h5>
                    <p class="card-text">Total gasto em compras de jogo do bicho</p>
                    @if ($ultimoJogoBichão)
                        <p class="card-text">Último Jogo do Bichão: {{ \Carbon\Carbon::parse($ultimoJogoBichão)->format('d/m/Y H:i') }}</p>
                    @else
                        <p class="card-text">Nenhum jogo do bicho registrado.</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Card para Total Apostado nas Loterias -->
        <div class="col-md-6">
            <div class="card text-white bg-warning mb-3">
                <div class="card-header">Total Apostado nas Loterias</div>
                <div class="card-body">
                    <h5 class="card-title">R$ {{ number_format($totalJogosLoterias, 2, ',', '.') }}</h5>
                    <p class="card-text">Total gasto em compras de jogos da loteria</p>
                    @if ($ultimoJogoLoterias)
                        <p class="card-text">Último Jogo da Loteria: {{ \Carbon\Carbon::parse($ultimoJogoLoterias)->format('d/m/Y H:i') }}</p>
                    @else
                        <p class="card-text">Nenhum jogo da loteria registrado.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12 mt-4">
        <h3>Usuários Indicados</h3>
        <!-- Filtro de quantidade de registros por página -->
        <div class="row mb-3">
            <!-- Filtro de quantidade de registros por página -->
            <div class="col-md-6 form-group">
                <label for="perPage">Registros por página:</label>
                <select wire:model="perPage" id="perPage" class="form-control">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>
    
            <!-- Filtro de pesquisa por nome -->
            <div class="col-md-6 form-group">
                <label for="search">Pesquisar por nome:</label>
                <input type="text" wire:model.debounce.300ms="search" id="search" class="form-control" placeholder="Digite o nome para pesquisar">
            </div>
        </div>
        <table class="table table-striped table-hover table-dark">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Classificação</th>
                    <th>Nível da Indicação</th>
                </tr>
            </thead>
            <tbody>
                @if ($indicados && $indicados->count() > 0)
                    @foreach ($indicados as $indicado)
                        <tr>
                            <td>{{ $indicado->id }}</td>
                            <td>{{ $indicado->name }} {{ $indicado->last_name }}</td>
                            <td>{{ $indicado->classificacao }}</td>
                            <td>{{ $indicado->nivel }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="4">Nenhum usuário encontrado.</td>
                    </tr>
                @endif
            </tbody>
        </table>
        <!-- Controles de paginação -->
        <div class="d-flex justify-content-center">
            @if($indicados instanceof \Illuminate\Pagination\LengthAwarePaginator)
                {{ $indicados->links() }}
            @endif
        </div>
    </div>
    </div>
</div>
