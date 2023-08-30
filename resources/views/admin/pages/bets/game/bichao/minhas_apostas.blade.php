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

            <button class="btn btn-info my-2 ml-1">{{ trans('admin.bichao.minhasaposts') }}</button>
                </a>
            <a href="{{ route('admin.bets.bichao.cotacao')}}">

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
        <h1>{{ trans('admin.bichao.minhasaposts') }}</h1>
        </div>
        <hr />
        <div class="row">
            <div class="col-md-6 col-12">
                <div class="row busca-container">
                    <div class="col-md-2 col-6">
                        <select class="change-busca form-control" name="busca-per-page" data-busca-param="perPage">
                            <option value="10" {{ $perPage == '10' ? 'selected' : '' }} >10</option>
                            <option value="20" {{ $perPage == '20' ? 'selected' : '' }} >20</option>
                            <option value="50" {{ $perPage == '50' ? 'selected' : '' }} >50</option>
                            <option value="100" {{ $perPage == '100' ? 'selected' : '' }} >100</option>
                        </select>
                    </div>
                    <div class="col-md-2 col-6">
                        <select class="change-busca form-control" name="busca-intervalo" data-busca-param="intervalo">
                        <option value="30" {{ $intervalo == '30' ? 'selected' : '' }} >{{ trans('admin.bichao.30days') }}</option>
                            <option value="60" {{ $intervalo == '60' ? 'selected' : '' }} >{{ trans('admin.bichao.60days') }}</option>
                            <option value="90" {{ $intervalo == '90' ? 'selected' : '' }} >{{ trans('admin.bichao.90days') }}</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col overflow-auto">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th scope="col" style="max-width: 150px">ID</th>
                            <th scope="col">{{ trans('admin.bichao.client') }}</th>
                            <th scope="col">{{ trans('admin.bichao.value') }}</th>
                            <th scope="col" style="max-width: 250px">{{ trans('admin.bichao.loteria') }}</th>
                            <th scope="col" style="max-width: 180px">{{ trans('admin.bichao.modalidade') }}</th>
                            <th scope="col" style="max-width: 120px">{{ trans('admin.bichao.aposta') }}</th>
                            <th scope="col" style="max-width: 140px">{{ trans('admin.bichao.premios') }}</th>
                            <th scope="col" style="max-width: 180px">{{ trans('admin.bichao.criadoem') }}</th>
                            <th scope="col" style="max-width: 50px">{{ trans('admin.bichao.acoes') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($apostas as $aposta)
                            <tr>
                                <th>{{ $aposta['id'] }}</th>
                                <td>{{ $aposta['cliente_nome'] }} {{ $aposta['cliente_sobrenome'] }}</td>
                                <td>{{ number_format($aposta['valor'], 2, ',', '.') }}</td>
                                <td>{{ date('H\hi', strtotime($aposta['horario'])) }} - {{ $aposta['banca'] }}</td>
                                <td>{{ $aposta['modalidade_nome'] }}</td>
                                <td>
                                    <?php
                                        $games = [];
                                        if (strval($aposta['game_1']) > 0) $games[] = $aposta['game_1'];
                                        if (strval($aposta['game_2']) > 0) $games[] = $aposta['game_2'];
                                        if (strval($aposta['game_3']) > 0) $games[] = $aposta['game_3'];
                                    ?>
                                    {{ str_pad(join(' - ', $games), 2, 0, STR_PAD_LEFT) }}
                                </td>
                                <td>
                                    <?php
                                        $premios = [];
                                        if ($aposta['premio_1'] == 1) $premios[] = 1;
                                        if ($aposta['premio_2'] == 1) $premios[] = 2;
                                        if ($aposta['premio_3'] == 1) $premios[] = 3;
                                        if ($aposta['premio_4'] == 1) $premios[] = 4;
                                        if ($aposta['premio_5'] == 1) $premios[] = 5;

                                        $premioMaximo = $aposta['valor'] * $aposta['multiplicador'] / sizeof($premios);
        
                                        if ($aposta['modalidade_id'] == 6 || $aposta['modalidade_id'] == 8 || $aposta['modalidade_id'] == 9) {
                                            $premioMaximo = $aposta['valor'] * $aposta['multiplicador'];
                                        }
                                        if ($aposta['modalidade_id'] == 7) {
                                            $premioMaximo = sizeof($premios) == 3 ? $aposta['valor'] * $aposta['multiplicador'] : $aposta['valor'] * $aposta['multiplicador_2'];
                                        }
                                    ?>
                                    {{ join('°, ', $premios) }}°
                                </td>
                                <td>{{ date('d/m/Y H:i', strtotime($aposta['created_at'])) }}</td>
                                <td>
                                    <a href="{{ route('admin.bets.bichao.receipt', ['id' => $aposta['id'], 'tipo' => 'txt']) }}">
                                        <button type="button" class="btn btn-primary text-light" title="Baixar bilhete TXT">
                                            <i class="bi bi-ticket"></i>
                                        </button>
                                    </a>
                                    <a href="{{ route('admin.bets.bichao.receipt', ['id' => $aposta['id'], 'tipo' => 'pdf']) }}">
                                        <button type="button" class="btn btn-danger text-light" title="Baixar bilhete PDF">
                                            <i class="bi bi-ticket"></i>
                                        </button>
                                    </a>
                                    <a href="https://api.whatsapp.com/send?phone=55{{ $aposta['cliente_ddd'].$aposta['cliente_phone'] }}&text=Jogo de {{ $aposta['modalidade_nome'] }} cadastrado com sucesso! Id da Aposta: {{ $aposta['id'] }}, Cliente: {{ $aposta['cliente_nome'] }} {{ $aposta['cliente_sobrenome'] }}, Aposta: {{ str_pad(join(' - ', $games), 2, 0, STR_PAD_LEFT) }}, Valor R$ {{ number_format($aposta['valor'], 2, ',', '.') }}, Prêmio Máximo R$ {{ number_format($premioMaximo, 2, ',', '.') }}, Data: {{ date('d/m/Y H:i', strtotime($aposta['created_at'])) }}" target="_blank">
                                        <button type="button" class="btn btn-success text-light" title="Enviar por whatsapp">
                                            <i class="bi bi-whatsapp"></i>
                                        </button>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @if ($apostas->withQueryString()->links()->paginator->hasPages())
                    <div class="mt-4 p-4 box has-text-centered pagination-custom">
                        {{ $apostas->links() }}
                    </div>
                @endif
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

        .pagination-custom > nav > div:first-child {
            display: none;
        }

        .pagination-custom svg {
            width: 30px;
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
    $('.change-busca').change(function() {
        const value = $(this).val();
        const param = $(this).attr('data-busca-param');
        const newUrl = new URL(window.location.href);
        
        newUrl.searchParams.set(param, value);
        if (param === 'perPage') newUrl.searchParams.set('page', 1);

        window.location.href = newUrl.toString();
    });
</script>
@endpush
