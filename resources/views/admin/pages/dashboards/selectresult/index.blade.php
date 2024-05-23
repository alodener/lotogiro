@extends('admin.layouts.master')

@section('title', 'Resultados')

@section('content')

{{-- interface dos cards --}}
<div class="container" style="padding:0px;">
    <img src="{{ $banner->url ? asset("storage/{$banner->url}") : asset('https://i.ibb.co/VWhHF8D/Yys88-SZf-Yy-AI4oo61k-Bd-Fw-Kq-Sl-R0k-Cu-Wd-DDQUVj5.jpg') }}"
     style="width:100%;max-height:150px;">
</div>

<div class="card-deck container card-master" style="width: 100%; margin-bottom: 10px; margin-left: auto; margin-right: auto; margin-top:30px">
    <div class="card mb-6" style="background-color:#202223;">
        <div class="card-header">Bilhetes Totais</div>
        <div class="card-body">
            <h5 class="card-title" style="font-size: 30px" id="campobilhetes">0 bilhetes</h5>
            <i class="nav-icon fa fa-ticket" style="float: right; font-size: 50px; color:#98C715;"></i>
        </div>
    </div>

    <div class="card mb-6" style="background-color:#202223;">
        <div class="card-header">Premiações Totais</div>
        <div class="card-body">
            <h5 class="card-title" style="font-size: 30px" id="campopremiacoes">R$ 22.300,00</h5>
            <i class="nav-icon fas fa-dollar-sign" style="float: right; font-size: 50px;color:#98C715;"></i>
        </div>
    </div>
</div>

{{-- Formulario onde buscaremos uma data especifica --}}
<div class="container mt-1 d-flex justify-content-center align-items-center" style="padding: 0px;">
    <div class="card-deck container d-flex justify-content-between card-header" style="margin:0px;">
        <div class="col-md-6 text-md-start ">
            <h3 style="margin:0;">Concursos Sorteados</h3>
        </div>
        <div class="col-md-6 d-flex align-items-center justify-content-end flex-md-row flex-column">
            <div class="d-flex justify-content-center align-items-center" style="background:#222425; border-radius:10px;">
                <select id="dateSelect" class="form-control date">
                    <option value="24">Ultimas 24 horas</option>
                    <option value="48">Ultimos 2 dias</option>
                    <option value="72">Ultimos 3 dias</option>
                    <option value="168">Ultimos 7 dias</option>
                </select>
                <i class="nav-icon fa fa-clock-o ml-2" style="float: right; font-size: 20px; color:#98C715;"></i>
            </div>
        </div>
    </div>
</div>

<div id="result" class="mt-3 text-center"></div>

<!-- Todos os jogos -->
@if(\App\Models\TypeGame::count() > 0)
<div class="container mt-3">
    <button class="mt-2 mb-2 btn-resultados-disponiveis">Resultados Disponíveis<i class="fa fa-check-circle ml-3" aria-hidden="true"></i>
    </button>

    <div class="d-flex flex-wrap justify-content-center" id="available-games">
        @php
        $typeGames = \App\Models\TypeGame::get();
        @endphp

        @foreach($typeGames as $typeGame)
        <div class="d-flex p-2 box-imgs game-container" data-game-name="{{ $typeGame->name }}">
            <a href="/admin/dashboards/foundresult/{{ $typeGame->id }}" class="hover-container">
                <img class="img-todos-jogos" style="border-radius: 10px; width: 100%; height: 100%; object-fit: cover;"
                    src="{{ $typeGame->banner_mobile ? asset("storage/{$typeGame->banner_mobile}") :
                asset('https://i.ibb.co/0yB31KB/60-Yp-Ckw9vf-EZXF9-Md4la52d-BK5j-YUPfqjx-E6c-Pro.jpg') }}"
                alt="{{ $typeGame->name }} " >
                <div class="hover-content">
                    <p>{{ $typeGame->name }}</p>
                    <button class="btn btn-primary">Selecionar</button>
                </div>
            </a>
        </div>
        @endforeach
    </div>
</div>

<div class="container mt-3">
    <button class="mt-2 mb-2 btn-aguardando-resultado">Aguardando Resultado<i class="fa fa-clock-o ml-3" aria-hidden="true"></i>
    </button>

    <div class="d-flex flex-wrap justify-content-center" id="unavailable-games">
        <!-- Jogos indisponíveis serão movidos para esta div via JavaScript -->
    </div>
</div>
@endif

<div class="p-3"></div>

@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        var system = @json($system);
        var partnerId = system.find(config => config.nome_config === "partner_id").value;

        function somarPremios(dados) {
            return dados.reduce((total, item) => {
                let premioNumerico = typeof item.premio === 'string' 
                    ? parseFloat(item.premio.replace(/\D/g, ''))
                    : item.premio;
                return total + premioNumerico;
            }, 0).toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
        }

        function somarNumTickets(dados) {
            return dados.reduce((total, item) => total + item.num_tickets, 0);
        }

        function listaall(dataSelecionada) {
            $.ajax({
                type: 'GET',
                url: `https://web.loteriasalternativas.com.br/api/winners-list2?partner=${partnerId}&hours=${dataSelecionada}`,
                success: function(response) {
                    console.log(response);

                    var winnerGameNames = response.map(winner => winner.game_name);
                    var gameContainers = document.querySelectorAll('.game-container');
                    var availableGamesContainer = document.getElementById('available-games');
                    var unavailableGamesContainer = document.getElementById('unavailable-games');

                    gameContainers.forEach(container => {
                        availableGamesContainer.appendChild(container);
                    });

                    gameContainers.forEach(container => {
                        var gameName = container.getAttribute('data-game-name');
                        if (!winnerGameNames.includes(gameName)) {
                            unavailableGamesContainer.appendChild(container);
                        }
                    });

                    $('#campobilhetes').text(`${somarNumTickets(response)} bilhetes`);
                    $('#campopremiacoes').text(somarPremios(response));
                }
            });
        }

        function loadResults() {
            var hours = $('#dateSelect').val();
            listaall(hours);
        }

        $('#dateSelect').change(loadResults);

        loadResults(); // Trigger the function on page load
    });
</script>

<style>
    .btn-aguardando-resultado {
        background: gray;
        border: none;
        padding: 5px 10px;
        font-size: 15px;
        color: white;
        font-weight: bold;
        border-radius: 10px;
    }

    .btn-resultados-disponiveis {
        background: #98C715;
        border: none;
        padding: 5px 10px;
        font-size: 15px;
        color: white;
        font-weight: bold;
        border-radius: 10px;
    }

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
</style>
