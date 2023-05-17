@extends('admin.layouts.master')

@section('title', trans('admin.competitions.create-page-title'))

@section('content')

    <div class="col-md-12">
        <section class="content">
            <form action="{{route('admin.bets.competitions.store')}}" method="POST">
                @csrf
                @method('POST')
                @include('admin.pages.bets.competition._form')
            </form>
        </section>
    </div>

@endsection

@push('scripts')

    <script type="text/javascript">
        $(document).ready(function () {

        });
    </script>

@endpush
