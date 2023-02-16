<div>
    <div class="row">
        <div class="col-md-12">
            <div class="card-header indica-card">
                {{ trans('admin.extracts.manual-recharge') }}
            </div>
        </div>
    </div>
    <div class="row" style="margin-left: 10px;margin-right: 10px;">
        <div class="col-md-4">
            <div class="form-group">
                <select wire:model="adminSelected" class="custom-select" id="user" name="user">
                    <option value="0">{{ trans('admin.all-admins') }}</option>
                    @foreach($admins as $admin)
                        <option value="{{$admin['id']}}">{{ $admin['name'] }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <select wire:model="range" class="custom-select" id="range" name="range">
                    <option value="0">{{ trans('admin.all') }}</option>
                    <option value="1">{{ trans('admin.monthly') }}</option>
                    <option value="2">{{ trans('admin.weekly') }}</option>
                    <option value="3">{{ trans('admin.daily') }}</option>
                    <option value="4">{{ trans('admin.custom') }}</option>
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
        <div class="col-md-12 extractable-cel">
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered table-lg">
                    <thead>
                    <tr>
                        <th>{{ trans('admin.extracts.table-date-header') }}</th>
                        <th>{{ trans('admin.extracts.table-responsible-header') }}</th>
                        <th>{{ trans('admin.extracts.table-user-header') }}</th>
                        <th>{{ trans('admin.extracts.table-value-header') }}</th>
                        <th>{{ trans('admin.extracts.table-wallet-header') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($transacts as $transact)
                        <tr>
                            <td>{{ $transact->data }}</td>
                            <td>{{ $transact->responsavel }}</td>
                            <td>{{ $transact->usuario }}</td>
                            <td>{{ $transact->value }}</td>
                            <td>{{ $transact->wallet == 'balance' ? trans('admin.balance') : trans('admin.bonus') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">
                                <div class="row">
                                    <div class="col-sm-12">
                                        {{ trans('admin.entries-not-found') }}
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="5">
                            <div class="row">
                                <div class="col-sm-12 col-md-9">
                                    {{ $transacts->links() }}
                                </div>
                                <div class="col-sm-12 col-md-3 text-right text-bold">
                                    {{ trans('admin.total') }}: R$ {{ $transacts->valueTotal }}
                                </div>
                            </div>
                        </td>
                    </tr>
                    </tfoot>
                </table>
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