<div>
    <div class="col-md-12 p-4 card-header">
        <h3 class="text-center text-bold">SAQUE</h3>
    </div>
    @include('admin.pages.dashboards.wallet.saldo')

    <div class="col-md-12">
        <div class="">
            <div class="card-header indica-card">
                <h3 class="card-title">{{ trans('admin.falta.transfSaldo') }}</h3>
            </div>


            <div class="" style="margin-top: -35px !important;">
                <div x-data="{data: @entangle('user')}">
                    <form wire:submit.prevent="transferToClient()">
                        <div class="d-flex flex-column mt-5">
                            <div class="d-flex justify-content-center ">
                                <div class="card-master mr-5">
                                    <div class="card-header ">
                                        <h6><b>{{ trans('admin.pagesF.dadosRec') }}</b></h6>
                                    </div>
                                    <div class="col-sm-12 mb-1">
                                        <b>{{ trans('admin.pagesF.name') }}: </b> <span x-text="data.name"></span>
                                    </div>
                                    <div class="col-sm-12 mb-1">
                                        <b>{{ trans('admin.pagesF.email') }}: </b> <span x-text="data.email"></span>
                                    </div>
                                    <div class="col-sm-12 mb-1">
                                        <b>{{ trans('admin.pagesF.telefone') }}: </b> <span x-text="data.phone"></span>
                                    </div>
                                    <div class="col-sm-12 mb-1">
                                        <b>PIX: </b>
                                    </div>
                                    <div class="col-sm-12">
                                        <input wire:model.defer="pixSaque" class='col-sm-10 form-control' type="text"
                                            style="margin-bottom: 15px;" />
                                    </div>
                                    <small>{{ trans('admin.pagesF.aoAlt') }}</small>

                                </div>
                                <div class="card-master">

                                    <div class="card-header mb-5 ">
                                        <h6><b>{{ trans('admin.pagesF.valorRet') }}</b></h6>
                                    </div>
                                    <small class="text-muted" style="color:#A3D712 !important;"><h5>{{ trans('admin.pagesF.valorMin') }} R$ {{ $valorMinimo }}</h5>

                                        
                                    </small>

                                    <div class="input-group">
                                        <input wire:model="valueTransfer" x-on:focus="formatInput()" type="text"
                                            class="search-query form-control" placeholder="Valor a retirar"
                                            id="valueTransfer" inputmode="numeric" value="0,00" />
                                    </div>
                                    <small class=" mt-2">
                                            {{ trans('admin.pagesF.valorInse') }}
                                        </small>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 mx-auto mt-5">
                                <div class="input-group">

                                    <button wire:click="requestWithdraw" type="button" class="btn btn-green btn-block">
                                        {{ trans('admin.pagesF.solicitar') }} <span class="fa fa-send"></span>

                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card-master-bottom {
        border-bottom: 1px solid #A3D712;
        min-width: 300px;
        padding: 30px;
    }

    .btn-green {
        padding: 10px;

        font-weight: 700;
        color: #424647;
        background: #a3d712;
        border: #a3d712;
        box-shadow: 0 0 10px 2px rgba(163, 215, 18, .5);

    }

    .btn-primary {
        min-width: 200px;
    }

    .btn-green:hover {}

    .card-master-bottom p {
        color: #a3d712;
        font-weight: bold;
    }

    @media (max-width: 992px) {
        .card-master-bottom {
            padding: 10px !important;
            min-width: 200px;


        }

        .card-master-bottom h1 {
            font-size: 25px;

        }

        .card-master-bottom p {
            color: #a3d712;
            font-weight: bold;
        }


    }
</style>
@push('scripts')

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<x-livewire-alert::scripts />

<script src="https://cdn.jsdelivr.net/npm/vanilla-masker@1.1.1/build/vanilla-masker.min.js"></script>

<script type="text/javascript">
    function formatInput() {
        VMasker(document.getElementById("valueTransfer")).maskMoney();
    }
</script>
@endpush