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
            <div class="form-row">
                <div class="form-group col-md-6">
                    <input wire:model="searchTerm" type="text" class="form-control" id="searchTerm"  name="searchTerm"  placeholder="Pesquisar por nome...">
                    @if (!empty($searchTerm))
                        <ul class="name-list">
                            @foreach($users as $user)
                                <li wire:click="selectUser({{$user->id}}, '{{$user->name}} {{$user->last_name}}')" class="name-item">{{$user->name}} {{$user->last_name}}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
                
                <div class="form-group col-md-6">
                    <select wire:model="adminFilter" class="custom-select" id="adminFilter" name="adminFilter" wire:change="updateAdminFilter($event.target.value)">
                        <option value="">Selecione um administrador</option>
                        @foreach($admins as $admin)
                            <option value="{{ $admin->id }}">{{ $admin->name }} {{ $admin->last_name }}</option>
                        @endforeach
                    </select>
                </div>
                
            </div>  
            

            <div class="form-row">
                <div class="form-group col-md-6">
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

            <div class="form-group col-md-6">
                    <select wire:model="typeFilter" class="custom-select" id="typeFilter" name="typeFilter">
                        <option value="">Selecione um tipo de transação</option>
                        <option value="pix">Recargas via pix</option>
                        <option value="manual_recharge">Recarga Manual</option>
                        <option value="bonus_balance">Bônus</option>
                        <option value="saquedisponivel_saldo">Converção de Saque Dísponivel para Saldo</option>
                        <option value="bonus_saquedisponivel">Converção de Bônus para Saque Disponível</option>
                        <option value="saldo_bonus">Conversão de bônus para saldo</option>
                        <option value="bonus_purchase">Bônus de jogo</option>
                        <option value="bichao_purchase">Compra Bichão</option>
                        <option value="game_purchase">Compra Loteria</option>
                        <option value="solicitacao_saque">Solicitação de Saque</option>
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
    
    <div class="col-md-12 p-4">
        <div class="container card-master">
            <div class="row">
                <!--Recargas Através do pix -->
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

                <div class="col-md-6">
                    <!--Total de bonus-->
                    <div class="small-box ">
                        <div class="inner">
                            <h3>R${{number_format($bonus, 2, ',', '.')}}</h3>
                            <p>Total de bônus</p>
                        </div>
                        <div class="icon">
                            <i class="bi bi-cash-coin" style="color:#208E39;"></i>
                        </div>
                        <span class="small-box-footer p-2"></span>
                    </div>
                </div>
            </div>
            <div class="row ">
                <!--Total de recarga manual -->
                <div class="col-md-6">
                    <div class="small-box ">
                        <div class="inner">
                            <h3>R${{number_format($recargaManual, 2, ',', '.')}}</h3>
                            <p>Recarga Manual</p>
                        </div>
                        <div class="icon">
                            <i class="bi bi-cash-coin" style="color:#208E39;"></i>
                        </div>
                        <span class="small-box-footer p-2"></span>
                    </div>
                </div>
                <!--Total de Jogos Bichão  icone do dado-->
                <div class="col-md-6">
                    <div class="small-box ">
                        <div class="inner">
                            <h3>R${{number_format($jogosBichao, 2, ',', '.')}}</h3> 
                            <p>Apostas Jogo do Bicho</p>
                        </div>
                        <div class="icon">
                            <i class="bi bi-joystick" style="color:#850252;"></i>
                        </div>
                        <span class="small-box-footer p-2"></span>
                    </div>
                </div>
            </div>
            
            <div class="row ">
                <!--Jogos realizados-->
                <div class="col-md-6">
                    <div class="small-box ">
                        <div class="inner">
                            <h3>R${{number_format($jogosRealizados, 2, ',', '.')}}</h3>
                            <p>Apostas Loterias</p>
                        </div>
                        <div class="icon">
                            <i class="bi bi-joystick" style="color:#850252;"></i>
                        </div>
                        <span class="small-box-footer p-2"></span>
                    </div>
                </div> 
                <!--Bônus para saldo-->
                <div class="col-md-6">
                    <div class="small-box ">
                        <div class="inner">
                            <h3>R${{number_format($conversaoBonusSaldo, 2, ',', '.')}}</h3>
                            <p>Conversão de bônus para saldo</p>
                        </div>
                        <div class="icon">
                            <i class="bi bi-arrow-left-right" style="color:#15d8e6;"></i>
                        </div>
                        <span class="small-box-footer p-2"></span>
                    </div>
                </div> 
            </div>

            <div class="row ">
                <!--Bônus para Saque Disponível-->
                <div class="col-md-6">
                    <div class="small-box ">
                        <div class="inner">
                            <h3>R${{number_format($conversaoBonusSaque, 2, ',', '.')}}</h3>
                            <p>Converção de Bônus para Saque Disponível</p>
                        </div>
                        <div class="icon">
                            <i class="bi bi-arrow-left-right" style="color:#15d8e6;"></i>
                        </div>
                        <span class="small-box-footer p-2"></span>
                    </div>
                </div>

                <!--Saque Disponível para Saldo-->
                <div class="col-md-6">
                    <div class="small-box ">
                        <div class="inner">
                            <h3>R${{number_format($conversaoSaqueSaldo, 2, ',', '.')}}</h3>
                            <p>Converção de Saque Dísponivel para Saldo</p>
                        </div>
                        <div class="icon">
                            <i class="bi bi-arrow-left-right" style="color:#15d8e6;"></i>
                        </div>
                        <span class="small-box-footer p-2"></span>
                    </div>
                </div> 
            </div>
            <div class="row ">
                <!--Total de todas as transações-->
                <div class="col-md-6">
                    <div class="small-box ">
                        <div class="inner">
                            <h3>R${{number_format($premioTotalLoteria, 2, ',', '.')}}</h3> 
                            <p>Premiação Loterias</p>
                        </div>
                        <div class="icon">
                            <i class="bi bi-currency-exchange" style="color:#cfdd11;"></i>
                        </div>
                        <span class="small-box-footer p-2"></span>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="small-box ">
                        <div class="inner">
                            <h3>R${{number_format($premiosBichao, 2, ',', '.')}}</h3> 
                            <p>Premiação Bichão</p>
                        </div>
                        <div class="icon">
                            <i class="bi bi-currency-exchange" style="color:#cfdd11;"></i>
                        </div>
                        <span class="small-box-footer p-2"></span>
                    </div>
                </div>
            </div>

            <div class="row ">
                <!--Total de todas as transações-->
                <div class="col-md-12">
                <div class="small-box ">
                    <div class="inner">
                        <h3>R${{number_format($totalTransacts, 2, ',', '.')}}</h3> 
                        <p>Total (Recargas via pix +  Recarga Manual - Total Bônus - Premiação JB - Premiação Lotérias) </p>
                    </div>
                    <div class="icon">
                        <i class="bi bi-coin" style="color:#208E39;"></i>
                    </div>
                    <span class="small-box-footer p-2"></span>
                </div>
            </div>
            </div>

        
            <div class="row p-3">
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <select wire:model="perPage" class="custom-select">
                            <option value="10">Mostrando 10 registros</option>
                            <option value="25">Mostrando 25 registros</option>
                            <option value="50">Mostrando 50 registros</option>
                            <option value="100">Mostrando 100 registros</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-12 extractable-cel">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-sm">
                            <thead>
                                <tr>
                                    <th>{{ trans('admin.extracts.table-date-header') }}</th>
                                    <th>{{ trans('admin.extracts.table-user-header') }}</th>
                                    <th>{{ trans('admin.extracts.table-responsible-header') }}</th>
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
                                        <td>
                                            @if($transact->user_id_sender)
                                                <?php
                                                $sender = App\Models\User::find($transact->user_id_sender);
                                                ?>
                                                @if($sender)
                                                    {{ $sender->name }} {{ $sender->last_name }}
                                                @else
                                                    Não encontrado
                                                @endif
                                            @else
                                                Não encontrado
                                            @endif
                                        </td>
                                        <td>{{ is_numeric($transact->value) ? number_format($transact->value, 2, ',', '.') : $transact->value }}</td>
                                        <td>{{ $transact->wallet == 'balance' ? trans('admin.balance') : trans('admin.bonus') }}</td>
                                        <td>{{ $transact->type }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="6">
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
