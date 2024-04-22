@extends('admin.layouts.master')

@section('title', 'Resultados')

@section('content')



{{-- interface dos cards --}}
<div class="container" style="padding:0px;">
    {{$game->banner_resultados}}
    <img src="{{ $game->banner_resultados ? asset("storage/{$game->banner_resultados}") : asset('https://i.ibb.co/VWhHF8D/Yys88-SZf-Yy-AI4oo61k-Bd-Fw-Kq-Sl-R0k-Cu-Wd-DDQUVj5.jpg') }}"
     style="width:100%;max-height:150px;">


</div>

<div class="d-flex container flex-md-row flex-column justify-content-between mt-2" style="padding:0px;">
    <div class="container" style="margin:0px; padding:0px; ">
        <div class="d-flex card-master flex-column" style="height:145px;">
            <div class="card container d-flex flex-row" style="margin-bottom:0px;">
                <div class="card-header" style="width:110%;align-self:center; margin-bottom:0px; font-size:19px;">Último
                    Resultado</div>
                <div class="card-header" style="width:90%;align-self:center; margin-bottom:0px; font-size:19px;">
                    Concurso: 12121</div>
            </div>
            <div class="card container d-flex flex-row align-items-center"
                style="background-color:#202223; padding:10px;">

                <h4 class="numbertext">08,22,18,06,20,21,19,13,16,03,17,02,12,24,09,25
                </h4>
            </div>
        </div>
    </div>
    <div class="container mt-2 mt-md-0" style="padding:0px;">
        <div class="d-flex card-master flex-column" style="height:145px;">
            <div class="card container d-flex flex-row" style="margin-bottom:0px;">
                <div class="card-header" style="width:125%;align-self:center; margin-bottom:0px; font-size:19px;">Menu
                    de Ações</div>
            </div>
            <div class="card container d-flex flex-row align-items-center justify-content-center"
                style="background-color:#202223; padding:10px;">
                <button class="btn btn-primary d-flex align-items-center justify-content-center font-btn" style="font-size:12px; color:white;"> <i class="fa fa-files-o mr-2 icon-btn" style="font-size:20px;" aria-hidden="true"></i>
                    Baixar PDF</button>
                <button class="btn btn-primary mr-2 ml-2  d-flex align-items-center justify-content-center font-btn" style="font-size:12px; color:white;"> <i class="fa fa-share-alt-square mr-2 icon-btn" style="font-size:20px;"aria-hidden="true"></i>
                    Compartilhar</button>
                <button class="btn btn-primary  d-flex align-items-center justify-content-center font-btn" style="font-size:12px; color:white; background:#C70067;"><i class="fa fa-money mr-2 icon-btn" style="font-size:20px;" aria-hidden="true"></i>
                    Ver Cotação</button>
            </div>
        </div>
    </div>
</div>
{{-- formulario onde buscaremos uma data especifica --}}


<div class="container mt-2 justify-content-center d-flex" style="padding:0px;">
    <div class="card-deck container d-flex justify-content-between card-header" style="padding: 10px;">
        <div class="col-md-6 text-md-start ">
            <h3 style="margin:0;">Todos os Resultados</h3>
        </div>
        <div class="col-md-6 d-flex align-items-center flex-md-row flex-column">
            <h4 style="margin:0;" class="mr-2 mt-3 mt-md-0">Data:</h4>
            <input class="form-control date" id="dataInput" type="date">
        </div>
    </div>
</div>

