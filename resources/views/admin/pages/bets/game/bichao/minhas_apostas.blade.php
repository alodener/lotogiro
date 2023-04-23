@extends('admin.layouts.master')

@section('title', trans('admin.games.listing-page-title'))

@section('content')
    <div class="col bg-white p-3">
        <div class="row">
            <div class="col-8 d-flex justify-content-end">
                <a href="{{ route('admin.bets.bichao.index')}}">
                    <button class="btn btn-info my-2 ml-1">Apostar</button>
                </a>
                <a href="{{ route('admin.bets.bichao.resultados') }}">
                    <button class="btn btn-info my-2 ml-1">Resultados</button>
                </a>
                <a href="{{ route('admin.bets.bichao.minhas.apostas') }}">
                    <button class="btn btn-info my-2 ml-1">Minhas apostas</button>
                </a>
                <a href="{{ route('admin.bets.bichao.cotacao')}}">
                    <button class="btn btn-info my-2 ml-1">Cotação</button>
                </a>
            </div>
        </div>
        <hr />
        <div class="row">
            <h1>Minhas Apostas</h1>
        </div>
        <hr />
        <div class="row">
            <div class="col-md-6 col-12">
                <div class="row busca-container">
                    <div class="col-2">
                        <select class="change-busca form-control" name="busca-per-page" data-busca-param="perPage">
                            <option value="10" {{ $perPage == '10' ? 'selected' : '' }} >10</option>
                            <option value="20" {{ $perPage == '20' ? 'selected' : '' }} >20</option>
                            <option value="50" {{ $perPage == '50' ? 'selected' : '' }} >50</option>
                            <option value="100" {{ $perPage == '100' ? 'selected' : '' }} >100</option>
                        </select>
                    </div>
                    <div class="col-2">
                        <select class="change-busca form-control" name="busca-intervalo" data-busca-param="intervalo">
                            <option value="30" {{ $intervalo == '30' ? 'selected' : '' }} >30 dias</option>
                            <option value="60" {{ $intervalo == '60' ? 'selected' : '' }} >60 dias</option>
                            <option value="90" {{ $intervalo == '90' ? 'selected' : '' }} >90 dias</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th scope="col" style="max-width: 150px">ID</th>
                            <th scope="col">Cliente</th>
                            <th scope="col">Valor</th>
                            <th scope="col" style="max-width: 250px">Loteria</th>
                            <th scope="col" style="max-width: 180px">Modalidade</th>
                            <th scope="col" style="max-width: 120px">Aposta</th>
                            <th scope="col" style="max-width: 140px">Prêmios</th>
                            <th scope="col" style="max-width: 180px">Criado em</th>
                            <th scope="col" style="max-width: 50px">Ações</th>
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
                                    ?>
                                    {{ join('°, ', $premios) }}°
                                </td>
                                <td>{{ date('H:i d/m/Y', strtotime($aposta['created_at'])) }}</td>
                                <td>
                                    <a href="{{ route('admin.bets.bichao.receipt', ['id' => $aposta['id'], 'tipo' => 'txt']) }}">
                                        <button type="button" class="btn btn-primary text-light" title="Baixar bilhete TXT">
                                            <i class="bi bi-ticket"></i>
                                        </button>
                                    </a>
                                    <a href="{{ route('admin.bets.bichao.receipt', ['id' => $aposta['id'], 'tipo' => 'pdf']) }}">
                                        <button type="button" class="btn btn-primary text-light" title="Baixar bilhete PDF">
                                            <i class="bi bi-ticket"></i>
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
