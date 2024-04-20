@extends('admin.layouts.master')

@section('title', trans('admin.games.listing-page-title'))

@section('content')
<div class="col  p-3">
    @include('admin.pages.bets.game.bichao.top_menu')
    <hr />
    <div class="d-flex justify-content-center flex-column align-items-center">
        <div class="card-header container-fluid align-items-center">
            <h4>{{ trans('admin.bichao.resultados') }}</h4>
            <p>{{ trans('admin.bichao.acompanheResults') }}</p>

            <hr />
        </div>
        <div class="d-flex container justify-content-center align-items-center card-master">
            <div class="">
                <div class="row">
                    <div class="col-6">
                        <div class="form-group w-100">
                            <label>{{ trans('admin.bichao.escolhaData') }}</label>
                            <input type="date" name="initial_date" class="form-control" id="initial_date"
                                value="{{date('Y-m-d')}}" max="{{date('Y-m-d')}}">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="selecionar-estado-bichao-resultados">{{ trans('admin.bichao.selecEstado')
                                }}</label>
                            <select class="form-control" id="selecionar-estado-bichao-resultados">
                                <option value="RJ" selected>Rio de Janeiro</option>
                                <option value="SP">São Paulo</option>
                                <option value="GO">Goiás</option>
                                <option value="MG">Minas Gerais</option>
                                <option value="BA">Bahia</option>
                                <option value="PB">Paraíba</option>
                                <option value="DF">Brasília</option>
                                <option value="CE">Ceará</option>
                                <option value="FED">Federal</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 col-12">
                        <button class="btn btn-primary" id="bichao-buscar-resultados" type="button">{{
                            trans('admin.bichao.buscResults') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex mt-5 card-master justify-content-center align-items-center flex-wrap container"
        id="bichao-resultado-busca">
        <div class="col-12">
            <p>{{ trans('admin.bichao.procurando') }}</p>
        </div>
    </div>
</div>
@endsection
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.13.3/css/selectize.min.css"
    integrity="sha512-bkB9w//jjNUnYbUpATZQCJu2khobZXvLP5GZ8jhltg7P/dghIrTaSJ7B/zdlBUT0W/LXGZ7FfCIqNvXjWKqCYA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
@push('styles')


<style>
    .card-master {


        background-color: #323637;
        padding: 10px;
        border-radius: 5px;
    }

    #filterForm {
        margin-top: 30px;
        margin-bottom: 30px;
    }

    #filterForm .form-row {
        justify-content: flex-end;
        align-items: flex-end;
        margin: 0;
    }

    .table-header {
        background-color: #212425;
    }

    .table-body {
        text-align: center;
    }

    .second-header td {
        padding-top: 20px;
        padding-bottom: 20px;
    }

    @media(max-width: 467px) {
        #filterForm .form-row {
            flex-direction: column;
        }
    }

    @media(max-width: 600px) {
        .container-menu-items {
            flex-wrap: wrap;
        }

        .container-menu-items a {
            flex: 50%;
            width: 100%;
        }

        .container-menu-items a button {
            width: 100%;
        }
    }
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function () {
    $('#bichao-buscar-resultados').click(function () {
        fetchResultados();
    });
});

function fetchResultados() {
    const estado = $('#selecionar-estado-bichao-resultados').val();
    const data = $('#initial_date').val();

    if (!estado) return alert('Selecione um estado');

    $('#bichao-resultado-busca').html(`
            <div class="col-12">
                <p>Procurando resultados...</p>
            </div>
        `);

    $.ajax({
        url: '{{ url('/') }}/api/scrape',
        type: 'GET',
        dataType: 'json',
        data: { data, estado },
        success: function (data) {
            if ($.isEmptyObject(data)) {
                $('#bichao-resultado-busca').html(`
                        <div class="col-12">
                            <p>Sem jogos hoje!</p>
                        </div>
                    `);
                return;
            }

            const html = Object.keys(data).map(function (lottery) {
                const subhtml = data[lottery].map(function (item) {
                    return `
                        <tr>
                            <td>${item.lugar}</td>
                            <td>${item.numero}</td>
                            <td>${item.grupo}</td>
                            <td>${item.animal}</td>
                        </tr>
                    `;
                }).join('');

                return `
                    <div class="mr-md-5">
                        <table class="table table-striped table-bordered table-dark">
                            <thead>
                                <tr class="table-header">
                                    <th class="text-center" colspan="4">${lottery}</th>
                                </tr>
                            </thead>
                            <tbody class="table-body">
                                <tr class="second-header">
                                    <td>Lugar</td>
                                    <td>Número</td>
                                    <td>Grupo</td>
                                    <td>Animal</td>
                                </tr>
                                ${subhtml}
                            </tbody>
                        </table>
                    </div>
                `;
            }).join('');

            $('#bichao-resultado-busca').html(html);
        },
        error: function () {
            $('#bichao-resultado-busca').html(`
                    <div class="col-12">
                        <p>Nenhum resultado encontrado.</p>
                    </div>
                `);
        }
    });
}
</script>
@endpush