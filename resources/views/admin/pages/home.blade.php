@extends('admin.layouts.master')

@section('title', trans('admin.dashboard.page-title'))

@section('content')
<div class="row bg-cc p-2 p-md-5">

    {{-- caso o cliente seja cambista --}}
    @if($User['type_client'] == 1)
    <div class="card-deck" style="width: 100%; margin-bottom: 30px; margin-left: auto;
                margin-right: auto">

        <div class="card text-white bg-success mb-6">
            <div class="card-body">
                <h5 class="card-title text-bold">{{ trans('admin.dashboard.games-done-title') }}</h5>
                <i class="nav-icon fas fa-chart-line" style="float: right; font-size: 50px"></i>
                <p class="card-text">{{ $JogosFeitos }}</p>
            </div>
        </div>
        <div class="card text-white bg-danger mb-6" style="">
            <div class="card-body text-bold">
                <h5 class="card-title">{{ trans('admin.dashboard.balance-title') }}</h5> <i
                    class="nav-icon fas fa-chart-line" style="float: right; font-size: 50px"></i>
                <p class="card-text">R${{ $saldo }}</p>
            </div>
        </div>
    </div>
</div>
@endif

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
                <img class="d-block w-100" src="{{ url("storage/{$item['url']}") }}" alt="{{ $item['nome'] }}"
                    style="object-fit: cover;">
            </div>
            @endif
            @endforeach
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>




</div>
<div class="container mt-2">
    <div class="d-flex swipe-controles align-items-center">
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

    <!-- Nav icons -->

   <!-- Conteúdo da sua view existente -->
<div class="swiperroll p-2">
    <div class="swiper-wrapper">
        <!-- {{$TypeGamesRoll}} -->
        @foreach($TypeGamesRoll as $typeGame)
            <div class="swiper-slide d-flex flex-column category-info" data-type-game-id="{{ $typeGame->category }}"style="">
                    <div class="icon-container">
                        <img class="img-bold" src="/storage/{{str_replace('.png', '-bold.png', $typeGame->icon)}}" alt="">
                    </div>
                <div>
                    <p class="txtnav">{{ ucwords(str_replace('_', ' ', $typeGame->category)) }}</p>
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
    @if(\App\Models\TypeGame::where('recomendado', 1)->count() > 0)
    <div class="swiper">
        <div class="swiper-wrapper">
            @foreach(\App\Models\TypeGame::where('recomendado', 1)->get() as $typeGame)
                <div class="swiper-slide">
                <a href="{{route('admin.bets.games.create', ['type_game' => $typeGame->id])}}">

                    <img src="{{ url("storage/{$typeGame->banner_pc}")}}" alt="{{ $typeGame->name }}" class="d-none d-md-block">
                    <img src="{{ url("storage/{$typeGame->banner_mobile}")}}" alt="{{ $typeGame->name }}" class="d-md-none">
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
        <svg width="10" class="ml-3 mr-3 swiper-list-prev swp" fill="#5A6268" color="#5A6268" data-v-3d6f2aec=""
            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
            <path fill="currentColor"
                d="M41.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.3 256 246.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z">
            </path>
        </svg>
        <svg width="10" class="swiper-list-next swp" fill="#5A6268" color="#5A6268" data-v-3d6f2aec=""
            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
            <path fill="currentColor"
                d="M278.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-160 160c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L210.7 256 73.4 118.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l160 160z">
            </path>
        </svg>
    </div>

    <div class="swiper-list swiper-full">
        <div class="swiper-wrapper">
            @foreach(\App\Models\TypeGame::get() as $typeGame)
            <div class="swiper-slide">
                <a href="{{ route('admin.bets.games.create', ['type_game' => $typeGame->id]) }}"
                    class="hover-container">
                    <img src="{{ url("storage/{$typeGame->banner_mobile}")}}" alt="{{ $typeGame->name }}">
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


<!-- Bichao da sorte -->

