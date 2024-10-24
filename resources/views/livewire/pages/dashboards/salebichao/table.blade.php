<div>
    <div class="row">
            <div class="col-md-12">
                <div class="card-header indica-card">
                    {{ trans('admin.sales.page-header') }}
                </div>
            </div>
        </div>
        <div class="container ganhos card-master">
            <div class="card-header indica-card">
                {{ trans('admin.filters') }}
            </div>
            <div>
                <div class="d-flex container justify-content-center align-items-center flex-column">
                    <div class="d-flex">
                        <div class="form-group mr-5">
                            <label for="status">{{ trans('admin.status') }}</label>
                            <select wire:model="status" class="custom-select" id="status" name="status">
                                <option value="">{{ trans('admin.all2') }}</option>
                                <option value="1">{{ trans('admin.open') }}</option>
                                <option value="2">{{ trans('admin.paid') }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="range">{{ trans('admin.period') }}</label>
                            <select wire:model.defer="range" class="custom-select" id="range" name="range">
                                <option value="1">{{ trans('admin.monthly') }}</option>
                                <option value="2">{{ trans('admin.weekly') }}</option>
                                <option value="3">{{ trans('admin.daily') }}</option>
                                <option value="4">{{ trans('admin.custom') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="">
                        <form wire:submit.prevent="submit">
                            <div class="form-row">
                                <div class="form-group col-md-6 @if($range != 4) d-none @endif">
                                    <input wire:model="dateStart" type="text"
                                        class="form-control @error('dateStart') is-invalid @enderror" id="date_start"
                                        name="dateStart" autocomplete="off" maxlength="50"
                                        placeholder="{{ trans('admin.initial-date') }}"
                                        onchange="this.dispatchEvent(new InputEvent('input'))">
                                    @error('dateStart')
                                    <span class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6 @if($range != 4) d-none @endif">
                                    <input wire:model="dateEnd" type="text"
                                        class="form-control date @error('dateEnd') is-invalid @enderror" id="date_end"
                                        name="dateEnd" autocomplete="off" maxlength="50"
                                        placeholder="{{ trans('admin.end-date') }}"
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
                    <div class="d-flex">
                        <div class="form-group">
                            <label for="valor">Valor</label>
                            <input wire:model.defer="valor" type="text" id="valor" class="form-control" placeholder="ex.: 50.00, 1.000.00">
                        </div>

                        <div class="form-group d-flex align-items-center">
                            <label for="horario" class="mr-2"> Horário</label>
                            <div class="d-flex align-items-center">
                                <select wire:model="horario" class="custom-select" id="horario" wire:key="horario-filter">
                                    <option value="">{{ trans('admin.all') }}</option>
                                    @foreach($horarios as $horarioOption)
                                        <option value="{{ $horarioOption->horario }}">{{ $horarioOption->horario }}</option>
                                    @endforeach
                                </select>
                                <!-- Botão de atualizar ao lado do filtro de horário -->
                                <button type="button" wire:click="reloadHorarios" class="btn btn-light ml-2">
                                    <i class="fas fa-sync-alt"></i> <!-- Ícone de atualização -->
                                </button>
                        </div>
                        </div>
                    </div>
                    
                    
                    <div class="form-group col-md-3">
                        <button wire:click="applyFilters" type="button" class="btn btn-info btn-block">
                            Buscar
                        </button>
                    </div>
                    
                    
                </div>
                
            </div>
        </div>
        @if($auth->hasPermissionTo('read_all_sales'))
        <div class="container card-master mt-3">
            <div class="card-header ">
                {{ trans('admin.user') }}
            </div>
    
            <div class="col-md-12">
                <div class="input-group mb-3">
                    <input wire:model="search" type="text" id="author" class="form-control"
                        placeholder="{{ trans('admin.search-user') }}" autocomplete="off">
                    <div class="input-group-append">
                        <span wire:click="clearUser" class="input-group-text" title="Limpar"><i
                                class="fas fa-user-times"></i></span>
                    </div>
                </div>
            </div>
            @endif
            <div class="row mb-3" id="list_group" style="max-height: 100px; overflow-y: auto">
                <div class="col-md-12">
                    @if($showList && $users->count())
                    <ul class="list-group">
                        @foreach($users as $user)
                        <li wire:click="setId({{ $user }})" class="list-group-item" style="cursor:pointer;">
                            {{ $user['name'] . ' ' . $user['last_name'] . ' - ' . $user['email'] }}
                        </li>
                        @endforeach
                    @endif
    
                </div>
            </div>
        </div>
        <div class="container mt-1 d-flex card-master">
            <div class="col-md-6">
                <div class="small-box">
                    <div class="inner">
                        <h3>{{$i ?? null }}</h3>
    
                        <p>{{ trans('admin.gains.sales-quantity') }}</p>
                    </div>
                    <div class="icon">
                    <i class="fas fa-shopping-cart" style="color:#FFC107;"></i>
                    </div>
                    <span class="small-box-footer p-2"></span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="small-box">
                    <div class="inner">
    
    
                        <h3>R${{\App\Helper\Money::toReal($value)}}</h3>
                        <p>{{ trans('admin.gains.direct-sales') }}</p>
                    </div>
                    <div class="icon">
                    <i class="fas fa-dollar-sign" style="color:#208E39;"></i>
                    </div>
                    <span class="small-box-footer p-2"></span>
                </div>
            </div>
    
        </div>
        <div class="card-master mt-3 container">
            <div class="col-md-12 extractable-cel">
                <div class="col-md-12 d-flex justify-content-between">
                    <div class="form-group col-md-1">
                        <select wire:model="perPage" class="custom-select" id="per_page">
                            <option>10</option>
                            <option>25</option>
                            <option>50</option>
                            <option>100</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button wire:click="getReport" type="button" class="btn btn-info btn-block">{{
                            trans('admin.generate-report') }}</button>
                    </div>
                </div>
                <div class="table-responsive">
                <table class="table table-striped table-hover table-sm" id="game_table">
                    <thead> 
                        <tr>
                            <th>{{ trans('admin.gains.table-id-header') }}</th>
                            <th>{{ trans('admin.bichao.loteria') }}</th>
                            <th>{{ trans('admin.bichao.modalidade') }}</th>
                            <th>{{ trans('admin.bichao.aposta') }}</th>
                            <th scope="col">{{ trans('admin.bichao.resultados') }} <br />({{ trans('admin.falta.valorPagar') }})</th>
                            <th>{{ trans('admin.gains.table-customer-header') }}</th>
                            <th>{{ trans('admin.gains.table-user-header') }}</th>
                            <th>{{ trans('admin.gains.table-status-header') }}</th>
                            <th>{{ trans('admin.gains.posicao') }}</th>
                            <th>{{ trans('admin.gains.table-value-header') }}</th>
                            <th>{{ trans('admin.gains.table-creation-header') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($games as $game)
                            <?php
                                $gameNumbers = [];
                                $prizes = [];

                                if (!is_null($game->game_1)) $gameNumbers[] = str_pad($game->game_1, 2, '0', STR_PAD_LEFT);
                                if (!is_null($game->game_2)) $gameNumbers[] = str_pad($game->game_2, 2, '0', STR_PAD_LEFT);
                                if (!is_null($game->game_3)) $gameNumbers[] = str_pad($game->game_3, 2, '0', STR_PAD_LEFT);
    
                                if ($game['premio_1'] == 1) $prizes[] = 1;
                                if ($game['premio_2'] == 1) $prizes[] = 2;
                                if ($game['premio_3'] == 1) $prizes[] = 3;
                                if ($game['premio_4'] == 1) $prizes[] = 4;
                                if ($game['premio_5'] == 1) $prizes[] = 5;
                            ?>
                            <tr>
                                <td>{{ $game->id }}</td>
                                <td>{{ date('H\hi', strtotime($game->horario->horario)) }} - {{ $game->horario->banca }}</td>
                                <td>{{ $game->modalidade->nome }}</td>
                                <td>{{ str_pad(join(' - ', $gameNumbers), 2, 0, STR_PAD_LEFT) }}</td>
                                <td>
                                    R$ {{$game->premio_a_receber}}
                                 </td>
                                <td>{{ $game->client->name . ' ' . $game->client->last_name }}</td>
                                <td>{{ $game->user->name . ' ' . $game->user->last_name }}</td>
                                <td>@if($game->comission_payment) Pago @else Aberto @endif</td>
                                <td>{{ join('°, ', $prizes) }}°</td>
                                <td>{{ 'R$' . \App\Helper\Money::toReal($game->valor) }}</td>
                                <td>{{ \Carbon\Carbon::parse($game->created_at)->format('d/m/Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td class="text-center" colspan="7">
                                    {{ trans('admin.entries-not-found') }}.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-12">
            {{ $games->links() }}
        </div>
    </div>
    
        </div>
    </div>
    
    @push('styles')
        <link href="{{asset('admin/layouts/plugins/select2/css/select2.min.css')}}" rel="stylesheet"/>
        <link href="{{asset('admin/layouts/plugins/select2-bootstrap4-theme/select2-bootstrap4.css')}}" rel="stylesheet"/>
    @endpush
    
    @push('scripts')
    
        <script src="{{asset('admin/layouts/plugins/daterangepicker/momentd.min.js')}}"></script>
        <script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js"></script>
        <script src="{{asset('admin/layouts/plugins/select2/js/select2.min.js')}}"></script>
    
    
        <style>
        .small-box {
            background: #212425;
        }
        
    </style>
    
        <script>
    
            $(document).ready(function () {
                $('#user').select2({
                    theme: "bootstrap"
                });
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

            document.addEventListener('DOMContentLoaded', function () {
        // Adiciona uma máscara de entrada no campo de valor
            var valorInput = document.getElementById('valor');
                valorInput.addEventListener('input', function (e) {
                    var value = e.target.value;

                    // Remove todos os caracteres não numéricos exceto pontos
                    value = value.replace(/[^0-9.]/g, '');

                    // Adiciona formatação com múltiplos pontos
                    var parts = value.split('.');
                    if (parts.length > 1) {
                        // Mantém os pontos no meio para separar milhares e unidades
                        value = parts.slice(0, -1).join('.') + '.' + parts[parts.length - 1];
                    }

                    // Atualiza o valor do campo com a formatação correta
                    e.target.value = value;
                });
            });
        </script>
    
    
    @endpush
    
    @push('styles')
        <style>
    
            @media screen and (max-width: 760px) {
                
                .extractable-cel {
                    font-size: 8px;
                }
                .extractable-cel thead th {
                    font-size: 9px;
                    text-align: center;
                }
            }
    
        </style>
    @endpush
    
