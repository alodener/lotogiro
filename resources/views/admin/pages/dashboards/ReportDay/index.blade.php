@extends('admin.layouts.master')

@section('title', trans('admin.network-sales.page-title'))

@section('content')
{{-- calculando venda total da rede --}}
@php
foreach ($result as $valor) {
$valorTotal = $valorTotal + $valor->valorVenda;
}
foreach ($jogosFeitos as $Soma) {
$totalJogos = $totalJogos + $Soma->jogoFeitos;
}
@endphp


{{-- formulario onde buscaremos uma data especifica --}}
<form id='FiltroPersonalizado' style="display: none; margin-top: 20px" method="post"
    action="{{ route('admin.dashboards.Reportday.filtro-especifico') }}">
    @csrf
    <div class="container">
        <div>
            <label for="">{{ trans('admin.initial-date') }}:</label>
            <input id="startDate" name='dataInicio' class="form-control" type="date" />
        </div>

        <div>
            <label for="">{{ trans('admin.end-date') }}:</label>
            <input id="endDate" name='dataFinal' class="form-control" type="date" />
        </div>

        <button type="submit" style="margin-top: 20px" class="btn btn-primary">{{ trans('admin.pagesF.pesquisar')
            }}</button>

    </div>
</form>

{{-- interface dos cards --}}
<div class="card-deck container card-master" style="width: 100%; margin-bottom: 30px; margin-left: auto;
    margin-right: auto; margin-top:30px">

    <div class="card mb-6" style="background-color:#202223;">
        <div class="card-header">{{ trans('admin.network-sales.games-done') }}</div>
        <div class="card-body">
            <h5 class="card-title" style="font-size: 30px">{{ $totalJogos }}</h5> <i class="nav-icon fas fa-chart-line"
                style="float: right; font-size: 50px; color:#98C715;"></i>
            <p class="card-text"></p>
        </div>
    </div>

    <div class="card mb-6" style="background-color:#202223;">
        <div class="card-header">{{ trans('admin.network-sales.network-sales') }}</div>
        <div class="card-body">
            <h5 class="card-title" style="font-size: 30px">R${{ floatval($valorTotal) }}</h5> <i
                class="nav-icon fas fa-dollar-sign" style="float: right; font-size: 50px;color:#98C715;"></i>
            <p class="card-text"></p>
        </div>
    </div>
    
</div>
  
{{-- filtro de data --}}
    <div class="container card-master">
        <select id="Filtro" class="form-control " aria-label="Default select example" onchange="Filtro()">
            <option selected value='0'>{{ trans('admin.select-period') }}</option>
            <option value="1">{{ trans('admin.daily') }}</option>
            <option value="2">{{ trans('admin.weekly') }}</option>
            <option value="3">{{ trans('admin.monthly') }}</option>
            <option value="4">{{ trans('admin.custom') }}</option>
        </select>
    </div> 
</div>

{{-- tabela de rede --}}
<div class="container card-master mt-3">
    <table id="relatorio" class="table table-striped " style="width: 100%">
        <thead>
            <tr>
                <th>{{ trans('admin.network-sales.table-id-header') }}</th>
                <th>{{ trans('admin.network-sales.table-name-header') }}</th>
                <th>{{ trans('admin.network-sales.table-email-header') }}</th>
                <th>{{ trans('admin.network-sales.table-total-sales-header') }}</th>
            </tr>
        </thead>
        @foreach ($result as $InfoRede)
        <tr>
            <td>{{ $InfoRede->id }}</td>
            <td>{{ $InfoRede->name . ' ' . $InfoRede->last_name }}</td>
            <td>{{ $InfoRede->email }}</td>
            <td>R${{ $InfoRede->valorVenda }}</td>
        </tr>
        @endforeach
    </table>
</div>

<div class="p-3"></div>

@endsection



@push('scripts')

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script>

<script>
    function Filtro() {
        var select = document.getElementById('Filtro');
        var value = select.options[select.selectedIndex].value;
        if (value == 4) {
            document.getElementById("FiltroPersonalizado").style.display = "block";
        }
        else if (value == 0) {
            document.getElementById("FiltroPersonalizado").style.display = "none";
        }
        else {
            document.getElementById("FiltroPersonalizado").style.display = "none";
            location.href = "{{env('APP_URL')}}/admin/dashboards/Reportday/FiltroEspecifico/" + value;
        }
    }

</script>

<script>
    $(document).ready(function () {
        $('#relatorio').DataTable({
            theme: "bootstrap",
            "scrollX": true,
            "columnDefs": [
                { "className": "dt-center", "targets": "_all" }
            ],

            "language": {
                "lengthMenu": "{{ trans('admin.pagesF.mostrandoRegs') }}",
                "zeroRecords": "{{ trans('admin.pagesF.ndEncont') }}",
                "info": "{{ trans('admin.pagesF.mostrandoPags') }}",
                "infoEmpty": "{{ trans('admin.pagesF.nhmRegs') }}",
                "infoFiltered": "{{ trans('admin.pagesF.filtrado') }}",
                "search": "{{ trans('admin.pagesF.search') }}",
                "previous": "{{ trans('admin.pagesF.previous') }}",
                "next": "{{ trans('admin.pagesF.next') }}"

            }
        });
    });
</script>
@endpush