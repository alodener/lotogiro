@extends('admin.layouts.master')

@section('title', trans('admin.games.listing-page-title'))

@section('content')
    <div class="col bg-white p-3">
        <h1>{{ trans ('admin.detailedView.visaoC') }}  </h1>
        <hr/>
        <form method="POST" action="{{ route('admin.dashboards.customer.filter.winner')}}">
            @csrf
            <div class="row mb-4">
                <div class="col">
                    <a href="{{ route('admin.dashboards.customer.balance')}}"><button type="button" class="btn btn-secondary"><i class="bi bi-arrow-left-square-fill"></i></button></a>
                    <div class="form-group w-25 mt-3">
                        <label for="exampleFormControlSelect1">{{ trans ('admin.detailedView.selecC') }} </label>
                        <select class="form-control" id="select-names" name="select_names">
                            @foreach ($winners as $winner)
                                <option value="{{ $winner[0] }}">{{ $winner[1] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-2">
                    <label for="">{{ trans ('admin.detailedView.dateI') }}  </label>
                    <input type="date" id="initial_date" class="form-control" name="initial_date" value="initial_date">
                </div>
            </div>
            <div class="row">
                <div class="col-2">
                    <label for="">{{ trans ('admin.detailedView.dateF') }}   </label>
                    <input type="date" id="final_date" class="form-control" name="final_date" value="initial_date">
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-2">
                    <button  type="submit" class="btn btn-primary">{{ trans ('admin.detailedView.filtrar') }}  </button>
                </div>
            </div>
            <div class="row mt-2">
                <p><b>{{ trans ('admin.detailedView.obs') }}   </b></p>
            </div>
        </form>
    </div>

@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.13.3/css/selectize.min.css"
        integrity="sha512-bkB9w//jjNUnYbUpATZQCJu2khobZXvLP5GZ8jhltg7P/dghIrTaSJ7B/zdlBUT0W/LXGZ7FfCIqNvXjWKqCYA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        #filterForm {
            margin-top: 30px;
            margin-bottom: 30px;
        }

        #filterForm .form-row {
            justify-content: flex-end;
            align-items: flex-end;
            margin: 0;
        }

        @media(max-width: 467px) {
            #filterForm .form-row {
                flex-direction: column;
            }
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
@endpush
