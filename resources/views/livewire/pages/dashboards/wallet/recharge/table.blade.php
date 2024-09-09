<div>
<div class="col-md-12 p-4 card-header">
        <h3 class="text-center text-bold">{{ trans('admin.pagesF.carteira') }}</h3>
    </div>
    @include('admin.pages.dashboards.wallet.saldo')

    <div class="col-md-6 justify-content-center mx-auto">
        <div class="card card-info">
            <div class="card-header indica-card">
                <h3 class="card-title">{{ trans('admin.pagesF.addSaldo') }}</h3>
            </div>
            <div class="card-master container">
                <div class="row">
                    <div class="col-sm-12">
                        <div x-data="{}" id="custom-search-input">
                            <form>
                                <div class="d-flex justify-content-center">
                                    
                                    <div class="col-sm-12 col-md-12 d-flex justify-content-center align-items-center flex-column ">
                                        <ul class="list-group mb-3">
                                            <li class="list-group-item">
                                                <div class="d-flex flex-column">
                                                    <div class="">
                                                        <h5 class="my-0">{{ trans('admin.pagesF.valorAdd') }}</h5>
                                                        <small class="text-muted">{{ trans('admin.pagesF.valorMin') }} R$ 1,00

                                                            <p class="text-muted"><p>{{ trans('admin.pagesF.valorInserido') }}</p></small>
                                                        </small>
                                                    </div>

                                                    <div class="col-sm-12 col-md-12 input-group card-master">
                                                        <input wire:model="valueAdd" x-on:focus="formatInput()"
                                                               type="text" name="valueAdd" id="valueAdd" value="0"
                                                               class="search-query form-control w-100" placeholder="Valor" />
                                                    </div>

                                                </div>
                                            </li>
                                        </ul>
                                        <div class="d-flex flex-wrap ">
                                        <button wire:click="increment(10)" class="btn btn-despositar btn-small mb-1" >+ R$ 10,00</button>
                                        <button wire:click="increment(20)" class="btn btn-despositar btn-small mb-1 mr-2 ml-2"  >+ R$:20,00</button>

                                        <button wire:click="increment(50)" class="btn btn-despositar btn-small mb-1" >+ R$:50,00</button>
                                        <button wire:click="increment(100)" class="btn btn-despositar btn-small mb-1 ml-2">+ R$:100,00</button>

                                        <style>
                                            .btn-small{
                                                padding: 7px;
                                                font-size: 13px;
                                                transition: 0.2s;

                                            }

                                            .btn-small:hover{
                                                transition: 0.2s;
                                                padding: 11px;
                                                background: #bbf411;
                                            }
                                            </style>
                                        </div>

                                        <div class="input-group-append bt-recharge mx-auto mt-5">
                                             @if(config('services.activeGateway') == 'MP')
                                                 <button wire:click.prevent="callMPPix" type="submit"
                                                         @if($valueAdd <= 0.99) disabled @endif

                                                        class="btn btn-green btn-md btn-block">{{ trans('admin.lwIndicated.cont') }} {{$valueAdd}}</button>
                                             @elseif(config('services.activeGateway') == 'doBank')
                                             <button wire:click.prevent="callDoBank" type="submit"
                                                     @if($valueAdd <= 9.99) disabled @endif

                                                    class="btn btn-green btn-md btn-block">{{ trans('admin.lwIndicated.cont') }}  {{$valueAdd}}</button>
                                             @elseif(config('services.activeGateway') == 'SuitPay')
                                             <button wire:click.prevent="callSuitPayPix" type="submit"
                                                     @if($valueAdd <= 0.99) disabled @endif

                                                    class="btn btn-green btn-md btn-block">{{ trans('admin.lwIndicated.cont') }}  {{$valueAdd}}</button>
                                             @elseif(config('services.activeGateway') == 'MutualPay')
                                             <button wire:click.prevent="callMutualPayPix" type="submit"
                                                     @if($valueAdd <= 0.99) disabled @endif

                                                    class="btn btn-green btn-md btn-block">{{ trans('admin.lwIndicated.cont') }}  {{$valueAdd}}</button>
                                             @else
                                                 <button wire:click.prevent="callZoop" type="submit"
                                                     @if($valueAdd <= 9.99) disabled @endif
                                                     class="btn btn-green btn-md btn-block"> {{ trans('admin.lwIndicated.cont') }} {{$valueAdd}}</button>
                                             @endif
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<style>
    .btn-primary:disabled {
        padding: 10px;
    font-weight: 700;
    color: #a3d712;
    background: #424647;
    border: #424647;
}
.btn-green {
        padding: 10px;

        font-weight: 700;
        color: #424647;
        background: #a3d712;
        border: #a3d712;
        box-shadow: 0 0 10px 2px rgba(163,215,18,.5);

    }
</style>

@push('styles')

@endpush

@push('scripts')
    <script src="https://sdk.mercadopago.com/js/v2"></script>

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <x-livewire-alert::scripts />

    <script src="https://cdn.jsdelivr.net/npm/vanilla-masker@1.1.1/build/vanilla-masker.min.js"></script>

    <script type="text/javascript">

var botoes = document.querySelectorAll('.btn-small');
botoes.forEach(function(botao) {
    botao.addEventListener('click', function(event) {
        event.preventDefault();
    });
});

        function formatInput(){
            VMasker(document.getElementById("valueAdd")).maskMoney();
        }

                function redirect(link){
           
            window.open(link, "_blank");
            window.location.href = 'recharge-order';
        }
        function redirectPix(){
           window.location.href = 'recharge-order';
       }

       function extrairValorNumerico(valorFormatado) {
        // Remove todos os caracteres que não são dígitos ou ponto
        var valorNumerico = parseFloat(valorFormatado.replace(/[^0-9.]/g, ''));

        // Se não for um número válido, retorna 0
        return isNaN(valorNumerico) ? 0 : valorNumerico;
    }

    function somarComValor(valorASomar) {
        // Pega o valor formatado do input
        var valorFormatado = document.getElementById('valueAdd').value;

        // Extrai o valor numérico a partir do valor formatado
        var valorNumerico = extrairValorNumerico(valorFormatado);

        // Soma os valores
        var resultado = valorNumerico + valorASomar;

        // Formata o resultado e substitui o valor no input
        document.getElementById('valueAdd').value = VMasker.toMoney(resultado);
        callMPPix();
        
    }   
    </script>
@endpush
