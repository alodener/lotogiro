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
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="name">{{ trans('admin.dozens') }}</label>
                        <input type="text" class="form-control @error('dozens') is-invalid @enderror" id="dozens"
                               name="dozens"
                               maxlength="50" value="{{old('dozens', $value->numbers ?? null)}}">
                        @error('dozens')
                        <span class="invalid-feedback" role="alert">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-md-3">
                        <label for="multiplicador">{{ trans('admin.game-types.multiplicator') }}</label>
                        <input type="text" class="form-control @error('multiplicador') is-invalid @enderror"
                               id="multiplicador"
                               name="multiplicador"
                               maxlength="100" value="{{old('multiplicador', isset($value->multiplicador) ? ($value->multiplicador) : null)}}">
                        @error('multiplicador')
                        <span class="invalid-feedback" role="alert">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-md-3">
                        <label for="maxreais">{{ trans('admin.game-types.max-bet') }}</label>
                        <input type="text" class="form-control @error('maxreais') is-invalid @enderror"
                               id="maxreais"
                               name="maxreais"
                               maxlength="100" value="{{old('maxreais', isset($value->maxreais) ? \App\Helper\Money::toReal($value->maxreais) : null)}}">
                        @error('maxreais')
                        <span class="invalid-feedback" role="alert">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-md-3">
                        <label for="name">{{ trans('admin.game-types.max-repeated') }}</label>
                        <input type="text" class="form-control @error('max_repeated_games') is-invalid @enderror" id="max_repeated_games"
                               name="max_repeated_games"
                               maxlength="50" value="{{old('max_repeated_games', $value->max_repeated_games ?? null)}}">
                        @error('max_repeated_games')
                            <span class="invalid-feedback" role="alert">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6 mb-3">
        <a href="{{route('admin.bets.type_games.edit', ['type_game' => $typeGame->id ?? $value->type_game_id])}}">
            <button type="button" class="btn btn-block btn-outline-secondary">{{ trans('admin.game-types.max-repeated') }}</button>
        </a>
    </div>
    <div class="col-md-6 mb-3">
        <button type="submit"
                class="btn btn-block btn-outline-success">@if(Route::currentRouteName() == 'admin.bets.type_games.values.create') {{ trans('admin.game-types.register') }}  @else  {{ trans('admin.game-types.update') }} @endif </button>
    </div>
</div>

@push('scripts')

    <script src="{{asset('admin/layouts/plugins/inputmask/jquery.inputmask.min.js')}}"></script>
    <script>


        $(document).ready(function () {
            $('#dozens').inputmask("9999");
            $('#max_repeated_games').inputmask("9999");
            $("#amount").inputmask( 'currency',{"autoUnmask": true,
                radixPoint:",",
                groupSeparator: ".",
                allowMinus: false,
                digits: 2,
                digitsOptional: false,
                rightAlign: true,
                unmaskAsNumber: true
            });
            $("#prize").inputmask( 'currency',{"autoUnmask": true,
                radixPoint:",",
                groupSeparator: ".",
                allowMinus: false,
                digits: 2,
                digitsOptional: false,
                rightAlign: true,
                unmaskAsNumber: true
            });
        });
    </script>

@endpush
