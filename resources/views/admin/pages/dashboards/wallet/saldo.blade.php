

    <div class="d-flex justify-content-center flex-md-row flex-column mt-5">
        <div class="d-flex justify-content-between mb-3">
            <div class="card-master card-master-bottom text-center">
                <p>{{ trans('admin.pagesF.saldo') }}</p>
                <h1>R${{ \App\Helper\Money::toReal(auth()->user()->balance) }}</h1>
            </div>
            <div class="card-master card-master-bottom  mr-md-5 ml-md-5 text-center">
                <p>{{ trans('admin.pagesF.bonus') }}</p>
                <h1>R${{ \App\Helper\Money::toReal(auth()->user()->bonus) }}</h1>
            </div>
        </div>

        <div class="card-master card-master-bottom text-center mb-3">
            <p>{{ trans('admin.pagesF.saqueDisponivel') }}</p>
            <h1>R${{ \App\Helper\Money::toReal(auth()->user()->available_withdraw) }}</h1>
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
</style>

@push('scripts')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<x-livewire-alert::scripts />
@endpush