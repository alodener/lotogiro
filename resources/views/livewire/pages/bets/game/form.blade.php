<div>
    <div class="divider mt-2"></div>

    <div class="d-flex flex-md-row flex-column-reverse mt-2">
        {{-- CARD 1 --}}
        <div class="d-md-none d-flex funtions-mobile">
            <div class="col-md-6 justify-content-center align-items-center text-center">
                <div class="d-flex card-header container justify-content-center align-items-center"
                    style="min-height: 62px;">
                    <div class="d-flex card-acoes">
                        <button data-toggle="modal" data-target="#ModalResultados" class="btn-copiacola "
                            style="background: #212425;"><i class="fa fa-trophy mr-2" style="font-size: 15px;"
                                aria-hidden="true"></i>
                            Ultimos Resultados</button> <button data-toggle="modal" data-target="#exampleModal"
                            class="btn-copiacola btn-divisor"><i class="fa fa-money mr-2" style="font-size: 15px;"
                                aria-hidden="true"></i>
                            Ver Cotação</button>
                        <a 
                            class="btn btn-copiacola" id="openModalButton2" data-toggle="modal" onclick="lockmodal()" data-target="#ModalCopiacola"><i class="fa fa-ticket mr-2" style="font-size: 15px;"
                                aria-hidden="true"></i>
                            Copia e Cola</a>
                    </div>
                </div>

            </div>
        </div>
        {{-- PARTE DE CALCULO DE VALORES DO JOGO --}}
        @if(isset($values) && $values->count() > 0)
        @foreach($values as $value)
        <input type="text" id="multiplicador" value="{{$value->multiplicador}}" name="multiplicador" hidden>
        <input type="text" id="maxreais" value="{{$value->maxreais}}" name="maxreais" hidden>
        <input type="text" id="valueId" value="{{$value->id}}" name="valueId" hidden>
        <div class="d-flex flex-column col-md-4">
            <div class="card-header text-center d-flex flex-column justify-content-center align-items-center"
                style="min-height: 162px;">
                <h5 style="font-weight: bold;" class="textcard">{{ trans('admin.falta.digitValor') }}</h5>
                <input class="form-control" style="text-align:center;" type="text" id="value" onchange="altera()"
                    value="" name="value" value="{{ old('value') ?? session('value') }}" required
                    oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');">
                <div class="d-flex cardbtsadd container justify-content-around align-items-center mt-2">
                    <p style="font-size:10px; margin:0px;">Valores Rápidos:</p>
                    <div class="d-flex">
                    <button class="btn-add-value-extra" onclick="addmoney(event,1)">+ R$ 1,00</button>
                    <button class="btn-add-value-extra mr-1 ml-1" onclick="addmoney(event,5)">+ R$ 5,00</button>
                    <button class="btn-add-value-extra" onclick="addmoney(event,10)">+ R$ 10,00</button>
                </div>
                </div>
            </div>
            <div class="d-flex card-header flex-column justify-content-center align-items-center"
                style="min-height: 62px;">
                <h5 style="font-weight: bold; font-size:15px; min-width:150px; margin:0px;">Premiação Total</h5>
                <input class="form-control" type="text" id="premio" value="" name="premio" readonly>
            </div>
        </div>
        <!-- <button  class="btn btn-info" type="button" onclick="altera();">{{ trans('admin.falta.calcular') }}</button> -->
        @endforeach
        @else

        @endif

        

        {{-- CARD 2 --}}

        <div class="col-md-4 justify-content-center align-items-center text-center">
            <div class="card-header automatic-bet d-flex flex-column justify-content-center align-items-center "
                style="min-height: 162px;">
                <h5 style="font-weight: bold;" class="textcard"> Gerar Jogo Aleatório </h5>
                {{-- puxar do banco de dados quantos numeros pode se jogar --}}
                <div>
                    @foreach ($busca as $buscas)

                    <button style="margin-top: 1%" wire:click="randomNumbers({{ $buscas['numbers'] }})"
                        class="{{ env('randomNumbersColor') }}" type="button" onclick="limpacampos();">{{
                        $buscas['numbers']
                        }}</button>
                    @endforeach
                </div>
            </div>
            <div class="d-none d-md-flex  card-header flex-column justify-content-center align-items-center"
                style="min-height: 62px;">
                <h5 style="font-weight: bold; font-size:15px; min-width:150px; margin:0px;" class="mb-1">Multiplos Jogos
                </h5>
                <a 
                    class="btn btn-copiacola" id="openModalButton" onclick="lockmodal()" data-toggle="modal" data-target="#ModalCopiacola"><i class="fa fa-ticket mr-2" style="font-size: 15px;"
                        aria-hidden="true"></i>
                    Copia e Cola</a>
            </div>
        </div>
        {{-- CARD 3 --}}

        <div class="col-md-4 flex-column d-flex  align-items-center text-center">
            <div class="card-header container" style="min-height: 162px;">
                @if($User['type_client'] == 1)

                <input type="text" value="{{ $FiltroUser['name'] }}" disabled class="form-control">
                <input type="hidden" name="client" value="{{ $FiltroUser['id'] }}" readonly>
                <input type="hidden" name="type_client" value="{{ $User['type_client'] }}" readonly>
                @endif


                @if($User['type_client'] == 1)
                <input type="hidden" name="numbers" id="numbers"
                    value="@foreach ($selectedNumbers as $selectedNumbers1) {{ $selectedNumbers1 }} @endforeach"
                    readonly>
                <input type="hidden" class="form-control" id="type_game" name="type_game" value="{{$typeGame->id}}"
                    readonly>
                @endif

                @if($User['type_client'] == null)

                {{-- INPUT DO SEARCH SE NÃO TIVER AUTENTICADO --}}

                <div class="form-row">
                    <div class="form-group col-md-12">
                        <div wire:ignore>
                            <div class="mt-3">
                                <h5 style="font-weight: bold;" class="textcard">Selecione o Cliente
                                </h5>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="input-group mb-3">
                                    <input wire:model="search" type="text" id="author" class="form-control"
                                        placeholder="Pesquisar Cliente" autocomplete="off" required>
                                    <div class="input-group-append">
                                        <span wire:click="clearUser" class="input-group-text" title="Limpar"><i
                                                class="fas fa-user-times"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- PARTE DE PESQUISA DE CLIENTE SE NÃO TIVER AUTENTICAÇÃO --}}

                        <input type="hidden" name="client" value="{{$clientId}}">

                        <input type="hidden" name="numbers" id="numbers"
                            value="@foreach ($selectedNumbers as $selectedNumbers1) {{ $selectedNumbers1 }} @endforeach"
                            readonly>
                    </div>
                    <input type="hidden" class="form-control" id="type_game" name="type_game" value="{{$typeGame->id}}"
                        readonly>
                </div>

                @endif
            </div>
            <div class="d-none d-md-flex card-header flex-column container justify-content-center align-items-center "
                style="min-height: 62px;">
                <h5 style="font-weight: bold; font-size:15px; margin:0px; " class="mb-1">Consultar</h5>
                <div class="d-flex btsconsultar ">
                    <button data-toggle="modal" data-target="#ModalResultados" class="btn-copiacola mr-2 ml-2"
                        style="background: #212425;"><i class="fa fa-trophy mr-2" style="font-size: 15px;"
                            aria-hidden="true"></i>
                        Ultimos Resultados</button> <button data-toggle="modal" data-target="#exampleModal"
                        class="btn-copiacola"><i class="fa fa-money mr-2" style="font-size: 15px;"
                            aria-hidden="true"></i>
                        Ver Cotação</button>
                </div>
            </div>
        </div>
        
        
    </div>
    <div class="divider"></div>
    <div class="row mb-3" id="list_group" style="max-height: 100px; overflow-y: auto">
        <div class="col-md-12">
            @if($showList)
            <ul class="list-group">
                @if(isset($clients) && $clients->count() > 0)
                @foreach($clients as $client)
                <li wire:click="setId({{ $client }})" class="list-group-item" style="cursor:pointer;">{{
                    $client->name . ' ' . $client->last_name .' - '. $client->email . ' - '.
                    \App\Helper\Mask::addMaksPhone($client->ddd.$client->phone)}} </li>
                @endforeach
                @endif
            </ul>
            @endif
        </div>
    </div>
    {{-- PARTE DE ESCOLHER NUMEROS DO JOGO --}}
    <div class="row text-center">
        <div class="col-md-12">
            @if(isset($matriz))
            <div class="d-flex container-fluid justify-content-between align-items-center card-comands-pc">
                <button class="btn btn-block btn-success btn-comandos" >Completar Jogo</button>
                <h4 style="background:#303536; padding:10px; border-radius:100px;" class="numselecteds textbtnresponsive">{{
                    trans('admin.falta.quantSelec')
                    }}:<c style="color:#96C614;">({{count($selectedNumbers)}}/{{$numbers}})</c>
                </h4>
                @if($typeGame->name == "SLG - 15 Lotofácil" || $typeGame->name == "SLG - 20 LotoMania" ||
                $typeGame->name ==
                "Lotogiro - 1000X Lotofácil" || $typeGame->name == "ACUMULADO 15 lotofacil")
                <button wire:click="selecionaTudo()" class="{{ env('AllColor') }}" type="button"
                    onclick="limpacampos();">{{
                    trans('admin.falta.selecNums') }}</button>
                @endif
                <button type="submit"  id="button_game"
                    class="btn btn-block btn-success btn-comandos" >Confirmar Aposta
                </button>
            </div>
            <div class="d-flex container-fluid flex-column justify-content-between align-items-center card-comands-mobile">
                <h4 style="background:#303536; padding:10px; border-radius:100px;" class="numselecteds">{{
                    trans('admin.falta.quantSelec')
                    }}:<c style="color:#96C614;">({{count($selectedNumbers)}}/{{$numbers}})</c>
                </h4>
                <div class="d-flex mt-2">
                <button class="btn btn-block btn-success btn-comandos mr-2" >Completar Jogo</button>

                @if($typeGame->name == "SLG - 15 Lotofácil" || $typeGame->name == "SLG - 20 LotoMania" ||
                $typeGame->name ==
                "Lotogiro - 1000X Lotofácil" || $typeGame->name == "ACUMULADO 15 lotofacil")
                <button wire:click="selecionaTudo()" class="{{ env('AllColor') }}" type="button"
                    onclick="limpacampos();">{{
                    trans('admin.falta.selecNums') }}</button>
                @endif
                <button type="submit"  id="button_game"
                    class="btn btn-block btn-success btn-comandos btnprevent"style="margin: 0px;" onclick="submit()">Confirmar Aposta
                </button>
            </div>
            </div>
            <br>





            <div class="table-responsive responsive-bet">
                <table class="table text-center">
                    <tbody>
                        @foreach($matriz as $lines)
                        <tr>
                            @foreach($lines as $cols)
                            <td>
                                <button wire:click="selectNumber({{$cols}})" id="number_{{$cols}}" type="button"
                                    class="btn {{in_array($cols, $selectedNumbers) ? 'btn-beat-number' : 'btn-warning'}} btn-full">{{$cols}}</button>
                            </td>
                            @endforeach
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>
    </div>

