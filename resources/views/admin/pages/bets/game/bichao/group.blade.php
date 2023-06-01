@extends('admin.layouts.master')

@section('title', trans('admin.games.listing-page-title'))

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
            </div>
        </div>
        <hr />
        <div class="row">
            <div class="col-md-8 col-12 justify-content-center">
                <div class="row">
                    <div class="col">
                        <h1>Bichão da Sorte</h1>
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
            </div>
            @include('admin.pages.bets.game.bichao.carrinho')
        </div>
        <hr />
        <div class="row">
            <div class="col">
            <p>{{ trans('admin.bichao.escolha') }}</p>
            </div>
        </div>
        <div class="row">
            <div class="col button-group overflow-auto">
            <a class="btn btn-outline-primary mb-1" href="{{ route('admin.bets.bichao.index') }}"><b>{{ trans('admin.bichao.milhar') }}</b></a>
                <a class="btn btn-outline-primary mb-1" href="{{ route('admin.bets.bichao.centena') }}"><b>{{ trans('admin.bichao.centena') }}</b></a>
                <a class="btn btn-outline-primary mb-1" href="{{ route('admin.bets.bichao.dezena') }}"><b>{{ trans('admin.bichao.dezena') }}</b></a>
                <a class="btn btn-primary mb-1" id="btn-group" href="#"><b>{{ trans('admin.bichao.grupo') }}</b></a>
                 <a class="btn btn-outline-primary mb-1"
                    href="{{ route('admin.bets.bichao.milhar.centena') }}"><b>{{ trans('admin.bichao.milhcent') }}</b></a>
                <a class="btn btn-outline-primary mb-1" href="{{ route('admin.bets.bichao.terno.dezena') }}"><b>{{ trans('admin.bichao.terndez') }}</b></a>
                <a class="btn btn-outline-primary mb-1" href="{{ route('admin.bets.bichao.terno.grupo') }}"><b>{{ trans('admin.bichao.terngrup') }}</b></a>
                <a class="btn btn-outline-primary mb-1" href="{{ route('admin.bets.bichao.duque.dezena') }}"><b>{{ trans('admin.bichao.duqdez') }}</b></a>
                <a class="btn btn-outline-primary mb-1" href="{{ route('admin.bets.bichao.duque.grupo') }}"><b>{{ trans('admin.bichao.duqgrup') }}</b></a>
            </div>
        </div>
        <hr/>
        <div class="form-row">
            <div class="form-group col-md-12">
                <div wire:ignore>
                    <div class="card-header ganhos-card">
                    <h4>{{ trans('admin.bichao.client') }}</h4>
                    </div>
                </div>
                <div class="form-group col-md-12">
                    @if (auth()->user()->type_client != 1)
                        @livewire('utils.clientautocomplete.table')
                    @else
                        <input type="text" value="{{auth()->user()->name}} {{auth()->user()->last_name}}" disabled="" class="form-control">
                        <input type="hidden" id="livewire-client-id" value="1">
                    @endif
                </div>

            {{-- PARTE DE PESQUISA DE CLIENTE SE NÃO TIVER AUTENTICAÇÃO --}}

            <input type="hidden" name="client" value="">
                <div class="row mb-3" id="list_group" style="max-height: 100px; overflow-y: auto">
                    <div class="col-md-12">
                    </div>
                </div>

                </div>
            <input type="hidden" class="form-control" id="type_game" name="type_game" value="" readonly>
        </div>
        <div id="animals-group" class="col-12">
            <hr />
            <div class="row">
                <div class="col">
                <p>{{ trans('admin.bichao.escGrup') }}</p>
                </div>
            </div>
            <div class="row">
                <div class="col animal-wrapper">
                    <div id="animal-container" button-variant="outline-primary" class="wrap-animal btn-group-toggle d-inline-block mb-1">
                        <label id="animal-container-1" onclick="select_animals_1()" class="btn btn-outline-primary animal-container-choose">
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

                                         13
                                     </div>
                                     <div class="col-8">
                                         <img src="{{ asset('site/images/painel/bichos/galo.png') }}" height="52px"
                                             width="52" alt="Galo" class="animal-img">
                                        <p>Galo</p>
                                        <p>{{ trans('admin.bichao.galo') }}</p>
                                     </div>
                                 </div>
                                 <div class="row">
                                     <div class="col">
                                         49

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
        <hr/>
        <div class="row">
            <div class="col">
            <p>{{ trans('admin.bichao.selecPremios') }}</p>
            </div>
        </div>
        <div class="row">
            <div class="col button-group">
                <a><button id="btn-award-first" onclick="button_first_award()" class="btn btn-outline-primary btn-award"><b>1º</b></button></a>
                <a><button id="btn-award-second" onclick="button_second_award()" class="btn btn-outline-primary btn-award"><b>2º</b></button></a>
                <a><button id="btn-award-third" onclick="button_third_award()" class="btn btn-outline-primary btn-award"><b>3º</b></button></a>
                <a><button id="btn-award-fourth" onclick="button_fourth_award()" class="btn btn-outline-primary btn-award"><b>4º</b></button></a>
                <a><button id="btn-award-fifth" onclick="button_fifth_award()" class="btn btn-outline-primary btn-award"><b>5º</b></button></a>
                <a><button id="btn-award-first-to-fifth" onclick="button_first_to_fifth_award()" class="btn btn-outline-primary btn-award"><b>1º ao 5º</b></button></a>
            </div>
        </div>
        <div class="row mt-md-4 col-12">
            <div class="col">
                <span id="message-award-value" class="text-danger d-none"><b>{{ trans('admin.bichao.favSelec') }}</b></span>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col">
                <p>{{ trans('admin.bichao.insValor') }} </p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2 col-12">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">R$</span>
                    </div>
                    <input id="input_value_bet" type="text" class="form-control" placeholder="0,00" aria-label="valor"
                        aria-describedby="basic-addon1">
                </div>
            </div>
        </div>
        <div id="message-minimum-value" class="row hide">
            <div class="col">
                <span class="text-danger"><b>{{ trans('admin.bichao.valorM') }} 0,01</b></span>
            </div>
        </div>
        <div id="message-maximum-value" class="row hide">
            <div class="col">
                <span class="text-danger"><b>{{ trans('admin.bichao.premiacaoL') }}</b></span>
            </div>
        </div>
        <div class="row" id="price_award_check">
            <div class="col">
                <p>{{ trans('admin.bichao.premiacao') }}
                    <span id="price_award" class="text-success">R$0,00</span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="0.9em" height="0.9em" fill="currentColor"
                        class="bi bi-question-circle-fill" viewBox="0 0 16 16">
                        <path
                            d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.496 6.033h.825c.138 0 .248-.113.266-.25.09-.656.54-1.134 1.342-1.134.686 0 1.314.343 1.314 1.168 0 .635-.374.927-.965 1.371-.673.489-1.206 1.06-1.168 1.987l.003.217a.25.25 0 0 0 .25.246h.811a.25.25 0 0 0 .25-.25v-.105c0-.718.273-.927 1.01-1.486.609-.463 1.244-.977 1.244-2.056 0-1.511-1.276-2.241-2.673-2.241-1.267 0-2.655.59-2.75 2.286a.237.237 0 0 0 .241.247zm2.325 6.443c.61 0 1.029-.394 1.029-.927 0-.552-.42-.94-1.029-.94-.584 0-1.009.388-1.009.94 0 .533.425.927 1.01.927z" />
                    </svg>
                </p>
            </div>
        </div>
        <hr />
        <div class="row">
            <div class="col mb-2">
                <a><button id="btn-add-to-chart" class="btn btn-success disabled" disabled><b>{{ trans('admin.bichao.addCarrinho') }}</b></button></a>
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

        .button-group button {
            background-color: #fff !important;
            color: #007bff !important;
        }

        .button-group .active {
            background-color: #007bff !important;
            color: #fff !important;
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
        const initial_value = 0;
        const input_value = $('#input_value');
        const button_first = $('#btn-award-first');
        const button_second = $('#btn-award-second');
        const label_award = $('#price_award');
        const input_value_bet = $('#input_value_bet');
        const message_minimum = $('#message-minimum-value');
        const message_maximum = $('#message-maximum-value');
        const animal_container = $('.wrap-animal');
        let animal_escolhido = 0;
        let award_type = [];
        let value;
        
        $('#btn-add-to-chart').click(function() {
            const option_award = validate_award();
            const value = $('#input_value_bet').val();
            const client_id = $('#livewire-client-id').val();

            if (!option_award > 0) return alert('Selecione um dos prêmios');
            if (!value > 0) return alert('Insira um valor pra aposta');
            if (!animal_escolhido > 0) return alert('Escolha um dos grupos');
            if (!client_id > 0) return alert('Escolha um cliente');

            award_type.sort();
            
            const item = {
                award_type,
                value: value.replace(',', '.'),
                client_id,
                modality: '{{$modalidade->nome}}',
                game: String(animal_escolhido).padStart(2, '0'),
            };

            addChartItem(item);
        });


        function randomNumber(min, max) {
            return Math.floor(Math.random() * (max - min) + min);
        }

        function calculate_award() {
            const input_value_bet = $('#input_value_bet');
            const label_award = $('#price_award');
            const limit_minimum_bet = 0.01;
            const message = $('#message-minimum-value');
            const award_total = parseInt('{{$modalidade->multiplicador}}');
            const option_award = validate_award() === 6 ? 5 : validate_award();

            let limit_maximum_bet = 20000 / award;
            let value = 0;

            if (option_award > 0) limit_maximum_bet = limit_maximum_bet * option_award;

            const value_input_bet = parseFloat(input_value_bet.val().replace(',', '.')) || 0;

            $('#price_award_check').hide();
            if(value_input_bet < limit_minimum_bet){
                message_maximum.addClass('hide');
                message_minimum.removeClass('hide');
            } else if(value_input_bet > limit_maximum_bet){
                message_maximum.removeClass('hide');
                message_minimum.addClass('hide');
            } else{
                $('#price_award_check').show();
                message_maximum.addClass('hide');
                message_minimum.addClass('hide');

                if(option_award == 1){
                    value = award_total;
                }else if(option_award == 2){
                    value = (award_total/2);
                }else if(option_award == 3){
                    value = (award_total/3);
                }else if(option_award == 4){
                    value = (award_total/4);
                }else if(option_award == 5){
                    value = (award_total/5);
                }else if(option_award == 6){
                    value = (award_total/5);
                }

                const result = value*value_input_bet;
                
                if (result > 0 && animal_escolhido > 0) {
                    $('#btn-add-to-chart').removeClass('disabled').attr('disabled', false);
                } else {
                    $('#btn-add-to-chart').addClass('disabled').attr('disabled', true);
                }
                label_award.text('R$' + result.toLocaleString('pt-br', {minimumFractionDigits: 2}));
            }
        }

        function toggleAll() {
            if (
                $('#btn-award-first').hasClass('active') &&
                $('#btn-award-second').hasClass('active') &&
                $('#btn-award-third').hasClass('active') &&
                $('#btn-award-fourth').hasClass('active') &&
                $('#btn-award-fifth').hasClass('active')
            ) {
                $('#btn-award-first-to-fifth').addClass('active');
            } else {
                $('#btn-award-first-to-fifth').removeClass('active');
            }
            calculate_awards();
        }

        input_value_bet.keyup(function () {
            calculate_award();
        });

        function insere_valor(){
            const btn_gerar_milhar = $('#btn-gerar-centena');
            const input_milhar = $('#input-centena');

            input_milhar.val((randomNumber(0, 9)+''+randomNumber(0, 9)+''+randomNumber(0, 9)));
        }

        function clear_animals() {
            animal_escolhido = 0;
            $('.animal-container-choose').removeClass('active');
        }

        function select_animals_1(){
            const animal_container_1 = $('#animal-container-1');

            clear_animals();
            if(!animal_container_1.hasClass('active')){
                animal_escolhido = 1;
                animal_container_1.addClass('active');
            }else{
                animal_container_1.removeClass('active');
            }
            calculate_award();
        }

        function select_animals_2(){
            const animal_container_2 = $('#animal-container-2');

            clear_animals();
            if(!animal_container_2.hasClass('active')){
                animal_escolhido = 2;
                animal_container_2.addClass('active');
            }else{
                animal_container_2.removeClass('active');
            }
            calculate_award();
        }

        function select_animals_3(){
            const animal_container_3 = $('#animal-container-3');

            clear_animals();
            if(!animal_container_3.hasClass('active')){
                animal_escolhido = 3;
                animal_container_3.addClass('active');
            }else{
                animal_container_3.removeClass('active');
            }
            calculate_award();
        }

        function select_animals_4(){
            const animal_container_4 = $('#animal-container-4');

            clear_animals();
            if(!animal_container_4.hasClass('active')){
                animal_escolhido = 4;
                animal_container_4.addClass('active');
            }else{
                animal_container_4.removeClass('active');
            }
            calculate_award();
        }

        function select_animals_5(){
            const animal_container_5 = $('#animal-container-5');

            clear_animals();
            if(!animal_container_5.hasClass('active')){
                animal_escolhido = 5;
                animal_container_5.addClass('active');
            }else{
                animal_container_5.removeClass('active');
            }
            calculate_award();
        }

        function select_animals_6(){
            const animal_container_6 = $('#animal-container-6');

            clear_animals();
            if(!animal_container_6.hasClass('active')){
                animal_escolhido = 6;
                animal_container_6.addClass('active');
            }else{
                animal_container_6.removeClass('active');
            }
            calculate_award();
        }

        function select_animals_7(){
            const animal_container_7 = $('#animal-container-7');

            clear_animals();
            if(!animal_container_7.hasClass('active')){
                animal_escolhido = 7;
                animal_container_7.addClass('active');
            }else{
                animal_container_7.removeClass('active');
            }
            calculate_award();
        }

        function select_animals_8(){
            const animal_container_8 = $('#animal-container-8');

            clear_animals();
            if(!animal_container_8.hasClass('active')){
                animal_escolhido = 8;
                animal_container_8.addClass('active');
            }else{
                animal_container_8.removeClass('active');
            }
            calculate_award();
        }

        function select_animals_9(){
            const animal_container_9 = $('#animal-container-9');

            clear_animals();
            if(!animal_container_9.hasClass('active')){
                animal_escolhido = 9;
                animal_container_9.addClass('active');
            }else{
                animal_container_9.removeClass('active');
            }
            calculate_award();
        }

        function select_animals_10(){
            const animal_container_10 = $('#animal-container-10');

            clear_animals();
            if(!animal_container_10.hasClass('active')){
                animal_escolhido = 10;
                animal_container_10.addClass('active');
            }else{
                animal_container_10.removeClass('active');
            }
            calculate_award();
        }

        function select_animals_11(){
            const animal_container_11 = $('#animal-container-11');

            clear_animals();
            if(!animal_container_11.hasClass('active')){
                animal_escolhido = 11;
                animal_container_11.addClass('active');
            }else{
                animal_container_11.removeClass('active');
            }
            calculate_award();
        }

        function select_animals_12(){
            const animal_container_12 = $('#animal-container-12');

            clear_animals();
            if(!animal_container_12.hasClass('active')){
                animal_escolhido = 12;
                animal_container_12.addClass('active');
            }else{
                animal_container_12.removeClass('active');
            }
            calculate_award();
        }

        function select_animals_13(){
            const animal_container_13 = $('#animal-container-13');

            clear_animals();
            if(!animal_container_13.hasClass('active')){
                animal_escolhido = 13;
                animal_container_13.addClass('active');
            }else{
                animal_container_13.removeClass('active');
            }
            calculate_award();
        }

        function select_animals_14(){
            const animal_container_14 = $('#animal-container-14');

            clear_animals();
            if(!animal_container_14.hasClass('active')){
                animal_escolhido = 14;
                animal_container_14.addClass('active');
            }else{
                animal_container_14.removeClass('active');
            }
            calculate_award();
        }

        function select_animals_15(){
            const animal_container_15 = $('#animal-container-15');

            clear_animals();
            if(!animal_container_15.hasClass('active')){
                animal_escolhido = 15;
                animal_container_15.addClass('active');
            }else{
                animal_container_15.removeClass('active');
            }
            calculate_award();
        }

        function select_animals_16(){
            const animal_container_16 = $('#animal-container-16');

            clear_animals();
            if(!animal_container_16.hasClass('active')){
                animal_escolhido = 16;
                animal_container_16.addClass('active');
            }else{
                animal_container_16.removeClass('active');
            }
            calculate_award();
        }

        function select_animals_17(){
            const animal_container_17 = $('#animal-container-17');

            clear_animals();
            if(!animal_container_17.hasClass('active')){
                animal_escolhido = 17;
                animal_container_17.addClass('active');
            }else{
                animal_container_17.removeClass('active');
            }
            calculate_award();
        }

        function select_animals_18(){
            const animal_container_18 = $('#animal-container-18');

            clear_animals();
            if(!animal_container_18.hasClass('active')){
                animal_escolhido = 18;
                animal_container_18.addClass('active');
            }else{
                animal_container_18.removeClass('active');
            }
            calculate_award();
        }

        function select_animals_19(){
            const animal_container_19 = $('#animal-container-19');

            clear_animals();
            if(!animal_container_19.hasClass('active')){
                animal_escolhido = 19;
                animal_container_19.addClass('active');
            }else{
                animal_container_19.removeClass('active');
            }
            calculate_award();
        }

        function select_animals_20(){
            const animal_container_20 = $('#animal-container-20');

            clear_animals();
            if(!animal_container_20.hasClass('active')){
                animal_escolhido = 20;
                animal_container_20.addClass('active');
            }else{
                animal_container_20.removeClass('active');
            }
            calculate_award();
        }

        function select_animals_21(){
            const animal_container_21 = $('#animal-container-21');

            clear_animals();
            if(!animal_container_21.hasClass('active')){
                animal_escolhido = 21;
                animal_container_21.addClass('active');
            }else{
                animal_container_21.removeClass('active');
            }
            calculate_award();
        }

        function select_animals_22(){
            const animal_container_22 = $('#animal-container-22');

            clear_animals();
            if(!animal_container_22.hasClass('active')){
                animal_escolhido = 22;
                animal_container_22.addClass('active');
            }else{
                animal_container_22.removeClass('active');
            }
            calculate_award();
        }

        function select_animals_23(){
            const animal_container_23 = $('#animal-container-23');

            clear_animals();
            if(!animal_container_23.hasClass('active')){
                animal_escolhido = 23;
                animal_container_23.addClass('active');
            }else{
                animal_container_23.removeClass('active');
            }
            calculate_award();
        }

        function select_animals_24(){
            const animal_container_24 = $('#animal-container-24');

            clear_animals();
            if(!animal_container_24.hasClass('active')){
                animal_escolhido = 24;
                animal_container_24.addClass('active');
            }else{
                animal_container_24.removeClass('active');
            }
            calculate_award();
        }

        function select_animals_25(){
            const animal_container_25 = $('#animal-container-25');

            clear_animals();
            if(!animal_container_25.hasClass('active')){
                animal_escolhido = 25;
                animal_container_25.addClass('active');
            }else{
                animal_container_25.removeClass('active');
            }
            calculate_award();
        }

        function button_first_award(){
            const button_first = $('#btn-award-first');

            if(!button_first.hasClass('active')){
                button_first.addClass('active');
                award_type.push(1);
            }else{
                button_first.removeClass('active');
                award_type = award_type = award_type.filter((i) => i != 1);
            }
            calculate_award();
            toggleAll();

        }

        function button_second_award(){
            const button_second = $('#btn-award-second');

            if(!button_second.hasClass('active')){
                button_second.addClass('active');
                award_type.push(2);
            }else{
                button_second.removeClass('active');
                award_type = award_type = award_type.filter((i) => i != 2);
            }
            calculate_award();
            toggleAll();

        }

        function button_third_award(){
            const button_third = $('#btn-award-third');

            if(!button_third.hasClass('active')){
                button_third.addClass('active');
                award_type.push(3);
            }else{
                button_third.removeClass('active');
                award_type = award_type = award_type.filter((i) => i != 3);
            }
            calculate_award();
            toggleAll();

        }

        function button_fourth_award(){
            const button_fourth = $('#btn-award-fourth');

            if(!button_fourth.hasClass('active')){
                button_fourth.addClass('active');
                award_type.push(4);
            }else{
                button_fourth.removeClass('active');
                award_type = award_type = award_type.filter((i) => i != 4);
            }
            calculate_award();
            toggleAll();

        }

        function button_fifth_award(){
            const button_fifth = $('#btn-award-fifth');

            if(!button_fifth.hasClass('active')){
                button_fifth.addClass('active');
                award_type.push(5);
            }else{
                button_fifth.removeClass('active');
                award_type = award_type = award_type.filter((i) => i != 5);
            }
            calculate_award();
            toggleAll();
        }

        function button_first_to_fifth_award(){

            const button_first = $('#btn-award-first');
            const button_second = $('#btn-award-second');
            const button_fifth = $('#btn-award-fifth');
            const button_third = $('#btn-award-third');
            const button_fourth = $('#btn-award-fourth');
            const button_first_to_fifth = $('#btn-award-first-to-fifth');

            if(!button_first_to_fifth.hasClass('active')){
                button_first.addClass('active');
                button_second.addClass('active');
                button_third.addClass('active');
                button_fourth.addClass('active');
                button_fifth.addClass('active');
                button_first_to_fifth.addClass('active');
                award_type = [1,2,3,4,5];
            }else{
                button_first.removeClass('active');
                button_second.removeClass('active');
                button_third.removeClass('active');
                button_fourth.removeClass('active');
                button_fifth.removeClass('active');
                button_first_to_fifth.removeClass('active');
                award_type = [];
            }
            calculate_award();
        }

        function validate_award(){
            const array_buttons = $('.btn-award');
            const label_award = $('#price_award');

            const message = $('#message-award-value');
            let contador = 0;

            for(i=0;i<array_buttons.length;i++){
                const btn_id = $(`#${array_buttons[i]['id']}`);
                if(btn_id.hasClass('active')){
                    contador += 1;
                }
            }

            return contador;
        }

        function check_award(){
            const message = $('#message-award-value');
            const label_award = $('#price_award');
            const btn_add_to_cart = $('#btn-add-to-chart');

            if(validate_award() == 0){
                message.removeClass('d-none');
                message.addClass('d-block');
                const initial_value = 0;

                label_award.text(('R$'+initial_value+',00').toLocaleString('pt-BR',{
                    minimumFractionDigits: 2
                }));
            }else if(validate_award() == 1){
                message.removeClass('d-block');
                message.addClass('d-none');

                label_award.text('R$'+award.toLocaleString('pt-BR',{
                    minimumFractionDigits: 2,
                }));
                btn_add_to_cart.removeClass('disabled');
            }else if(validate_award() == 2){
                message.removeClass('d-block');
                message.addClass('d-none');

                label_award.text('R$'+(award/2).toLocaleString('pt-BR',{
                    minimumFractionDigits: 2,
                }));
                btn_add_to_cart.removeClass('disabled');
            }else if(validate_award() == 3){
                message.removeClass('d-block');
                message.addClass('d-none');

                label_award.text('R$'+(award/3).toLocaleString('pt-BR',{
                    minimumFractionDigits: 2,
                }));
                btn_add_to_cart.removeClass('disabled');
            }else if(validate_award() == 4){
                message.removeClass('d-block');
                message.addClass('d-none');

                label_award.text('R$'+(award/4).toLocaleString('pt-BR',{
                    minimumFractionDigits: 2,
                }));
                btn_add_to_cart.removeClass('disabled');
            }else if(validate_award() == 5){
                message.removeClass('d-block');
                message.addClass('d-none');

                label_award.text('R$'+(award/5).toLocaleString('pt-BR',{
                    minimumFractionDigits: 2,
                }));
                btn_add_to_cart.removeClass('disabled');
            }else if(validate_award() == 6){
                message.removeClass('d-block');
                message.addClass('d-none');

                label_award.text('R$'+(award/5).toLocaleString('pt-BR',{
                    minimumFractionDigits: 2,
                }));
                btn_add_to_cart.removeClass('disabled');
            }
        }
    </script>
@endpush
