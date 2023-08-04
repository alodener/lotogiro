@extends('admin.layouts.master')

@section('title', 'Extrato de Saldo')

@section('content')
    <style>
        ul.pagination{
            float:right !important;
        }
    </style>
    <div class="row bg-white p-3">
        <div class="col-md-12">
            @error('success')
            @push('scripts')
                <script>
                    toastr["success"]("{{ $message }}")
                </script>
            @endpush
            @enderror
            @error('error')
            @push('scripts')
                <script>
                    toastr["error"]("{{ $message }}")
                </script>
            @endpush
            @enderror
            {{-- TODO: Verificar permissões para acessar rota e recurso --}}
            <div class="table-responsive">
                <div class="row">
                <h4 class="my-4">{{ trans('admin.pagesF.extratSaldo') }} | {{ $user->name }} - {{ trans('admin.pagesF.saldoTotal') }}: {{ \App\Helper\Money::toReal($user->balance) }} | {{ trans('admin.pagesF.bonus') }}: R${{\App\Helper\Money::toReal($user->bonus)}}</h4>
                <table class="table table-striped table-hover table-bordered table-lg" id="statementBalance_table">
                    <div class="my-4 col-md-4 text-right">
                    <a href= "{{route('admin.settings.users.statementBalanceFiltrado', $user->id)}}" class="btn btn-primary"> {{ trans('admin.pagesF.filtrarR') }} </a>
                    </div>
                </div>
                    <thead>
                    <tr>
                        <th>{{ trans('admin.pagesF.date') }} </th>
                        <th>{{ trans('admin.pagesF.responsavel') }}</th>
                        <th>{{ trans('admin.pagesF.carteira') }}</th>
                        <th>{{ trans('admin.pagesF.valueAnt') }}</th>
                        <th>{{ trans('admin.pagesF.valor') }}</th>
                        <th>{{ trans('admin.pagesF.valueAtual') }}</th>
                        <th>{{ trans('admin.pagesF.descricao') }}</th>
                        
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($historybalance as $history)
                        <tr>
                            <td>{{ $history->data }}</td>
                            <td>{{ $history->responsavel }}</td>
                            <td>{{ $history->wallet == 'balance' ? 'Saldo' : 'Bônus' }}</td>
                            <td>{{ $history->old_value }}</td>
                            <td>{{ $history->value }}</td>
                            <td>{{ $history->value_a }}</td>
                            <td>{{ $history->type }}</td>
                            
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">{{ trans('admin.pagesF.nenhumdado') }}</td>
                        </tr>
                    @endforelse
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="4">
                            {!! $historybalance->links('pagination::bootstrap-4') !!}
                        </td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endsection
