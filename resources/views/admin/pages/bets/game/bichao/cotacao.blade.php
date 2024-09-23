@extends('admin.layouts.master')

@section('title', trans('admin.games.listing-page-title'))

@include('admin.pages.bets.game.bichao.carrinho')

@section('content')
<div class="col  p-3">
    @include('admin.pages.bets.game.bichao.top_menu')

    <hr />


    <div class="card-header container-fluid align-items-center">
        <h4>{{ trans('admin.bichao.veja') }}</h4>
        <p>{{ trans('admin.bichao.plataform') }} </p>

    </div>
    <div class="row mt-2 card-master">
        <div class="col">
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th scope="col"></th>
                        <th scope="col">{{ trans('admin.bichao.modalidade') }}</th>
                        <th scope="col"></th>
                        <th scope="col">{{ trans('admin.bichao.cotacao') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cotacoes as $cotacao)
                    @if ($cotacao->id == 6 || $cotacao->id == 7 ||  $cotacao->id == 8 )
                    <tr>
                        <th scope="row">
                        <td>{{ $cotacao['nome'] }} 1 ao 3</td>
                        </th>
                        <th scope="row">
                        <td>{{'1x R$'. number_format($cotacao['multiplicador'], 2, ',', '.') }}</td>
                        </th>
                    </tr>
                    <tr>
                        <th scope="row">
                        <td>{{ $cotacao['nome'] }} 1 ao 5</td>
                        </th>
                        <th scope="row">
                        <td>{{'1x R$'. number_format($cotacao['multiplicador_2'], 2, ',', '.') }}</td>
                        </th>
                    </tr>
                    @else
                    <tr>
                        <th scope="row">
                        <td>{{ $cotacao['nome'] }}</td>
                        </th>
                        <th scope="row">
                        <td>{{'1x R$'. number_format($cotacao['multiplicador'], 2, ',', '.') }}</td>
                        </th>
                    </tr>
                    @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.13.3/css/selectize.min.css"
    integrity="sha512-bkB9w//jjNUnYbUpATZQCJu2khobZXvLP5GZ8jhltg7P/dghIrTaSJ7B/zdlBUT0W/LXGZ7FfCIqNvXjWKqCYA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

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