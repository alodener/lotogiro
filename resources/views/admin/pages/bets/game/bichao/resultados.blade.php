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

            // Mapear os números para os nomes dos animais
            const animais = {
                "01": "Avestruz",
                "02": "Águia",
                "03": "Burro",
                "04": "Borboleta",
                "05": "Cachorro",
                "06": "Cabra",
                "07": "Carneiro",
                "08": "Camelo",
                "09": "Cobra",
                "10": "Coelho",
                "11": "Cavalo",
                "12": "Elefante",
                "13": "Galo",
                "14": "Gato",
                "15": "Jacaré",
                "16": "Leão",
                "17": "Macaco",
                "18": "Porco",
                "19": "Pavão",
                "20": "Peru",
                "21": "Touro",
                "22": "Tigre",
                "23": "Urso",
                "24": "Veado",
                "25": "Vaca"
            };

            const html = Object.keys(data).map(function (lottery) {
                const lotteryData = data[lottery].slice(0, 5); // Aqui é onde limitamos para os 5 primeiros itens
                const subhtml = lotteryData.map(function (item, index) {
                    // Tratamento dos caracteres malformados
                    const formattedItem = item.map(function (value) {
                        return value.replace(/[^a-zA-Z0-9 ]/g, '');
                    });

                    // Extrair o número do bicho
                    const animalNumber = formattedItem[2].match(/\d+/)[0];
                    // Obter o nome do animal a partir do número
                    const animalName = animais[animalNumber];

                    return `
                        <tr>
                            <td>${formattedItem[0]}</td>
                            <td>${formattedItem[1]}</td>
                            <td>${animalNumber}</td>
                            <td>${animalName ? animalName : formattedItem[2]}</td>
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
                                    <td>Prêmio</td>
                                    <td>Milhar</td>
                                    <td>Grupo</td>
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
