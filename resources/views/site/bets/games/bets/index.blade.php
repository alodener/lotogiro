@extends('site.layouts.master')

@section('title', 'Inicio')

@section('content')
<div class="">
    <div class="row row-pai">
        <div class="col-md-12">
            <div class="">
                
                <div class="card-body">
                    @if(isset($bet) && !$bet->status && $bet->botao_finalizar == 3)
                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-danger" role="alert">
                                <h4 class="alert-heading">{{ trans('admin.sitePages.atencao') }} </h4>
                                <p>{{ trans('admin.sitePages.npossivel') }} </p>
                                <hr>
                                <p class="mb-0">{{ trans('admin.sitePages.iniccApost') }} <a
                                        href="{{route('games.bet', ['user' => $user->id])}}">{{
                                        trans('admin.sitePages.clicAq') }} </a>
                                </p>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="row">
                        <div class="col-md-12">
                            <div>
                                @if (session('success'))
                                            
                                @push('scripts')
                                <script>
                                    toastr["success"]("{{ session('success') }}")
                                </script>
                                @endpush
                                @endif
                                @if (session('error'))
                               
                                @push('scripts')
                                <script>
                                    toastr["error"]("{{ session('error') }}")
                                </script>
                                @endpush
                                @endif
                            </div>
                        </div>
                    </div>

                    @if(empty($bet))
                    <div class="row card-inicia-aposta d-flex justify-content-center">
                        <div class="col-md-6 ">
                            <form action="{{route('games.bet.store', ['user' => $user->id])}}" method="post">
                                @csrf
                                <div class="d-flex justify-content-center align-items-center flex-column">
                                    <img src="{{ App\Helper\Configs::getConfigLogo() }}" style="max-width: 120px;"
                                        alt="Logo" class="brand-image img-circle " style="opacity: .8">
                                    <h4 class="mt-3 mb-3">Bem vindo, apostador !</h4>
                                </div>
                                <button type="submit" class="btn btn-primary btn-block">{{
                                    trans('admin.sitePages.criarApost') }}
                                </button>
                            </form>
                        </div>
                    </div>
                    @else
                    @if(isset($bet) && empty($bet->client_id))

                  

                    <div class="row container mx-auto">
                        <div class="col-md-12 card-master container" style="padding:20px;">
                            @livewire('site.pages.bets.games.bet.client', ['bet' => $bet, 'typeGames'
                            =>
                            $typeGames])
                        </div>
                    </div>
                    @else
                 
                    <div class="row">



                        <div class="container">
                            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                                <ol class="carousel-indicators">
                                    @foreach($layout_carousel_grande as $key => $item)
                                    @if($item['visivel'] == 1)
                                    <li data-target="#carouselExampleIndicators" data-slide-to="{{ $key }}"
                                        class="{{ $key == 0 ? 'active' : '' }}"></li>
                                    @endif
                                    @endforeach
                                </ol>
                                <div class="carousel-inner">
                                    @foreach($layout_carousel_grande as $key => $item)
                                    @if($item['visivel'] == 1)
                                    <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                        <img class="d-block w-100" src="{{ isset($item['url']) ? asset("storage/{$item['url']}") :
                                            asset('https://i.ibb.co/68Nh8sS/pf-Skj6-MF8b-Rv1-POOPGCee-EL94u8-P2bf9jl2czixi.jpg')
                                            }}" alt="{{ $item['nome'] }}">
                                    </div>
                                    @endif
                                    @endforeach
                                </div>
                                <a class="carousel-control-prev nott" href="#carouselExampleIndicators" role="button"
                                    data-slide="prev">
                                    <span class="carousel-control-prev-icon " aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="carousel-control-next nott" href="#carouselExampleIndicators" role="button"
                                    data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </div>
                        </div>
                        <input type="text"  value="{{$bet->id}}" id="bet-id" hidden>
                    <input type="text"  value="{{$user->id}}" id="user-id" hidden>
                        <div class="container mt-2">
                            <div class="d-flex swipe-controles align-items-center">
                                <svg width="10" class="ml-3 mr-3 swiper-prev swp" fill="#5A6268" color="#5A6268"
                                    data-v-3d6f2aec="" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                                    <path fill="currentColor"
                                        d="M41.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.3 256 246.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z">
                                    </path>
                                </svg>
                                <svg width="10" class="swiper-next swp" fill="#5A6268" color="#5A6268"
                                    data-v-3d6f2aec="" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                                    <path fill="currentColor"
                                        d="M278.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-160 160c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L210.7 256 73.4 118.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l160 160z">
                                    </path>
                                </svg>
                            </div>


                            <!-- Nav icons -->
<!-- Button trigger modal -->





