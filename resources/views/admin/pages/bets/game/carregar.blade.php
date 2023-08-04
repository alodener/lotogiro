@extends('admin.layouts.master')

@section('title', trans('admin.games.create-page-title'))

@section('content')
 <form action="{{route('admin.bets.games.store')}}" method="POST" id="form_game">
    @csrf
    @method('POST')
    @include('admin.pages.bets.game._form2')
</form>
        <!-- /.modal -->
@endsection

@push('scripts')
    

@endpush