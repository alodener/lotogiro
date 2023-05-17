<div>
    <div class="col-md-12 p-4 faixa-jogos">
        <h3 class="text-center text-bold"> {{ trans('admin.carteira.wallet') }} </h3>
    </div>
    <div class="row bg-white p-3">
        <div class="col-md-12">
            <div class="card-header indica-card">
            {{ trans('admin.carteira.balanceS') }} | {{ auth()->user()->name }} - {{ trans('admin.carteira.totalB') }} R${{ \App\Helper\Money::toReal
                (auth()->user()->balance) }} | {{ trans('admin.carteira.bonus') }}  R${{\App\Helper\Money::toReal(auth()->user()->bonus)}}
            </div>
            <div class="table-responsive extractable-cel" >
                
                <table x-data="{data: @entangle('trasacts')}" class="table table-striped table-hover table-bordered table-lg" id="statementBalance_table">
                    <thead>
                    <tr>
                        <th> {{ trans('admin.carteira.date') }} </th>
                        <th> {{ trans('admin.carteira.responsible') }} </th>
                        <th> {{ trans('admin.carteira.previousValue') }} </th>
                        <th> {{ trans('admin.carteira.value') }} </th>
                        <th> {{ trans('admin.carteira.currentValue') }} </th>
                        <th> {{ trans('admin.carteira.description') }} </th>
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
                                        @if(is_null($paginate['prev'])) disabled @endif">{{ trans('admin.carteira.previous') }} </a>
                                </div>
                                <div class="col-sm-6">
                                    <a href="{{ $paginate['next'] }}" class="btn btn-info btn-block
                                        @if(is_null($paginate['next'])) disabled @endif">{{ trans('admin.carteira.next') }} </a>
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