@if(\App\Models\TypeGame::count() > 0)
<div class="container mt-5">
    <div class="d-flex swipe-controles align-items-center mb-2">
        <h1 style="color:white">Bichão da Sorte</h1>
        <svg width="10" class="ml-3 mr-3 swiper-bichao-prev swp" fill="#5A6268" color="#5A6268" data-v-3d6f2aec=""
            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
            <path fill="currentColor"
                d="M41.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.3 256 246.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z">
            </path>
        </svg>
        <svg width="10" class="swiper-bichao-next swp" fill="#5A6268" color="#5A6268" data-v-3d6f2aec=""
            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
            <path fill="currentColor"
                d="M278.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-160 160c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L210.7 256 73.4 118.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l160 160z">
            </path>
        </svg>
    </div>

    <div class="swiper-bichao">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <a href="/admin/bets/bichao"
                    class="hover-container">
                    <img src="https://imagedelivery.net/BgH9d8bzsn4n0yijn4h7IQ/3deaeed0-dbf3-4064-ada6-00ed81a72d00/ipad" alt="{{ $typeGame->name }}">
                    <div class="hover-content">
                        <p>Milhar</p>
                        <button class="btn btn-primary">Jogar Agora</button>
                    </div>
                </a>
            </div>
            <div class="swiper-slide">
                <a href="/admin/bets/bichao/centena"
                    class="hover-container">
                    <img src="https://imagedelivery.net/BgH9d8bzsn4n0yijn4h7IQ/3deaeed0-dbf3-4064-ada6-00ed81a72d00/ipad" alt="{{ $typeGame->name }}">
                    <div class="hover-content">
                        <p>Centena</p>
                        <button class="btn btn-primary">Jogar Agora</button>
                    </div>
                </a>
            </div>
            <div class="swiper-slide">
                <a href="/admin/bets/bichao/dezena"
                    class="hover-container">
                    <img src="https://imagedelivery.net/BgH9d8bzsn4n0yijn4h7IQ/3deaeed0-dbf3-4064-ada6-00ed81a72d00/ipad" alt="{{ $typeGame->name }}">
                    <div class="hover-content">
                        <p>Dezena</p>
                        <button class="btn btn-primary">Jogar Agora</button>
                    </div>
                </a>
            </div>
            <div class="swiper-slide">
                <a href="/admin/bets/bichao/group"
                    class="hover-container">
                    <img src="https://imagedelivery.net/BgH9d8bzsn4n0yijn4h7IQ/3deaeed0-dbf3-4064-ada6-00ed81a72d00/ipad" alt="{{ $typeGame->name }}">
                    <div class="hover-content">
                        <p>Grupo</p>
                        <button class="btn btn-primary">Jogar Agora</button>
                    </div>
                </a>
            </div>

        </div>
    </div>
</div>
@endif

