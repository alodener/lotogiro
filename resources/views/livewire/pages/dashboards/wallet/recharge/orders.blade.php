<div>
<div class="col-md-12 p-4 card-header">
        <h3 class="text-center text-bold">PEDIDOS DE RECARGA</h3>
    </div>
    <div class="row  p-3">
        <div class="col-md-12">
           
            <div class="table-responsive extractable-cel">
                <table class="table table-striped table-hover table-sm dataTable no-footer">
                    <thead>
                    <tr>
                        <th>{{ trans('admin.pagesF.date') }}</th>
                        <th>{{ trans('admin.pagesF.user') }}</th>
                        <th>{{ trans('admin.pagesF.valor') }}</th>
                        <th>{{ trans('admin.pagesF.status') }}</th>
                        <th>{{ trans('admin.pagesF.acoes') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($orders as $order)
                        <tr>
                            <td>{{ $order->data }}</td>
                            <td>{{ $order->user }}</td>
                            <td>{{ $order->value }}</td>
                            <td>{{ $order->statusTxt }}</td>
                            <td width="5%" align="center">
                                <a href="{{ route('admin.dashboards.wallet.order-detail', $order->reference) }}"
                                   type="button"
                                   class="btn btn-info">
                                    <i class="fa fa-eye"></i>
                                    {{ trans('admin.pagesF.detalhes') }}
                                </a>
                            </td>
                        </tr>
                    @empty

                    @endforelse
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="5">
                            <div class="row">
                                <div class="col-sm-12">
                                    {{ $orders->links() }}
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
                font-size: 9px;
            }
            tbody tr td {
                font-size: 9px;
            }
        }



    </style>
@endpush
