@extends('admin.layouts.master')

@section('title', trans('admin.games.listing-page-title'))

@section('content')
    <div class="col bg-white p-3">
        <div class="row border-bottom">
            <div class="col">
                <h1>Visão Detalhada de Clientes Premiados</h1>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col">
                <a href="{{ route('admin.dashboards.customer.balance') }}"><button type="button"
                    class="btn btn-secondary"><i class="bi bi-arrow-left-square-fill"></i></button>
                </a>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col">
                <form class="mb-2" action="{{ route('admin.dashboards.customer.detailed.view.user') }}" method="POST">
                    @csrf
                    <div id="user_name" class="form-group ui-widget w-25">
                        <label for="input-url4">Selecionar Cliente</label>
                        <input type="text" class="form-control" name="user_name" placeholder="Digite Aqui ..."
                            id="winners_names" />
                    </div>
                    <div class="form-group w-25">
                        <label>Data Inicio</label>
                        <input type="date" name="initial_date" class="form-control" id="initial_date">
                    </div>
                    <div class="form-group w-25">
                        <label>Data Final</label>
                        <input type="date" class="form-control" name="final_date" id="final_date">
                    </div>
                    <button type="submit" onclick="validate_date(event)" class="btn btn-primary">Filtrar</button>
                </form>
                <p class="mt-3"><b>Obs: Para filtrar todo o histórico do cliente, deixe os campos de data em branco, ou
                        informe o intervalo desejado</b></p>
            </div>

        </div>

    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.13.3/css/selectize.min.css"
        integrity="sha512-bkB9w//jjNUnYbUpATZQCJu2khobZXvLP5GZ8jhltg7P/dghIrTaSJ7B/zdlBUT0W/LXGZ7FfCIqNvXjWKqCYA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <style>
        #filterForm {
            margin-top: 30px;
            margin-bottom: 30px;
        }

        #filterForm .form-row {
            justify-content: flex-end;
            align-items: flex-end;
            margin: 0;
        }

        @media(max-width: 467px) {
            #filterForm .form-row {
                flex-direction: column;
            }
        }
    </style>
@endpush

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.3.slim.js"
        integrity="sha256-DKU1CmJ8kBuEwumaLuh9Tl/6ZB6jzGOBV/5YpNE2BWc=" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script>
        function validate_date(event) {
            const initial_date = $('#initial_date');
            const final_date = $('#final_date');


            if (initial_date.val() == '' && final_date.val() != '') {
                event.preventDefault();
                alert('Insira as datas')
            } else if (initial_date.val() != '' && final_date.val() == '') {
                event.preventDefault();
                alert('Insira as datas')
            }
        }
    </script>

    <script>
        $.ajax({
            url: 'http://127.0.0.1:8000/users/winners',
            type: 'GET',
            dataType: 'json',
        })
        .done(function(response) {
            let users_winners = Object.values(response);
            let id_name_users_winners = [];
            users_winners.forEach(element => {
                id_name_users_winners.push(
                    element['name']
                );
            });
            $('#winners_names').autocomplete({
                source: id_name_users_winners
            });
        })
        .fail(function() {
            console.log("error");
        });
    </script>
@endpush
