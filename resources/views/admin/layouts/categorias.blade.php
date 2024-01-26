@if(\App\Models\TypeGame::count() > 0)
<div class="container  mt-5">
    <div class="d-flex swipe-controles align-items-center mb-2">
        <div class="d-flex flex-column">
            <div class="d-flex ">
                <h1 style="color:white">Sua pesquisa:</h1>


                <svg width="10" class="ml-3 mr-3 swiper-pesquisa-prev swp" fill="#5A6268" color="#5A6268"
                    data-v-3d6f2aec="" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                    <path fill="currentColor"
                        d="M41.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.3 256 246.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z">
                    </path>
                </svg>
                <svg width="10" class="swiper-pesquisa-next swp" fill="#5A6268" color="#5A6268" data-v-3d6f2aec=""
                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                    <path fill="currentColor"
                        d="M278.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-160 160c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L210.7 256 73.4 118.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l160 160z">
                    </path>
                </svg>
            </div>
            <div>
                <p id="nome_pesq">aaaaa</p>
            </div>
        </div>
    </div>

    <div class="swiper-pesquisa">
        <div class="swiper-wrapper">
            @foreach($typeGames as $typeGame)
            <div class="swiper-slide">
                <a href="{{ route('admin.bets.games.create', ['type_game' => $typeGame->id]) }}"
                    class="hover-container pesq">
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


<script>
    var swiperpesquisa = new Swiper('.swiper-pesquisa', {
        slidesPerView: 3,
        navigation: {
            nextEl: '.swiper-pesquisa-next',
            prevEl: '.swiper-pesquisa-prev',
        },
        breakpoints: {
            768: {
                slidesPerView: 6, // Altere para o número desejado em telas mobile
            }
        }
    });




    // Obtém a URL atual da página
    var currentUrl = window.location.href;
    // Verifica se a URL contém "/admin/home"
    if (!currentUrl.includes('/admin/home')) {
        $('.pesq').on('click', function (event) {
            console.log('category');
            // Se não estiver autenticado, abre o modal
            event.preventDefault();
            $('#exampleModalCenter').modal('show');
        });
    } 

</script>