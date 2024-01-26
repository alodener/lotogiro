<div class="row">
    <div class="col-md-12">
        @error('success')
        @push('scripts')
            <script>
                toastr["success"]("{{ $message }}")
            </script>
        @endpush
        @enderror
        @error('error')
        @push('scripts')
            <script>
                toastr["error"]("{{ $message }}")
            </script>
        @endpush
        @enderror
    </div>
    <div class="col-md-12">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">{{ trans('admin.game-types.game-type') }}</h3>
            </div>
            <div class="card-body">
                @livewire('pages.bets.type-game.form', ['typeGame' => $typeGame ?? null] )
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6 mb-3">
        <a href="{{route('admin.bets.type_games.index')}}">
            <button type="button" class="btn btn-block btn-outline-secondary">{{ trans('admin.back-to-main-page') }}</button>
        </a>
    </div>
    <div class="col-md-6 mb-3">
        <button type="submit"
                class="btn btn-block btn-outline-success">@if(request()->is('admin/bets/type_games/create')) {{ trans('admin.game-types.game-type-register-button') }}  
                @else  {{ trans('admin.game-types.game-type-update-button') }} @endif </button>
    </div>
</div>


@push('scripts')

    <script src="{{asset('admin/layouts/plugins/inputmask/jquery.inputmask.min.js')}}"></script>
    <script>
        $(document).ready(function () {
            $('#cpf').inputmask("999.999.999-99");
            $('#phone').inputmask("(99) 9999[9]-9999");
        });
    </script>

@endpush
