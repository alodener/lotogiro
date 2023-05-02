@extends('admin.layouts.master')

@section('title', trans('admin.games.listing-page-title'))

@section('content')
    <?php use App\Models\Animals; ?>
    <div class="col bg-white p-3">
        <div class="row">
            <div class="col-8 d-flex justify-content-end">
                <a href="{{ route('admin.bets.bichao.index') }}">
                    <button class="btn btn-info my-2 ml-1">Apostar</button>
                </a>
                <a href="{{ route('admin.bets.bichao.resultados') }}">
                    <button class="btn btn-info my-2 ml-1">Resultados</button>
                </a>
                <a href="{{ route('admin.bets.bichao.minhas.apostas') }}">
                    <button class="btn btn-info my-2 ml-1">Minhas apostas</button>
                </a>
                <a href="{{ route('admin.bets.bichao.cotacao') }}">
                    <button class="btn btn-info my-2 ml-1">Cotação</button>
                </a>
            </div>
        </div>
        <hr/>
        <div class="row">
            <h1>Resultados do Jogo do Bicho</h1>
        </div>
        <div class="row">
            <p>Acompanhe diariamente os principais resultados do Jogo do Bicho</p>
        </div>
        <hr/>
        @foreach ($results as $result)
        <div class="row">
                <div class="col">
                    <h3>{{ $result->date.' | '.$result->lottery.' - '.$result->time.'H'}}</h3>
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col"></th>
                            <th scope="col">Prêmio</th>
                            <th scope="col">Milhar</th>
                            <th scope="col">Grupo</th>
                            <th scope="col">Bicho</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($result->placement as $result_array)
                                <tr>
                                    <th scope="row"></th>
                                    <td>{{strval($result_array['premio']+1).'º Prêmio'}}</td>
                                    <td>{{$result_array['value']}}</td>
                                    <td>{{$result_array['group']}}</td>
                                    <td>{{$result_array['name_animal']}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach
        <div class="row">
            <h4>Resultados</h4>
            <p>Está em busca dos resultados do Jogo do Bicho?
                Neste lugar, você encontrará atualizações regulares referentes ao desfecho do Bicho Rio,
                Bicho São Paulo, Bicho Minas, Bicho Bahia, Bicho Goiás,Bicho Brasília, Bicho Paraíba e Bicho Ceará.
                Além disso, disponibilizamos informações acerca do poste do jogo federal e sugestões e palpites para
                auxiliá-lo na escolha dos seus números. Mantenha-se alerta ao nosso site eletrônico para obter os resultados
                mais recentes do Jogo do Bicho.
            </p>
        </div>
    </div>
    <div class="row ml-2">
        <a class="btn btn-primary" href="{{route('admin.bets.bichao.resultados')}}">Voltar</a>
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
