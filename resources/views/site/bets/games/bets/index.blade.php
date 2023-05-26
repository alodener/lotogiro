@extends('site.layouts.master')

@section('title', 'Inicio')

@section('content')
    <div class="container p-0 my-3">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-info">
                    <div class="card-header">
                    <h3 class="card-title"> {{ trans('admin.sitePages.apost') }}</h3>
                         @if(!empty($bet) && $bet->status && $bet->botao_finalizar == 0)
                          <div class=" text-right">
                                 <form action="{{route('games.bet.update', ['user' => $bet->user->id, 'bet' => $bet])}}"
                                       method="post">
                                     @csrf
                                    <button type="submit" class="btn btn-warning btn-sm">{{ trans('admin.sitePages.fimApost') }}</button>
                                      
                                </form>
                            </div>
                        @endif
                    </div>
                    <div class="card-body">
                        @if(isset($bet) && !$bet->status && $bet->botao_finalizar == 3) 
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="alert alert-danger" role="alert">
                                    <h4 class="alert-heading">{{ trans('admin.sitePages.atencao') }} </h4>
                                        <p>{{ trans('admin.sitePages.npossivel') }}  </p>
                                         <hr>
                                        <p class="mb-0">{{ trans('admin.sitePages.iniccApost') }}   <a
                                                href="{{route('games.bet', ['user' => $user->id])}}">{{ trans('admin.sitePages.clicAq') }}  </a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="row">
                                <div class="col-md-12">
                                    <div>
                                        @if (session('success'))
                                            <div class="alert alert-success" role="alert">
                                                {{ session('success') }}
                                            </div>
                                        @endif
                                        @if (session('error'))
                                            <div class="alert alert-danger" role="alert">
                                                {{ session('error') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @if(empty($bet))
                                <div class="row mt-3 d-flex justify-content-center">
                                    <div class="col-md-6">
                                        <form action="{{route('games.bet.store', ['user' => $user->id])}}"
                                              method="post">
                                            @csrf
                                            <button type="submit" class="btn btn-warning btn-block">{{ trans('admin.sitePages.criarApost') }}  
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @else
                                @if(isset($bet) && empty($bet->client_id))
                                    <div class="row">
                                        <div class="col-md-12">
                                            @livewire('site.pages.bets.games.bet.client', ['bet' => $bet, 'typeGames'
                                            =>
                                            $typeGames])
                                        </div>
                                    </div>
                                @else
                                    <div class="row mt-3">
                                        <div class="col-md-12">
                                            <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                <tr>
                                                    <th scope="col">Cpf</th>
                                                    <th scope="col">{{ trans('admin.sitePages.name') }}</th>
                                                    <th scope="col">Pix</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td>{{$bet->client->cpf}}</td>
                                                    <td>{{$bet->client->name}} {{$bet->client->last_name}}</td>
                                                    <td>{{$bet->client->pix}}</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 text-center">
                                        <h5>{{ trans('admin.sitePages.selecGame') }} </h5>
                                        </div>
                                        @forelse($typeGames as $typeGame)
                                            <div class="col-md-6 my-3">
                                                <a href="{{route('games.bet.game.create', ['user' => $bet->user->id, 'bet' => $bet->id, 'typeGame' => $typeGame->id])}}">
                                                    <button type="button" class="btn btn-block text-white"
                                                            style="background-color: {{$typeGame->color}};">{{$typeGame->name}}</button>
                                                </a>
                                            </div>
                                        @empty
                                        @endforelse
                                    </div>
                                @endif
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                            <th scope="col">{{ trans('admin.sitePages.typeGame') }}</th>
                                                <th scope="col">{{ trans('admin.sitePages.doz') }}</th>
                                                <th scope="col">{{ trans('admin.sitePages.value') }} </th>
                                                <th scope="col">{{ trans('admin.sitePages.premio') }}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @php($totalValue = 0)
                                            @php($totalPrize = 0)
                                            @forelse($bet->games as $game)
                                                <tr>
                                                    <td>{{$game->typeGame->name}}</td>
                                                    <td>{{$game->numbers}}</td>
                                                    <td>
                                                        R${{\App\Helper\Money::toReal($game->value)}}</td>
                                                    <td>
                                                        R${{\App\Helper\Money::toReal($game->premio)}}</td>
                                                </tr>
                                                @php($totalValue += $game->value)
                                                @php($totalPrize += $game->premio)
                                            @empty
                                                <tr class="text-center">
                                                <td colspan="4">{{ trans('admin.sitePages.naoExist') }}</td>
                                                </tr>
                                            </tbody>
                                            @endforelse
                                            <tfoot>
                                            <tr>
                                                <th scope="col">Total</th>
                                                <th scope="col"></th>
                                                <th scope="col">R${{\App\Helper\Money::toReal($totalValue)}}</th>
                                                <th scope="col">R${{\App\Helper\Money::toReal($totalPrize)}}</th>
                                            </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
