@extends('admin.layouts.master')

@section('title', trans('admin.games.listing-page-title'))

@section('content')
<div class="col p-3">
    @include('admin.pages.bets.game.bichao.top_menu')
    <hr />
    <div class="card-master container d-flex justify-content-center align-items-center">
        <div class="">
            <div class="card-header align-items-center">
                <h4>Bichão da Sorte</h4>
            </div>
            <p>{{ trans('admin.bichao.aposte') }}</p>
            <hr />

            <p><u>{{ trans('admin.bichao.comofunciona') }}</u></p>
            <p>

                {{ trans('admin.bichao.primerpremio') }}
            </p>
            <p>

                {{ trans('admin.bichao.segunpremio') }}
            </p>
            <p>

                {{ trans('admin.bichao.fatormult2') }}
            </p>
            <p>

                {{ trans('admin.bichao.fatormult3') }}
            </p>

            {{ trans('admin.bichao.fatormult4') }}
            </p>

            {{ trans('admin.bichao.fatormult5') }}
            </p>

            <p>{{ trans('admin.bichao.details') }} <b>{{ trans('admin.bichao.cotacaoo') }}</b></p>
        </div>
    </div>
    <hr />


    <div class="">
        <div class="form-group container card-master">
            <div wire:ignore>
                <div class="card-header align-items-center">
                    <h4>{{ trans('admin.bichao.client') }}</h4>
                </div>
            </div>
            <div class="form-group col-md-12">
                @if (auth()->user()->type_client != 1)
                @livewire('utils.clientautocomplete.table')
                @else
                <input type="text" value="{{auth()->user()->name}} {{auth()->user()->last_name}}" disabled=""
                    class="form-control">
                <input type="hidden" id="livewire-client-id" value="1">
                @endif
            </div>
        </div>
        @include('admin.pages.bets.game.bichao.menu_jogos')
        <hr />
        <div id="animals-group"
            class="container card-master justify-content-start align-items-start d-flex flex-column text-start">
            <hr />
            <div class="d-flex justify-content-center">
                <div class="card-header align-items-center">
                    <h4>{{ trans('admin.bichao.escGrup') }}</h4>
                </div>
            </div>
            <div class="row">
                <div class="col animal-wrapper">
                    <div ion-variant="outline-primary" class="wrap-animal btn-group-toggle d-inline-block mb-1">
                        <label class="btn btn-outline-primary animal-container-choose">
                            <div class="animal-container">
                                <div class="row">
                                    <div class="col-2">
                                        01
                                    </div>
                                    <div class="col-8">
                                        <img src="{{ asset('site/images/painel/bichos/avestruz.png') }}" height="52"
                                            width="52" alt="Avestruz" class="animal-img">
                                        <p>{{ trans('admin.bichao.avestruz') }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        01
                                    </div>
                                    <div class="col">
                                        02
                                    </div>
                                    <div class="col">
                                        03
                                    </div>
                                    <div class="col">
                                        04
                                    </div>
                                </div>
                            </div>
                        </label>
                    </div>

                    <div button-variant="outline-primary" class="wrap-animal btn-group-toggle d-inline-block mb-1">
                        <label class="btn btn-outline-primary animal-container-choose">
                            <div class="animal container">
                                <div class="row">
                                    <div class="col-2 ">
                                        02
                                    </div>
                                    <div class="col-8">
                                        <img src="{{ asset('site/images/painel/bichos/aguia.png') }}" height="52"
                                            width="52" alt="Águia" class="animal-img">
                                        <p>{{ trans('admin.bichao.aguia') }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        05
                                    </div>
                                    <div class="col">
                                        06
                                    </div>
                                    <div class="col">
                                        07
                                    </div>
                                    <div class="col">
                                        08
                                    </div>
                                </div>
                            </div>
                        </label>
                    </div>

                    <div button-variant="outline-primary" class="wrap-animal btn-group-toggle d-inline-block mb-1">
                        <label class="btn btn-outline-primary animal-container-choose">
                            <div class="animal container">
                                <div class="row">
                                    <div class="col-2 ">
                                        03
                                    </div>
                                    <div class="col-8">
                                        <img src="{{ asset('site/images/painel/bichos/burro.png') }}" height="52px"
                                            width="52px" alt="Burro" class="animal-img">
                                        <p>{{ trans('admin.bichao.burro') }} </p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        09
                                    </div>
                                    <div class="col">
                                        10
                                    </div>
                                    <div class="col">
                                        11
                                    </div>
                                    <div class="col">
                                        12
                                    </div>
                                </div>
                            </div>
                        </label>
                    </div>

                    <div button-variant="outline-primary" class="wrap-animal btn-group-toggle d-inline-block mb-1">
                        <label class="btn btn-outline-primary animal-container-choose">
                            <div class="animal container">
                                <div class="row">
                                    <div class="col-2 ">
                                        04
                                    </div>
                                    <div class="col-8">
                                        <img src="{{ asset('site/images/painel/bichos/borboleta.png') }}" height="52px"
                                            width="52" alt="Borboleta" class="animal-img">
                                        <p>{{ trans('admin.bichao.borboleta') }}</p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        13
                                    </div>
                                    <div class="col">
                                        14
                                    </div>
                                    <div class="col">
                                        15
                                    </div>
                                    <div class="col">
                                        16
                                    </div>
                                </div>
                            </div>
                        </label>
                    </div>

                    <div button-variant="outline-primary" class="wrap-animal btn-group-toggle d-inline-block mb-1">
                        <label class="btn btn-outline-primary animal-container-choose">
                            <div class="animal container">
                                <div class="row">
                                    <div class="col-2 ">
                                        05
                                    </div>
                                    <div class="col-8">
                                        <img src="{{ asset('site/images/painel/bichos/cachorro.png') }}" height="52px"
                                            width="52" alt="Cachorro" class="animal-img">
                                        <p>{{ trans('admin.bichao.cachorro') }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        17
                                    </div>
                                    <div class="col">
                                        18
                                    </div>
                                    <div class="col">
                                        19
                                    </div>
                                    <div class="col">
                                        20
                                    </div>
                                </div>
                            </div>
                        </label>
                    </div>

                    <div button-variant="outline-primary" class="wrap-animal btn-group-toggle d-inline-block mb-1">
                        <label class="btn btn-outline-primary animal-container-choose">
                            <div class="animal container">
                                <div class="row">
                                    <div class="col-2 ">
                                        06
                                    </div>
                                    <div class="col-8">
                                        <img src="{{ asset('site/images/painel/bichos/cabra.png') }}" height="52px"
                                            width="52" alt="Cabra" class="animal-img">
                                        <p>{{ trans('admin.bichao.cabra') }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        21
                                    </div>
                                    <div class="col">
                                        22
                                    </div>
                                    <div class="col">
                                        23
                                    </div>
                                    <div class="col">
                                        24
                                    </div>
                                </div>
                            </div>
                        </label>
                    </div>


                    <div button-variant="outline-primary" class="wrap-animal btn-group-toggle d-inline-block mb-1">
                        <label class="btn btn-outline-primary animal-container-choose">
                            <div class="animal container">
                                <div class="row">
                                    <div class="col-2 ">
                                        07
                                    </div>
                                    <div class="col-8">
                                        <img src="{{ asset('site/images/painel/bichos/carneiro.png') }}" height="52px"
                                            width="52" alt="Carneiro" class="animal-img">
                                        <p>{{ trans('admin.bichao.carneiro') }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        25
                                    </div>
                                    <div class="col">
                                        26
                                    </div>
                                    <div class="col">
                                        27
                                    </div>
                                    <div class="col">
                                        28
                                    </div>
                                </div>
                            </div>
                        </label>
                    </div>

                    <div button-variant="outline-primary" class="wrap-animal btn-group-toggle d-inline-block mb-1">
                        <label class="btn btn-outline-primary animal-container-choose">
                            <div class="animal container">
                                <div class="row">
                                    <div class="col-2 ">
                                        08
                                    </div>
                                    <div class="col-8">
                                        <img src="{{ asset('site/images/painel/bichos/camelo.png') }}" height="52px"
                                            width="52" alt="Camelo" class="animal-img">
                                        <p>{{ trans('admin.bichao.camelo') }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        29
                                    </div>
                                    <div class="col">
                                        30
                                    </div>
                                    <div class="col">
                                        31
                                    </div>
                                    <div class="col">
                                        32
                                    </div>
                                </div>
                            </div>
                        </label>
                    </div>

                    <div button-variant="outline-primary" class="wrap-animal btn-group-toggle d-inline-block mb-1">
                        <label class="btn btn-outline-primary animal-container-choose">
                            <div class="animal container">
                                <div class="row">
                                    <div class="col-2 ">
                                        09
                                    </div>
                                    <div class="col-8">
                                        <img src="{{ asset('site/images/painel/bichos/cobra.png') }}" height="52px"
                                            width="52" alt="Cobra" class="animal-img">
                                        <p>{{ trans('admin.bichao.cobra') }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        33
                                    </div>
                                    <div class="col">
                                        34
                                    </div>
                                    <div class="col">
                                        35
                                    </div>
                                    <div class="col">
                                        36
                                    </div>
                                </div>
                            </div>
                        </label>
                    </div>

                    <div button-variant="outline-primary" class="wrap-animal btn-group-toggle d-inline-block mb-1">
                        <label class="btn btn-outline-primary animal-container-choose">
                            <div class="animal container">
                                <div class="row">
                                    <div class="col-2 ">
                                        10
                                    </div>
                                    <div class="col-8">
                                        <img src="{{ asset('site/images/painel/bichos/coelho.png') }}" height="52px"
                                            width="52" alt="Coelho" class="animal-img">

                                        <p>{{ trans('admin.bichao.coelho') }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        37
                                    </div>
                                    <div class="col">
                                        38
                                    </div>
                                    <div class="col">
                                        39
                                    </div>
                                    <div class="col">
                                        40
                                    </div>
                                </div>
                            </div>
                        </label>
                    </div>

                    <div button-variant="outline-primary" class="wrap-animal btn-group-toggle d-inline-block mb-1">
                        <label class="btn btn-outline-primary animal-container-choose">
                            <div class="animal container">
                                <div class="row">
                                    <div class="col-2 ">
                                        11
                                    </div>
                                    <div class="col-8">
                                        <img src="{{ asset('site/images/painel/bichos/cavalo.png') }}" height="52px"
                                            width="52" alt="Cavalo" class="animal-img">
                                        <p>{{ trans('admin.bichao.cavalo') }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        41
                                    </div>
                                    <div class="col">
                                        42
                                    </div>
                                    <div class="col">
                                        43
                                    </div>
                                    <div class="col">
                                        44
                                    </div>
                                </div>
                            </div>
                        </label>
                    </div>

                    <div button-variant="outline-primary" class="wrap-animal btn-group-toggle d-inline-block mb-1">
                        <label class="btn btn-outline-primary animal-container-choose">
                            <div class="animal container">
                                <div class="row">
                                    <div class="col-2 ">
                                        12
                                    </div>
                                    <div class="col-8">
                                        <img src="{{ asset('site/images/painel/bichos/elefante.png') }}" height="52px"
                                            width="52" alt="elefante" class="animal-img">
                                        <p>{{ trans('admin.bichao.elefante') }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        45
                                    </div>
                                    <div class="col">
                                        46
                                    </div>
                                    <div class="col">
                                        47
                                    </div>
                                    <div class="col">
                                        48
                                    </div>
                                </div>
                            </div>
                        </label>
                    </div>

                    <div button-variant="outline-primary" class="wrap-animal btn-group-toggle d-inline-block mb-1">
                        <label class="btn btn-outline-primary animal-container-choose">
                            <div class="animal container">
                                <div class="row">
                                    <div class="col-2 ">
                                        13
                                    </div>
                                    <div class="col-8">
                                        <img src="{{ asset('site/images/painel/bichos/galo.png') }}" height="52px"
                                            width="52" alt="Galo" class="animal-img">
                                        <p>{{ trans('admin.bichao.galo') }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        49
                                    </div>
                                    <div class="col">
                                        50
                                    </div>
                                    <div class="col">
                                        51
                                    </div>
                                    <div class="col">
                                        52
                                    </div>
                                </div>
                            </div>
                        </label>
                    </div>

                    <div button-variant="outline-primary" class="wrap-animal btn-group-toggle d-inline-block mb-1">
                        <label class="btn btn-outline-primary animal-container-choose">
                            <div class="animal container">
                                <div class="row">
                                    <div class="col-2 ">
                                        14
                                    </div>
                                    <div class="col-8">
                                        <img src="{{ asset('site/images/painel/bichos/gato.png') }}" height="52px"
                                            width="52" alt="gato" class="animal-img">
                                        <p>{{ trans('admin.bichao.gato') }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        53
                                    </div>
                                    <div class="col">
                                        54
                                    </div>
                                    <div class="col">
                                        55
                                    </div>
                                    <div class="col">
                                        56
                                    </div>
                                </div>
                            </div>
                        </label>
                    </div>

                    <div button-variant="outline-primary" class="wrap-animal btn-group-toggle d-inline-block mb-1">
                        <label class="btn btn-outline-primary animal-container-choose">
                            <div class="animal container">
                                <div class="row">
                                    <div class="col-2 ">
                                        15
                                    </div>
                                    <div class="col-8">
                                        <img src="{{ asset('site/images/painel/bichos/jacare.png') }}" height="52px"
                                            width="52" alt="Jacaré" class="animal-img">
                                        <p>{{ trans('admin.bichao.jacare') }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        57
                                    </div>
                                    <div class="col">
                                        58
                                    </div>
                                    <div class="col">
                                        59
                                    </div>
                                    <div class="col">
                                        60
                                    </div>
                                </div>
                            </div>
                        </label>
                    </div>

                    <div button-variant="outline-primary" class="wrap-animal btn-group-toggle d-inline-block mb-1">
                        <label class="btn btn-outline-primary animal-container-choose">
                            <div class="animal container">
                                <div class="row">
                                    <div class="col-2 ">
                                        16
                                    </div>
                                    <div class="col-8">
                                        <img src="{{ asset('site/images/painel/bichos/leao.png') }}" height="52px"
                                            width="52" alt="Leao" class="animal-img">
                                        <p>{{ trans('admin.bichao.leao') }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        61
                                    </div>
                                    <div class="col">
                                        62
                                    </div>
                                    <div class="col">
                                        63
                                    </div>
                                    <div class="col">
                                        64
                                    </div>
                                </div>
                            </div>
                        </label>
                    </div>

                    <div button-variant="outline-primary" class="wrap-animal btn-group-toggle d-inline-block mb-1">
                        <label class="btn btn-outline-primary animal-container-choose">
                            <div class="animal container">
                                <div class="row">
                                    <div class="col-2 ">
                                        17
                                    </div>
                                    <div class="col-8">
                                        <img src="{{ asset('site/images/painel/bichos/macaco.png') }}" height="52px"
                                            width="52" alt="Macaco" class="animal-img">
                                        <p>{{ trans('admin.bichao.macaco') }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        65
                                    </div>
                                    <div class="col">
                                        66
                                    </div>
                                    <div class="col">
                                        67
                                    </div>
                                    <div class="col">
                                        68
                                    </div>
                                </div>
                            </div>
                        </label>
                    </div>

                    <div button-variant="outline-primary" class="wrap-animal btn-group-toggle d-inline-block mb-1">
                        <label class="btn btn-outline-primary animal-container-choose">
                            <div class="animal container">
                                <div class="row">
                                    <div class="col-2 ">
                                        18
                                    </div>
                                    <div class="col-8">
                                        <img src="{{ asset('site/images/painel/bichos/porco.png') }}" height="52px"
                                            width="52" alt="Porco" class="animal-img">
                                        <p>{{ trans('admin.bichao.porco') }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        69
                                    </div>
                                    <div class="col">
                                        70
                                    </div>
                                    <div class="col">
                                        71
                                    </div>
                                    <div class="col">
                                        72
                                    </div>
                                </div>
                            </div>
                        </label>
                    </div>

                    <div button-variant="outline-primary" class="wrap-animal btn-group-toggle d-inline-block mb-1">
                        <label class="btn btn-outline-primary animal-container-choose">
                            <div class="animal container">
                                <div class="row">
                                    <div class="col-2 ">
                                        19
                                    </div>
                                    <div class="col-8">
                                        <img src="{{ asset('site/images/painel/bichos/pavao.png') }}" height="52px"
                                            width="52" alt="Pavao" class="animal-img">
                                        <p>{{ trans('admin.bichao.pavao') }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        73
                                    </div>
                                    <div class="col">
                                        74
                                    </div>
                                    <div class="col">
                                        75
                                    </div>
                                    <div class="col">
                                        76
                                    </div>
                                </div>
                            </div>
                        </label>
                    </div>

                    <div button-variant="outline-primary" class="wrap-animal btn-group-toggle d-inline-block mb-1">
                        <label class="btn btn-outline-primary animal-container-choose">
                            <div class="animal container">
                                <div class="row">
                                    <div class="col-2 ">
                                        20
                                    </div>
                                    <div class="col-8">
                                        <img src="{{ asset('site/images/painel/bichos/peru.png') }}" height="52px"
                                            width="52" alt="Peru" class="animal-img">
                                        <p>{{ trans('admin.bichao.peru') }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        77
                                    </div>
                                    <div class="col">
                                        78
                                    </div>
                                    <div class="col">
                                        79
                                    </div>
                                    <div class="col">
                                        80
                                    </div>
                                </div>
                            </div>
                        </label>
                    </div>

                    <div button-variant="outline-primary" class="wrap-animal btn-group-toggle d-inline-block mb-1">
                        <label class="btn btn-outline-primary animal-container-choose">
                            <div class="animal container">
                                <div class="row">
                                    <div class="col-2 ">
                                        21
                                    </div>
                                    <div class="col-8">
                                        <img src="{{ asset('site/images/painel/bichos/touro.png') }}" height="52px"
                                            width="52" alt="Touro" class="animal-img">
                                        <p>{{ trans('admin.bichao.touro') }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        81
                                    </div>
                                    <div class="col">
                                        82
                                    </div>
                                    <div class="col">
                                        83
                                    </div>
                                    <div class="col">
                                        84
                                    </div>
                                </div>
                            </div>
                        </label>
                    </div>

                    <div button-variant="outline-primary" class="wrap-animal btn-group-toggle d-inline-block mb-1">
                        <label class="btn btn-outline-primary animal-container-choose">
                            <div class="animal container">
                                <div class="row">
                                    <div class="col-2 ">
                                        22
                                    </div>
                                    <div class="col-8">
                                        <img src="{{ asset('site/images/painel/bichos/tigre.png') }}" height="52px"
                                            width="52" alt="Tigre" class="animal-img">
                                        <p>{{ trans('admin.bichao.tigre') }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        85
                                    </div>
                                    <div class="col">
                                        86
                                    </div>
                                    <div class="col">
                                        87
                                    </div>
                                    <div class="col">
                                        88
                                    </div>
                                </div>
                            </div>
                        </label>
                    </div>

                    <div button-variant="outline-primary" class="wrap-animal btn-group-toggle d-inline-block mb-1">
                        <label class="btn btn-outline-primary animal-container-choose">
                            <div class="animal container">
                                <div class="row">
                                    <div class="col-2 ">
                                        23
                                    </div>
                                    <div class="col-8">
                                        <img src="{{ asset('site/images/painel/bichos/urso.png') }}" height="52px"
                                            width="52" alt="Urso" class="animal-img">
                                        <p>{{ trans('admin.bichao.urso') }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        89
                                    </div>
                                    <div class="col">
                                        90
                                    </div>
                                    <div class="col">
                                        91
                                    </div>
                                    <div class="col">
                                        92
                                    </div>
                                </div>
                            </div>
                        </label>
                    </div>

                    <div button-variant="outline-primary" class="wrap-animal btn-group-toggle d-inline-block mb-1">
                        <label class="btn btn-outline-primary animal-container-choose">
                            <div class="animal container">
                                <div class="row">
                                    <div class="col-2 ">
                                        24
                                    </div>
                                    <div class="col-8">
                                        <img src="{{ asset('site/images/painel/bichos/veado.png') }}" height="52px"
                                            width="52" alt="Veado" class="animal-img">
                                        <p>{{ trans('admin.bichao.veado') }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        93
                                    </div>
                                    <div class="col">
                                        94
                                    </div>
                                    <div class="col">
                                        95
                                    </div>
                                    <div class="col">
                                        96
                                    </div>
                                </div>
                            </div>
                        </label>
                    </div>

                    <div button-variant="outline-primary" class="wrap-animal btn-group-toggle d-inline-block mb-1">
                        <label class="btn btn-outline-primary animal-container-choose">
                            <div class="animal container">
                                <div class="row">
                                    <div class="col-2 ">
                                        25
                                    </div>
                                    <div class="col-8">
                                        <img src="{{ asset('site/images/painel/bichos/vaca.png') }}" height="52px"
                                            width="52" alt="Vaca" class="animal-img">
                                        <p>{{ trans('admin.bichao.vaca') }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        97
                                    </div>
                                    <div class="col">
                                        98
                                    </div>
                                    <div class="col">
                                        99
                                    </div>
                                    <div class="col">
                                        00
                                    </div>
                                </div>
                            </div>
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <hr />
        <div class="d-flex card-master flex-column container">
            <div class="card-header align-items-center">
                <h4>Jogos e premios</h4>
            </div>
            <div class="d-flex">
                <div class="d-flex container align-items-center justify-content-center flex-column">
                    <div class="">
                        <p style="margin:0px;">{{ trans('admin.bichao.insiraJ') }}</p>
                    </div>
                    <div class="">
                        <div class="input-group mb-3">
                            <textarea class="form-control" id="input-group" rows="2" aria-describedby="basic-addon1"
                                style="resize: none;"></textarea>
                        </div>
                    </div>
                    <div class="">
                        <button id="btn-gerar-group" onclick="insere_valor()" type="button" class="btn btn-secondary">Gerar Aposta</button>
                    </div>
                </div>
                <div class="d-flex container align-items-center justify-content-start flex-column">
                    <div class="text-center">
                        {{ csrf_field() }}

                        <p>{{ trans('admin.falta.selecPremios') }}</p>

                        <a><button id="btn-award-first-to-third" onclick="button_first_to_third_award()" class="btn btn-outline-primary btn-award"><b>1º ao 3º</b></button></a>
<a><button id="btn-award-first-to-fifth" onclick="button_first_to_fifth_award()" class="btn btn-outline-primary btn-award"><b>1º ao 5º</b></button></a>
                    </div>
                    <div class="row mt-4">
                        <div class="col">
                            <span id="message-award-value" class="text-danger d-none"><b>{{
                                    trans('admin.bichao.favSelec')
                                    }}</b></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
    <hr>
    <div class="card-master d-flex container flex-column">
        <div class="card-header align-items-center">
            <h4>Aposta</h4>
        </div>
        <div class="d-flex justify-content-center align-items-md-center align-items-between">
            <div class="d-flex flex-column mr-4">
                <div class="">
                    <p>{{ trans('admin.bichao.insValor') }}</p>
                </div>
                <div class="">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">R$</span>
                        </div>
                        <input id="input_value_bet" type="text" class="form-control" placeholder="0,00"
                            aria-label="valor" aria-describedby="basic-addon1">
                    </div>
                </div>
            </div>
            <div class="d-flex flex-column justify-content-md-center justify-content-between">
                <div class="">
                    <p>Quantas Teimosinha?</p>
                </div>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon2">{{ trans('admin.bichao.teimosinha')
                            }}</span>
                    </div>
                    <input id="input_teimosinha_bet" type="number" class="form-control" value="0">
                </div>
            </div>
        </div>

        <div>
            <div id="message-minimum-value" class="col-12 hide">
                <span class="text-danger"><b>{{ trans('admin.bichao.valorM') }} 0,01</b></span>
            </div>
            <div id="message-maximum-value" class="col-12 hide">
                <span class="text-danger"><b>{{ trans('admin.bichao.premiacaoLCustom') }} R$ <span
                            id="maximum-prize-value"></span> {{ trans('admin.bichao.premiacaoRCustom') }}</b></span>
            </div>
            <div id="message-no-prize" class="col-12 hide">
                <span class="text-danger"><b>{{ trans('admin.bichao.premiacaoSemLimite') }}</b></span>
            </div>
        </div>

        <div class="d-flex container justify-content-center align-items-center text-center mt-5" id="price_award_check">
            <div class="">
                <p>{{ trans('admin.bichao.premiacao') }}
                    <span id="price_award" style="color:#a3d712;">R$0,00</span>

                </p>
                <a><button id="btn-add-to-chart" class="btn btn-secondary disabled" disabled><b>{{
                            trans('admin.bichao.addCarrinho') }}</b></button></a>
            </div>

        </div>

        <hr />
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

        .button-group button {
            background-color: #fff !important;
            color: #007bff !important;
        }

        .button-group .active {
            background-color: #007bff !important;
            color: #fff !important;
        }

        .wrap-animal, .animal-container-choose {
            cursor: default !important;
        }

        .wrap-animal:hover, .animal-container-choose:hover {
            background-color: transparent !important;
            color: #007bff !important;
            cursor: default !important;
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

            .animal-wrapper {
                display: flex;
                flex-wrap: wrap;
                
            }

            .animal-wrapper > div {
                flex: 50%;
                padding: 5px;
            }

            .animal-wrapper > div > label {
                height: 100%;
            }
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.13.3/js/standalone/selectize.min.js"
        integrity="sha512-pF+DNRwavWMukUv/LyzDyDMn8U2uvqYQdJN0Zvilr6DDo/56xPDZdDoyPDYZRSL4aOKO/FGKXTpzDyQJ8je8Qw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>

        const award = parseInt('{{$modalidade->multiplicador}}');
        const award_2 = parseInt('{{$modalidade->multiplicador_2}}');
        const initial_value = 0;
        const button_first = $('#btn-award-first');
        const button_second = $('#btn-award-second');
        const label_award = $('#price_award');
        const input_value_bet = $('#input_value_bet');
        const message_minimum = $('#message-minimum-value');
        const message_maximum = $('#message-maximum-value');
        let award_type = 0;
        let animais_escolhidos = [];
        let value = 0;

        function checkGame() {
            const games = $('#input-group').val().replaceAll(' ', '').split(',');

            for (const game of games) {
                const game_input = game.split('-');
                if (game_input.length != 3) return false;
                const match = game_input.filter((item) => item >= 0 && item <= 25);
                if (game_input.length !== match.length) return false;
            }

            return true;
        }

        function randomNumber(min, max) {
            return Math.floor(Math.random() * (max - min) + min);
        }

        function insere_valor() {
            const field = $('#input-group');

            const value = `${String(randomNumber(1, 25)).padStart(2, '0')}-${String(randomNumber(1, 25)).padStart(2, '0')}-${String(randomNumber(1, 25)).padStart(2, '0')}`;
            if (!field.val()) return field.val(value);

            const old = field.val().split(',');
            old.push(value);
            field.val(old.join(','));
            calculate_award();
        }

        $('#btn-add-to-chart').click(function() {
            const value = $('#input_value_bet').val();
            const client_id = $('#livewire-client-id').val();
            const game = $('#input-group').val().replaceAll(' ', '');
            const teimosinha = $('#input_teimosinha_bet').val();

            if (!award_type > 0) return alert('Selecione um dos prêmios');
            if (!value > 0) return alert('Insira um valor pra aposta');
            if (!checkGame()) return alert('Escolha três grupos');
            if (!client_id > 0) return alert('Escolha um cliente');
            
            const item = {
                award_type: award_type == 1 ? [1,2,3] : [1,2,3,4,5],
                value: value.replace(',', '.'),
                client_id,
                modality: '{{$modalidade->nome}}',
                game,
                teimosinha: parseInt(teimosinha),
            };

            addChartItem(item);
        });

        function calculate_award() {
            const input_value_bet = $('#input_value_bet');
            const label_award = $('#price_award');
            const limit_minimum_bet = 0.01;
            const message = $('#message-minimum-value');
            const award_total= parseInt('{{$modalidade->multiplicador}}');
            const game = $('#input-group').val().replaceAll(' ', '');

            if (!checkGame()) return;

            $('#btn-add-to-chart').addClass('disabled').attr('disabled', true);
            $.ajax({
                url: '{{url('/')}}/admin/bets/bichao/premio-maximo-json',
                type: 'POST',
                dataType: 'json',
                data: { modalidade_id: '{{$modalidade->id}}', game },
                success: function(data) {
                    message_maximum.addClass('hide');
                    message_minimum.addClass('hide');
                    $('#message-no-prize').addClass('hide');

                    $('#price_award_check').hide();
                    const { premio_maximo } = data;
                    if (premio_maximo === 0) {
                        $('#message-no-prize').removeClass('hide');
                        return;
                    }

                    let limit_maximum_bet = premio_maximo / award;
                    let value = 0;
    
                    if (award_type == 2) limit_maximum_bet = premio_maximo / award_2;
    
                    const value_input_bet = parseFloat(input_value_bet.val().replace(',', '.')) || 0;
    
                    $('#price_award_check').hide();
                    if (value_input_bet < limit_minimum_bet) {
                        message_minimum.removeClass('hide');
                    } else if (!limit_maximum_bet > 0 || value_input_bet > limit_maximum_bet) {
                        $('#maximum-prize-value').text(premio_maximo.toLocaleString('pt-br', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
                        message_maximum.removeClass('hide');
                    } else {
                        $('#price_award_check').show();
    
                        if(award_type == 1) {
                            value = award_total;
                        }else if(award_type == 2){
                            value = parseInt('{{$modalidade->multiplicador_2}}');
                        }

                        const result = value * value_input_bet;
                        
                        if (result > 0) {
                            $('#btn-add-to-chart').removeClass('disabled').attr('disabled', false);
                        } else {
                            $('#btn-add-to-chart').addClass('disabled').attr('disabled', true);
                        }
    
                        label_award.text('R$' + result.toLocaleString('pt-br', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
                    }
                }
            });
        }

        input_value_bet.keyup(function (){
            calculate_award();
        });

        function button_first_to_third_award(){

            const button_first_to_third = $('#btn-award-first-to-third');
            const button_first_to_fifth = $('#btn-award-first-to-fifth');

            if(!button_first_to_third.hasClass('active')){
                button_first_to_third.addClass('active');
                button_first_to_fifth.removeClass('active');
                award_type = 1;
            }
            calculate_award();
        }

        function button_first_to_fifth_award(){

            const button_first_to_third = $('#btn-award-first-to-third');
            const button_first_to_fifth = $('#btn-award-first-to-fifth');

            if(!button_first_to_fifth.hasClass('active')){
                button_first_to_fifth.addClass('active');
                button_first_to_third.removeClass('active');
                
                award_type = 2;
            }
            calculate_award();
        }

        function check_award(){
            const message = $('#message-award-value');
            const label_award = $('#price_award');
            const btn_add_to_cart = $('#btn-add-to-chart');
            const third_award = 1300;
            const fifth_award = 150;

            const btn_first_to_third = $('#btn-award-first-to-third');
            const btn_first_to_fifth = $('#btn-award-first-to-fifth');

            if(!btn_first_to_third.hasClass('active') && !btn_first_to_fifth.hasClass('active')){
                message.removeClass('d-none');
                message.addClass('d-block');
                const initial_value = 0;

                label_award.text(('R$'+initial_value+',00').toLocaleString('pt-BR',{
                    minimumFractionDigits: 2
                }));

            }else if(btn_first_to_third.hasClass('active') && !btn_first_to_fifth.hasClass('active')){
                message.removeClass('d-block');
                message.addClass('d-none');
                label_award.text(('R$'+third_award+',00').toLocaleString('pt-BR',{
                    minimumFractionDigits: 2
                }));

            }else if(!btn_first_to_third.hasClass('active') && btn_first_to_fifth.hasClass('active')){
                message.removeClass('d-block');
                message.addClass('d-none');
                label_award.text(('R$'+fifth_award+',00').toLocaleString('pt-BR',{
                    minimumFractionDigits: 2
                }));
            }else{
                message.removeClass('d-none');
                message.addClass('d-block');
                const initial_value = 0;

                label_award.text(('R$'+initial_value+',00').toLocaleString('pt-BR',{
                    minimumFractionDigits: 2
                }));
            }
        }

        function select_animals_1(){
            const animal_container_1 = $('#animal-container-1');

            if(!animal_container_1.hasClass('active')){
                if (animais_escolhidos.length == 3) return alert('Escolha apenas três grupos');
                animal_container_1.addClass('active');
                animais_escolhidos.push(1);
            }else{
                animal_container_1.removeClass('active');
                animais_escolhidos = animais_escolhidos = animais_escolhidos.filter((i) => i != 1);
            }
            calculate_award();
        }

        function select_animals_2(){
            const animal_container_2 = $('#animal-container-2');

            if(!animal_container_2.hasClass('active')){
                if (animais_escolhidos.length == 3) return alert('Escolha apenas três grupos');
                animal_container_2.addClass('active');
                animais_escolhidos.push(2);
            }else{
                animal_container_2.removeClass('active');
                animais_escolhidos = animais_escolhidos = animais_escolhidos.filter((i) => i != 2);
            }
            calculate_award();
        }

        function select_animals_3(){
            const animal_container_3 = $('#animal-container-3');

            if(!animal_container_3.hasClass('active')){
                if (animais_escolhidos.length == 3) return alert('Escolha apenas três grupos');
                animal_container_3.addClass('active');
                animais_escolhidos.push(3);
            }else{
                animal_container_3.removeClass('active');
                animais_escolhidos = animais_escolhidos = animais_escolhidos.filter((i) => i != 3);
            }
            calculate_award();
        }

        function select_animals_4(){
            const animal_container_4 = $('#animal-container-4');

            if(!animal_container_4.hasClass('active')){
                if (animais_escolhidos.length == 3) return alert('Escolha apenas três grupos');
                animal_container_4.addClass('active');
                animais_escolhidos.push(4);
            }else{
                animal_container_4.removeClass('active');
                animais_escolhidos = animais_escolhidos = animais_escolhidos.filter((i) => i != 4);
            }
            calculate_award();
        }

        function select_animals_5(){
            const animal_container_5 = $('#animal-container-5');

            if(!animal_container_5.hasClass('active')){
                if (animais_escolhidos.length == 3) return alert('Escolha apenas três grupos');
                animal_container_5.addClass('active');
                animais_escolhidos.push(5);
            }else{
                animal_container_5.removeClass('active');
                animais_escolhidos = animais_escolhidos = animais_escolhidos.filter((i) => i != 5);
            }
            calculate_award();
        }

        function select_animals_6(){
            const animal_container_6 = $('#animal-container-6');

            if(!animal_container_6.hasClass('active')){
                if (animais_escolhidos.length == 3) return alert('Escolha apenas três grupos');
                animal_container_6.addClass('active');
                animais_escolhidos.push(6);
            }else{
                animal_container_6.removeClass('active');
                animais_escolhidos = animais_escolhidos = animais_escolhidos.filter((i) => i != 6);
            }
            calculate_award();
        }

        function select_animals_7(){
            const animal_container_7 = $('#animal-container-7');

            if(!animal_container_7.hasClass('active')){
                if (animais_escolhidos.length == 3) return alert('Escolha apenas três grupos');
                animal_container_7.addClass('active');
                animais_escolhidos.push(7);
            }else{
                animal_container_7.removeClass('active');
                animais_escolhidos = animais_escolhidos = animais_escolhidos.filter((i) => i != 7);
            }
            calculate_award();
        }

        function select_animals_8(){
            const animal_container_8 = $('#animal-container-8');

            if(!animal_container_8.hasClass('active')){
                if (animais_escolhidos.length == 3) return alert('Escolha apenas três grupos');
                animal_container_8.addClass('active');
                animais_escolhidos.push(8);
            }else{
                animal_container_8.removeClass('active');
                animais_escolhidos = animais_escolhidos = animais_escolhidos.filter((i) => i != 8);
            }
            calculate_award();
        }

        function select_animals_9(){
            const animal_container_9 = $('#animal-container-9');

            if(!animal_container_9.hasClass('active')){
                if (animais_escolhidos.length == 3) return alert('Escolha apenas três grupos');
                animal_container_9.addClass('active');
                animais_escolhidos.push(9);
            }else{
                animal_container_9.removeClass('active');
                animais_escolhidos = animais_escolhidos = animais_escolhidos.filter((i) => i != 9);
            }
            calculate_award();
        }

        function select_animals_10(){
            const animal_container_10 = $('#animal-container-10');

            if(!animal_container_10.hasClass('active')){
                if (animais_escolhidos.length == 3) return alert('Escolha apenas três grupos');
                animal_container_10.addClass('active');
                animais_escolhidos.push(10);
            }else{
                animal_container_10.removeClass('active');
                animais_escolhidos = animais_escolhidos = animais_escolhidos.filter((i) => i != 10);
            }
            calculate_award();
        }

        function select_animals_11(){
            const animal_container_11 = $('#animal-container-11');

            if(!animal_container_11.hasClass('active')){
                if (animais_escolhidos.length == 3) return alert('Escolha apenas três grupos');
                animal_container_11.addClass('active');
                animais_escolhidos.push(11);
            }else{
                animal_container_11.removeClass('active');
                animais_escolhidos = animais_escolhidos = animais_escolhidos.filter((i) => i != 11);
            }
            calculate_award();
        }

        function select_animals_12(){
            const animal_container_12 = $('#animal-container-12');

            if(!animal_container_12.hasClass('active')){
                if (animais_escolhidos.length == 3) return alert('Escolha apenas três grupos');
                animal_container_12.addClass('active');
                animais_escolhidos.push(12);
            }else{
                animal_container_12.removeClass('active');
                animais_escolhidos = animais_escolhidos = animais_escolhidos.filter((i) => i != 12);
            }
            calculate_award();
        }

        function select_animals_13(){
            const animal_container_13 = $('#animal-container-13');

            if(!animal_container_13.hasClass('active')){
                if (animais_escolhidos.length == 3) return alert('Escolha apenas três grupos');
                animal_container_13.addClass('active');
                animais_escolhidos.push(13);
            }else{
                animal_container_13.removeClass('active');
                animais_escolhidos = animais_escolhidos = animais_escolhidos.filter((i) => i != 13);
            }
            calculate_award();
        }

        function select_animals_14(){
            const animal_container_14 = $('#animal-container-14');

            if(!animal_container_14.hasClass('active')){
                if (animais_escolhidos.length == 3) return alert('Escolha apenas três grupos');
                animal_container_14.addClass('active');
                animais_escolhidos.push(14);
            }else{
                animal_container_14.removeClass('active');
                animais_escolhidos = animais_escolhidos = animais_escolhidos.filter((i) => i != 14);
            }
            calculate_award();
        }

        function select_animals_15(){
            const animal_container_15 = $('#animal-container-15');

            if(!animal_container_15.hasClass('active')){
                if (animais_escolhidos.length == 3) return alert('Escolha apenas três grupos');
                animal_container_15.addClass('active');
                animais_escolhidos.push(15);
            }else{
                animal_container_15.removeClass('active');
                animais_escolhidos = animais_escolhidos = animais_escolhidos.filter((i) => i != 15);
            }
            calculate_award();
        }

        function select_animals_16(){
            const animal_container_16 = $('#animal-container-16');

            if(!animal_container_16.hasClass('active')){
                if (animais_escolhidos.length == 3) return alert('Escolha apenas três grupos');
                animal_container_16.addClass('active');
                animais_escolhidos.push(16);
            }else{
                animal_container_16.removeClass('active');
                animais_escolhidos = animais_escolhidos = animais_escolhidos.filter((i) => i != 16);
            }
            calculate_award();
        }

        function select_animals_17(){
            const animal_container_17 = $('#animal-container-17');

            if(!animal_container_17.hasClass('active')){
                if (animais_escolhidos.length == 3) return alert('Escolha apenas três grupos');
                animal_container_17.addClass('active');
                animais_escolhidos.push(17);
            }else{
                animal_container_17.removeClass('active');
                animais_escolhidos = animais_escolhidos = animais_escolhidos.filter((i) => i != 17);
            }
            calculate_award();
        }

        function select_animals_18(){
            const animal_container_18 = $('#animal-container-18');

            if(!animal_container_18.hasClass('active')){
                if (animais_escolhidos.length == 3) return alert('Escolha apenas três grupos');
                animal_container_18.addClass('active');
                animais_escolhidos.push(18);
            }else{
                animal_container_18.removeClass('active');
                animais_escolhidos = animais_escolhidos = animais_escolhidos.filter((i) => i != 18);
            }
            calculate_award();
        }

        function select_animals_19(){
            const animal_container_19 = $('#animal-container-19');

            if(!animal_container_19.hasClass('active')){
                if (animais_escolhidos.length == 3) return alert('Escolha apenas três grupos');
                animal_container_19.addClass('active');
                animais_escolhidos.push(19);
            }else{
                animal_container_19.removeClass('active');
                animais_escolhidos = animais_escolhidos = animais_escolhidos.filter((i) => i != 19);
            }
            calculate_award();
        }

        function select_animals_20(){
            const animal_container_20 = $('#animal-container-20');

            if(!animal_container_20.hasClass('active')){
                if (animais_escolhidos.length == 3) return alert('Escolha apenas três grupos');
                animal_container_20.addClass('active');
                animais_escolhidos.push(20);
            }else{
                animal_container_20.removeClass('active');
                animais_escolhidos = animais_escolhidos = animais_escolhidos.filter((i) => i != 20);
            }
            calculate_award();
        }

        function select_animals_21(){
            const animal_container_21 = $('#animal-container-21');

            if(!animal_container_21.hasClass('active')){
                if (animais_escolhidos.length == 3) return alert('Escolha apenas três grupos');
                animal_container_21.addClass('active');
                animais_escolhidos.push(21);
            }else{
                animal_container_21.removeClass('active');
                animais_escolhidos = animais_escolhidos = animais_escolhidos.filter((i) => i != 21);
            }
            calculate_award();
        }

        function select_animals_22(){
            const animal_container_22 = $('#animal-container-22');

            if(!animal_container_22.hasClass('active')){
                if (animais_escolhidos.length == 3) return alert('Escolha apenas três grupos');
                animal_container_22.addClass('active');
                animais_escolhidos.push(22);
            }else{
                animal_container_22.removeClass('active');
                animais_escolhidos = animais_escolhidos = animais_escolhidos.filter((i) => i != 22);
            }
            calculate_award();
        }

        function select_animals_23(){
            const animal_container_23 = $('#animal-container-23');

            if(!animal_container_23.hasClass('active')){
                if (animais_escolhidos.length == 3) return alert('Escolha apenas três grupos');
                animal_container_23.addClass('active');
                animais_escolhidos.push(23);
            }else{
                animal_container_23.removeClass('active');
                animais_escolhidos = animais_escolhidos = animais_escolhidos.filter((i) => i != 23);
            }
            calculate_award();
        }

        function select_animals_24(){
            const animal_container_24 = $('#animal-container-24');

            if(!animal_container_24.hasClass('active')){
                if (animais_escolhidos.length == 3) return alert('Escolha apenas três grupos');
                animal_container_24.addClass('active');
                animais_escolhidos.push(24);
            }else{
                animal_container_24.removeClass('active');
                animais_escolhidos = animais_escolhidos = animais_escolhidos.filter((i) => i != 24);
            }
            calculate_award();
        }

        function select_animals_25(){
            const animal_container_25 = $('#animal-container-25');

            if(!animal_container_25.hasClass('active')){
                if (animais_escolhidos.length == 3) return alert('Escolha apenas três grupos');
                animal_container_25.addClass('active');
                animais_escolhidos.push(25);
            }else{
                animal_container_25.removeClass('active');
                animais_escolhidos = animais_escolhidos = animais_escolhidos.filter((i) => i != 25);
            }
            calculate_award();
        }
    </script>
@endpush
