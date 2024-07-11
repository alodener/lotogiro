<div>
    <div class="col-md-12 p-4 card-header">
        <h3 class="text-center text-bold">EXTRATO</h3>
    </div>
    <div class="row p-3">
        <div class="col-md-12">
            @include('admin.pages.dashboards.wallet.saldo')

            <!-- Filtros -->
            <div class="row mb-3 bg-secondary text-white p-3 rounded">
                <div class="col-md-4">
                    <select wire:model="description" class="form-control">
                        <option value="">Escolha a Descrição</option>
                        <option value="Recarga efetuada por meio da plataforma">Pix</option>
                        <option value="Add por Admin">Recarga Manual</option>
                        <option value="Compra - Jogo de id:">Jogos Realizados</option>
                        <option value="BONUS DE JOGO">Bônus</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="date" wire:model="dateFrom" class="form-control" placeholder="Data de Início">
                </div>
                <div class="col-md-2">
                    <input type="date" wire:model="dateTo" class="form-control" placeholder="Data de Fim">
                </div>
                <div class="col-md-3">
                    <button wire:click="applyFilters" class="btn btn-primary btn-block">Aplicar Filtros</button>
                </div>
                <div class="col-md-1">
                    <select wire:model="perPage" class="form-control">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>
            </div>

            <!-- Card de soma dos valores filtrados -->
            @if($filtersApplied)
                <div class="d-flex justify-content-center mb-5">
                    <div class="card-master card-master-bottom mr-md-5 ml-md-5 text-center">
                        <h5 class="card-title">Soma dos Valores Filtrados</h5>
                        <p class="card-text">{{ \App\Helper\Money::toReal($filteredSum) }}</p>
                    </div>
                </div>
            @endif

            <div class="table-responsive extractable-cel">
                <table x-data="{data: @entangle('trasacts')}" class="table table-striped table-hover table-sm dataTable no-footer" id="statementBalance_table">
                    <thead>
                    <tr>
                        <th>{{ trans('admin.pagesF.date') }}</th>
                        <th>{{ trans('admin.pagesF.responsavel') }}</th>
                        <th>{{ trans('admin.pagesF.valueAnt') }}</th>
                        <th>{{ trans('admin.pagesF.valor') }}</th>
                        <th>{{ trans('admin.pagesF.valueAtual') }}</th>
                        <th>{{ trans('admin.pagesF.descricao') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                        <template x-for="history in data" :key="history.data">
                            <tr>
                                <td x-text="history.data"></td>
                                <td x-text="history.responsavel"></td>
                                <td x-text="history.old_value"></td>
                                <td x-text="history.value"></td>
                                <td x-text="history.value_a"></td>
                                <td x-text="history.obs"></td>
                            </tr>
                        </template>
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="6">
                            {{ $transacts->links() }} 
                        </td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

@push('styles')
    <style>
        @media screen and (max-width: 760px) {
            .btn-info {
                margin-bottom: 10px;
            }
            .indica-card {
                font-size: 13px;
            }
        }
    </style>
@endpush
