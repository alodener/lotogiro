@extends('admin.layouts.master')

@section('title', trans('admin.network-sales.page-title'))

@section('content')
    {{-- calculando venda total da rede --}}
    @php
        foreach ($result as $valor) {
            $valorTotal =  $valorTotal + $valor->valorVenda;
        }
        foreach ($jogosFeitos as $Soma) {
            $totalJogos = $totalJogos + $Soma->jogoFeitos;
        }
    @endphp
    
    {{-- filtro de data --}}
    <div class="container">
        <select id="Filtro" class="form-select" aria-label="Default select example" onchange="Filtro()">
            <option selected value='0'>{{ trans('admin.select-period') }}</option>
            <option value="1">{{ trans('admin.daily') }}</option>
            <option value="2">{{ trans('admin.weekly') }}</option>
            <option value="3">{{ trans('admin.monthly') }}</option>
            <option value="4">{{ trans('admin.custom') }}</option>
        </select>
    </div> 

    {{-- formulario onde buscaremos uma data especifica --}}
    <form id='FiltroPersonalizado' style="display: none; margin-top: 20px" method="post" action="{{ route('admin.dashboards.Reportday.filtro-especifico') }}">
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
            
            <button type="submit"  style="margin-top: 20px" class="btn btn-primary">Pesquisar</button>

        </div>
    </form>

    {{-- interface dos cards --}}
    <div class="card-deck" style="width: 100%; margin-bottom: 30px; margin-left: auto;
    margin-right: auto; margin-top:30px">

        <div class="card text-white bg-warning mb-6" style="">
            <div class="card-header">{{ trans('admin.network-sales.games-done') }}</div>
                <div class="card-body">
                    <h5 class="card-title" style="font-size: 30px">{{ $totalJogos }}</h5> <i class="nav-icon fas fa-chart-line"  style="float: right; font-size: 50px"></i>
                    <p class="card-text"></p>
                </div>
            </div>

            <div class="card text-white bg-success mb-6" style="">
                <div class="card-header">{{ trans('admin.network-sales.network-sales') }}</div>
                <div class="card-body">
                    <h5 class="card-title" style="font-size: 30px">R${{ floatval($valorTotal) }}</h5> <i class="nav-icon fas fa-dollar-sign"  style="float: right; font-size: 50px"></i>
                    <p class="card-text"></p>
                </div>
            </div>
        </div>

    </div>

    {{-- tabela de rede --}}
    <div class="container">
        <table id="relatorio" class="table table-striped" style="width: 100%">
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

@endsection


@push('styles')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap5.min.css">

@endpush

@push('scripts')

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script>

<script>
    function Filtro(){
        var select = document.getElementById('Filtro');
        var value = select.options[select.selectedIndex].value;
        if(value == 4){
            document.getElementById("FiltroPersonalizado").style.display = "block";
        }
        else if(value == 0){
            document.getElementById("FiltroPersonalizado").style.display = "none";
        }
        else{
            document.getElementById("FiltroPersonalizado").style.display = "none";
            location.href = "{{env('APP_URL')}}/admin/dashboards/Reportday/FiltroEspecifico/" + value;
        }
    }
    	
</script>

<script>
$(document).ready(function(){
  $('#relatorio').DataTable({
    theme: "bootstrap",
    "scrollX": true,
    "columnDefs": [
   {"className": "dt-center", "targets": "_all"}
],
        
        "language": {
            "lengthMenu": "Mostrando _MENU_ registros por página",
            "zeroRecords": "Nada encontrado",
            "info": "Mostrando página _PAGE_ de _PAGES_",
            "infoEmpty": "Nenhum registro disponível",
            "infoFiltered": "(filtrado de _MAX_ registros no total)"
        }
    });
});
</script>
@endpush
