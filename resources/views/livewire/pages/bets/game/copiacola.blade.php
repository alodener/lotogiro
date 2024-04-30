<div>
    @if($User['type_client'] == null)


    <div class="container" style="padding:0px;">
        <img src="https://ambientedev.loteriabr.com/storage/banner_resultados/JGxuSQmnlEtd1EL6wsOs4IyfIcfiplJ2JuHxfBlm.jpg"
            style="width:100%;max-height:150px;">
    </div>
    <div class="alert container text-center alert-primary mt-2" role="alert">
        Para importar os jogos, é só colar cada jogo em uma linha. Você pode separar as dezenas com um dos
                caracteres:<br> (-.,_ ) Exemplo:
                 1-2-3-4-5 // 1.2.3.4.5 // 1 2 3 4 5 //
      </div>
      @if(!@empty($msg))

      <div class="alert container alert-danger mt-2" role="alert">
{{$msg}}
      </div>
      @endif
    <div class="d-flex justify-content-center flex-md-row flex-column align-items-start container" style="padding: 0px;">
        <div class="container col-md-6 ">
            <div class="card-header card-copiacola text-center d-flex justify-content-around align-items-center">
                <h3 class="card-title2" style="font-weight: bold; text-transform:uppercase;">
                    {{$typeGame->name}}</h3>
                <h4 class="card-title2">Tipo: {{$typeGame->name}}</h4>
                <h4 class="card-title2">Concurso: {{$typeGame->competitions->last()->number}}
                </h4>
                <h4 class="card-title2">Data do Sorteio:
                    {{\Carbon\Carbon::parse($typeGame->competitions->last()->sort_date)->format('d/m/Y H:i:s')}}
                </h4>
            </div>
            <div>
                <div class="head-textarea">
                    <p>Denezas</p>
                </div>
                <div class="textarea-container d-flex">
                    <div class="line-numbers" id="line-numbers"></div>
                    <input type="hidden" name="dezena">
                     <input type="hidden" name="controle" id="controle" value="{{$controle}}">
                <input type="hidden" class="form-control" id="type_game" name="type_game" value="{{$typeGame->id}}">
                <input hidden value="1" id="xml" name="xml">
                <input type="hidden" name="dezena">
                <input type="hidden" name="qtdDezena" value="{{$qtdDezena}}">
                    <textarea wire:model="dezena" class="textarea" id="dezena" name="dezena" oninput="updateLineNumbers()"></textarea>
                </div>
                <div class="head-textarea mt-2">
                    <div class="d-flex flex-column buttons-box-textarea ml-2 ">

                        <div class="container">
                            <button  wire:click="dezenas" style="background:#B0045B; width:100%; " class="btnprevent">Computar</button>
                        </div>
                    </div>
                </div>
                <div class="footer-textarea d-flex">
                    <div class="d-flex">
                        <div class="d-flex align-items-center justify-content-center box-textarea mr-2 aj">
                            <h1>Jogos Contabilizados:</h1>
                            <p>{{$contadorJogos}}</p>
                        </div>
                        <div class="d-flex align-items-center justify-content-center box-textarea aj">
                            <h1>Aposta Total:</h1>
                            <p class="valueaposta">R$:0,00</p>
                        </div>
                    </div>
                    <div class="d-flex flex-column buttons-box-textarea ml-2 ">
                        <div>
                            <button style="background:#8C52FF; " class="mb-2">Correção Mágica</button>
                        </div>
                        <div>
                            <button style="background:#B0045B;" class="btnprevent" onclick="limparlista()">Limpar Lista</button>
                        </div>
                    </div>

                </div>
            </div>
            <div class="d-flex justify-content-center align-items-center">
                <div class="card-header col-md-6 d-flex align-items-center justify-content-center box-textarea-infos">
                    <h1>Valor da Aposta:</h1>
                    <input type="text" id="value" class="form-control" onchange="altera();" value="" name="value"
                         oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');
                             var valor = document.getElementById('value').value;
                             var contadorJogos = document.getElementById('contadorJogos').value;
                             var contadorJogos =  parseFloat(contadorJogos);
                             var numberValor = parseFloat(valor);
                             var valorTotal = contadorJogos * numberValor;
                             document.getElementById('ValorTotal').value = valorTotal.toFixed(2);
                             var premioEstimadoElement = document.getElementById('premioestimado');
                             if (!isNaN(numberValor)) {
                                 premioEstimadoElement.innerHTML = valorTotal.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
                             } else {
                                 premioEstimadoElement.innerHTML = '';
                             }
             
                             var elements = document.getElementsByClassName('valueaposta');
                             for(var i = 0; i < elements.length; i++) {
                                 if (!isNaN(numberValor)) {
                                     elements[i].innerHTML = numberValor.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
                                 } else {
                                     elements[i].innerHTML = '';
                                 }
                             }">
                </div>
                <div class="card-header col-md-6 d-flex align-items-center justify-content-center box-textarea-infos">
                    <h1>Saldo da Carteira:</h1>
                    <p>R$:274,00</p>
                </div>
            </div>

            <div class="card-header d-flex col-md-12 searchcard">
                <div class="col-md-4">
                    <h1>Saldo da Carteira:</h1>
                </div>
                <div class="col-md-8 input-group mb-3">
                    <input wire:model="search" type="text" id="author" class="form-control"
                        placeholder="{{ trans('admin.search-customer') }}" autocomplete="off" >

                    <div class="input-group-append">
                        <span wire:click="clearUser" class="input-group-text" title="{{ trans('admin.clear') }}"><i
                                class="fas fa-user-times"></i></span>
                    </div>
                </div>
            </div>

        </div>
        <div class="text-center d-flex justify-content-around align-items-start container col-md-6 ">
            <div class="container" style="padding: 0px;">
                <div class="d-flex card-header  container justify-content-center align-items-center "
                    style="min-height: 62px;">
                    <h5 style="font-weight: bold; font-size:15px; margin:0px; " class="mr-4">Resultados e Cotações</h5>
                    <div class="d-flex btsconsultar ">
                        <button data-toggle="modal" data-target="#ModalResultados" class="btn-copiacola  btnprevent"
                            style="background: #212425;"><i class="fa fa-trophy mr-2" style="font-size: 15px;"
                                aria-hidden="true"></i>
                            Ultimos Resultados</button> <button data-toggle="modal" data-target="#exampleModal"
                            class="btn-copiacola btnprevent"><i class="fa fa-money mr-2" style="font-size: 15px;"
                                aria-hidden="true"></i>
                            Ver Cotação</button>
                    </div>
                </div>
                <div class="textarea-container d-flex">
                    <div class="line-numbers boxbig" id="line-numbers1"></div>
                    <div class="line-numbers" id="line-numbers2" style="overflow: auto;"></div>
                    <div class="d-flex flex-column">
                        <!-- Valores serão inseridos automaticamente aqui -->
                    </div>
                </div>
                <div class="footer-textarea d-flex flex-column">
                    <div class="d-flex">
                        <div class="d-flex align-items-center justify-content-center box-textarea aj">
                            <h1>Aposta:</h1>
                            <p class="valueaposta">R$:0,00</p>
                        </div>
                        <div class="d-flex align-items-center justify-content-center box-textarea  mr-2 ml-2 aj">
                            <h1>Jogos contabilizados:</h1>
                            <p>{{$contadorJogos}}</p>
                        </div>
                        <div class="d-flex align-items-center justify-content-center box-textarea aj">
                            <h1>Aposta total</h1>
                            <p class="valueaposta">R$:0,00</p>
                        </div>
                    </div>
                    <div>
                    </div>


                </div>
                <div class="footer-textarea d-flex ">
                    <div class="card-header col-md-8 d-flex align-items-center justify-content-center box-textarea"
                        style="background: #212425 !important; margin-bottom:0px;">
                        <h1>Premiação Total Estimada</h1>
                        <p id="premioestimado">R$:0,00</p>
                    </div>
                    <div class="col-md-4">
                        @if($podeCriar && empty($msg) && $search)
                <button type="submit" id="submit_game" class="padraobtn btnprevent mr-2 ml-2" onclick="submit();" style="background: #00A651;">
                    Confirmar Aposta</button>
                    
                    @else
                    <button class="padraobtn btnprevent mr-2 ml-2"  disabled style="background: gray; color: black !important;">Confirmar Aposta</button>

                @endif
                       
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mx-auto container text-center col-md-12" @if($showList) style="border: 2px solid #323637;" @endif>

       
        <input type="hidden" name="client" value="{{$clientId}}">
        <input type="hidden" name="type_client" value="{{ $User['type_client'] }}" readonly>
        <div class="row mb-3 container mx-auto" id="list_group" style="max-height: 100px; overflow-y: auto" >
            <div class="col-md-12">
                @if($showList)
                <ul class="list-group" >
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

        @endif

        @if($User['type_client'] == 1)

        <input type="text" value="{{ $FiltroUser['name'] }}" disabled class="form-control">
        <input type="hidden" name="client" value="{{ $FiltroUser['id'] }}" readonly>
        <input type="hidden" name="type_client" value="{{ $User['type_client'] }}" readonly>

        @endif

        {{-- parte de calculo de valores --}}
        <div class="form-group col-md-6 mx-auto">
            @if(isset($values) && $values->count() > 0)
            @foreach($values as $value)
            <input type="text" id="multiplicador" value="{{$value->multiplicador}}" name="multiplicador" hidden>
            <input type="text" id="maxreais" value="{{$value->maxreais}}" name="maxreais" hidden>
            <input type="text" id="valueId" value="{{$value->id}}" name="valueId" hidden>
            <input type="hidden" id="premio" value="" name="premio" readonly>
            @endforeach
            <div class="d-none justify-content-center align-items-center">
                <div class="mr-3">
                    <label for="quantidadeJogos">{{ trans('admin.lwGame.quantJ') }} </label>
                    <input type="text" class="form-control" id="contadorJogos" disabled value="{{$contadorJogos}}"
                        name="contadorJogos">
                </div>
                {{-- valor total --}}
                <div>
                    <label for="quantidadeJogos">{{ trans('admin.lwGame.valueT') }} R$</label>
                    <input type="text" class="form-control" id="ValorTotal" value="" disabled name="ValorTotal">
                </div>
            </div>
            @endif
        </div>
       
        
    </div>
