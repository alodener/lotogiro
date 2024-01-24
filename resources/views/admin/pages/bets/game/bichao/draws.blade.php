@extends('admin.layouts.master')

@section('title', trans('admin.games.listing-page-title'))

@section('content')
    <div class="col  p-3">
    
        <div class="card-header align-items-center">
                    <h4>{{ trans('admin.bichao.vencendores') }}</h4>
                </div>
        <hr />
        <div class="row card-master">
            <div class="col-md-6 col-12">
                <div class="row busca-container">
                    <div class="col-md-3 col-12 mb-2">
                        <select class="change-busca form-control" name="busca-per-page" data-busca-param="perPage">
                            <option value="10" {{ $perPage == '10' ? 'selected' : '' }} >10</option>
                            <option value="20" {{ $perPage == '20' ? 'selected' : '' }} >20</option>
                            <option value="50" {{ $perPage == '50' ? 'selected' : '' }} >50</option>
                            <option value="100" {{ $perPage == '100' ? 'selected' : '' }} >100</option>
                        </select>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="form-group w-100">
                            <input type="date" class="change-busca form-control" value="{{$startAt}}" max="{{date('Y-m-d')}}" data-busca-param="startAt">
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="form-group w-100">
                            <input type="date" class="change-busca form-control" value="{{$endAt}}" min="{{$startAt}}" max="{{date('Y-m-d')}}" data-busca-param="endAt">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-12">
                <form target="_blank" action="{{ route('admin.bets.bichao.draws.reports') }}" method="POST">
                    @csrf
                    <div class="row busca-container justify-content-end">
                        <div class="col-md-4 col-4">
                            <input type="hidden" name="search_date_start" value="{{$startAt}}">
                            <input type="hidden" name="search_date_end" value="{{$endAt}}">
                            <button class="btn btn-info" id="bichao-buscar-resultados" type="submit">{{ trans('admin.bichao.gerarRelat') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row mt-4 card-master">
            <div class="col overflow-auto">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th scope="col" style="max-width: 150px">ID</th>
                            <th scope="col">{{ trans('admin.bichao.client') }}</th>
                            <th scope="col">{{ trans('admin.bichao.value') }}</th>
                            <th scope="col">{{ trans('admin.bichao.resultados') }} <br />({{ trans('admin.falta.valorPagar') }})</th>
                             <th scope="col">PIX</th>
                            <th scope="col" style="max-width: 250px">{{ trans('admin.bichao.loteria') }}</th>
                            <th scope="col" style="max-width: 180px">{{ trans('admin.bichao.modalidade') }}</th>
                            <th scope="col" style="max-width: 120px">{{ trans('admin.bichao.aposta') }}</th>
                            <th scope="col" style="max-width: 140px">{{ trans('admin.bichao.premios') }}</th>
                            <th scope="col">{{ trans('admin.bichao.pago') }} </th>
                            <th scope="col" style="max-width: 180px">{{ trans('admin.bichao.criadoem') }}</th>
                            <th scope="col" style="max-width: 50px">{{ trans('admin.bichao.acoes') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (sizeof($apostas) === 0)
                            <tr><td colspan="12" style="text-align: center">Nenhum jogo encontrado</td></tr>
                        @endif
                        @foreach ($apostas as $aposta)
                            <?php
                                $games = [];
                                $premios = [];

                                if (strval($aposta['game_1']) > 0) $games[] = $aposta['game_1'];
                                if (strval($aposta['game_2']) > 0) $games[] = $aposta['game_2'];
                                if (strval($aposta['game_3']) > 0) $games[] = $aposta['game_3'];
                                if (strval($aposta['game_4']) > 0) $games[] = $aposta['game_4'];
                                if (strval($aposta['game_5']) > 0) $games[] = $aposta['game_5'];

                                if ($aposta['premio_1'] == 1) $premios[] = 1;
                                if ($aposta['premio_2'] == 1) $premios[] = 2;
                                if ($aposta['premio_3'] == 1) $premios[] = 3;
                                if ($aposta['premio_4'] == 1) $premios[] = 4;
                                if ($aposta['premio_5'] == 1) $premios[] = 5;
                            ?>
                            <tr>
                                <th>{{ $aposta['id'] }}</th>
                                <td>{{ $aposta['cliente_nome'] }} {{ $aposta['cliente_sobrenome'] }}</td>
                                <td>{{ number_format($aposta['valor'], 2, ',', '.') }}</td>
                                <td>{{ number_format($aposta['valor_premio'], 2, ',', '.') }}</td>
                                <td>{{ $aposta['pix'] }}</td>
                                <td>{{ date('H\hi', strtotime($aposta['horario'])) }} - {{ $aposta['banca'] }}</td>
                                <td>{{ $aposta['modalidade_nome'] }}</td>
                                <td>{{ $aposta['modalidade_id'] !== 12 ? str_pad(join(' - ', $games), 2, 0, STR_PAD_LEFT) : $aposta['game_1'] }}</td>
                                <td>{{ join('°, ', $premios) }}°</td>
                                <td>{{ $aposta['payment'] == 1 ? 'Pago' : 'Aberto' }}</td>
                                <td>{{ date('d/m/Y H:i', strtotime($aposta['created_at'])) }}</td>
                                <td>
                                    <a href="{{ route('admin.bets.bichao.receipt', ['id' => $aposta['id'], 'tipo' => 'txt']) }}">
                                        <button type="button" class="btn btn-primary " title="Baixar bilhete TXT">
                                            <i class="bi bi-ticket"></i>
                                        </button>
                                    </a>
                                    <a href="{{ route('admin.bets.bichao.receipt', ['id' => $aposta['id'], 'tipo' => 'pdf']) }}">
                                        <button type="button" class="btn btn-danger mt-2 mb-2 mt-md-0 mb-md-0 " title="Baixar bilhete PDF">
                                            <i class="bi bi-ticket"></i>
                                        </button>
                                    </a>
                                    @if ($aposta['payment'] == 0)
                                    <a href="#" id="marcar-premio-pago" data-id="{{ $aposta['id_premio'] }}">
                                        <button type="button" class="btn btn-primary " title="Marcar como prêmio pago">
                                            <i class="bi bi-wallet"></i>
                                        </button>
                                    </a>
                                    @endif
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
