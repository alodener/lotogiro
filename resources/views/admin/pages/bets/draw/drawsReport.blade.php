@extends('admin.layouts.master')

@section('title', trans('admin.competitions.test'))

@section('content')
    <div class="card">
        <div class="card-header">
            <h1>Relatório de Sorteios</h1>
        </div>

    </div>
    
    <div class="card">
    <div class="card-body">
        @php
            use App\Helper\Money;
        @endphp

        <form action="{{ route('admin.bets.report-draws') }}" method="GET">
            <div class="row">
            <label for="date">Selecione a data:</label>
            <input type="date" class="form-control col-md-3" name="date" id="date" value="{{ request('date') }}">

            <label for="type">Tipo:</label>
            <select name="type"  class="form-control form-select col-md-3"  id="type">
                <option value="geral" {{ request('type') === 'geral' ? 'selected' : '' }}>Geral</option>
                <option value="financeiro" {{ request('type') === 'financeiro' ? 'selected' : '' }}>Financeiro</option>
            </select>
            &nbsp;
            &nbsp;
            &nbsp;
            <button type="submit" class="col-md-2 form-control btn btn-primary">Buscar</button>
</div>
        </form>

        
</div>
    </div>
@endsection