</div>


<!-- O modal -->



@push('styles')
<link href="{{asset('admin/layouts/plugins/select2/css/select2.min.css')}}" rel="stylesheet" />
<link href="{{asset('admin/layouts/plugins/select2-bootstrap4-theme/select2-bootstrap4.css')}}" rel="stylesheet" />



@endpush

@push('scripts')

<script src="{{asset('admin/layouts/plugins/select2/js/select2.min.js')}}"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

{{--
<script>
    $(document).ready(function () {
        $('#clients').select2({
            theme: "bootstrap"
        });
        $('#sort_date').inputmask("99/99/9999 99:99:99");
    });
</script> --}}

<script>
    function submit(){
        document.getElementById('form_game').submit();

    }
</script>

<style>
     .numselecteds{
        margin:0px;
     }
     @media (max-width: 500px) {
        .card-comands-pc{
            display: none !important;
        }

        .num-responsive{
            font-size:20px !important;
        }
       
     
    }

    @media (min-width: 500px) {
        .card-comands-mobile{
            display: none !important;
        }
        .numselecteds{
            font-size:20px !important;
        }
        
     
    }
     @media (max-width: 650px) {
        
        .textbtnresponsive{
            font-size:15px !important;
        }

        .btn-comandos {
            max-width: 130px !important;
            font-size: 10px !important;

        }
    } @media (max-width: 550px) {
       
        .btn-comandos {
            max-width: 110px !important;

        }
    }
    .btn-cotacao-download {
        padding: 5px;
        border: none;
        background: gray;
        border-radius: 10px;
        font-size: 12px;
    }

    .btn-comandos{
        max-width: 200px;
    }

    .btn-divisor{
         margin-left: 10px;
         margin-right: 10px;
    }
    
   
    @media (max-width: 1404px) {
        .textcard {
            font-size: 15px;
        }

        .numselecteds {
            font-size: 15px;
        }
        @media (max-width: 1100px) {
            .btn-comandos{
                max-width: 100px;
                font-size: 12px;
            }
    
        }

        @media (max-width: 1200px) {
            .btn-comandos{
                max-width: 150px;
            }
            .cardbtsadd {
                flex-direction: column;
            }

            .btspadding {
                margin-top: 5px !important;
                margin-bottom: 5px !important;
            }

            .btsconsultar {
                flex-direction: column;

            }
        }

    }
    @media (max-width: 465px) {
    .card-acoes{
        flex-direction: column;
    }
    .btn-divisor{
    margin-right: 0px;
    margin-left: 0px;
    margin-top: 10px;
    margin-bottom: 10px;
    }
    }

    .btn-add-value-extra {
        background: #a3d712;
        border: none;
        padding: 5px;
        font-weight: bold;
        color: black;
        font-size: 10px;
    }

    .divider {
        padding: 5px;
        background: #303536;
    }

    .btn-copiacola {
        height: 38px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        background: #B0045B;
        font-size: 10px;
        color: white;
        border: none;
        border-radius: 3px;
    }

    .btn-copiacola:hover {
        color: white;
    }
