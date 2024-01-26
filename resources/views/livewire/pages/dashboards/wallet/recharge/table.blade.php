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
                                    <div class="col-sm-12 col-md-6">
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
                                                               type="text" name="valueAdd" id="valueAdd"
                                                               class="search-query form-control w-100" placeholder="Valor" />
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>

                                        <div class="input-group-append bt-recharge">
                                             @if(config('services.activeGateway') == 'MP')
                                                 <button wire:click.prevent="callMPPix" type="submit"
                                                         @if($valueAdd <= 0.99) disabled @endif

                                                        class="btn btn-green btn-md btn-block">{{ trans('admin.lwIndicated.cont') }} {{$valueAdd}}</button>
                                             @elseif(config('services.activeGateway') == 'doBank')
                                             <button wire:click.prevent="callDoBank" type="submit"
                                                     @if($valueAdd <= 9.99) disabled @endif

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
    </script>
@endpush
