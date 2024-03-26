@extends('admin.layouts.master')

@section('title', 'Resultados')

@section('content')



{{-- formulario onde buscaremos uma data especifica --}}

 <div class="container">
                        <div class="card-deck container d-flex justify-content-between card-header" style="padding: 30px;">
                          <div class="col-md-6">
        <h3 style="margin:0;">Lista de Ganhadores</h3>
                          </div>
                          <div class="col-md-6 d-flex align-items-center">
                            <h4 style="margin:0;" class="mr-2">Data:</h4>
        <input class="form-control date " type="date">
                          </div>                        </div>
                    </div>
{{-- interface dos cards --}}
<div class="card-deck container card-master" style="width: 100%; margin-bottom: 30px; margin-left: auto;
    margin-right: auto; margin-top:30px">

    <div class="card mb-6" style="background-color:#202223;">
        <div class="card-header"> Bilhetes Sorteados</div>
        <div class="card-body">
            <h5 class="card-title" style="font-size: 30px">52 bilhetes            </h5> <i class="nav-icon fas fa-chart-line"
                style="float: right; font-size: 50px; color:#98C715;"></i>
            <p class="card-text"></p>
        </div>
    </div>

    <div class="card mb-6" style="background-color:#202223;">
        <div class="card-header">Premiações de Hoje</div>
        <div class="card-body">
  
                <h5 class="card-title" style="font-size: 30px">R$ 23.503,00</h5> <i 
                class="nav-icon fas fa-dollar-sign" style="float: right; font-size: 50px;color:#98C715;"></i>
            <p class="card-text"></p>
        </div>
    </div>
    
</div>
  
<div class="container d-flex flex-md-row flex-column">

    <div class="col-md-6 card-header">
      <h3 style="margin:0;">Apostas Vencedoras</h3>
    </div>
  <div class="col-md-3 card-2" style="max-height:57px" >
    <button class="btn btn-secondary mr-md-3 mr-2 d-flex justify-content-center align-items-center " style="border-radius: 90px;">
      <i style="color:#a3d712" class="fa fa-files-o wallet-nav"></i>
  </button>
      <p style="margin:0;">Copiar Lista</p>
  </div>
  <div class="col-md-3 card-2" style="max-height:57px" >
    <button class="btn btn-secondary mr-md-3 mr-2 d-flex justify-content-center align-items-center " style="border-radius: 90px;">
      <i style="color:#a3d712" class="fa fa-whatsapp wallet-nav"></i>
  </button>
      <p style="margin:0;">Enviar ao WhatsApp</p>
  </div>

</div>

{{-- tabela de rede --}}
<div class="container card-master mt-3">
    <table id="relatorio" class="table table-striped " style="width: 100%">
        <thead>
            <tr>
                <th>{{ trans('admin.network-sales.table-id-header') }}</th>
                <th>{{ trans('admin.network-sales.table-name-header') }}</th>
                <th>Prêmio</th>
                <th>Bilhetes</th>

                <th>Modalidade</th>
                <th>Status</th>
            </tr>
        </thead>

        <tr>
          <th>2354203</th>
          <th>Gisele Barbosa Bezerra</th>
          <th>R$ 300,00</th>
          <th>1</th>
          <th>LTP-ST LUCIA DOUBLE</th>
          <th>Pago</th>
        </tr>
        <tr>
          <th>2354285</th>
          <th>Wenio Rodrigues Moreira</th>
          <th>R$ 300,00</th>
          <th>1</th>
          <th>LTP-ST LUCIA DOUBLE</th>
          <th>Pago</th>
        </tr>
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