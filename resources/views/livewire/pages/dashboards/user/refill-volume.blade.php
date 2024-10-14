
<div class="row  p-3">
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

            
    <div class="row">
        <div class="col-md-12">
            <div class="card-header indica-card">
                Volume de Recarga
            </div>
        </div> 
    </div>

    <div class="container ganhos card-master">
        <div class="card-header indica-card">
            {{ trans('admin.filters') }}
        </div>


        <!-- Exibindo o total de cadastros -->
        
        <div class="d-flex container justify-content-center align-items-center flex-column">
                <div class="d-flex">
                
                    <div class="form-group mr-5">
                        <label for="status">Total de Cadastro</label>
                        <input type="text" class="form-control" id="total_cadastros" value="{{ $totalCadastros }}" readonly>
                    </div> 
                

        <!-- Exibindo o total de recarga -->
        
                    <div class="form-group mr-5">
                        <label for="status">Total de Recarga</label>
                        <input type="text" class="form-control" id="total_cadastros" value= R${{\App\Helper\Money::toReal($totalRecarga)}} readonly>
                    </div> 


                    <!-- Exibindo as datas de início e fim -->
                    <div class="form-group">
                        <label for="range">{{ trans('admin.period') }}</label>
                        <select wire:model="range" class="custom-select" id="range" name="range">
                            <option value="1">{{ trans('admin.daily') }}</option>
                            <option value="2">{{ trans('admin.weekly') }}</option>
                            <option value="3">{{ trans('admin.monthly') }}</option>
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
        
        <!-- Tabela de Volume de Recarga -->
        <div class="table-responsive">
            <!-- Filtro de quantidade de registros por página -->
        <div class="row">
            <!-- Filtro de quantidade de registros por página -->
            <div class="col-md-3 form-group">
                <label for="perPage">Registros por página:</label>
                <select wire:model="perPage" id="perPage" class="form-control">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>
        </div>
            <table class="table table-striped table-hover table-sm" id="user_table">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>R$</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>R${{ \App\Helper\Money::toReal($user->total_recarga) }}</td> 
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center">Nenhum dado encontrado para o período selecionado.</td>
                    </tr>
                    @endforelse
                </tbody>
                
            </table>
        </div>
        <!-- Controles de paginação -->
    <div class="d-flex justify-content-center">
            
            {{ $users->links() }}
       
    </div>
    </div>
    
</div>
</div>
</div>
                


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

   

   

