<div>   
    <div class="row">
        <div class="col-md-12">
            <div class="card-header indica-card">
                Relatório de {{ trans('admin.gains-title') }}
            </div>
        </div>
    </div>

    <div class="container  ganhos card-master">
        <div class="card-header indica-card">
            {{ trans('admin.filters') }}
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <input wire:model="searchTerm" type="text" class="form-control" placeholder="Pesquisar por nome...">
                        @if (!empty($searchTerm))
                            <ul class="name-list">
                                @foreach($users as $user)
                                    <li wire:click="selectUser({{$user->id}}, '{{$user->name}} {{$user->last_name}}')" class="name-item">{{$user->name}} {{$user->last_name}}</li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
                <div class="col-md-6">
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
            </div>
        </div>
                  
    <div class="col-md-12">
      
            <div class="form-row">
                <div class="form-group col-md-6 @if($range != 4) d-none @endif">
                    <input wire:model.defer="dtS" type="date" class="form-control" id="date_start" name="dateStart" autocomplete="off" maxlength="50" placeholder="Data Inicial">
                </div>

                <div class="form-group col-md-6 @if($range != 4) d-none @endif">
                    <input wire:model.defer="dtF" type="date" class="form-control" id="date_end" name="dateEnd" autocomplete="off" maxlength="50" placeholder="Data Final">        
                </div>
                <div class="form-group col-md-6 @if($range != 4) d-none @endif">
                    <div class="mt-2">
                        <button wire:click="search"class="btn btn-primary">Buscar</button>
                    </div>
                    <div wire:loading.attr="disabled" wire:target="submit">
                        <!-- Conteúdo que você quer esconder durante a busca -->
                    </div>
                    <div wire:loading>
                        Buscando...
                    </div>
                </div>
            </div>
        
    </div>
</div> 
    <div class="col-md-12 p-4">
        <div class="container card-master">
            <!--Recargas Através do pix e o bônus recebidos através do pix -->
            <div class="row">
                <div class="col-md-6">
                    <div class="small-box ">
                        <div class="inner">
                            <h3>R${{number_format($recargaPix, 2, ',', '.')}}</h3>
                            <p>Recargas via pix</p>
                        </div>
                        <div class="icon">
                            <i class="bi bi-cash-coin" style="color:#208E39;"></i>
                        </div>
                        <span class="small-box-footer p-2"></span>
                    </div>
                </div>

                <!--Total de bonus-->
                <div class="col-md-6">
                    <div class="small-box ">
                        <div class="inner">
                            <h3>R${{number_format($bonus, 2, ',', '.')}}</h3>
                            <p>Total de bônus</p>
                        </div>
                        <div class="icon">
                            <i class="bi bi-coin" style="color:#208E39;"></i>
                        </div>
                        <span class="small-box-footer p-2"></span>
                    </div>
                </div>
            </div>

            <!--Total de recarga manual -->
            <div class="row ">
                <div class="col-md-6">
                    <div class="small-box ">
                        <div class="inner">
                            <h3>R${{number_format($recargaManual, 2, ',', '.')}}</h3>
                            <p>Recarga Manual</p>
                        </div>
                        <div class="icon">
                            <i class="bi bi-cash-coin" style="color:#FFC107;"></i>
                        </div>
                        <span class="small-box-footer p-2"></span>
                    </div>
                </div>

                <!--Total de todas as transações-->
                <div class="col-md-6">
                    <div class="small-box ">
                        <div class="inner">
                            <h3>R${{number_format($totalTransacts, 2, ',', '.')}}</h3> 
                            <p>Total</p>
                        </div>
                        <div class="icon">
                            <i class="bi bi-coin" style="color:#FFC107;"></i>
                        </div>
                        <span class="small-box-footer p-2"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row  p-3">
        <div class="col-md-12 extractable-cel">
            <div class="table-responsive">
                <table class="table table-striped table-hover table-sm">
                    <thead>
                        <tr>
                            <th>{{ trans('admin.extracts.table-date-header') }}</th>
                            <th>{{ trans('admin.extracts.table-user-header') }}</th>
                            <th>{{ trans('admin.extracts.table-value-header') }}</th>
                            <th>{{ trans('admin.extracts.table-wallet-header') }}</th>
                            <th>{{ "Type" }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transacts as $transact)
                            <tr>
                                <td>{{ $transact->created_at->timezone('America/Sao_Paulo')->format('d/m/Y H:i:s') }}</td>
                                <td>{{ $transact->user ? $transact->user->name . ' ' . $transact->user->last_name : 'Usuário não encontrado' }}</td>
                                <td>{{ is_numeric($transact->value) ? number_format($transact->value, 2, ',', '.') : $transact->value }}</td>
                                <td>{{ $transact->wallet == 'balance' ? trans('admin.balance') : trans('admin.bonus') }}</td>
                                <td>{{  $transact->type }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="5">
                                <div class="row">
                                    <div class="col-sm-12 col-md-9">
                                        {{ $transacts->links() }}
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
</div>
</div>

<style>

.name-list {
        list-style: none;
        padding: 0;
    }

    .name-item {
        cursor: pointer;
        padding: 8px 12px;
        margin-bottom: 5px;
        border-radius: 5px;
        background-color: #f0f0f0;
        transition: background-color 0.3s ease;
        color: black; /* Adicione esta linha para definir a cor do texto para preto */
    }

    .name-item:hover {
        background-color: #e0e0e0;
    }
</style>

@push('scripts')
    <script src="{{asset('admin/layouts/plugins/daterangepicker/moment.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js"></script>
    <script src="{{asset('admin/layouts/plugins/select2/js/select2.min.js')}}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/css/bootstrap-select.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/js/bootstrap-select.min.js"></script>


    <script>
        $(document).ready(function () {
        });

        $(document).ready(function() {
        $('.selectpicker').selectpicker();
    });
        
    </script>
@endpush
