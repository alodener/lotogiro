<div>
    @if($User['type_client'] == null)
    
        <div class="form-row">
            <div class="form-group col-md-12">
                <div wire:ignore>
                        <h4>{{ trans('admin.customer') }}</h4>
    
                <div class="dropdown-divider"></div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="input-group mb-3">
                            <input wire:model="search" type="text" id="author" class="form-control" placeholder="{{ trans('admin.search-customer') }}"autocomplete="off" required>
                        
                            <div class="input-group-append">
                                <span wire:click="clearUser" class="input-group-text" title="{{ trans('admin.clear') }}"><i class="fas fa-user-times"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
        </div>
    
        <input type="hidden" name="client" value="{{$clientId}}">
        <div class="row mb-3" id="list_group" style="max-height: 100px; overflow-y: auto">
            <div class="col-md-12">
                @if($showList)
                    <ul class="list-group">
                        @if(isset($clients) && $clients->count() > 0)
                            @foreach($clients as $client)
                                <li wire:click="setId({{ $client }})"
                                    class="list-group-item" style="cursor:pointer;">{{ $client->name . ' - ' . \App\Helper\Mask::addMaskCpf($client->cpf) . ' - ' . $client->email . ' - '. \App\Helper\Mask::addMaksPhone($client->ddd.$client->phone)}} </li>
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
    
    @endif
    
    {{-- parte de calculo de valores --}}
    <div class="form-group col-md-12">
            @if(isset($values) && $values->count() > 0)
            <label for="client">{{ trans('admin.games.value') }}: </label>
                @foreach($values as $value)
                    <input type="text" id="multiplicador" value="{{$value->multiplicador}}" name="multiplicador" hidden>
                    <input type="text" id="maxreais" value="{{$value->maxreais}}" name="maxreais" hidden>
                    <input type="text" id="valueId" value="{{$value->id}}" name="valueId" hidden>
                    {{ trans('admin.games.bet-value-label') }}
                    <input type="text" id="value" onchange="altera();" value="" name="value" required oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1'); 
                    
                    var valor = document.getElementById('value').value;
                    var contadorJogos = document.getElementById('contadorJogos').value;
                    var contadorJogos =  parseFloat(contadorJogos);
                    var numberValor = parseFloat(valor);
                    var valorTotal = contadorJogos * numberValor;
                    document.getElementById('ValorTotal').value = valorTotal.toFixed(2);">
                    
                    {{ trans('admin.games.prize-value-label') }} R$
                    <input type="text" id="premio" value="" name="premio" readonly>
                    <button  class="btn btn-success" type="button">{{ trans('admin.games.calculate') }}</button>
                @endforeach
    
                    <br>
                    <label for="quantidadeJogos">Quantidade Jogos:</label>
                    <input type="text" id="contadorJogos" disabled value="{{$contadorJogos}}" name="contadorJogos">
                    
                    {{-- valor total --}}
                    <label for="quantidadeJogos">Valor Total R$</label>
                    <input type="text" id="ValorTotal" value="" disabled name="ValorTotal">       
            @endif
    </div>
                    @if(!@empty($msg))
                 <div class="alert alert-danger" role="alert">
                                            <h4 class="alert-heading">{{$msg}}!</h4>
                               
                                            </div>
                                            @endif
            <input type="hidden" name="controle"  id="controle" value="{{$controle}}" >
     <label for="dezena">Dezenas:</label>             
    <div class="row">
        <div class="col-12 dezena">
             <input type="hidden" name="dezena" >
             <input type="hidden" name="qtdDezena" value="{{$qtdDezena}}" >

            <textarea wire:model="dezena" id="dezena"  onclick="bloqueia();"name="dezena" rows="20" cols="90"></textarea>

        </div>
    </div>
        <input type="hidden" class="form-control" id="type_game" name="type_game" value="{{$typeGame->id}}">
        <input hidden value="1" id="xml" name="xml">    
        <button type="button"  class="btn btn-secondary" wire:click="dezenas" >Computar</button>   
        <div class="modal-footer">
            <button type="submit" class="btn btn-info" id="submit_game">Criar</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            
        </div>
       
    </div>    
      @push('scripts')
    
    {{-- evento dispara quando retira o foco do campo texto --}}
    <script>
            //para realizar o calculo do multiplicador
             function altera(){
                var multiplicador = document.getElementById("multiplicador").value;
                var valor = document.getElementById("value").value;
                var Campovalor = document.getElementById("value");
                var campoDoCalculo = document.getElementById("premio");
                var maxreais = document.getElementById("maxreais").value;
                var resultado;
    
                var numberValor = parseFloat(valor);
                var numberReais = parseFloat(maxreais);   
    
                if( numberReais >= numberValor ){
                    resultado = valor * multiplicador;
                campoDoCalculo.value = resultado.toFixed(2);
                }
                else
                {
                resultado = maxreais * multiplicador;
                campoDoCalculo.value = resultado;
                Campovalor.value = maxreais;
                }
                
                var controlervar = document.getElementById("controle").value; 
                var textdezena = document.getElementById("dezena");
    
                if(controlervar == 1){
                    textdezena.readOnly = true;
                }     
    
                var valor = document.getElementById('value').value;
                    var contadorJogos = document.getElementById('contadorJogos').value;
                    var contadorJogos =  parseFloat(contadorJogos);
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


             function bloqueia(){

                  var controlervar = document.getElementById("controle").value; 
                var textdezena = document.getElementById("dezena");
    
                if(controlervar == 1){
                    textdezena.readOnly = true;
                }     
             }
             </script>
    @endpush