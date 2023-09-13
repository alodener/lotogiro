<div>
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

                    <h3 class="card-title">{{ trans('admin.lwDraw.sorteio') }} </h3>
                 </div>
                 <div class="card-body">
                     <form wire:submit.prevent="store" action="{{route('admin.bets.draws.store')}}" method="POST">
                         @csrf
                         @method('POST')
                         <div class="form-row">
                             <div class="form-group col-md-3">
                                <label for="type_game">{{ trans('admin.lwDraw.typegame') }}  </label>
                                <select wire:model="typeGame"
                                         class="custom-select @error('typeGame') is-invalid @enderror" name="typeGame"
                                         id="type_game">

                                    <option selected value="">{{ trans('admin.lwDraw.selecgame') }} </option>
                                     @if(isset($typeGames) && $typeGames->count() > 0)
                                         @foreach($typeGames as $typeGame)
                                             <option
                                                 value="{{$typeGame->id}}">{{$typeGame->name}}</option>
                                         @endforeach
                                        @endif
                                </select>
                                 @error('typeGame')
                                         {{ $message }}
                                     </span>
                                 @enderror
                             </div>
                             <div class="form-group col-md-2">

                                <label for="competition">{{ trans('admin.lwDraw.concur') }} </label>
                                 <select wire:model="competition"
                                         class="custom-select @error('competition') is-invalid @enderror"
                                         name="competition"
                                         id="competition">

                                    <option selected value="">{{ trans('admin.lwDraw.selec') }} </option>
                                     @if(isset($competitions) && $competitions->count() > 0)
                                         @foreach($competitions as $competition)
                                             <option
                                                 value="{{$competition->id}}">{{$competition->number}}</option>
                                         @endforeach
                                    @endif
                                </select>
                                 @error('competition')
                                         {{ $message }}
                                     </span>
                                 @enderror
                             </div>
                             <div class="form-group col-md-7">

                                <label for="numbers">{{ trans('admin.lwDraw.numsort') }} <small>{{ trans('admin.lwDraw.sepvirg') }} </small></label>
                                 <input wire:model="numbers" type="text"
                                        class="form-control @error('numbers') is-invalid @enderror" id="numbers"
                                        name="numbers"
                                        maxlength="60" value="{{old('numbers', $typeGame->name ?? null)}}">
                                 @error('numbers')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>
                        </div>
                         <div class="form-row">
                             <div class="form-group col-md-12">
                                 <button type="submit" class="btn btn-block btn-outline-success">
                                     <span wire:loading.class="spinner-grow spinner-grow-sm" wire:target="store" class=""
                                           role="status" aria-hidden="true"></span>

                                    <span>{{ trans('admin.lwDraw.buscganh') }}  </span>
                                 </button>
                             </div>
                         </div>
                     </form>
                     @if(!empty($draw))
                         <div class="row mb-3">
                             <div class="col-md-12">
                                 <div class="alert alert-success">
                                    <!-- id do jogo e nome do usuario -->
                                    <h3>{{ trans('admin.lwDraw.sortregis') }} </h3>
                                     <p>
                                         Id: {{$draw->id}}<br/>                                   
                                        {{ trans('admin.lwDraw.concurs') }}  {{$draw->competition}}<br/>
                                        {{ trans('admin.lwDraw.number') }}   {{$draw->numbers}}<br/>
                                        {{ trans('admin.lwDraw.gamesG') }}   {{!empty($draw->games) ? $draw->games : 'Não houve'}}<br/>
                                     </p>
                                 </div>
                             </div>
                         </div>
                     @endif
                     <div class="table-responsive extractable-cel">
                         <table class="table table-striped table-hover table-sm" id="result_table">
                             <thead>
                             <tr>

                                <th>{{ trans('admin.lwDraw.game') }} </th>
                                 <th>Cpf</th>
                                <th>{{ trans('admin.lwDraw.name') }}   </th>
                                <th>{{ trans('admin.lwDraw.valueA') }} </th>
                                <th>{{ trans('admin.lwDraw.valueP') }} </th>
                                <th>{{ trans('admin.lwDraw.rec') }} </th>
                             </tr>
                             </thead>
                             @if(isset($games))
                                 <tbody>
                                 @if($games->count() > 0)
                                 @foreach($games as $game)
                                            <td>{{\App\Helper\Money::toDatabase($game->id)}} </td>
                                            <td>{{\App\Helper\Money::toDatabase($game->client->cpf)}} </td>
                                            <td> {{\App\Helper\Money::toDatabase($game->client->name)}}  </td>
                                             <td>{{\App\Helper\Money::toReal($game->value)}}</td>
                                             <td>{{\App\Helper\Money::toReal($game->premio)}}</td>
                                             <td width="180">
                                                 <a href="{{route('admin.bets.games.receipt', ['game' => $game->id, 'format' => 'pdf', 'prize' => true])}}">
                                                     <button class="btn btn-info btn-sm">

                                                    {{ trans('admin.lwDraw.gerarP') }}
                                                     </button>
                                                 </a>
                                                 <a href="{{route('admin.bets.games.receipt', ['game' => $game, 'format' => 'txt', 'prize' => true])}}">
                                                     <button type="button" class="btn btn-info btn-sm">

                                                    {{ trans('admin.lwDraw.gerarT') }}
                                                     </button>
                                                 </a>
                                             </td>
                                         </tr>
                                     @endforeach
                                 @else
                                     <tr class="text-center">

                                        <td colspan="5"> {{ trans('admin.lwDraw.nHouve') }} {{$numbers}}</td>
                                     </tr>
                                 @endif
                                 </tbody>
                             @endif
                         </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
