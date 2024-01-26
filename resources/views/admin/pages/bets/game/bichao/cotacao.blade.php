@extends('admin.layouts.master')

@section('title', trans('admin.games.listing-page-title'))

@include('admin.pages.bets.game.bichao.carrinho')

@section('content')
    <div class="col bg-white p-3">
        <div class="row">
            <div class="col-md-8 col-12 d-flex justify-content-end container-menu-items">
            <a href="{{ route('admin.bets.bichao.index')}}">

            <button class="btn btn-info my-2 ml-1">{{ trans('admin.bichao.apostar') }}</button>
                </a>
            <a href="{{ route('admin.bets.bichao.resultados') }}">

            <button class="btn btn-info my-2 ml-1">{{ trans('admin.bichao.resultados') }}</button>
            </a>
            <a href="{{ route('admin.bets.bichao.minhas.apostas') }}">

            <button class="btn btn-info my-2 ml-1">{{ trans('admin.bichao.minhasaposts') }} </button>
            </a>
            <a href="#">

            <button class="btn btn-info my-2 ml-1">{{ trans('admin.bichao.cotacao') }}</button>
                </a>
                <button data-toggle="modal" data-target="#jogos-carrinho" class="btn btn-success my-2 ml-1 position-relative">
                    <i class="fas fa-shopping-cart"></i>
                    @if (sizeof($chart) > 0)
                        <div id="has-cart-alert" class="position-absolute rounded" style="background-color: red; height: 10px; width: 10px; top: -3px; right: -3px;"></div>
                    @endif
                    {{ trans('admin.bichao.labelCarrinho') }}
                </button>
            </div>
        </div>
        <hr />
        <div class="row">
            <div class="col">
            <h2>{{ trans('admin.bichao.veja') }} </h2>
             </div>
         </div>
         <div class="row">
             <div class="col">
              
                <p>{{ trans('admin.bichao.plataform') }} </p>
             </div>
        </div>
        <div class="row mt-2">
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
                        @if ($cotacao->id == 6 || $cotacao->id == 7)
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
