@extends('admin.layouts.master')

@section('title', trans('admin.games.listing-page-title'))

@section('content')
    <div class="col bg-white p-3">
        <div class="row border-bottom">
            <div class="col">
                <h1>{{ trans('admin.pagesF.visaoPremiado') }}</h1>
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
                        <label for="input-url4">{{ trans('admin.pagesF.selecUser') }}</label>
                        <input type="text" class="form-control" name="user_name" placeholder="{{ trans('admin.pagesF.digiteaq') }} ..."
                            id="winners_names" />
                        <input type="hidden" name="user_id" id="winners_games_id">
                    </div>
                    <div id="client_name" class="form-group ui-widget w-25 hide">
                        <label for="input-url4">{{ trans('admin.pagesF.selecClient') }}</label>
                        <input type="text" class="form-control" name="client_name" placeholder="{{ trans('admin.pagesF.digiteaq') }} ..."
                            id="winners_names_client" />
                        <input type="hidden" name="client_id" id="winners_games_client_id">
                    </div>
                    <div class="form-group w-25">
                        <label>{{ trans('admin.pagesF.dataInicio') }}</label>
                        <input type="date" name="initial_date" class="form-control" id="initial_date">
                    </div>
                    <div class="form-group w-25">
                        <label>{{ trans('admin.pagesF.dataFinal') }}</label>
                        <input type="date" class="form-control" name="final_date" id="final_date">
                    </div>
                    <button type="submit" onclick="validate_date(event)" class="btn btn-primary">Filtrar</button>
                </form>
                <p class="mt-3"><b>{{ trans('admin.pagesF.obs') }}</b></p>
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

        .hide {
            display: none;
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
        $('#winners_names_client').autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: `{{url('/')}}/users/winners-clients?user_id=${$('#winners_games_id').val()}&busca=${$('#winners_names_client').val()}`,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        response(Object.values(data).map((i) => ({ label: `${i.name} ${i.last_name} | ${i.email}`, value: i.id })));
                    }
                });
            },
            select: function (event, ui) {
                $("#winners_names_client").val(ui.item.label);
                $("#winners_games_client_id").val(ui.item.value);
                return false;
            }
        });

        $('#winners_names').autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: `{{url('/')}}/users/winners?busca=${$('#winners_names').val()}`,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        response(Object.values(data).map((i) => ({ label: `${i.name} ${i.last_name} | ${i.email}`, value: i.id })));
                    }
                });
            },
            select: function (event, ui) {
                $("#winners_names").val(ui.item.label);
                $("#winners_games_id").val(ui.item.value);
                $("#winners_names_client").val('');
                $("#winners_games_client_id").val('');
                $("#client_name").removeClass('hide');

                return false;
            }
        });
    </script>
@endpush
