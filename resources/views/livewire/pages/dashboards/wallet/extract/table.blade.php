<div>
    <div class="col-md-12 p-4 faixa-jogos">
        <h3 class="text-center text-bold">  {{ trans('admin.pagesF.carteira') }} </h3>
    </div>
    <div class="row bg-white p-3">
        <div class="col-md-12">
            <div class="card-header indica-card">
            {{ trans('admin.pagesF.extratSaldo') }} | {{ auth()->user()->name }} - {{ trans('admin.pagesF.saldoTotal') }}: R${{ \App\Helper\Money::toReal
                (auth()->user()->balance) }} | Bônus: R${{\App\Helper\Money::toReal(auth()->user()->bonus)}}
            </div>
            <div class="table-responsive extractable-cel" >
                
                <table x-data="{data: @entangle('trasacts')}" class="table table-striped table-hover table-bordered table-lg" id="statementBalance_table">
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
                        <template x-for="history in data">
                            <tr>
                                <td x-text="history.data"></td>
                                <td x-text="history.responsavel"></td>
                                <td x-text="history.old_value"></td>
                                <td x-text="history.value"></td>
                                <td x-text="history.value_a"></td>
                                <td x-text="history.obs"></td>
                                <!-- 'Venda - Jogo de id: ' . $game->id, 'do tipo: ' . $game->type_game_id -->
                            </tr>
                        </template>
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="9">
                            <div class="row">
                                <div class="col-sm-6">
                                    <a href="{{ $paginate['prev'] }}" class="btn btn-info btn-block
                                        @if(is_null($paginate['prev'])) disabled @endif">{{ trans('admin.pagesF.anterior') }}</a>
                                </div>
                                <div class="col-sm-6">
                                    <a href="{{ $paginate['next'] }}" class="btn btn-info btn-block
                                        @if(is_null($paginate['next'])) disabled @endif">{{ trans('admin.pagesF.proxima') }}</a>
                                </div>
                            </div>
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