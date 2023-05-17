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
                <h4 class="my-4">{{ trans('admin.statementBalance.balance') }}  | {{ $user->name }} - {{ trans('admin.statementBalance.balanceT') }}   {{ \App\Helper\Money::toReal($user->balance) }} | {{ trans('admin.statementBalance.bonus') }}  R${{\App\Helper\Money::toReal($user->bonus)}}</h4>
                <table class="table table-striped table-hover table-bordered table-lg" id="statementBalance_table">
                    <div class="my-4 col-md-4 text-right">
                    <a href= "{{route('admin.settings.users.statementBalance', $user->id)}}" class="btn btn-primary"> {{ trans('admin.statementBalance.back') }}   </a>
                    </div>
                </div>
                    <thead>
                    <tr>
                        <th>{{ trans('admin.statementBalance.date') }}  </th>
                        <th>{{ trans('admin.statementBalance.resp') }} </th>
                        <th>{{ trans('admin.statementBalance.wallet') }} </th>
                        <th>{{ trans('admin.statementBalance.valueA') }}  </th>
                        <th>{{ trans('admin.statementBalance.value') }}   </th>
                        <th>{{ trans('admin.statementBalance.aValue') }}   </th>
                        <th>{{ trans('admin.statementBalance.descrip') }}   </th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($historybalance as $history)
                        <tr>
                            <td>{{ $history->data }}</td>
                            <td>{{ $history->responsavel }}</td>
                            <td>{{ $history->wallet == 'balance' ? '{{ trans('admin.statementBalance.saldo') }}' : '{{ trans('admin.statementBalance.bonus') }}' }}</td>
                            <td>{{ $history->old_value }}</td>
                            <td>{{ $history->value }}</td>
                            <td>{{ $history->value_a }}</td>
                            <td>{{ $history->type }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">{{ trans('admin.statementBalance.dado-exibir') }}  </td>
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