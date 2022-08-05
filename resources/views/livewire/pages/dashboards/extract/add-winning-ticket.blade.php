<div>
    <div wire:loading.delay class="overlayLoading">
        <div class="spinner"></div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card-header indica-card">
                <span class="float-left">Cadastro de Bilhetes</span>
            </div>
        </div>
    </div>
    <div class="row" style="margin-left: 10px;margin-right: 10px;">
        <div class="col-md-2">
            <div class="form-group">
                <select wire:model="range" class="custom-select" id="range" name="range">
                    <option value="0">Diário</option>
                    <option value="1">Ontem</option>
                    <option value="2">Semanal</option>
                    <option value="3">Mensal</option>
                    <option value="4">Personalizado</option>
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <form wire:submit.prevent="submit">
                <div class="form-row">
                    <div class="form-group col-md-6 @if($range != 4) d-none @endif">
                        <input wire:model="dateStart" type="text"
                               class="form-control @error('dateStart') is-invalid @enderror"
                               id="date_start"
                               name="dateStart"
                               autocomplete="off"
                               maxlength="50"
                               placeholder="Data Inicial"
                               onchange="this.dispatchEvent(new InputEvent('input'))">
                        @error('dateStart')
                        <span class="invalid-feedback" role="alert">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-md-6 @if($range != 4) d-none @endif">
                        <input wire:model="dateEnd" type="text"
                               class="form-control date @error('dateEnd') is-invalid @enderror"
                               id="date_end"
                               name="dateEnd"
                               autocomplete="off"
                               maxlength="50"
                               placeholder="Data Final"
                               onchange="this.dispatchEvent(new InputEvent('input'))">
                        @error('dateEnd')
                        <span class="invalid-feedback" role="alert">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="row bg-white p-3">
        @php
            $idGame = 0;
        @endphp

        @forelse($dados as $dado)
            @php
                $nameGame = '';
            @endphp

            @if($idGame !== $dado->typeGame->id)
                @php
                    $nameGame = "<h4 class='alert-heading'>{$dado->typeGame->name}</h4><hr>";
                    $idGame = $dado->typeGame->id;
                @endphp
            @endif

            @forelse($dado->games as $game)
                <div class="col-sm-12 col-md-12">
                    <div class="alert">
                        {!! $nameGame !!}
                        @php
                            $nameGame = '';
                        @endphp

                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="d-flex flex-row">
                                <div class="col-10 bg-cyan align-middle text-left pt-1">
                                    <h5>{{ $game->user->name }} |
                                        <strong>Sorteado em:
                                            {{ \Carbon\Carbon::parse($dado->created_at)->format('d/m/Y') }}
                                        </strong>
                                    </h5>
                                    <small><strong>Sorteado:</strong> {{ $dado->numbers }}</small><br>
                                    <small><strong>Selecionados:</strong> {{ $game->numbers }}</small>
                                </div>
                                <div class="col-2 text-dark text-center">
                                    <button wire:click.prevent="requestApprove({{ $game->id }}, {{ $dado->id }})"
                                            class="btn
                                        btn-outline-success btn-block btn-circle btn-xl m-auto">
                                        <i class="fa fa-check-circle"></i>
                                    </button>
                                    <span class="text-bold">Aprovar</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty

            @endforelse
        @empty
            <div class="col-sm-12"><p>Nenhum jogo vendido.</p></div>
        @endforelse
    </div>
</div>


@push('styles')
    <style>
        .spinner {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            border: 9px solid;
            border-color: #dbdcef;
            border-right-color: #32689a;
            animation: spinner-d3wgkg 1s infinite linear;
            margin-left: calc(50% - 56px);
            margin-top: calc(25% - 56px);
        }
        .overlayLoading{
            min-width: 100%;
            min-height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 99999;
            background-image: repeating-linear-gradient(45deg, #32689a 0, #32689a 3px, transparent 0, transparent 50%);
            background-size: 21px 21px;
            background-color: #333333;
            opacity: .9;
        }

        @keyframes spinner-d3wgkg {
            to {
                transform: rotate(1turn);
            }
        }
        .info-block
        {
            border-right:5px solid #E6E6E6;
            margin-bottom:25px
        }
        .info-block .square-box
        {
            width:100px;
            min-height:110px;
            margin-right:22px;
            text-align:center!important;
            background-color:#676767;
            padding:20px 0
        }
        .info-block.block-info
        {
            border-color:#20819e
        }
        .info-block.block-info .square-box
        {
            background-color:#20819e;
            color:#FFF
        }
        .btn-circle {
            width: 30px;
            height: 30px;
            text-align: center;
            padding: 6px 0;
            font-size: 12px;
            line-height: 1.428571429;
            border-radius: 15px;
        }
        .btn-circle.btn-lg {
            width: 50px;
            height: 50px;
            padding: 10px 16px;
            font-size: 18px;
            line-height: 1.33;
            border-radius: 25px;
        }
        .btn-circle.btn-xl {
            width: 70px;
            height: 70px;
            padding: 10px 16px;
            font-size: 24px;
            line-height: 1.33;
            border-radius: 35px;
        }
    </style>
@endpush

@push('scripts')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <x-livewire-alert::scripts />
    <script src="{{asset('admin/layouts/plugins/daterangepicker/moment.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js"></script>
    <script src="{{asset('admin/layouts/plugins/select2/js/select2.min.js')}}"></script>

    <script>
        $(document).ready(function () {
        });

        var i18n = {
            previousMonth: 'Mês anterior',
            nextMonth: 'Próximo mês',
            months: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
            weekdays: ['Domingo', 'Segunda-feira', 'Terça-feira', 'Quarta-feira', 'Quinta-feira', 'Sexta-feira', 'Sábado'],
            weekdaysShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb']
        };

        var dateStart = new Pikaday({
            field: document.getElementById('date_start'),
            format: 'DD/MM/YYYY',
            i18n: i18n,
        });
        var dateEnd = new Pikaday({
            field: document.getElementById('date_end'),
            format: 'DD/MM/YYYY',
            i18n: i18n,
        });
    </script>

@endpush