<!-- Modal -->

<div class="modal fade bd-example-modal-lg" id="exampleModalCenter"  tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Carrinho</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span style="color:white;" aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">{{ trans('admin.sitePages.typeGame') }}</th>
                                        <th scope="col">{{ trans('admin.sitePages.doz') }}</th>
                                        <th scope="col">{{ trans('admin.sitePages.value') }} </th>
                                        <th scope="col">{{ trans('admin.sitePages.premio') }} </th>
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
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Sair</button>
        @if(!empty($bet) && $bet->status && $bet->botao_finalizar == 0)

<div class="ml-4 ">
    <form action="{{route('games.bet.update', ['user' => $bet->user->id, 'bet' => $bet])}}"
        method="post">
        @csrf
        <button type="submit" class="btn btn-primary">{{ trans('admin.sitePages.fimApost')
            }}</button>

    </form>
</div>
@endif      </div>
    </div>
  </div>
</div>
                            <!-- Conteúdo da sua view existente -->
                            <div class="swiperroll p-2">
                                <div class="swiper-wrapper">
                                    <!-- {{$TypeGamesRoll}} -->
                                    @foreach($TypeGamesRoll as $typeGame)
                                    <div class="swiper-slide d-flex flex-column category-info" data-type-game-id="{{ $typeGame->category }}">
                                        <div class="icon-container">
                                            <img class="img-bold"
                                                src="{{ $typeGame->icon ? asset('/storage/' . str_replace('.png', '-bold.png', $typeGame->icon)) : asset('/storage/megasena-bold.png') }}"
                                                alt="">

                                        </div>
                                        <div>
                                            <p class="txtnav">{{ ucwords(str_replace('_', ' ', $typeGame->category)) }}
                                            </p>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Div para renderizar as categorias -->
                            <div id="categories-container">
                            </div>
                        </div>
                        <!-- Recomendados -->
                        <div class="container mt-5">
                            <div class="d-flex swipe-controles align-items-center mb-2">
                                <h1 style="color:white">Recomendados</h1>
                                <svg width="10" class="ml-3 mr-3 swiper-prev swp" fill="#5A6268" color="#5A6268"
                                    data-v-3d6f2aec="" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                                    <path fill="currentColor"
                                        d="M41.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.3 256 246.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z">
                                    </path>
                                </svg>
                                <svg width="10" class="swiper-next swp" fill="#5A6268" color="#5A6268"
                                    data-v-3d6f2aec="" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                                    <path fill="currentColor"
                                        d="M278.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-160 160c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L210.7 256 73.4 118.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l160 160z">
                                    </path>
                                </svg>
                            </div>
                             @if(\App\Models\TypeGame::where('recomendado', 1)->count() > 0)
                            <div class="swiper">
                                <div class="swiper-wrapper">
                                    @foreach(\App\Models\TypeGame::where('recomendado', 1)->get() as $typeGame)
                                    <div class="swiper-slide">
                                        <a
                                            href="{{route('games.bet.game.create', ['user' => $bet->user->id, 'bet' => $bet->id, 'typeGame' => $typeGame->id])}}">
                                            <img src="{{ $typeGame->banner_pc ? asset("storage/{$typeGame->banner_pc}")
                                            :
                                            asset('https://i.ibb.co/VWhHF8D/Yys88-SZf-Yy-AI4oo61k-Bd-Fw-Kq-Sl-R0k-Cu-Wd-DDQUVj5.jpg')
                                            }}" alt="{{ $typeGame->name }}" class="d-none d-md-block">
                                            <img src="{{ $typeGame->banner_mobile ? asset("storage/{$typeGame->banner_mobile}") :asset('https://i.ibb.co/0yB31KB/60-Yp-Ckw9vf-EZXF9-Md4la52d-BK5j-YUPfqjx-E6c-Pro.jpg')}}" alt="{{ $typeGame->name }}" class="d-md-none">
                                            <a>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        </div>
                        <!-- Todos os jogos -->

                        @if(\App\Models\TypeGame::count() > 0)
                        <div class="container mt-5">
                            <div class="d-flex swipe-controles align-items-center mb-2">
                                <h1 style="color:white">Todos os Jogos</h1>
                                <svg width="10" class="ml-3 mr-3 swiper-list-prev swp" fill="#5A6268" color="#5A6268"
                                    data-v-3d6f2aec="" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                                    <path fill="currentColor"
                                        d="M41.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.3 256 246.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z">
                                    </path>
                                </svg>
                                <svg width="10" class="swiper-list-next swp" fill="#5A6268" color="#5A6268"
                                    data-v-3d6f2aec="" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                                    <path fill="currentColor"
                                        d="M278.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-160 160c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L210.7 256 73.4 118.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l160 160z">
                                    </path>
                                </svg>
                            </div>

                            <div class="swiper-list swiper-full">
                                <div class="swiper-wrapper">
                                    @foreach(\App\Models\TypeGame::get() as $typeGame)
                                    <div class="swiper-slide">
                                        <a href="{{route('games.bet.game.create', ['user' => $bet->user->id, 'bet' => $bet->id, 'typeGame' => $typeGame->id])}}"
                                            class="hover-container">
                                            <img src="{{ $typeGame->banner_mobile ? asset("storage/{$typeGame->banner_mobile}") : asset('https://i.ibb.co/0yB31KB/60-Yp-Ckw9vf-EZXF9-Md4la52d-BK5j-YUPfqjx-E6c-Pro.jpg') }}"
                                                alt="{{ $typeGame->name }}">
                                            <div class="hover-content">
                                                <p>{{ $typeGame->name }}</p>
                                                <button class="btn btn-primary">Jogar Agora</button>
                                            </div>
                                        </a>
                                    </div>
                                    @endforeach


                                </div>
                            </div>
                        </div>
                        @endif




                    </div>
                </div>
                @endif
                <div class="row mt-3">
                    <div class="col-md-12">
                      
                    </div>
                    @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')


