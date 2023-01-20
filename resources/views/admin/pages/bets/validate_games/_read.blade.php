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
                <h3 class="card-title">{{ trans('admin.validate-games.read-card-title') }}</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <h4>{{ trans('admin.validate-games.client') }}</h4>
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                <tr>
                                    {{-- <td>
                                        Cpf
                                    </td> --}}
                                    <td>
                                        {{ trans('admin.validate-games.name') }}
                                    </td>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    {{-- <td>
                                        {{\App\Helper\Mask::addMaskCpf($validate_game->client->cpf)}}
                                    </td> --}}
                                    <td>
                                        {{$validate_game->client->name}} {{$validate_game->client->last_name}}
                                    </td>
                                </tr>
                                <tr>

                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <h4>{{ trans('admin.validate-games.games') }}</h4>

                        @foreach($validate_game->games as $game)
                            @php
                                $checar = $game->checked;
                            @endphp
                        @endforeach

                        @if($checar == 1)
                        <div class="card-body col-lg-6 col-sm-12" style="float: left !important">
                            <a href="{{ route('admin.bets.games.receiptTudo', ['idcliente' =>$idCliente ]) }}">
                                <button type="button" class="btn btn-info btn-block">
                                    {{ trans('admin.validate-games.print-pdf') }}
                                </button>
                            </a>
                        </div>
                        
                        <div class="card-body col-lg-6 col-sm-12" style="float: left !important">
                            <a href="{{ route('admin.bets.games.getReceiptTudoTxt', ['idcliente' =>$idCliente ]) }}">
                                <button type="button" class="btn btn-info btn-block">
                                    {{ trans('admin.validate-games.print-txt') }}
                                </button>
                            </a>
                        </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-sm" id="myTable">
                                <thead>
                                <tr>
                                    <th scope="col">{{ trans('admin.validate-games.table-id-header') }}</th>
                                    <th scope="col">{{ trans('admin.validate-games.table-game-type-header') }}</th>
                                    <th scope="col">{{ trans('admin.validate-games.table-competitions-header') }}</th>
                                    <th scope="col">{{ trans('admin.validate-games.table-dozens-header') }}</th>
                                    <th scope="col">{{ trans('admin.validate-games.table-value-header') }}</th>
                                    <th scope="col">{{ trans('admin.validate-games.table-prize-header') }}</th>
                                    <th scope="col">{{ trans('admin.validate-games.table-invoice-header') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php($totalValue = 0)
                                @php($totalPrize = 0)
                                @forelse($validate_game->games as $game)
   
                                    <tr>
                                        <td>{{$game->id}}</td>
                                        <td>{{$game->typeGame->name}}</td>
                                        <td>{{$game->competition->number}}</td>
                                        <td>{{$game->numbers}}</td>
                                        <td>
                                            R${{\App\Helper\Money::toReal($game->value)}}</td>
                                        <td>
                                            R${{\App\Helper\Money::toReal($game->premio)}}</td>
                                            <td>                             @if($game->checked == 1)
                              <div class="card-body">
                <div class="row mb-2">
                    <div class="col-md-3 mb-3">
                        <a href="{{route('admin.bets.games.receipt', ['game' => $game, 'format' => 'pdf'])}}">
                            <button type="button" class="btn btn-info btn-block">
                                IMG
                            </button>
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{route('admin.bets.games.receipt', ['game' => $game, 'format' => 'txt'])}}">
                            <button type="button" class="btn btn-info btn-block">
                               TXT
                            </button>
                        </a>
                    </div>
                    <div class="col-md-6 ">
                        <a href="https://api.whatsapp.com/send?phone=55{{$validate_game->client->ddd.$validate_game->client->phone}}&text=Jogo de {{$game->typeGame->name }} cadastrado com sucesso! Id da Aposta: {{$game->id}}, Cliente: {{$validate_game->client->name. ' ' . $validate_game->client->last_name}}, Dezenas: {{$game->numbers}}, Valor R${{\App\Helper\Money::toReal($game->value)}}, Prêmio R${{\App\Helper\Money::toReal($game->premio)}}, Data: {{\Carbon\Carbon::parse($game->crated_at)->format('d/m/Y') }}" target="_blank">
                            <button type="button" class="btn btn-info btn-block">
                                WhatsApp
                            </button>
                        </a>
                    </div>
                </div>
                                @endif</td>
                                    </tr>
                                    @php($totalValue += $game->value)
                                    @php($totalPrize += $game->premio)
                                @empty
                                    <tr class="text-center">
                                        <td colspan="4">{{ trans('admin.validate-games.not-found') }}</td>
                                    </tr>
                                </tbody>
                                @endforelse
                                <tfoot>
                                <tr>
                                    <th scope="col">Total</th>
                                    <th scope="col"></th>
                                    <th scope="col"></th>
                                    <th scope="col">R${{\App\Helper\Money::toReal($totalValue)}}</th>
                                    <input type="text" hidden name="valor" value="{{$totalValue}}">
                                    <th scope="col">R${{\App\Helper\Money::toReal($totalPrize)}}</th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6 mb-3">
        <a href="{{route('admin.bets.validate-games.index')}}">
            <button type="button" class="btn btn-block btn-outline-secondary">{{ trans('admin.back-to-main-page') }}</button>
        </a>
    </div>
    <div class="col-md-6 mb-3">
        @if($validate_game->status == 1)
            <button type="submit" id="button_game" class="btn btn-block btn-outline-success" disabled>{{ trans('admin.validate-games.validated') }}!</button>
                
            @else
                <button type="submit" id="button_game" class="btn btn-block btn-outline-success">{{ trans('admin.validate-games.validate') }}</button>
           
        @endif

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
    <script>
        $(document).ready( function () {
            $('#myTable').DataTable();
        } );
    </script>

    <script src="//cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <script src="{{asset('admin/layouts/plugins/inputmask/jquery.inputmask.min.js')}}"></script>
   
   <script>
        $(document).ready(function () {
            $('#cpf').inputmask("999.999.999-99");
            $('#phone').inputmask("(99) 9999[9]-9999");
        });
    </script>

@endpush

