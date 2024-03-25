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
                                <option value="PO">Federal</option>
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
    fetchResultados();
});

function fetchResultados() {
    const estado = $('#selecionar-estado-bichao-resultados').val();
    let data = $('#initial_date').val();

    // Reformatar a data para o formato dd/mm/yyyy
    data = data.split('-').reverse().join('-');
    if (!estado) return alert('Selecione um estado');

    $('#bichao-resultado-busca').html(`
            <div class="col-12">
                <p>Procurando resultados...</p>
            </div>
        `);

    $.ajax({
        url: '{{url('/')}}/api/scrape',
        type: 'GET',
        dataType: 'json',
        data: { data, estado },
        success: function (data) {
            if ($.isEmptyObject(data)) {
                return $('#bichao-resultado-busca').html(`
                        <div class="col-12">
                            <p>Nenhum resultado encontrado.</p>
                        </div>
                    `);
            }

            // Array de animais com seus respectivos IDs
            const animais = [
                { id: 1, name: 'Avestruz' },
                { id: 2, name: 'Águia' },
                { id: 3, name: 'Burro' },
                { id: 4, name: 'Borboleta' },
                { id: 5, name: 'Cachorro' },
                { id: 6, name: 'Cabra' },
                { id: 7, name: 'Carneiro' },
                { id: 8, name: 'Camelo' },
                { id: 9, name: 'Cobra' },
                { id: 10, name: 'Coelho' },
                { id: 11, name: 'Cavalo' },
                { id: 12, name: 'Elefante' },
                { id: 13, name: 'Galo' },
                { id: 14, name: 'Gato' },
                { id: 15, name: 'Jacaré' },
                { id: 16, name: 'Leão' },
                { id: 17, name: 'Macaco' },
                { id: 18, name: 'Porco' },
                { id: 19, name: 'Pavão' },
                { id: 20, name: 'Peru' },
                { id: 21, name: 'Touro' },
                { id: 22, name: 'Tigre' },
                { id: 23, name: 'Urso' },
                { id: 24, name: 'Veado' },
                { id: 25, name: 'Vaca' }
            ];

            const html = Object.keys(data).map(function (lottery) {
                const lotteryData = data[lottery].slice(0, 5); // Aqui é onde limitamos para os 5 primeiros itens
                const subhtml = lotteryData.map(function (item, index) {
                    // Tratamento dos caracteres malformados e substituição do terceiro item pelo número
                    const formattedItem = item.map(function (value, index) {
                        if (index === 2) {
                            // Aplicar regex para extrair apenas o número
                            const numero = value.replace(/[^\d]+/g, '');
                            return numero;
                        }
                        return value.replace(/[^a-zA-Z0-9 ]/g, '');
                    });
                    return `
                        <tr>
                            <td>${formattedItem[0]}</td>
                            <td>${formattedItem[1]}</td>
                            <td>${formattedItem[2]}</td>
                        </tr>
                    `;
                }).join('');


                return `
                    <div class="mr-md-5">
                        <table class="table table-striped table-bordered table-dark">
                            <thead>
                                <tr class="table-header">
                                    <th class="text-center" colspan="3">${lottery}</th>
                                </tr>
                            </thead>
                            <tbody class="table-body">
                                <tr class="second-header">
                                    <td>Prêmio</td>
                                    <td>Milhar</td>
                                    <td>Bicho</td>
                                </tr>
                                ${subhtml}
                            </tbody>
                        </table>
                    </div>
                `;
            }).join('');

            $('#bichao-resultado-busca').html(html);
        }
    });
}


$('#bichao-buscar-resultados').click(function () {
    fetchResultados();
});
</script>
@endpush
