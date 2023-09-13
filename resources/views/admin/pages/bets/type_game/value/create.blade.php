@extends('admin.layouts.master')

@section('content')

    <div class="col-md-12">
        <section class="content">
            <form action="{{route('admin.bets.type_games.values.store', ['type_game' => $typeGame->id])}}" method="POST">
                @csrf
                @method('POST')
                @include('admin.pages.bets.type_game.value._form')
            </form>
        </section>
    </div>

@endsection