<!-- Todos os jogos -->
<div class="container card-master mt-3">

    <table id="relatorio" class="table table-striped" style="width: 100%">
        <div class="d-flex justify-content-end">

        </div>
        <thead>
            <tr>
                <th>{{ trans('admin.network-sales.table-id-header') }}</th>
                <th>Tipo de Jogos</th>
                <th>Resultado</th>
                <th>Concurso</th>
                <th>Data Sorteio</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th>171</th>
                <th>LTB - Lotinha</th>
                <th>08,22,18,06,20,21,19,13,16,03,17,02,12,24,09,25</th>
                <th>1212</th>
                <th>08/04/2023</th>
                <th>
                    <div class="d-flex justify-content-center align-items-center">
                        <button class="btn btn-secondary mr-2  ">
                            <i class="fa fa-files-o" aria-hidden="true"></i>
                        </button>
                        <button class="btn btn-secondary ">
                            <i class="fa fa-share-alt-square" aria-hidden="true"></i>
                        </button>
                    </div>
                </th>
            </tr>
            <tr>
                <th>171</th>
                <th>LTB - Lotinha</th>
                <th>08,22,18,06,20,21,19,13,16,03,17,02,12,24,09,25</th>
                <th>1212</th>
                <th>08/04/2023</th>
                <th>
                    <div class="d-flex justify-content-center align-items-center">
                        <button class="btn btn-secondary mr-2  ">
                            <i class="fa fa-files-o" aria-hidden="true"></i>
                        </button>
                        <button class="btn btn-secondary ">
                            <i class="fa fa-share-alt-square" aria-hidden="true"></i>
                        </button>
                    </div>
                </th>
            </tr>
            <tr>
                <th>171</th>
                <th>LTB - Lotinha</th>
                <th>08,22,18,06,20,21,19,13,16,03,17,02,12,24,09,25</th>
                <th>1212</th>
                <th>08/04/2023</th>
                <th>
                    <div class="d-flex justify-content-center align-items-center">
                        <button class="btn btn-secondary mr-2  ">
                            <i class="fa fa-files-o" aria-hidden="true"></i>
                        </button>
                        <button class="btn btn-secondary ">
                            <i class="fa fa-share-alt-square" aria-hidden="true"></i>
                        </button>
                    </div>
                </th>
            </tr>
            <tr>
                <th>171</th>
                <th>LTB - Lotinha</th>
                <th >08,22,18,06,20,21,19,13,16,03,17,02,12,24,09,25</th>
                <th>1212</th>
                <th>08/04/2023</th>
                <th>
                    <div class="d-flex justify-content-center align-items-center">
                        <button class="btn btn-secondary mr-2  ">
                            <i class="fa fa-files-o" aria-hidden="true"></i>
                        </button>
                        <button class="btn btn-secondary ">
                            <i class="fa fa-share-alt-square" aria-hidden="true"></i>
                        </button>
                    </div>
                </th>
            </tr>
        </tbody>
    </table>
</div>

<div class="p-3"></div>


<style>
    .card {
        margin-bottom: 0px !important;
    }
</style>

@endsection

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.13/jspdf.plugin.autotable.min.js"></script>
@push('scripts')

<script>
    $(document).ready(function() {
        // Inicializa o DataTable
        var table = $('#relatorio').DataTable({
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

<style>
    .hover-container {
        position: relative;
    }

    .hover-content {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        text-align: center;
        display: none;
        background-color: rgba(0, 0, 0, 0.7);
        padding: 20px;
        border-radius: 10px;
        color: #fff;
        box-sizing: border-box;
    }

    .hover-container:hover .hover-content {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .hover-content p {

        font-weight: 700;

    }

    .hover-button {
        padding: 10px;
        background-color: #3498db;
        color: #fff;
        border: none;
        cursor: pointer;
    }



    @media screen and (max-width: 1400px) {
        .hover-content {
            padding: 10px !important;
        }

        .hover-content p {
            font-size: 12px;

        }

        .hover-content button {
            font-size: 10px;
            padding: 5px;

        }
    }


    @media screen and (max-width: 1290px) {
       .numbertext{
        font-size:20px;
       }
       .font-btn{
        font-size:10px;
        padding: 5px !important;
       }
    }
    @media screen and (max-width: 1145px) {
       .numbertext{
        font-size:15px !important;
       }
       .font-btn{
        font-size:8px !important;
        padding: 5px !important;
       }

       .icon-btn{
        font-size:10px;
       }
    }
    @media screen and (max-width: 767px) {
      
       .font-btn{
        font-size:12px !important;
       }

       
    }
   
</style>