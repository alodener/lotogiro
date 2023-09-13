@extends('admin.layouts.master')

@section('title', trans('admin.games.listing-page-title'))

@section('content')
    <?php use App\Models\Animals; ?>
    <div class="col bg-white p-3">
        <div class="row">
            <div class="col-8 d-flex justify-content-end">
            <a href="{{ route('admin.bets.bichao.index') }}">

            <button class="btn btn-info my-2 ml-1">{{ trans('admin.bichao.apostar') }}</button>
                </a>
            <a href="{{ route('admin.bets.bichao.resultados') }}">

            <button class="btn btn-info my-2 ml-1">{{ trans('admin.bichao.resultados') }}</button>
                </a>
            <a href="{{ route('admin.bets.bichao.minhas.apostas') }}">

            <button class="btn btn-info my-2 ml-1">{{ trans('admin.bichao.minhasaposts') }}</button>
                </a>
            <a href="{{ route('admin.bets.bichao.cotacao') }}">

            <button class="btn btn-info my-2 ml-1">{{ trans('admin.bichao.cotacao') }}</button>
                </a>
            </div>
        </div>
        <hr/>
        <div class="row">
        <h1>{{ trans('admin.bichao.resultJogos') }}</h1>
         </div>
         <div class="row">

            <p>{{ trans('admin.bichao.acompanheResults') }}</p>
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
                            <th scope="col">{{ trans('admin.bichao.premio') }}</th>
                            <th scope="col">{{ trans('admin.bichao.milhar') }}</th>
                            <th scope="col">{{ trans('admin.bichao.grupo') }}</th>
                            <th scope="col">{{ trans('admin.bichao.bicho') }}</th>
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
        <h4>{{ trans('admin.bichao.resultados') }}</h4>
            <p>{{ trans('admin.bichao.estaembusca') }}
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
