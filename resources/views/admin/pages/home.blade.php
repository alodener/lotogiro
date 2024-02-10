@extends('admin.layouts.master')

@section('title', trans('admin.dashboard.page-title'))

@section('content')
<div class="row bg-cc p-2 p-md-5">


    <!-- Modal LOGIN -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-login" style="border-radius:10px;">

                @include('admin.pages.auth.login')


            </div>
            <div class="modal-content modal-register" style="border-radius:10px;">

                @include('admin.pages.auth.register')


            </div>

        </div>
    </div>
    <script>


        $('.modal-register').hide();



        function toggleModal(modalType) {

            if (!modalType) {
                // Se nenhum parâmetro for fornecido, faz o toggle automaticamente
                $('.modal-login, .modal-register').toggle();
            } else if (modalType === 'login') {
                $('.modal-login').show();
                $('.modal-register').hide();
            } else if (modalType === 'register') {
                $('.modal-login').hide();
                $('.modal-register').show();
            }
        }
    </script>

    <!-- CARD GRANDE -->
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
                    <a href="{{$item['link']}}" target="_blank">
                        <img class="d-block w-100" src="{{ isset($item['url']) ? asset("storage/{$item['url']}") :
                            asset('https://i.ibb.co/68Nh8sS/pf-Skj6-MF8b-Rv1-POOPGCee-EL94u8-P2bf9jl2czixi.jpg') }}"
                            alt="{{ $item['nome'] }}">
                    </a>
                </div>
                @endif
                @endforeach
            </div>
            <a class="carousel-control-prev nott" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon " aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next nott" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
    <div class="container mt-2">



        <!-- Nav icons -->

        <!-- Conteúdo da sua view existente -->
        <div class="swiperroll p-2">
            <div class="swiper-wrapper">
                <!-- {{$TypeGamesRoll}} -->
                @foreach($TypeGamesRoll as $typeGame)
                <div class="swiper-slide d-flex flex-column category-info"
                    data-type-game-id="{{ $typeGame->category }}">
                    <div class="icon-container">
                        <img class="img-bold"
                            src="{{ $typeGame->icon ? asset('/storage/' . str_replace('.png', '-bold.png', $typeGame->icon)) : asset('/storage/megasena-bold.png') }}"
                            alt="">

                    </div>
                    <div>
                        <p class="txtnav">{{ ucwords(str_replace('_', ' ', $typeGame->category)) }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>


        @if(auth()->user())
        <!-- Se for usuario aparece -->
        @if($User['type_client'] == 1)
        <div class="container-fluid d-flex align-items-center justify-content-center card-indica mt-2 "
            href="#collapseExample2" data-toggle="collapse" role="button" aria-expanded="false"
            aria-controls="collapseExample" style="border-bottom:1px solid #A3D712;">
            <span style="font-size:20px;" class="mr-3">💥</span>
            <h5 class="mr-3">Indique e ganhe em cada amigo que convidar</h5>
            <span style="font-size:20px;" class="mr-3">💥</span>

            <i class="fa fa-angle-down" style="color:#A3D712;" aria-hidden="true"></i>

        </div>
        <p>
        </p>
        <div class="collapse" id="collapseExample2">
            <div class="card card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Indicação</th>
                            <th scope="col">Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Cadastro</td>
                            <td> <sl-copy-button class="icon-copy"
                                    value="{{ env('APP_URL') }}/admin/indicate/{{ auth()->user()->indicador }}"></sl-copy-button>
                            </td>
                        </tr>
                        @if($User['type_client'] != 1)


                        <tr>
                            <td>Minhas Indicações</td>
                            <td><a href="{{ env('APP_URL') }}/admin/settings/indicated"><i
                                        style="font-size:20px; color:#A3D712;" class="fa fa-arrow-right"
                                        aria-hidden="true"></i></a>

                            </td>
                        </tr>
                        @endif



                    </tbody>
                </table>
            </div>
        </div>
        @endif
        @if($User['type_client'] != 1)

        <div class="container-fluid d-flex align-items-center justify-content-center card-indica mt-2 "
            href="#collapseExample" data-toggle="collapse" role="button" aria-expanded="false"
            aria-controls="collapseExample" style="border-bottom:1px solid red;">
            <span style="font-size:20px;" class="mr-3">💥</span>
            <h5 class="mr-3">Indique e ganhe em cada amigo que convidar</h5>
            <span style="font-size:20px;" class="mr-3">💥</span>

            <i class="fa fa-angle-down" style="color:#A3D712;" aria-hidden="true"></i>

        </div>
        <p>
        </p>
        <div class="collapse" id="collapseExample">
            <div class="card card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Indicação</th>
                            <th scope="col">Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Cadastro</td>
                            <td> <sl-copy-button class="icon-copy"
                                    value="{{ env('APP_URL') }}/admin/indicate/{{ auth()->user()->indicador }}"></sl-copy-button>
                            </td>
                        </tr>
                        @if($User['type_client'] != 1)

                        <tr>
                            <td>Jogo Avulso</td>
                            <td> <sl-copy-button class="icon-copy"
                                    value="{{ env('APP_URL') }}/games/{{ auth()->user()->id }}"></sl-copy-button>
                            </td>
                        </tr>
                        <tr>
                            <td>Minhas Indicações</td>
                            <td><a href="{{ env('APP_URL') }}/admin/settings/indicated"><i
                                        style="font-size:20px; color:#A3D712;" class="fa fa-arrow-right"
                                        aria-hidden="true"></i></a>

                            </td>
                        </tr>
                        @endif



                    </tbody>
                </table>
            </div>
        </div>


        @endif

        <!-- Div para renderizar as categorias -->
        <div id="categories-container">
        </div>
    </div>
    @endif
    <!-- Recomendados -->
    <div class="container mt-5">
        <div class="d-flex swipe-controles justify-content-between align-items-center mb-2">
            <div class="d-flex">
                <h1 style="color:white">Recomendados</h1>
                <svg width="10" class="ml-3 mr-3 swiper-prev swp" fill="#5A6268" color="#5A6268" data-v-3d6f2aec=""
                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                    <path fill="currentColor"
                        d="M41.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.3 256 246.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z">
                    </path>
                </svg>
                <svg width="10" class="swiper-next swp" fill="#5A6268" color="#5A6268" data-v-3d6f2aec=""
                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                    <path fill="currentColor"
                        d="M278.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-160 160c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L210.7 256 73.4 118.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l160 160z">
                    </path>
                </svg>
            </div>
            <div>
                <!-- <button class="btn btn-moregame">Ver todos</button> -->
            </div>
        </div>
        @if(\App\Models\TypeGame::where('recomendado', 1)->count() > 0)
        <div class="swiper">
            <div class="swiper-wrapper">
                @foreach(\App\Models\TypeGame::where('recomendado', 1)->get() as $typeGame)
                <div class="swiper-slide" >
                    <a href="{{route('admin.bets.games.create', ['type_game' => $typeGame->id])}}">
                        <img style="border-radius: 10px; width: 100%; height: 100%; object-fit: cover;" src="{{ $typeGame->banner_pc ? asset("storage/{$typeGame->banner_pc}") :
                        asset('https://i.ibb.co/VWhHF8D/Yys88-SZf-Yy-AI4oo61k-Bd-Fw-Kq-Sl-R0k-Cu-Wd-DDQUVj5.jpg') }}"
                        alt="{{ $typeGame->name }}" class="d-none d-md-block">
                        <img style="border-radius: 10px; width: 100%; height: 100%; object-fit: cover;"  src="{{ $typeGame->banner_mobile ? asset("storage/{$typeGame->banner_mobile}") :
                        asset('https://i.ibb.co/0yB31KB/60-Yp-Ckw9vf-EZXF9-Md4la52d-BK5j-YUPfqjx-E6c-Pro.jpg') }}"
                        alt="{{ $typeGame->name }}" class="d-md-none" >

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
        </div>

        <div class="d-flex flex-wrap justify-content-center">
            @php
            $typeGames = \App\Models\TypeGame::get();
            $count = 0;
            @endphp

            @foreach($typeGames as $typeGame)
            <div class="d-flex p-2 box-imgs">
                <a href="{{ route('admin.bets.games.create', ['type_game' => $typeGame->id]) }}"
                    class="hover-container" >
                    <img class="img-todos-jogos"  style="border-radius: 10px; width: 100%; height: 100%; object-fit: cover;" src="{{ $typeGame->banner_mobile ? asset("storage/{$typeGame->banner_mobile}") :
                    asset('https://i.ibb.co/0yB31KB/60-Yp-Ckw9vf-EZXF9-Md4la52d-BK5j-YUPfqjx-E6c-Pro.jpg') }}"
                    alt="{{ $typeGame->name }} " >
                    <div class="hover-content">
                        <p>{{ $typeGame->name }}</p>
                        <button class="btn btn-primary">Jogar Agora</button>
                    </div>
                </a>
            </div>

           
            @endforeach
        @endif
     
    <!-- @if(\App\Models\TypeGame::count() > 0)
    <div class="container mt-5">
        <div class="d-flex swipe-controles align-items-center mb-2">
            <h1 style="color:white">Todos os Jogos</h1>
        </div>

        <div class="d-flex flex-wrap justify-content-center">
            @php
            $typeGames = \App\Models\TypeGame::get();
            $count = 0;
            @endphp

            @foreach($typeGames as $typeGame)
            <div class="d-flex p-2 box-imgs">
                <a href="{{ route('admin.bets.games.create', ['type_game' => $typeGame->id]) }}"
                    class="hover-container" >
                    <img class="img-todos-jogos"  style="border-radius: 10px; width: 100%; height: 100%; object-fit: cover;" src="{{ $typeGame->banner_mobile ? asset("storage/{$typeGame->banner_mobile}") :
                    asset('https://i.ibb.co/0yB31KB/60-Yp-Ckw9vf-EZXF9-Md4la52d-BK5j-YUPfqjx-E6c-Pro.jpg') }}"
                    alt="{{ $typeGame->name }} " >
                    <div class="hover-content">
                        <p>{{ $typeGame->name }}</p>
                        <button class="btn btn-primary">Jogar Agora</button>
                    </div>
                </a>
            </div>

            @php
            $count++;
            if ($count == 12) {
            break;
            }
            @endphp
            @endforeach

            @if($typeGames->count() > 12)
            <p>
            <div class="collapse" id="collapseExampledd">
            <div class="d-flex flex-wrap justify-content-center justify-content-md-start ">
                    @foreach($typeGames->splice(12) as $typeGame)
                    <div class="d-flex p-2 box-imgs">
                        <a href="{{ route('admin.bets.games.create', ['type_game' => $typeGame->id]) }}"
                            class="hover-container">
                            <img class="img-todos-jogos"  style="border-radius:10px;" src="{{ $typeGame->banner_mobile ? asset("storage/{$typeGame->banner_mobile}") :
                            asset('https://i.ibb.co/0yB31KB/60-Yp-Ckw9vf-EZXF9-Md4la52d-BK5j-YUPfqjx-E6c-Pro.jpg') }}"
                            alt="{{ $typeGame->name }} " >
                            <div class="hover-content">
                                <p>{{ $typeGame->name }}</p>
                                <button class="btn btn-primary">Jogar Agora</button>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>

            </p>
            @endif
        </div> -->
        <!-- @if(\App\Models\TypeGame::count() > 12)

        <div class="d-flex justify-content-center align-items-center mt-5">
            <button class="btn btn-primary btn-collapse" data-toggle="collapse" href="#collapseExampledd" role="button"
                aria-expanded="false" aria-controls="collapseExample">
                Ver Mais
            </button>
        </div>
        @endif -->

    </div>
    @endif


    <!-- Bichao da sorte

    <div class="container mt-5">
        <div class="d-flex swipe-controles align-items-center mb-2">
            <h1 style="color:white">Bichão da Sorte</h1>
        </div>

        <div class="d-flex flex-wrap justify-content-center">
                                

            <div class="d-flex p-2 box-imgs">
                <a href="/admin/bets/bichao" class="hover-container">
                    <img class="img-todos-jogos" style="border-radius:10px;"  src="https://imagedelivery.net/BgH9d8bzsn4n0yijn4h7IQ/3deaeed0-dbf3-4064-ada6-00ed81a72d00/ipad"
                        alt="{{ $typeGame->name }}">
                    <div class="hover-content">
                        <p>Milhar</p>
                        <button class="btn btn-primary">Jogar Agora</button>
                    </div>
                </a>
            </div>
            <div class="d-flex p-2 box-imgs">
                <a href="/admin/bets/bichao/centena" class="hover-container">
                    <img class="img-todos-jogos" style="border-radius:10px;"  src="https://imagedelivery.net/BgH9d8bzsn4n0yijn4h7IQ/3deaeed0-dbf3-4064-ada6-00ed81a72d00/ipad"
                        alt="{{ $typeGame->name }}">
                    <div class="hover-content">
                        <p>Centena</p>
                        <button class="btn btn-primary">Jogar Agora</button>
                    </div>
                </a>
            </div>
            <div class="d-flex p-2 box-imgs">
                <a href="/admin/bets/bichao/dezena" class="hover-container">
                    <img class="img-todos-jogos" style="border-radius:10px;"  src="https://imagedelivery.net/BgH9d8bzsn4n0yijn4h7IQ/3deaeed0-dbf3-4064-ada6-00ed81a72d00/ipad"
                        alt="{{ $typeGame->name }}">
                    <div class="hover-content">
                        <p>Dezena</p>
                        <button class="btn btn-primary">Jogar Agora</button>
                    </div>
                </a>
            </div>
            <div class="d-flex p-2 box-imgs">
                <a href="/admin/bets/bichao/group" class="hover-container">
                    <img class="img-todos-jogos" style="border-radius:10px;"  src="https://imagedelivery.net/BgH9d8bzsn4n0yijn4h7IQ/3deaeed0-dbf3-4064-ada6-00ed81a72d00/ipad"
                        alt="{{ $typeGame->name }}">
                    <div class="hover-content">
                        <p>Grupo</p>
                        <button class="btn btn-primary">Jogar Agora</button>
                    </div>
                </a>
            </div>
            <div class="d-flex p-2 box-imgs">
                <a href="/admin/bets/bichao/milhar/centena" class="hover-container">
                    <img class="img-todos-jogos" style="border-radius:10px;"  src="https://imagedelivery.net/BgH9d8bzsn4n0yijn4h7IQ/3deaeed0-dbf3-4064-ada6-00ed81a72d00/ipad"
                        alt="{{ $typeGame->name }}">
                    <div class="hover-content">
                        <p>Milhar/Centena</p>
                        <button class="btn btn-primary">Jogar Agora</button>
                    </div>
                </a>
            </div>
            <div class="d-flex p-2 box-imgs">
                <a href="/admin/bets/bichao/terno/dezena" class="hover-container">
                    <img class="img-todos-jogos" style="border-radius:10px;"  src="https://imagedelivery.net/BgH9d8bzsn4n0yijn4h7IQ/3deaeed0-dbf3-4064-ada6-00ed81a72d00/ipad"
                        alt="{{ $typeGame->name }}">
                    <div class="hover-content">
                        <p>Terno/Dezena</p>
                        <button class="btn btn-primary">Jogar Agora</button>
                    </div>
                </a>
            </div>
            <div class="d-flex p-2 box-imgs">
                <a href="/admin/bets/bichao/duque/dezena" class="hover-container">
                    <img class="img-todos-jogos" style="border-radius:10px;"  src="https://imagedelivery.net/BgH9d8bzsn4n0yijn4h7IQ/3deaeed0-dbf3-4064-ada6-00ed81a72d00/ipad"
                        alt="{{ $typeGame->name }}">
                    <div class="hover-content">
                        <p>Duque/Dezena</p>
                        <button class="btn btn-primary">Jogar Agora</button>
                    </div>
                </a>
            </div>
            <div class="d-flex p-2 box-imgs">
                <a href="/admin/bets/bichao/quina/grupo" class="hover-container">
                    <img class="img-todos-jogos" style="border-radius:10px;"  src="https://imagedelivery.net/BgH9d8bzsn4n0yijn4h7IQ/3deaeed0-dbf3-4064-ada6-00ed81a72d00/ipad"
                        alt="{{ $typeGame->name }}">
                    <div class="hover-content">
                        <p>Quina/Grupo</p>
                        <button class="btn btn-primary">Jogar Agora</button>
                    </div>
                </a>
            </div>
            <div class="d-flex p-2 box-imgs">
                <a href="/admin/bets/bichao/quadra/grupo" class="hover-container">
                    <img class="img-todos-jogos" style="border-radius:10px;"  src="https://imagedelivery.net/BgH9d8bzsn4n0yijn4h7IQ/3deaeed0-dbf3-4064-ada6-00ed81a72d00/ipad"
                        alt="{{ $typeGame->name }}">
                    <div class="hover-content">
                        <p>Quadra/Grupo</p>
                        <button class="btn btn-primary">Jogar Agora</button>
                    </div>
                </a>
            </div>
            <div class="d-flex p-2 box-imgs">
                <a href="/admin/bets/bichao/terno/grupo" class="hover-container">
                    <img class="img-todos-jogos" style="border-radius:10px;"  src="https://imagedelivery.net/BgH9d8bzsn4n0yijn4h7IQ/3deaeed0-dbf3-4064-ada6-00ed81a72d00/ipad"
                        alt="{{ $typeGame->name }}">
                    <div class="hover-content">
                        <p>Terno/Grupo</p>
                        <button class="btn btn-primary">Jogar Agora</button>
                    </div>
                </a>
            </div>
            <div class="d-flex p-2 box-imgs">
                <a href="/admin/bets/bichao/duque/grupo" class="hover-container">
                    <img class="img-todos-jogos" style="border-radius:10px;"  src="https://imagedelivery.net/BgH9d8bzsn4n0yijn4h7IQ/3deaeed0-dbf3-4064-ada6-00ed81a72d00/ipad"
                        alt="{{ $typeGame->name }}">
                    <div class="hover-content">
                        <p>Duque/Grupo</p>
                        <button class="btn btn-primary">Jogar Agora</button>
                    </div>
                </a>
            </div>
            <div class="d-flex p-2 box-imgs">
                <a href="/admin/bets/bichao/unidade" class="hover-container">
                    <img class="img-todos-jogos" style="border-radius:10px;"  src="https://imagedelivery.net/BgH9d8bzsn4n0yijn4h7IQ/3deaeed0-dbf3-4064-ada6-00ed81a72d00/ipad"
                        alt="{{ $typeGame->name }}">
                    <div class="hover-content">
                        <p>Unidade</p>
                        <button class="btn btn-primary">Jogar Agora</button>
                    </div>
                </a>
            </div>
           
            <p>
            <div class="collapse" id="collapseExampleddd">
                <div class="d-flex">
                <div class="d-flex p-2 box-imgs">
                <a href="/admin/bets/bichao/milhar/invertida" class="hover-container">
                    <img class="img-todos-jogos" style="border-radius:10px;"  src="https://imagedelivery.net/BgH9d8bzsn4n0yijn4h7IQ/3deaeed0-dbf3-4064-ada6-00ed81a72d00/ipad"
                        alt="{{ $typeGame->name }}">
                    <div class="hover-content">
                        <p>Milhar/Inverida</p>
                        <button class="btn btn-primary">Jogar Agora</button>
                    </div>
                </a>
            </div> <div class="d-flex p-2 box-imgs">
                <a href="/admin/bets/bichao/centena/invertida" class="hover-container">
                    <img class="img-todos-jogos" style="border-radius:10px;"  src="https://imagedelivery.net/BgH9d8bzsn4n0yijn4h7IQ/3deaeed0-dbf3-4064-ada6-00ed81a72d00/ipad"
                        alt="{{ $typeGame->name }}">
                    <div class="hover-content">
                        <p>Centena/Invertida</p>
                        <button class="btn btn-primary">Jogar Agora</button>
                    </div>
                </a>
            </div>
                </div>
            </div>

            </p>
        </div>
        <div class="d-flex justify-content-center align-items-center mt-5 mb-5">
            <button class="btn btn-primary btn-collapse" data-toggle="collapse" href="#collapseExampleddd" role="button"
                aria-expanded="false" aria-controls="collapseExample">
                Ver Mais
            </button>
        </div>
         
        </div>
       
    </div> -->

   <!-- Bichao da sorte -->

   <div class="container mt-5">
        <div class="d-flex swipe-controles align-items-center mb-2">
            <h1 style="color:white">Bichão da Sorte</h1>
        </div>

        <div class="d-flex flex-wrap justify-content-center">
                                

            <div class="d-flex p-2 box-imgs">
                <a href="/admin/bets/bichao" class="hover-container">
                    <img class="img-todos-jogos" style="border-radius:10px;"  src="https://i.ibb.co/m65kWYw/Milhar-165-x-192-px.png"
                        alt="{{ $typeGame->name }}">
                    <div class="hover-content">
                        <p>Milhar</p>
                        <button class="btn btn-primary">Jogar Agora</button>
                    </div>
                </a>
            </div>
            <div class="d-flex p-2 box-imgs">
                <a href="/admin/bets/bichao/centena" class="hover-container">
                    <img class="img-todos-jogos" style="border-radius:10px;"  src="https://i.ibb.co/Wgtc5bN/Centena-165-x-192-px.png"
                        alt="{{ $typeGame->name }}">
                    <div class="hover-content">
                        <p>Centena</p>
                        <button class="btn btn-primary">Jogar Agora</button>
                    </div>
                </a>
            </div>
            <div class="d-flex p-2 box-imgs">
                <a href="/admin/bets/bichao/dezena" class="hover-container">
                    <img class="img-todos-jogos" style="border-radius:10px;"  src="https://i.ibb.co/GHf0xCL/1.png"
                        alt="{{ $typeGame->name }}">
                    <div class="hover-content">
                        <p>Dezena</p>
                        <button class="btn btn-primary">Jogar Agora</button>
                    </div>
                </a>
            </div>
            <div class="d-flex p-2 box-imgs">
                <a href="/admin/bets/bichao/group" class="hover-container">
                    <img class="img-todos-jogos" style="border-radius:10px;"  src="https://i.ibb.co/cNvL0Ky/2.png"
                        alt="{{ $typeGame->name }}">
                    <div class="hover-content">
                        <p>Grupo</p>
                        <button class="btn btn-primary">Jogar Agora</button>
                    </div>
                </a>
            </div>
            <div class="d-flex p-2 box-imgs">
                <a href="/admin/bets/bichao/milhar/centena" class="hover-container">
                    <img class="img-todos-jogos" style="border-radius:10px;"  src="https://i.ibb.co/yN3GZHt/8.png"
                        alt="{{ $typeGame->name }}">
                    <div class="hover-content">
                        <p>Milhar/Centena</p>
                        <button class="btn btn-primary">Jogar Agora</button>
                    </div>
                </a>
            </div>
            <div class="d-flex p-2 box-imgs">
                <a href="/admin/bets/bichao/terno/dezena" class="hover-container">
                    <img class="img-todos-jogos" style="border-radius:10px;"  src="https://i.ibb.co/wK8SCfb/3.png"
                        alt="{{ $typeGame->name }}">
                    <div class="hover-content">
                        <p>Terno/Dezena</p>
                        <button class="btn btn-primary">Jogar Agora</button>
                    </div>
                </a>
            </div>
            <div class="d-flex p-2 box-imgs">
                <a href="/admin/bets/bichao/duque/dezena" class="hover-container">
                    <img class="img-todos-jogos" style="border-radius:10px;"  src="https://i.ibb.co/984j3Nv/4.png"
                        alt="{{ $typeGame->name }}">
                    <div class="hover-content">
                        <p>Duque/Dezena</p>
                        <button class="btn btn-primary">Jogar Agora</button>
                    </div>
                </a>
            </div>
            <div class="d-flex p-2 box-imgs">
                <a href="/admin/bets/bichao/quina/grupo" class="hover-container">
                    <img class="img-todos-jogos" style="border-radius:10px;"  src="https://i.ibb.co/M6PjL5v/6.png"
                        alt="{{ $typeGame->name }}">
                    <div class="hover-content">
                        <p>Quina/Grupo</p>
                        <button class="btn btn-primary">Jogar Agora</button>
                    </div>
                </a>
            </div>
            <div class="d-flex p-2 box-imgs">
                <a href="/admin/bets/bichao/quadra/grupo" class="hover-container">
                    <img class="img-todos-jogos" style="border-radius:10px;"  src="https://i.ibb.co/N2WD7Pg/7.png"
                        alt="{{ $typeGame->name }}">
                    <div class="hover-content">
                        <p>Quadra/Grupo</p>
                        <button class="btn btn-primary">Jogar Agora</button>
                    </div>
                </a>
            </div>
            <div class="d-flex p-2 box-imgs">
                <a href="/admin/bets/bichao/terno/grupo" class="hover-container">
                    <img class="img-todos-jogos" style="border-radius:10px;"  src="https://i.ibb.co/7yMMg0L/8.png"
                        alt="{{ $typeGame->name }}">
                    <div class="hover-content">
                        <p>Terno/Grupo</p>
                        <button class="btn btn-primary">Jogar Agora</button>
                    </div>
                </a>
            </div>
            <div class="d-flex p-2 box-imgs">
                <a href="/admin/bets/bichao/duque/grupo" class="hover-container">
                    <img class="img-todos-jogos" style="border-radius:10px;"  src="https://i.ibb.co/HdN58PM/9.png"
                        alt="{{ $typeGame->name }}">
                    <div class="hover-content">
                        <p>Duque/Grupo</p>
                        <button class="btn btn-primary">Jogar Agora</button>
                    </div>
                </a>
            </div>
            <div class="d-flex p-2 box-imgs">
                <a href="/admin/bets/bichao/unidade" class="hover-container">
                    <img class="img-todos-jogos" style="border-radius:10px;"  src="https://i.ibb.co/svXBSb3/10.png"
                        alt="{{ $typeGame->name }}">
                    <div class="hover-content">
                        <p>Unidade</p>
                        <button class="btn btn-primary">Jogar Agora</button>
                    </div>
                </a>
            </div>
            <p>
            <div class="collapse" id="collapseExampleddd">
                <div class="d-flex">
                <div class="d-flex p-2 box-imgs">
                <a href="/admin/bets/bichao/milhar/invertida" class="hover-container">
                    <img class="img-todos-jogos" style="border-radius:10px;"  src="https://i.ibb.co/RH22Q2X/11.png"
                        alt="{{ $typeGame->name }}">
                    <div class="hover-content">
                        <p>Milhar/Inverida</p>
                        <button class="btn btn-primary">Jogar Agora</button>
                    </div>
                </a>
            </div> <div class="d-flex p-2 box-imgs">
                <a href="/admin/bets/bichao/centena/invertida" class="hover-container">
                    <img class="img-todos-jogos" style="border-radius:10px;"  src="https://i.ibb.co/nssBBTy/12.png"
                        alt="{{ $typeGame->name }}">
                    <div class="hover-content">
                        <p>Centena/Invertida</p>
                        <button class="btn btn-primary">Jogar Agora</button>
                    </div>
                </a>
            </div>
                </div>
            </div>

            </p>
        </div>
     
        </div>
       
    </div>


    