<style>
    .swiper-full {
        margin-left: auto;
        margin-right: auto;
        position: relative;
        overflow: hidden;
        list-style: none;
        padding: 0;
        z-index: 1;
        display: block;
    }


    .swiperroll {
        margin-left: auto;
        margin-right: auto;
        position: relative;
        overflow: hidden;
        list-style: none;
        padding: 0;
        z-index: 1;
        display: block;
    }

    .swiper-bichao {
        margin-left: auto;
        margin-right: auto;
        position: relative;
        overflow: hidden;
        list-style: none;
        padding: 0;
        z-index: 1;
        display: block;
    }

    .swiper-pesquisa {
        margin-left: auto;
        margin-right: auto;
        position: relative;
        overflow: hidden;
        list-style: none;
        padding: 0;
        z-index: 1;
        display: block;
    }


    .swiper-slide {
        display: flex !important;
        align-items: center;
        justify-content: center;
        padding-right: 10px !important;

    }

    .swiper-slide img {
        width: 100%;
        border-radius: 10px;
    }
</style>

<script>

$('.category-info').click(function () {
            var typeGameId = $(this).data('type-game-id');
            var categoriesContainer = $('#categories-container');

            var userId = $('#user-id').val();;
            var betId = $('#bet-id').val();;
            
            // Verifica se o container está visível
            $.ajax({
                    url: '/admin/categoriaavulso/' + typeGameId + '?bet=' + userId + '&user=' +  betId,
                    type: 'GET',
                    success: function (data) {
                        $('#categories-container').html(data);
                        var formattedTypeGameId = formatTypeGameId(typeGameId);
                        $('#nome_pesq').text(formattedTypeGameId);

                        // Atualiza os atributos de data para o novo typeGameId
                        categoriesContainer.data('type-game-id', typeGameId);
                    },
                    error: function (error) {
                        console.log('Erro na requisição AJAX:', error);
                    }
                });
        });

    $(document).ready(function () {
       
        var swiperroll = new Swiper('.swiperroll', {
            slidesPerView: 5,

            breakpoints: {
                768: {
                    slidesPerView: 6,
                }
            }
        });


        var swiperlist = new Swiper('.swiper-list', {
            slidesPerView: 4,
            navigation: {
                nextEl: '.swiper-list-next',
                prevEl: '.swiper-list-prev',
            },
            breakpoints: {
                768: {
                    slidesPerView: 6,
                }
            }
        });

        var swiperbichao = new Swiper('.swiper-bichao', {
            slidesPerView: 3,
            navigation: {
                nextEl: '.swiper-bichao-next',
                prevEl: '.swiper-bichao-prev',
            },
            breakpoints: {
                768: {
                    slidesPerView: 6,
                }
            }
        });

        var swiper = new Swiper('.swiper', {
            slidesPerView: 3,
            navigation: {
                nextEl: '.swiper-next',
                prevEl: '.swiper-prev',
            },
        });

        function formatTypeGameId(typeGameId) {
            // Divide a string em palavras
            var words = typeGameId.split('_');

            // Capitaliza a primeira letra de cada palavra
            for (var i = 0; i < words.length; i++) {
                words[i] = words[i].charAt(0).toUpperCase() + words[i].slice(1);
            }

            // Junta as palavras novamente com espaço em branco
            return words.join(' ');
        }







    });




</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="text/javascript">

</script>
@endpush
