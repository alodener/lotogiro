<div>
    <div class="card-header ">
       Vencedores

    </div>


    <div class="card-master container">
        <div class="card-header">
            {{ trans('admin.filters') }}
        </div>
        <div class="d-flex container justify-content-center align-items-center flex-column">
                <div class="d-flex">
                   
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
            </div>
    </div>



    <!-- usuario -->
    @if($auth->hasPermissionTo('read_all_sales'))
   
    <div class="mt-3 card-master container">
        <div class="col-md-12">
            <div class="input-group mb-3">
                <input wire:model="searchUser" type="text" id="author" class="form-control" placeholder="Pesquisar Usuário"
                    autocomplete="off">
                <div class="input-group-append">
                    <span wire:click="clearUser" class="input-group-text" title="Limpar">
                        <i class="fas fa-user-times"></i></span>
                </div>
            </div>
        </div>
        <div class="row mb-3" style="max-height: 100px; overflow-y: auto">
            <div class="col-md-12">
                @if($showList)
                <ul class="list-group">
                    @foreach($users as $user)
                    <li wire:click="setId({{ $user }})" class="list-group-item" style="cursor:pointer;">{{ $user->name .
                        ' ' . $user->last_name . ' - ' . $user->email}}</li>
                    @endforeach
                </ul>
                @endif
            </div>
        </div>
    </div>
    @endif

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
                            <th>{{ trans('admin.draws.table-id') }}</th>
                            <th>{{ trans('admin.draws.table-game-type') }}</th>
                            <th>{{ trans('admin.draws.table-game-customer-document') }}</th>
                            <th>{{ trans('admin.draws.table-customer') }}</th>
                            <th>{{ trans('admin.draws.table-user') }}</th>
                            <th>{{ trans('admin.draws.table-competition') }}</th>
                            <th>{{ trans('admin.draws.table-numbers') }}</th>
                            <th>{{ trans('admin.draws.table-prize') }}</th>
                            <th>{{ trans('admin.draws.table-created-at') }}</th>
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
                                {{ $game->competition->id }}
                            </td>
                            <td>
                                {{ $game->numbers }}
                            </td>
                            <td>
                                {{ 'R$' . \App\Helper\Money::toReal($game->premio) }}
                            </td>
                            <td>
                                {{ \Carbon\Carbon::parse($game->competition->sort_date)->format('d/m/Y') }}
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