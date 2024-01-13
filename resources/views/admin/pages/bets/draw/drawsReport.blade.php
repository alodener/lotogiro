@extends('admin.layouts.master')

@section('title', 'Relatório de Sorteios')

@section('content')

<div class="row bg-white p-3">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12">
                <div class="card-header indica-card">
                {{ trans('admin.falta.relatorioSort') }}
                </div>
            </div>
        </div>
    
    <div class="card">
    <div class="card-body">
        @php
            use App\Helper\Money;
        @endphp

        <form action="{{ route('admin.bets.report-draws') }}" method="GET">
            <div class="row">
            <label for="date">{{ trans('admin.falta.selecData') }}:</label>
            <input type="date" class="form-control col-md-3" name="date" id="date" value="{{ request('date') }}">

            <label for="type">{{ trans('admin.falta.tipo') }}:</label>
            <select name="type"  class="form-control form-select col-md-3"  id="type">
                <option value="geral" {{ request('type') === 'geral' ? 'selected' : '' }}>{{ trans('admin.falta.geral') }}</option>
                <option value="financeiro" {{ request('type') === 'financeiro' ? 'selected' : '' }}>{{ trans('admin.falta.financeiro') }}</option>
            </select>
            &nbsp;
            &nbsp;
            &nbsp; 
            <button type="submit" class="col-md-2 form-control btn btn-primary">{{ trans('admin.falta.buscar') }}</button>
</div>
        </form>

</div>
</div>
</div>
    </div>
@endsection


