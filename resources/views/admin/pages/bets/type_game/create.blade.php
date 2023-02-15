@extends('admin.layouts.master')

@section('title', trans('admin.game-types.new-game-type'))

@section('content')

    <div class="col-md-12">
        <section class="content">
            <form action="{{route('admin.bets.type_games.store')}}" method="POST">
                @csrf
                @method('POST')
                @include('admin.pages.bets.type_game._form')
            </form>
        </section>
    </div>

@endsection

