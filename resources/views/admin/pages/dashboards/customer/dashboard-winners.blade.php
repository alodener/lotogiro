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
                <a href="{{ route('admin.dashboards.customer.balance')}}"><button type="button" class="btn btn-secondary"><i class="bi bi-arrow-left-square-fill"></i></button></a>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col">
                <form class="mb-2" action="{{ route('admin.dashboards.customer.detailed.view.user') }}" method="POST">
                    @csrf
                    <div class="form-group w-25">
                      <label>Selecionar Cliente</label>
                      <select class="form-control" name="id_user">
                        @foreach ($users as $user_name)
                            <option value="{{ $user_name['id']}}">{{ $user_name['name']}}</option>
                        @endforeach
                      </select>
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
                <p><b>Obs: Para filtrar todo o histórico do cliente, deixe os campos de data em branco, ou informe o intervalo desejado</b></p>
            </div>

        </div>

    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.13.3/css/selectize.min.css"
        integrity="sha512-bkB9w//jjNUnYbUpATZQCJu2khobZXvLP5GZ8jhltg7P/dghIrTaSJ7B/zdlBUT0W/LXGZ7FfCIqNvXjWKqCYA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

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
    <script src="https://code.jquery.com/jquery-3.6.3.slim.js" integrity="sha256-DKU1CmJ8kBuEwumaLuh9Tl/6ZB6jzGOBV/5YpNE2BWc=" crossorigin="anonymous"></script>
    <script>
        function validate_date(event){
            const initial_date = $('#initial_date');
            const final_date = $('#final_date');


            if(initial_date.val() == '' && final_date.val() != ''){
                event.preventDefault();
                alert('Insira as datas')
            }else if(initial_date.val() != '' && final_date.val() == ''){
                event.preventDefault();
                alert('Insira as datas')
            }
        }
    </script>
@endpush