</div>
@push('scripts')
<style>

.card-title2 h3{
    font-size: 12px !important;
}

.card-title2 h4{
    font-size:10px !important;
}

@media (min-width: 1200px) {
    .btsconsultar button:nth-child(1){
        margin-right: 10px;
        margin-left: 10px;
    }
}

@media (max-width: 1200px) {
    .btsconsultar button:nth-child(1){
        margin-bottom: 10px;
    }
}

@media (max-width: 992px) {
    .buttons-box-textarea button {
        
        font-size: 10px !important;
        min-width: none !important;
    }
    .footer-textarea h1 {
    font-size: 9px !important;
    margin-right: 0px !important;
}
.footer-textarea p {
    font-size: 12px !important;
}
.box-textarea {
    padding: 5px !important;
}
.padraobtn {
    padding: 5px !important;
    font-size: 9px !important;
    min-width: 95px !important;
}
.card-copiacola h3 {
        font-size: 12px !important;
    }
    .card-copiacola h4 {
        font-size: 10px !important;
    }

    .box-textarea-infos p {
    font-size: 10px !important;
}
.box-textarea-infos h1 {
    font-size: 10px !important;}

}

@media (max-width: 420px) {

    .aj{
        flex-direction: column !important;
    }
}
   
    .boxbig {
        margin-right: 10px;
    }

    .line-numbers-chose p {
        font-weight: bold;
    text-align: center;
    height: 20px;
    margin: 0px;
    background: #B7B7B7;
    border-radius: 100%;
    width: 20px;
    align-items: center;
    display: flex;
    justify-content: center;
    margin-right: 5px;
    font-size: 10px;
    padding: 10px;
    }

    .searchcard {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .searchcard h1 {
        font-size: 15px;
        margin: 0px;
    }

    .box-textarea-infos h1 {
        font-size: 12px;
        margin: 0px;
        font-weight: bold;
        margin-right: 10px;
    }

    .padraobtn {
        color: white;
        font-weight: bold;
        border: none;
        padding: 10px;
        font-size: 12px;
        min-width: 125px;
        height: 100%;
    }

    .box-textarea-infos p {
        font-weight: bold;

        font-size: 18px;
        margin: 0px;
        background: #191919;
        padding: 5px;
    }

    .head-textarea,
    .footer-textarea {
        text-align: center;
        background: #323637;
        padding: 10px;
        margin-bottom: 10px;
    }

    .buttons-box-textarea button {
        color: white;
        font-weight: bold;
        border: none;
        padding: 10px;
        font-size: 12px;
        min-width: 125px;
    }

    .box-textarea {
        background: #212425;
        padding: 10px;
    }

    .box-textarea p {
        background: #191919;
        padding: 5px;
    }


    .footer-textarea {
        margin-top: 10px;
    }

    .footer-textarea h1 {
        font-size: 13px;
        margin: 0px;
        margin-right: 10px;
    }

    .footer-textarea p {
        font-size: 12px;
        margin: 0px;
    }

    .head-textarea p {
        margin: 0px;
        font-size: 12px;
        font-weight: bold;
    }

    /* Estilo para o contêiner do textarea */
    .textarea-container {
        position: relative;
    }

    /* Estilo para o contador de linhas */
    .line-number {
        color: white;
        display: flex;
        left: 0;
        top: 0;
        bottom: 0;
        width: 30px;
        text-align: center;
        pointer-events: none;
        background: #B7B7B7;
        text-align: center;
        justify-content: center;
        align-items: center;
    }

    /* Estilo para o textarea */
    .textarea {
        width: 100%;
        padding: 0px 10px !important;
        background: #323637;
        min-height: 121px;
        box-sizing: border-box;
        resize: vertical;
        /* Permite redimensionar verticalmente apenas */
    }
</style>
<style>
    .card-copiacola h3 {
        font-size: 15px ;
    }
    .card-copiacola h4 {
        font-size: 13px;
    }

    .bts>.btn {
        max-width: 120px;
        width: 100%;
        color: #A3D712;
        background: #212425 !important;
    }

    .bts>.btn:hover {
        background: #A3D712 !important;
        color: #212425;
    }

    .repeated {
        background: red !important;
    }

    .checker {
        border: 1px solid white;
    width: 20px;
    height: 20px;
    padding: 10px;
    border-radius: 190px;
    display: flex;
    justify-content: center;
    align-items: center;
    }
</style>

{{-- evento dispara quando retira o foco do campo texto --}}
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
   
    Livewire.on('atualizacao-dezena', () => {
        organizedez();
        updateLineNumbers();
    });

    function organizedez() {
    var textarea = document.getElementById("dezena");
    var lines = textarea.value.split(',');
    var newText = lines.join('\n');
    textarea.value = newText;
}


  // Chamar a função inicialmente para exibir o contador de linhas
  function updateLineNumbers() {
    var textarea = document.getElementById("dezena");

    var lines = textarea.value.split("\n").length;
    var lineNumbers = "";

    // Construir os elementos div para cada linha
    for (var i = 1; i <= 5; i++) {
      lineNumbers += "<div class='line-number'>" + i.toString().padStart(2, "0") + "</div>";
    }

    for (var i = 6; i <= lines; i++) {
      lineNumbers += "<div class='line-number'>" + i.toString().padStart(2, "0") + "</div>";
    }

    document.getElementById("line-numbers").innerHTML = lineNumbers;
    document.getElementById("line-numbers1").innerHTML = lineNumbers;
    
    // Obtém o valor do textarea
    var textareaValue = textarea.value;
    // Divide o valor do textarea em linhas
    var lines = textareaValue.split('\n');
    // Seleciona a div onde os números de linha serão inseridos
    var lineNumbersDiv = document.getElementById('line-numbers2');
    // Limpa a div antes de inserir os novos números de linha
    lineNumbersDiv.innerHTML = '';
    // Loop através de cada linha
    lines.forEach(function(line) {
        // Divide a linha em números usando espaço, vírgula, ponto ou traço como separador
        var numbers = line.split(/[ ,.-]+/);
        // Cria uma div para a linha de números
        var lineDiv = document.createElement('div');
        lineDiv.className = 'line-numbers-chose d-flex';
        // Array para armazenar os números repetidos
        var repeatedNumbers = [];
        // Loop através de cada número
        numbers.forEach(function(number) {
            // Verifica se o número já foi encontrado anteriormente
            if (numbers.indexOf(number) !== numbers.lastIndexOf(number) && !repeatedNumbers.includes(number)) {
                // Adiciona o número ao array de números repetidos
                repeatedNumbers.push(number);
            }
            // Cria um elemento <p> para o número
            var numberElement = document.createElement('p');
            numberElement.textContent = number;
            // Verifica se o número é repetido e adiciona a classe 'repeated' se for
            if (repeatedNumbers.includes(number)) {
                numberElement.classList.add('repeated');
            }
            // Adiciona o número como filho da div da linha de números
            lineDiv.appendChild(numberElement);
        });
        // Adiciona o ícone de verificação ou "X" no final da linha
        var icon = document.createElement('i');
        if (repeatedNumbers.length > 0) {
            icon.className = 'fa fa-times checker';
            icon.style.color = 'red'; // Definindo a cor vermelha para o ícone "X"

        } else {
            icon.className = 'fa fa-check checker';
            icon.style.color = 'green'; // Definindo a cor vermelha para o ícone "X"

        }
        icon.setAttribute('aria-hidden', 'true');
        lineDiv.appendChild(icon);
        
        // Adiciona a div da linha de números à div principal de números de linha
        lineNumbersDiv.appendChild(lineDiv);
    });
}
// Chama a função uma vez para exibir os números de linha inicialmente
updateLineNumbers();
    //para realizar o calculo do multiplicador
    function altera() {
        var multiplicador = document.getElementById("multiplicador").value;
        var valor = document.getElementById("value").value;
        var Campovalor = document.getElementById("value");
        var campoDoCalculo = document.getElementById("premio");
        var maxreais = document.getElementById("maxreais").value;
        var resultado;

        var numberValor = parseFloat(valor);
        var numberReais = parseFloat(maxreais);

        if (numberReais >= numberValor) {
            resultado = valor * multiplicador;
            campoDoCalculo.value = resultado.toFixed(2);
        }
        else {
            resultado = maxreais * multiplicador;
            campoDoCalculo.value = resultado;
            Campovalor.value = maxreais;
        }

        var controlervar = document.getElementById("controle").value;
        var textdezena = document.getElementById("dezena");

      

        var valor = document.getElementById('value').value;
        var contadorJogos = document.getElementById('contadorJogos').value;
        var contadorJogos = parseFloat(contadorJogos);
        var numberValor = parseFloat(valor);
        var valorTotal = contadorJogos * numberValor;
        document.getElementById('ValorTotal').value = valorTotal.toFixed(2);

        // var contadorJogos = document.getElementById("contadorJogos").value;
        // var contadorJogos =  parseFloat(contadorJogos);
        // var valorTotal = contadorJogos *numberValor;

        // if (valorTotal > maxreais)
        // {
        //     var contadorJogos = document.getElementById("contadorJogos").value;
        //     var contadorJogos =  parseFloat(contadorJogos);
        //     var valorTotal = contadorJogos *numberValor;
        //     document.getElementById("ValorTotal").value = valorTotal;
        // }
        // else
        // {
        //     document.getElementById("ValorTotal").value = valorTotal;
        // }

    }


    function bloqueia() {

        var controlervar = document.getElementById("controle").value;
        var textdezena = document.getElementById("dezena");

        if (controlervar == 1) {
            textdezena.readOnly = true;
        }
    }

    function limparlista(){
        var textarea = document.getElementById("dezena");
        textarea.value ='';
        updateLineNumbers();

    }
</script>

@endpush