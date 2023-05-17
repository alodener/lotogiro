<div>
    <div class="col-md-12 p-4 faixa-jogos">
        <h3 class="text-center text-bold">{{ trans('admin.ordersBlade.WALLET') }}</h3>
    </div>
    <div class="row bg-white p-3">
        <div class="col-md-12">
            <div class="card-header indica-card">
            {{ trans('admin.ordersBlade.peRecharge') }}
            </div>
            <div class="table-responsive extractable-cel">
                <table class="table table-striped table-hover table-bordered table-lg">
                    <thead>
                    <tr>
                        <th>{{ trans('admin.ordersBlade.date') }} </th>
                        <th>{{ trans('admin.ordersBlade.user') }} </th>
                        <th>{{ trans('admin.ordersBlade.value') }} </th>
                        <th>{{ trans('admin.ordersBlade.status') }} </th>
                        <th>{{ trans('admin.ordersBlade.action') }} </th>
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
                                    {{ trans('admin.ordersBlade.details') }}
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
