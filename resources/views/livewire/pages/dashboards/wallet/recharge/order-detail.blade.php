<div>
    @if ($order->status == 0)
        <div class="row">
            <div class="col text-center">
                <img src="{{ $qrCode }}" width="400" class="img-fluid img-thumbnail mb-3">
            </div>
        </div>
    @endif
    <div class="alert alert-success" role="alert">
        <h4 class="alert-heading">{{ trans('admin.pagesF.detalhesP') }}  #{{ $order->reference }}</h4>
        <hr>
        <div class="row">
            <div class="col-sm-12" style="line-height: 3rem;">
                <p class="mb-0"><b>{{ trans('admin.pagesF.ultimasAt') }} {{ $order->data }}</b></p>
                <p class="mb-0"><b>{{ trans('admin.pagesF.usuario') }}  {{ $order->usuario }}</b></p>
                <p class="mb-0"><b>{{ trans('admin.pagesF.recarga') }} </b> R$ {{ $order->value }}</p>
                <p class="mb-0"><b>{{ trans('admin.pagesF.status') }}: </b>{{ $order->statusTxt }}</p>
            </div>
        </div>
    </div>

    @if($allOrder->count() > 1)
    <div class="row">
        <div class="col-sm-10 offset-sm-1">
            <table class="table table-striped">
                <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">{{ trans('admin.pagesF.date') }}</th>
                    <th scope="col">{{ trans('admin.pagesF.status') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($allOrder as $item)
                <tr>
                    <th scope="row">1</th>
                    <td>{{ $item->data }}</td>
                    <td>{{ $item->statusTxt }}</td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    @if($order->status != 1)
    <div class="row">
        <div class="col-sm-12">
            <a class="btn btn-primary btn-block" href="{{ $order->link }}" target="_blank">{{ trans('admin.pagesF.tentNov') }}</a>
        </div>
    </div>
    @endif
</div>
