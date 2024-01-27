<nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
    <div class="container">
        <a href="#" class="navbar-brand">

            <img src="{{ App\Helper\Configs::getConfigLogo() }}" alt="Logo" class="brand-image  rounded-circle"
                style="height: 50px">
        </a>
        <div class="d-flex align-items-center">

            @if(!empty($bet->client->name))
            {{$bet->client->name}} {{$bet->client->last_name}}

            @if($bet->botao_finalizar != 3)

            <button type="button" class="btn btn-primary ml-4" data-toggle="modal" data-target="#exampleModalCenter">
                Finalizar Aposta</button>
            @endif
            @endif




        </div>
    </div>

</nav>