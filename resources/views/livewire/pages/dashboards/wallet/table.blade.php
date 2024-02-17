<div>

<!-- Card carteira -->
    <div class="col-md-12 p-4 card-header">
        <h3 class="text-center text-bold">{{ trans('admin.pagesF.carteira') }}</h3>
    </div>


    <!-- Card Dinheiros saldo, bonus, disponivel -->

    @include('admin.pages.dashboards.wallet.saldo')

   
        <!-- Botoes verdes primarios -->


    <div class="d-flex mt-3 justify-content-center align-items-center">
        <a href="{{ route('admin.dashboards.wallet.recharge') }}" type="button" class="btn btn-green 
                        text-bold">
            <i class="fas fa-piggy-bank"></i>
            {{ trans('admin.pagesF.recarregar') }}
        </a>
        <a href="{{ route('admin.dashboards.wallet.withdraw') }}" type="button" class="btn mr-md-5 ml-md-5 mr-2 ml-2  btn-green
                        text-bold">
            <i class="fas fa-money-bill-alt"></i>
            {{ trans('admin.pagesF.retirar') }}
        </a>
        <a href="{{ route('admin.dashboards.wallet.convert') }}" type="button" class="btn  btn-green
                        text-bold">
                <i class="fas fa-exchange-alt"></i>
                {{ trans('admin.pagesF.converter') }}
            </a>
    </div>

            <!-- Botoes secundarios -->

    <div class="d-flex container justify-content-center col-md-12 mt-5">
        <div class="d-flex flex-column card-master">

            <div class="d-flex justify-content-center flex-md-row flex-column align-items-center ">
                <div class=" ">
                    <a href="{{ route('admin.dashboards.wallet.extract') }}" type="button" class="btn btn-primary  
                            text-bold">{{ trans('admin.pagesF.extratoo') }}</a>
                </div>
                <div class="mt-2 mb-2 mt-md-0 mb-md-0">
                    <a href="{{ route('admin.dashboards.wallet.withdraw-list') }}" type="button" class="btn
                        btn-primary mr-md-5 ml-md-5 
                            text-bold">{{ trans('admin.pagesF.solicitSaquee') }}</a>
                </div>
                <div class=" ">
                    <a href="{{ route('admin.dashboards.wallet.recharge-order') }}" type="button" class="btn
                        btn-primary 
                            text-bold">{{ trans('admin.pagesF.pedRecarga') }}</a>
                </div>

                <div>
               
                </div>
            </div>
            <!-- <div class="row mt-5">
                   <div class="col-sm-4 bt-esp">
                        <a href="{{ route('admin.dashboards.wallet.transfer') }}" type="button" class="btn btn-block btn-success text-light
                        text-bold">Transferir</a>
                    </div>
                    <div class="col-sm-4 bt-esp">
                        <a href="{{ route('admin.dashboards.wallet.recharge') }}" type="button" class="btn btn-block btn-success text-light
                        text-bold">Recarregar</a>
                    </div>
                    <div class="col-sm-4 bt-esp">
                        <a href="{{ route('admin.dashboards.wallet.withdraw') }}" type="button" class="btn btn-block btn-success text-light
                        text-bold">Retirar</a>
                    </div>-->
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
        box-shadow: 0 0 10px 2px rgba(163,215,18,.5);

    }

    .btn-primary{
        min-width:200px;
    }

    .btn-green:hover {
      
     
    }

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

    @media (max-width: 442px) {
        .card-master-bottom {
            padding: 10px !important;
            min-width: 130px;


        }

        .card-master-bottom h1 {
            font-size: 25px;

        }

        .card-master-bottom p {
            color: #a3d712;
            font-weight: bold;
        }

        .btn-green {
            font-size: 10px;
        }


    }
</style>

@push('scripts')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<x-livewire-alert::scripts />
@endpush