<div class="col-md-12 p-4">
    <div class="card w-100">
        <div class="card-header indica-card">
            {{ trans('admin.pagesF.indicacoes') }}
        </div>
        <div class="container">
            <div class="row">
                @if($User['type_client'] != 1)
                <div class="card-body col-lg-12 col-sm-12">
                    <div class="col-lg-12 my-2 ">
                        <div class="form-group">
                            <input type="text" class="form-control" id="link_copy"
                                value="{{route('games.bet', ['user' => auth()->id()])}}">
                        </div>
                    </div>
                </div>
                @endif
                <!-- button indique e ganhe -->
                @if($User['type_client'] == 1)
                <div class="card-body   col-lg-4 col-sm-6 mx-auto">
                    <div class="col-lg-12 card text-white   my-2 alert bg-light indica-corpo text-center" role="alert">
                        <input id="linkDeIndicacao" style="display:none;" type="text" readonly class="link_copy_link "
                            value="{{ env('APP_URL') }}/admin/indicate/{{ auth()->user()->indicador}}" />
                        <p class="mensagem">{{ trans('admin.dashboard.referral-message') }}</p>
                        <button type="button" id="btn_copy_link2" class="btn btn-success btn-block"
                            onclick="CopyMe(getUrl())"> {{ trans('admin.dashboard.referral-button-text-client') }}
                        </button>
                    </div>
                </div>
                @elseif($User['type_client'] != 1)
                <div class="card-body   col-lg-4 col-sm-6">
                    <div class="col-lg-12 card text-white   my-2 alert bg-light indica-corpo" role="alert">
                        <input id="linkDeIndicacao" style="display:none;" type="text" readonly class="link_copy_link "
                            value="{{ env('APP_URL') }}/admin/indicate/{{ auth()->user()->id }}" />
                        <p class="mensagem">{{ trans('admin.dashboard.referral-message') }}</p>
                        <button type="button" id="btn_copy_link2" class="btn btn-success btn-block"
                            onclick="CopyMe(getUrl())"><i class="bi bi-coin"></i> {{
                            trans('admin.dashboard.referral-button-text') }} </button>
                    </div>
                </div>
                @endif

                <!-- button copiar link  -->
                @if($User['type_client'] == 1)
                <div class="card-body col-lg-4 col-sm-5">
                </div>
                @elseif($User['type_client'] != 1)
                <div class="card-body col-lg-4 col-sm-5">
                    <div class="col-lg-12 card text-white my-2 alert bg-light indica-corpo" style="float:left;">
                        <p class="mensagem">{{ trans('admin.dashboard.copy-link-message') }}</p>
                        <button type="button" id="btn_copy_link" class="btn btn-info btn-block">{{
                            trans('admin.copy-link-button') }}</button>
                    </div>
                </div>
                @endif

                <!-- button seus indicados -->
                <div class="card-body col-lg-4 col-sm-6">
                    <div class="col-lg-12 card text-white my-2 indica-corpo bg-light-2" style="color: #fff;"
                        role="alert">
                        <p class="mensagem">{{ trans('admin.dashboard.referrals-message') }}</p>
                        <a href="{{ route('admin.settings.users.indicated') }}" class="btn btn-block btn-info">
                            {{ trans('admin.dashboard.referrals-button') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>





@endsection

@push('styles')
<style>
    .img-bold{
        
        width: 100%;
        max-width:50px;
         position: relative;
          z-index: 1;
          transition: .2s;
    }
    .img-bold:hover{
        max-width:60px;

    }

    .txtnav{
        font-weight:bold;text-align:center ;font-size:14px;
    }
    .icon-container {
        position: relative;
        display: inline-block;
        padding:20px;
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
        .img-bold{
        
            max-width:35px;
    } 
    .txtnav{
        font-size:12px;
    }
    .icon-container:after {
      
        width: 60px;
        height: 60px;
     
    }
    .img-bold:hover{
        max-width:40px;

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
    }
</style>
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
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


});


   

</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="text/javascript">
    const copiedUrlText = "{{ trans('admin.dashboard.copied-url') }}";

    $('#btn_copy_link').clic k(function () {
        var link = document.getElementById("link_copy");
        link.select();
        document.execCommand('copy');
        Swal.fire(
            copiedUrlText,
            '',
            'success'
        );
    });

    function CopyMe(TextToCopy) {
        var TempText = document.createElement("input");
        TempText.value = TextToCopy;
        document.body.appendChild(TempText);
        TempText.select();

        document.execCommand("copy");
        document.body.removeChild(TempText);
        Swal.fire(
            copiedUrlText,
            '',
            'success'
        );
    };

    function getUrl() {
        return document.getElementById("linkDeIndicacao").value;
    };

    (function () {
        function copy(element) {
            ret urn function () {
                document.execCommand('copy', false, element.select());
            };
        };

        var linkIndicate = document.querySelector('.link_copy_link');
        var copyUrlIndicate = copy(linkIndicate);
        linkIndicate.addEventListener('click', copyUrlIndicate, false);));
</script>
@endpush