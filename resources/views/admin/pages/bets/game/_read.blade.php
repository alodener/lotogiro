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
                <h3 class="card-title">{{ trans('admin.game') }}</h3>
            </div>
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-md-3 mb-3">
                        <a href="{{route('admin.bets.games.receipt', ['game' => $game, 'format' => 'pdf'])}}">
                            <button type="button" class="btn btn-info btn-block">
                                {{ trans('admin.games.generate-pdf-invoice') }}
                            </button>
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{route('admin.bets.games.receipt', ['game' => $game, 'format' => 'txt'])}}">
                            <button type="button" class="btn btn-info btn-block">
                                {{ trans('admin.games.generate-txt-invoice') }}
                            </button>
                        </a>
                    </div>
                    <div class="col-md-3">
                    </div>
                    <div class="col-md-3 mb-3 text-right">
                        <a href="https://api.whatsapp.com/send?phone=55{{$client->ddd.$client->phone}}&text=Jogo de {{$typeGame->name }} cadastrado com sucesso! Id da Aposta: {{$game->id}}, Cliente: {{$client->name. ' ' . $client->last_name}}, Dezenas: {{$game->numbers}}, Valor R${{\App\Helper\Money::toReal($game->value)}}, Prêmio R${{\App\Helper\Money::toReal($game->premio)}}, Data: {{\Carbon\Carbon::parse($game->crated_at)->format('d/m/Y') }}" target="_blank">
                            <button type="button" class="btn btn-info btn-block">
                                {{ trans('admin.games.send-to-whatsapp') }}
                            </button>
                        </a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <tbody>
                                <tr>
                                    <td>
                                        {{ trans('admin.games.table-game-type-header') }}
                                    </td>
                                    <td>
                                        {{ trans('admin.games.table-competition-header') }}
                                    </td>
                                    <td>
                                        {{ trans('admin.games.table-draw-date-header') }}
                                    </td>
                                    <td>
                                        {{ trans('admin.games.table-client-header') }}
                                    </td>
                                    <td>
                                        {{ trans('admin.games.table-user-header') }}
                                    </td>
                                    <td>
                                        {{ trans('admin.games.table-bet-amount-header') }}
                                    </td>
                                    <td>
                                        {{ trans('admin.games.table-prize-amount-header') }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        {{$typeGame->name }}
                                    </td>
                                    <td>
                                        {{$game->competition->number }}
                                    </td>
                                    <td>
                                        {{\Carbon\Carbon::parse($game->competition->sort_date)->format('d/m/Y H:i:s') }}
                                    </td>
                                    <td>
                                        {{$client->name . ' ' . $client->last_name}}
                                    </td>
                                    <td>
                                        {{$game->user->name . ' ' . $game->user->last_name}}
                                    </td>
                                    <td>
                                        R${{\App\Helper\Money::toReal($game->value)}}
                                    </td>
                                    <td>
                                        R${{\App\Helper\Money::toReal($game->premio)}}
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        @if(isset($matriz))
                            <div class="table-responsive">
                                <table class="table  text-center">
                                    <tbody>
                                    @foreach($matriz as $lines)
                                        <tr>
                                            @foreach($lines as $cols)
                                                <td>
                                                    <button id="number_{{$cols}}"
                                                            type="button"
                                                            class="btn btn-success {{in_array($cols, $selectedNumbers) ? 'btn-success' : 'btn-warning'}} btn-beat-number">{{$cols}}</button>
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6 mb-3">
        <a href="{{route('admin.bets.games.index', ['type_game' => $typeGame->id])}}">
            <button type="button" class="btn btn-block btn-outline-secondary">{{ trans('admin.back-to-main-page') }}</button>
        </a>
    </div>
</div>

@push('styles')
    <style>
        .btn-beat-number {
            width: 100%;
        }
    </style>
@endpush


@push('scripts')

    <script src="{{asset('admin/layouts/plugins/inputmask/jquery.inputmask.min.js')}}"></script>
    <script>
        $(document).ready(function () {
            $('#cpf').inputmask("999.999.999-99");
            $('#phone').inputmask("(99) 9999[9]-9999");
        });
    </script>

@endpush