</div>

</div>





@endsection

@push('styles')
<style>
    .login100-form-btn {
        border-radius: 20px;
        padding: 10px;
        border: none;
        width: 100%;
        background: #9FD214;
        color: #212425;
        font-weight: 700;
    }

    .login100-form-btn:hover {
        background: #212425;
        color: #9FD214;
        font-weight: 700;
        border: 1px solid #9FD214;
    }
</style>
<style>
    .modal-content {
        background-color: #212425;
    }

    .img-bold {

        width: 100%;
        max-width: 50px;
        position: relative;
        z-index: 1;
        transition: .2s;
    }

    .img-bold:hover {
        max-width: 60px;

    }

    .txtnav {
        font-weight: bold;
        text-align: center;
        font-size: 14px;
    }

    .icon-container {
        position: relative;
        display: inline-block;
        padding: 20px;
    }

    .icon-container:after {
        content: "";
        position: absolute;
        border-radius: 50%;
        width: 80px;
        height: 80px;
        background: #A3D712;
        opacity: 0.15;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: -1;
    }

    .icon-container:hover:after {
        background-color: #bcff00;
    }

    @media screen and (max-width: 992px) {
        .img-bold {

            max-width: 35px;
        }

        .txtnav {
            font-size: 12px;
        }

        .icon-container:after {

            width: 60px;
            height: 60px;

        }

        .img-bold:hover {
            max-width: 40px;

        }


        .card-indica h5 {
            font-size: 15px;
        }

        .icon-copy {
            font-size: 25px;
            color: #A3D712;
        }


        .hover-content {
            padding: 10px !important;
        }

        .hover-content p {
            font-size: 10px;

        }

        .hover-content button {
            font-size: 10px;
            padding: 5px;

        }

    }

    *:focus {
        outline: none;
    }

    .link_copy_link {
        width: 100%;
        padding: .5em 0 .5em 0;
        border: 1px solid #007bff;
        font-size: 24px;
        text-align: center;
    }

    .link_copy_link:active,
    .link_copy_link:focus,
    .link_copy_link:focus-visible {
        border: 1px solid #00c054 !important;
    }

    .bg-light-2 {
        background-color: #f8f9fa !important;
    }

    .indica-corpo {
        padding: 35px;
    }

    .mensagem {
        color: #000;
        font-size: 10px;
        text-align: center;
        margin-top: 10px;
    }

    .hover-container {
        position: relative;
    }

    .hover-content {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        text-align: center;
        display: none;
        background-color: rgba(0, 0, 0, 0.7);
        padding: 20px;
        border-radius: 10px;
        color: #fff;
        box-sizing: border-box;
    }

    .hover-container:hover .hover-content {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .hover-content p {

        font-weight: 700;

    }

    .hover-button {
        padding: 10px;
        background-color: #3498db;
        color: #fff;
        border: none;
        cursor: pointer;
    }


    @media screen and (max-width: 600px) {
        .faixa-jogos {
            background: url(https://superlotogiro.com/images/super-lotogiro01.jpg) auto;
            background-position: center;
        }


        .btn {
            padding: 10px;

        }

        .indica-corpo {
            padding: 0px;
        }

        .layout-fixed .main-sidebar {
            top: 56px;
        }
    }

    @media screen and (max-width: 1400px) {
        .hover-content {
            padding: 10px !important;
        }

        .hover-content p {
            font-size: 12px;

        }

        .hover-content button {
            font-size: 10px;
            padding: 5px;

        }
    }
</style>
@endpush

@push('scripts')


<script>
    document.addEventListener('DOMContentLoaded', function () {
        var button = document.querySelector('.btn-collapse');
        button.addEventListener('click', function () {
            if (button.innerText === 'Ver Mais') {
                button.innerText = 'Ver Menos';
            } else {
                button.innerText = 'Ver Mais';
            }
        });
    });
</script>
<script>


    $(document).ready(function () {
        $('.category-info').click(function () {
            var typeGameId = $(this).data('type-game-id');
            var categoriesContainer = $('#categories-container');

            // Verifica se o container está visível
            if (categoriesContainer.is(':visible') && categoriesContainer.data('type-game-id') === typeGameId) {
                // Se estiver visível e clicando no mesmo typeGameId, oculta o container
                categoriesContainer.hide();
            } else {
                // Faz uma requisição AJAX para obter as categorias
                $.ajax({
                    url: '/admin/categoria/' + typeGameId,
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

                // Mostra o container
                categoriesContainer.show();
            }
        });

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


        @if (session('error') || session('erro') || $errors -> has('email') || $errors -> has('password'))
            $('#exampleModalCenter').modal('show');
        @endif


        @if (!auth() -> check())
            $('a:not(.login, .nott), button:not(.btn-side,.login,.nott)').on('click', function (event) {
                // Se não estiver autenticado, abre o modal
                event.preventDefault();
                $('#exampleModalCenter').modal('show');
            });
        @endif






    });




</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="text/javascript">

</script>
@endpush