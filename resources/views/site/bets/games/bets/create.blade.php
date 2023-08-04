@extends('site.layouts.master')

@section('title', 'Inicio')

@section('content')
    <div class="container text-center p-0 my-3">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-info">
                    <div class="card-header">
                    <h3 class="card-title">{{ trans('admin.sitePages.jogo') }}</h3>
                         <div class=" text-right">
                             <a href="{{route('games.bet', ['user' => $bet->user->id, 'bet' => $bet])}}">
                                 <button class="btn btn-warning btn-sm">
                                {{ trans('admin.sitePages.volta') }}
                                </button>
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if(isset($bet) && $bet->botao_finalizar == 3) 
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="alert alert-danger" role="alert">
                                        <h4 class="alert-heading">Atenção!</h4>
                                        <h4 class="alert-heading">{{ trans('admin.sitePages.atencao') }} </h4>
                                        <p>{{ trans('admin.sitePages.npossivel') }}</p>
                                         <hr>
                                        <p class="mb-0">{{ trans('admin.sitePages.iniccApost') }} <a
                                                href="{{route('games.bet', ['user' => $bet->user_id])}}">{{ trans('admin.sitePages.clicAq') }}</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @else
                        @livewire('site.pages.bets.games.bet.create', ['bet' => $bet, 'typeGame' => $typeGame])
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