</style>
<script>
     function submit(){
        document.getElementById('form_game').submit();

    }
    document.addEventListener('DOMContentLoaded', function() {
        // Selecionando todos os botões com a classe 'btnprevent'
        var btnPrevent = document.querySelectorAll('.btnprevent');

        // Adicionando um ouvinte de evento a cada botão
        btnPrevent.forEach(function(btn) {
            btn.addEventListener('click', function(event) {
                // Prevenir o comportamento padrão do botão
                event.preventDefault();
                // Coloque aqui o código que deseja executar ao clicar no botão
            });
        });
    });
        document.addEventListener('DOMContentLoaded', function() {      

       var copiaecolalock = localStorage.getItem('copiaecolalock');
    if (copiaecolalock === "true") {

        var openModalButton = document.getElementById('openModalButton');
        openModalButton.click();

    }
    console.log(copiaecolalock);
});
    function lockmodal(){
    localStorage.setItem('copiaecolalock', true);
}
    //Função para realizar o calculo do multiplicador
    function addmoney(event, v) {
    event.preventDefault(); // Evita o envio do formulário ao clicar no botão
    var campovalor = document.getElementById("value");
    // Converte o valor atual para um número e então realiza a adição
    campovalor.value = Number(campovalor.value) + Number(v);

    altera();
}   
    function altera() {
        var multiplicador = document.getElementById("multiplicador").value;
        var valor = document.getElementById("value").value;
        var Campovalor = document.getElementById("value");
        var campoDoCalculo = document.getElementById("premio");
        var maxreais = document.getElementById("maxreais").value;
        var resultado;
        var numberValor = parseInt(valor);
        var numberReais = parseInt(maxreais);

        //evento dispara quando retira o foco do campo texto
        if(!isNaN(numberValor)){
            if (numberReais >= numberValor) {
            resultado = valor * multiplicador;
            campoDoCalculo.value = resultado;
            } else {
            resultado = maxreais * multiplicador;
            campoDoCalculo.value = resultado;
            Campovalor.value = maxreais;
            }
        }
    }

    function mudarListaNumeros() {
        var input = document.querySelector("#numbers");
        var NovoTexto = input.value;
        console.log(NovoTexto);
        var NovoTexto = NovoTexto.trim();
        var NovoTexto = NovoTexto.split("  ");
        var NovoTexto = NovoTexto.toString();
        console.log(NovoTexto);
        document.getElementById('numbers').value = NovoTexto;

    }

    function mudarListaNumerosGeral() {
        altera();
        mudarListaNumeros();

    }

    function limpacampos() {
        var valor = document.getElementById("value").value;
        var Campovalor = document.getElementById("value");
        var campoDoCalculo = document.getElementById("premio");
        campoDoCalculo.value = "";
        Campovalor.value = "";
    }

</script>

@endpush