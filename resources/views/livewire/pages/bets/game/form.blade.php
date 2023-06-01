<div>
     <table class="table px-sorteio">
         <thead>
         <tr>

            <th class="col1" scope="col">{{ trans('admin.lwGame.type') }}</th>
            <th scope="col">{{ trans('admin.lwGame.concurs') }}</th>
            <th scope="col">{{ trans('admin.lwGame.dateS') }}</th>
            <th scope="col">{{ trans('admin.lwGame.importJ') }}</th>
         </tr>
         </thead>
         <tbody>
         <tr>
             <td>{{$typeGame->name}}</td>
             @if(empty($typeGame->competitions->last()))

                <td colspan="2" class="text-danger">{{ trans('admin.lwGame.nExist') }} </td>
             @else
                 <td>{{$typeGame->competitions->last()->number}}</td>
                 <td>{{\Carbon\Carbon::parse($typeGame->competitions->last()->sort_date)->format('d/m/Y H:i:s')}}</td>

                <td> <a href="{{route('admin.bets.games.carregarjogo', ['type_game' => $typeGame->id])}}"><button  class="btn btn-info" type="button">{{ trans('admin.lwGame.carreg') }}  </button></a></td>
             @endif
         </tr>
         </tbody>
     </table>
 

 
     <div class="form-row">
         <div class="form-group col-md-12">
             <div wire:ignore>
                 <div class="card-header ganhos-card">

                    <h4> {{ trans('admin.lwGame.client') }}</h4>
                 </div>
             </div>        
             <div class="row">
                 <div class="col-md-12">
                     <div class="input-group mb-3">

                 @if(isset($values) && $values->count() > 0)
                     @foreach($values as $value)
                         <input type="text" id="multiplicador" value="{{$value->multiplicador}}" name="multiplicador" hidden>
                         <input type="text" id="maxreais" value="{{$value->maxreais}}" name="maxreais" hidden>
                         <input type="text" id="valueId" value="{{$value->id}}" name="valueId" hidden>

                        {{ trans('admin.lwGame.digitVal') }}
                         <input type="text" id="value" onchange="altera()" value="" name="value" required oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');">

                        {{ trans('admin.lwGame.valueP') }} R$
                         <input type="text" id="premio" value="" name="premio" readonly>

                        <button  class="btn btn-info" type="button" onclick="altera();">{{ trans('admin.lwGame.calcu') }}</button>
                     @endforeach
                 @else
                 
                 @endif
         </div>

     <div class="row">
         <div class="col-md-12">
             @if(isset($matriz))
                 <h4>{{ trans('admin.lwGame.quantSelec') }} ({{count($selectedNumbers)}}/{{$numbers}})</h4>
                     @if($typeGame->name == "SLG - 15 LotofÃ¡cil" || $typeGame->name == "SLG - 20 LotoMania" || $typeGame->name == "Lotogiro - 1000X LotofÃ¡cil" || $typeGame->name == "ACUMULADO 15 lotofacil")

                      <button wire:click="selecionaTudo()" class="{{ env('AllColor') }}" type="button" onclick="limpacampos();">{{ trans('admin.lwGame.selecN') }} </button>
                     @endif
 
                     <br>
                     
                     <div class="col-md-12 automatic-bet">
                         <p style="font-size: 10px;margin-bottom: auto;">

                        {{ trans('admin.lwGame.selecQuant') }}
                         </p>
                         {{-- puxar do banco de dados quantos numeros pode se jogar --}}
                         @foreach ($busca as $buscas)
 
                             <button style="margin-top: 1%" wire:click="randomNumbers({{ $buscas['numbers'] }})" class="{{ env('randomNumbersColor') }}" type="button" onclick="limpacampos();">{{ $buscas['numbers'] }}</button>
                        @endforeach 
                    </div>



                <div class="table-responsive responsive-bet">
                    <table class="table text-center">
                        <tbody>
                        @foreach($matriz as $lines)
                            <tr>
                                @foreach($lines as $cols)
                                    <td>
                                        <button wire:click="selectNumber({{$cols}})" id="number_{{$cols}}" type="button"
                                                class="btn {{in_array($cols, $selectedNumbers) ? env('OneNumber2') : 'btn-warning'}} btn-beat-number">{{$cols}}</button>
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

@push('styles')
    <link href="{{asset('admin/layouts/plugins/select2/css/select2.min.css')}}" rel="stylesheet"/>
    <link href="{{asset('admin/layouts/plugins/select2-bootstrap4-theme/select2-bootstrap4.css')}}" rel="stylesheet"/>

    <style>
        .btn-beat-number {
            width: 100%;
        }

        .table th, .table td {
          border-top: none;
          padding: 5px 5px 5px 5px;
        }

        .ganhos-card h4 {
            font-size: 20px !important;
        }

        @media (max-width: 700px) {
            h4 {
                font-size: 15px;
                margin-left: 7px;
            }
        }
    </style>

@endpush

@push('scripts')

    <script src="{{asset('admin/layouts/plugins/select2/js/select2.min.js')}}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

{{-- <script>
        $(document).ready(function () {
            $('#clients').select2({
                theme: "bootstrap"
            });
            $('#sort_date').inputmask("99/99/9999 99:99:99");
        });
    </script> --}}
    
    <script>
        //Função para realizar o calculo do multiplicador
         function altera(){
            var multiplicador = document.getElementById("multiplicador").value;
            var valor = document.getElementById("value").value;
            var Campovalor = document.getElementById("value");
            var campoDoCalculo = document.getElementById("premio");
            var maxreais = document.getElementById("maxreais").value;
            var resultado;
            var numberValor = parseInt(valor);
            var numberReais = parseInt(maxreais);

            //evento dispara quando retira o foco do campo texto
                if( numberReais >= numberValor ){
                 resultado = valor * multiplicador;
                campoDoCalculo.value = resultado;
                }else{
                resultado = maxreais * multiplicador;
                campoDoCalculo.value = resultado;
                Campovalor.value = maxreais;
                }
         }



         function mudarListaNumeros(){
            var input = document.querySelector("#numbers");
            var NovoTexto = input.value;
            console.log(NovoTexto);
            var NovoTexto = NovoTexto.trim();
            var NovoTexto = NovoTexto.split("  ");
            var NovoTexto = NovoTexto.toString();
            console.log(NovoTexto);
            document.getElementById('numbers').value = NovoTexto;

         }

         function mudarListaNumerosGeral(){
             altera();
             mudarListaNumeros();

         }

         function limpacampos(){
            var valor = document.getElementById("value").value;
            var Campovalor = document.getElementById("value");
            var campoDoCalculo = document.getElementById("premio");
            campoDoCalculo.value = "";
            Campovalor.value = "";
         }

    </script>

@endpush

