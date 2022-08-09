<div>
    <div class="row">
        <div class="col-md-12">
            <div class="card-header indica-card">
                {{ trans('admin.gains-title') }}
            </div>
        </div>
    </div>
    <div class="row ganhos">
        <div class="card-header ganhos-card">
            {{ trans('admin.filters') }}
        </div>
    </div>
    <div class="row ganhos">
        <div class="col-md-3">
            <div class="form-group">
                <label for="status">{{ trans('admin.status') }}</label>
                <select wire:model="status" class="custom-select" id="status" name="status">
                    <option value="">{{ trans('admin.all2') }}</option>
                    <option value="1">{{ trans('admin.open') }}</option>
                    <option value="2">{{ trans('admin.paid') }}</option>
                </select>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="range">{{ trans('admin.period') }}</label>
                <select wire:model="range" class="custom-select" id="range" name="range">
                    <option value="1">{{ trans('admin.monthly') }}</option>
                    <option value="2">{{ trans('admin.weekly') }}</option>
                    <option value="3">{{ trans('admin.daily') }}</option>
                    <option value="4">{{ trans('admin.custom') }}</option>
                </select>
            </div>
        </div>
        <div class="col-md-6 align-self-end">
            <form wire:submit.prevent="submit">
                <div class="form-row">
                    <div class="form-group col-md-6 @if($range != 4) d-none @endif">
                        <input wire:model="dateStart" type="text"
                               class="form-control @error('dateStart') is-invalid @enderror"
                               id="date_start"
                               name="dateStart"
                               autocomplete="off"
                               maxlength="50"
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
                               class="form-control date @error('dateEnd') is-invalid @enderror"
                               id="date_end"
                               name="dateEnd"
                               autocomplete="off"
                               maxlength="50"
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
    </div>
    @if($auth->hasPermissionTo('read_all_sales'))
        <div class="row ganhos">
            <div class="card-header ganhos-card">
                {{ trans('admin.user') }}
            </div>
        </div>
        
        <div class="row ganhos">
            <div class="col-md-12">
                <div class="input-group mb-3">
                    <input wire:model="search" type="text" id="author" class="form-control" placeholder="{{ trans('admin.search-user') }}"autocomplete="off">
                    <div class="input-group-append">
                        <span wire:click="clearUser" class="input-group-text" title="Limpar"><i class="fas fa-user-times"></i></span>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div class="row mb-3" id="list_group" style="max-height: 100px; overflow-y: auto">
        <div class="col-md-12">
            @if($showList)
                <ul class="list-group">
                    @foreach($users as $user)
                        <li wire:click="setId({{ $user }})"
                            class="list-group-item" style="cursor:pointer;">{{ $user->name . ' ' . $user->last_name . ' - ' . $user->email}}</li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{$i ?? null }}</h3>
                    <p>{{ trans('admin.gains.sales-quantity') }}</p>
                </div>
                <div class="icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <span class="small-box-footer p-2"></span>
            </div>
        </div>
        <div class="col-md-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>R${{\App\Helper\Money::toReal($value)}}</h3>
                    <p>{{ trans('admin.gains.direct-sales') }}</p>
                </div>
                <div class="icon">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <span class="small-box-footer p-2"></span>
            </div>
        </div>
    </div>
        <div class="row">
        <div class="col-md-6">
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3>R${{\App\Helper\Money::toReal($valueBonus)}}</h3>
                    <p>{{ trans('admin.gains.bonus') }}</p>
                </div>
                <div class="icon">
                    <i class="fas fas fa-gift"></i>
                </div>
                <span class="small-box-footer p-2"></span>
            </div>
        </div>
        <div class="col-md-6">
            <div class="small-box bg-gold">
                <div class="inner">
                    <h3>R${{\App\Helper\Money::toReal($value + $valueBonus)}}</h3>
                    <p>{{ trans('admin.gains.total-gains') }}</p>
                </div>
                <div class="icon">
                    <i class="fas fa-wallet"></i>
                </div>
                <span class="small-box-footer p-2"></span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-1">
            <select wire:model="perPage" class="custom-select" id="per_page">
                <option>10</option>
                <option>25</option>
                <option>50</option>
                <option>100</option>
            </select>
        </div>
        <div class="form-group offset-md-8 col-md-3">
            <button wire:click="getReport" type="button" class="btn btn-info btn-block">{{ trans('admin.generate-report') }}</button>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 extractable-cel">
            <div class="table-responsive">
                <table class="table table-striped table-hover table-sm" id="game_table">
                    <thead>
                    <tr>
                        <th>{{ trans('admin.gains.table-id-header') }}</th>
                        <th>{{ trans('admin.gains.table-game-type-header') }}</th>
                        <th>{{ trans('admin.gains.table-cpf-header') }}</th>
                        <th>{{ trans('admin.gains.table-customer-header') }}</th>
                        <th>{{ trans('admin.gains.table-user-header') }}</th>
                        <th>{{ trans('admin.gains.table-status-header') }}</th>
                        <th>{{ trans('admin.gains.table-value-header') }}</th>
                        <th>%</th>
                        <th>{{ trans('admin.gains.table-comission-header') }}</th>
                        <th>{{ trans('admin.gains.table-creation-header') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($games as $game)
                        <tr>
                            <td>
                                {{ $game->id }}
                            </td>
                            <td>
                                {{ $game->typeGame->name }}
                            </td>
                            <td>
                                {{ \App\Helper\Mask::addMaskCpf($game->client->cpf) }}
                            </td>
                            <td>
                                {{ $game->client->name . ' ' . $game->client->last_name }}
                            </td>
                            <td>
                                {{ $game->user->name . ' ' . $game->user->last_name }}
                            </td>
                            <td>
                                @if($game->commission_payment) Pago @else Aberto @endif
                            </td>
                            <td>
                                {{ 'R$' . \App\Helper\Money::toReal($game->value) }}
                            </td>
                            <td>
                                {{ $game->commission_percentage ?? 0 }}%
                            </td>
                            <td>
                                {{ 'R$' . \App\Helper\Money::toReal($game->commission_value) }}
                            </td>
                            <td>
                                {{ \Carbon\Carbon::parse($game->created_at)->format('d/m/Y') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="text-center" colspan="9">
                                {{ trans('admin.entries-not-found') }}.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            <div>
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

    <script src="{{asset('admin/layouts/plugins/daterangepicker/moment.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js"></script>
    <script src="{{asset('admin/layouts/plugins/select2/js/select2.min.js')}}"></script>


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

    </style>
@endpush
