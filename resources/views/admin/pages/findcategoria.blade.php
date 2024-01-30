@extends('admin.layouts.master')

@section('title', trans('admin.dashboard.page-title'))

@section('content')
<div class="row bg-cc p-2 p-md-5">


    <!-- Modal LOGIN -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content" style="border-radius:10px;">

                @include('admin.pages.auth.login')


            </div>
        </div>
    </div>


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








    @if(\App\Models\TypeGame::count() > 0)
    <div class="container mt-5">
        <div class="d-flex swipe-controles align-items-center mb-2">
            <h1 style="color:white">Todos os Jogos</h1>

        </div>

        <div class="d-flex flex-wrap">
            @foreach($findcategory as $typeGame)
            <div class="d-flex p-2">
                <a href="{{ route('admin.bets.games.create', ['type_game' => $typeGame->id]) }}"
                    class="hover-container">
                    <img style="border-radius:10px;" src="{{ $typeGame->banner_mobile ? asset("
                        storage/{$typeGame->banner_mobile}") :
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
</div>
@endif




</div>

<div class="justify-content-center d-flex align-items-center">
    <a href="/"><button class="btn-secondary">Voltar</button></a>
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


    $(document).ready(function () {
        $('.category-info').clicon () {
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