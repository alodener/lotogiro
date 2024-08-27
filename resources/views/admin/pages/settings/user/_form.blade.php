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
    <div class="col-12 pb-3">
        <nav>
            <div class="nav nav-tabs card-master d-flex justify-content-start" id="nav-tab" role="tablist">
                <a class="nav-item nav-link active mr-2 mb-2" id="nav-settings-gerais" data-toggle="tab" href="#nav-gerais" role="tab" aria-controls="nav-gerais" aria-selected="true">Informações Gerais</a>
                @foreach ($types as $type)
                    <a class="nav-item nav-link mr-2 mb-2" id="nav-settings-{{$type->id}}" data-toggle="tab" href="#nav-{{$type->id}}" role="tab" aria-controls="nav-{{$type->id}}" aria-selected="true">{{$type->name}}</a>
                @endforeach
                <a class="nav-item nav-link mr-2 mb-2" id="nav-settings-bichao" data-toggle="tab" href="#nav-bichao" role="tab" aria-controls="nav-bichao" aria-selected="true">Bichão</a>
            </div>
        </nav>
    </div>
</div>
<div class="tab-content" id="nav-tabContent">
    <div class="tab-pane fade show active" id="nav-gerais" role="tabpanel" aria-labelledby="nav-settings-gerais">
        <div class="row">
            <div class="col-md-7 indica-user">
                <div class="card card-info pb-5">
                    <div class="card-header">
                        <h3 class="card-title">{{ trans('admin.pagesF.user') }}</h3>
                    </div>
                    <div class="card-body">
                        @if(Route::currentRouteName() == 'admin.settings.users.edit')
                        @can('update_user')
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="status" name="status"
                                       @isset($user->status) @if($user->status == 1) checked @endif @endisset>
                                <label class="custom-control-label" for="status">{{ trans('admin.pagesF.ativo') }}</label>
                            </div>
                            @endcan
                        @endif
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="name">{{ trans('admin.pagesF.name') }}</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                       name="name"
                                       maxlength="50" value="{{old('name', $user->name ?? null)}}">
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-8">
                                <label for="last_name">{{ trans('admin.pagesF.lastname') }}</label>
                                <input type="text" class="form-control @error('last_name') is-invalid @enderror" id="last_name"
                                       name="last_name"
                                       maxlength="100" value="{{old('last_name', $user->last_name ?? null)}}">
                                @error('last_name')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="indicador">{{ trans('admin.pagesF.id') }}</label>
        
                                <div class="input-group">
                                    <input type="number" class="form-control" id="indicador" name="indicador" value="{{old('indicador', $user->indicador ?? null)}}" maxlength="20">
                                    <div class="input-group-append">
                                      <button class="btn btn-outline-primary" data-toggle="modal" data-target="#exampleModal" type="button">{{ trans('admin.pagesF.detalhes') }}</button>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group col-md-8">
                                <label for="email">E-mail</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                       name="email"
                                       maxlength="100" value="{{old('email', $user->email ?? null)}}">
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                               {{ $message }}
                            </span>
                                @enderror
                            </div>
                        </div>
                        <!--<div class="form-row">
                            <div class="form-group col-sm-12">
                                <label for="password">Link de indicação</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon3">https://superjogo.loteriabr.com/admin/indicate/</span>
                                    </div>
                                    <input type="text" class="form-control" id="link" name="link"
                                           aria-describedby="basic-addon3" value="{{old('link', $user->link ?? null)}}">
                                </div>
                                <div class="col-sm-12">
                                    <p class="text-bold">https://superjogo.loteriabr.com/admin/indicate/{{old('link', $user->link ?? null)}}</p>
                                </div>
                            </div>
                        </div>-->
        
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="password">{{ trans('admin.pagesF.senha') }}</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                       id="password" name="password"
                                       maxlength="15">
                                @if(Route::currentRouteName() == 'admin.settings.users.edit')
                                    <small>{{ trans('admin.pagesF.embranco') }}</small>
                                @endif
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="confirm_password">{{ trans('admin.pagesF.confirmSenha') }}</label>
                                <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
                                       id="password_confirmation"
                                       name="password_confirmation" maxlength="15">
                                @error('password_confirmation')
                                <span class="invalid-feedback" role="alert">
                                   {{ $message }}
                                </span>
                                @enderror
                            </div>
        
                            {{-- parte de dados do cliente --}}
                            <div class="form-group col-md-6">
                                <label for="pix" id="pixL">Pix</label>
                                <input type="" class="form-control @error('pix') is-invalid @enderror"
                                       id="pix"
                                       name="pix" maxlength="50" value="{{old('pix', $user->pix ?? null)}}">
                                @error('pix')
                                <span class="invalid-feedback" role="alert">
                                   {{ $message }}
                                </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="telefone" id="telefoneL">{{ trans('admin.pagesF.telefone') }}</label>
                                <input type="text" class="form-control @error('telefone') is-invalid @enderror"
                                       id="telefone"
                                       name="telefone" maxlength="18" value="{{old('phone', isset($user->phone) && !empty($user->phone) ? $user->ddd.$user->phone : null) }}">
                                @error('telefone')
                                <span class="invalid-feedback" role="alert">
                                   {{ $message }}
                                </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="cpf" id="cpfL">Cpf</label>
                                <input type="" class="form-control @error('cpf') is-invalid @enderror"
                                       id="cpf"
                                       name="cpf" maxlength="11"  value="{{old('cpf', $user->cpf ?? null)}}">
                                @error('cpf')
                                <span class="invalid-feedback" role="alert">
                                   {{ $message }}
                                </span>
                                @enderror
                            </div>
        
                        </div>
                    </div>
                </div>
            </div>
           
            <div class="col-md-5 indica-user">
                <div class="card card-info pb-5">
                    <div class="card-header">
                        <h3 class="card-title">{{ trans('admin.pagesF.valores') }}</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="commission">{{ trans('admin.pagesF.porcentComissao') }}</label>
                            <input type="text" class="form-control @error('commission') is-invalid @enderror" id="commission"
                                   name="commission"
                                   maxlength="100" value="{{old('commission', $user->commission ?? null)}}">
                            @error('commission')
                            <span class="invalid-feedback" role="alert">
                               {{ $message }}
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="commission_lv_1">{{ trans('admin.pagesF.porcentComissao1') }}</label>
                            <input type="text" class="form-control @error('commission_lv_1') is-invalid @enderror" id="commission_lv_1"
                                   name="commission_lv_1"
                                   maxlength="100" value="{{old('commission_lv_1', $user->commission_lv_1 ?? null)}}">
                            @error('commission_lv_1')
                            <span class="invalid-feedback" role="alert">
                               {{ $message }}
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="commission_lv_2">{{ trans('admin.pagesF.porcentComissao2') }}</label>
                            <input type="text" class="form-control @error('commission_lv_2') is-invalid @enderror" id="commission_lv_2"
                                   name="commission_lv_2"
                                   maxlength="100" value="{{old('commission_lv_2', $user->commission_lv_2 ?? null)}}">
                            @error('commission_lv_2')
                            <span class="invalid-feedback" role="alert">
                               {{ $message }}
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="commission_lv_3">{{ trans('admin.pagesF.porcentComissao3') }}</label>
                            <input type="text" class="form-control @error('commission_lv_3') is-invalid @enderror" id="commission_lv_3"
                                   name="commission_lv_3"
                                   maxlength="100" value="{{old('commission_lv_3', $user->commission_lv_3 ?? null)}}">
                            @error('commission_lv_3')
                            <span class="invalid-feedback" role="alert">
                               {{ $message }}
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="commission_lv_4">{{ trans('admin.pagesF.porcentComissao4') }}</label>
                            <input type="text" class="form-control @error('commission_lv_4') is-invalid @enderror" id="commission_lv_4"
                                   name="commission_lv_4"
                                   maxlength="100" value="{{old('commission_lv_4', $user->commission_lv_4 ?? null)}}">
                            @error('commission_lv_4')
                            <span class="invalid-feedback" role="alert">
                               {{ $message }}
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="commission_lv_5">{{ trans('admin.pagesF.porcentComissao5') }}</label>
                            <input type="text" class="form-control @error('commission_lv_5') is-invalid @enderror" id="commission_lv_5"
                                   name="commission_lv_5"
                                   maxlength="100" value="{{old('commission_lv_5', $user->commission_lv_5 ?? null)}}">
                            @error('commission_lv_5')
                            <span class="invalid-feedback" role="alert">
                               {{ $message }}
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="commission_lv_6">{{ trans('admin.pagesF.porcentComissao6') }}</label>
                            <input type="text" class="form-control @error('commission_lv_6') is-invalid @enderror" id="commission_lv_6"
                                   name="commission_lv_6"
                                   maxlength="100" value="{{old('commission_lv_6', $user->commission_lv_6 ?? null)}}">
                            @error('commission_lv_6')
                            <span class="invalid-feedback" role="alert">
                               {{ $message }}
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="balanceAtual">{{ trans('admin.pagesF.saldoAtual') }}</label>
                            <input type="text" readonly class="form-control text-right" id="balanceAtual"
                                   name="balanceAtual"
                                   maxlength="100"
                                   value="{{old('balance', !empty($user->balance) ? \App\Helper\Money::toReal($user->balance) : null)}}">
        
                            <label for="balance">{{ trans('admin.pagesF.addSaldo') }}</label>
                            <input type="text" class="form-control @error('balance') is-invalid @enderror" id="balance"
                                   name="balance"
                                   maxlength="100">
                            @error('balance')
                            <span class="invalid-feedback" role="alert">
                               {{ $message }}
                            </span>
                            @enderror
                            <label for="maxSaque">{{ trans('saque máximo') }}</label>
                            <input type="text" class="form-control text-right" id="maxSaque"
                                name="max_saque"  
                                maxlength="255"  
                                value="{{ old('max_saque', isset($user) ? $user->max_saque : '') }}"> 
                                @if ($errors->has('max_saque'))
                                    <div class="alert alert-danger">
                                        {{ $errors->first('max_saque') }}
                                    </div>
                                @endif

                            <label for="saqueDesconto">{{ trans('desconto saque') }}</label>
                            <input type="text" class="form-control text-right" id="saqueDesconto"
                                name="saque_desconto"  
                                maxlength="255"  
                                value="{{ old('saque_desconto', isset($user) ? $user->saque_desconto: '') }}">
                        </div>
                        <div class="form-group">
                            @if(Route::currentRouteName() == 'admin.settings.users.edit')
                                <div class="row">
                                    <div class="col-md-6">
                                <a href="{{route('admin.settings.users.statementBalance', $user->id)}}" class="btn btn-primary btn-block">{{ trans('admin.pagesF.extratSaldo') }}</a>
                                    </div>
                                    <div class="col-md-6">
                                <button type="button" class="btn btn-primary btn-block" onclick="habilitarcampo();">{{ trans('admin.pagesF.ajustManual') }}</button>
                                    </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title">{{ trans('admin.pagesF.funcoes') }}</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            @can('update_role')
                                @if(isset($roles) && $roles->count() > 0)
                                    @foreach($roles as $role)
                                        <div class="custom-control custom-checkbox">
                                            <input type="radio"
                                                    onchange="radioCliente()"
                                                   class="custom-control-input roles"
                                                   id="role{{$role->id}}" value="{{$role->id}}"
                                                   name="roles[]" @if($role->can) checked @else '' @endif>
                                            <label class="custom-control-label" for="role{{$role->id}}">{{$role->name}}</label>
                                        </div>
                                    @endforeach
                                @else
                                    <p>{{ trans('admin.pagesF.aindNExist') }}</p>
                                @endif
                            @else
                                @if(isset($roles) && $roles->count() > 0)
                                    <ul class="list-group ">
                                        @foreach($roles as $role)
                                            <li class="list-group-item">{{$role->name}}</li>
                                        @endforeach
                                    </ul>
                                @endif
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @foreach ($types as $type)
        <div class="tab-pane fade show" id="nav-{{ $type->id }}" role="tabpanel" aria-labelledby="nav-settings-{{ $type->id }}">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-info pb-5">
                        <div class="card-header">
                            <h3 class="card-title">{{ $type->name }}</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @foreach (array_filter($type_values, fn ($val) => $val['type_game_id'] === $type->id) as $value)
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="">Comissão Direta: {{ $value['numbers'] }}</label>
                                            <input type="text" class="form-control"
                                                name="commission_individual[{{ $value['id'] }}]"
                                                maxlength="100" value="{{ isset($commissions->commission_individual[$value['id']]) ? $commissions->commission_individual[$value['id']] : '' }}">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="">Comissão Nivel 1: {{ $value['numbers'] }}</label>
                                            <input type="text" class="form-control"
                                                name="commission_individual_lv_1[{{ $value['id'] }}]"
                                                maxlength="100" value="{{ isset($commissions->commission_individual_lv_1[$value['id']]) ? $commissions->commission_individual_lv_1[$value['id']] : '' }}">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="">Comissão Nivel 2: {{ $value['numbers'] }}</label>
                                            <input type="text" class="form-control"
                                                name="commission_individual_lv_2[{{ $value['id'] }}]"
                                                maxlength="100" value="{{ isset($commissions->commission_individual_lv_2[$value['id']]) ? $commissions->commission_individual_lv_2[$value['id']] : '' }}">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    <div class="tab-pane fade show" id="nav-bichao" role="tabpanel" aria-labelledby="nav-settings-bichao">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-info pb-5">
                    <div class="card-header">
                        <h3 class="card-title">Bichão</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach ($bichao as $bichao_modalidade)
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="">Comissão Direta: {{ $bichao_modalidade->nome }}</label>
                                        <input type="text" class="form-control"
                                            name="commission_individual_bichao[{{ $bichao_modalidade->id }}]"
                                            maxlength="100" value="{{ isset($commissions->commission_individual_bichao[$bichao_modalidade->id]) ? $commissions->commission_individual_bichao[$bichao_modalidade->id] : '' }}">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="">Comissão Nivel 1: {{ $bichao_modalidade->nome }}</label>
                                        <input type="text" class="form-control"
                                            name="commission_individual_bichao_lv_1[{{ $bichao_modalidade->id }}]"
                                            maxlength="100" value="{{ isset($commissions->commission_individual_bichao_lv_1[$bichao_modalidade->id]) ? $commissions->commission_individual_bichao_lv_1[$bichao_modalidade->id] : '' }}">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="">Comissão Nivel 2: {{ $bichao_modalidade->nome }}</label>
                                        <input type="text" class="form-control"
                                            name="commission_individual_bichao_lv_2[{{ $bichao_modalidade->id }}]"
                                            maxlength="100" value="{{ isset($commissions->commission_individual_bichao_lv_2[$bichao_modalidade->id]) ? $commissions->commission_individual_bichao_lv_2[$bichao_modalidade->id] : '' }}">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <a href="{{route('admin.settings.users.index')}}">
            <button type="button" class="btn btn-block btn-outline-secondary">{{ trans('admin.pagesF.voltPrinc') }}</button>
        </a>
    </div>
    <div class="col-md-6 mb-3">
        <button type="submit"
                class="btn btn-block btn-outline-success">@if(request()->is('admin/settings/users/create')) {{ trans('admin.pagesF.cadastrar') }}
                {{ trans('admin.pagesF.usuario') }}  @else  {{ trans('admin.pagesF.atUser') }} @endif </button>
    </div>

    @if(isset($user))
        <div class="col-md-12">
            <a href="{{ route('admin.settings.users.login-as', $user->id) }}" class="btn btn-block btn-outline-info">{{ trans('admin.pagesF.entUser') }}</a>
        </div>
    @endif
</div>

  
  <!-- Modal -->

  @if(isset($user))
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">{{ trans('admin.pagesF.detIndic') }}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <p>

             <strong>{{ trans('admin.pagesF.name') }}: </strong> {{ $user->referrer ? $user->referrer->name . ' ' . $user->referrer->last_name : '-' }}
            </p>
            <p>
                <strong>{{ trans('admin.pagesF.email') }}: </strong> {{ $user->referrer ? $user->referrer->email : '-' }}
            </p>
            <p>
                <strong>{{ trans('admin.pagesF.tel') }}.: </strong> {{ $user->referrer ? $user->referrer->phone : '-' }}
            </p>

            

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
          <a type="button" href="{{ route('admin.settings.users.edit', ['user' => $user->indicador]) }}" target="_blank" class="btn btn-info">Abrir em nova Aba</a>
        </div>
      </div>
    </div>
  </div>

  @endif

  <style>
    .btn-outline-primary {
    padding: 0px 10px;
  
}
  </style>

@push('scripts')
    <script src="{{asset('admin/layouts/plugins/inputmask/jquery.inputmask.min.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $("#balance").inputmask('currency', {
                "autoUnmask": true,
                radixPoint: ",",
                groupSeparator: ".",
                allowMinus: false,
                digits: 2,
                digitsOptional: false,
                rightAlign: true,
                unmaskAsNumber: true
            });
        });

        function habilitarcampo(){
            var campoSaldoAtual = document.getElementById('balanceAtual');
            var campoSaldo = document.getElementById('balance');
            campoSaldoAtual.readOnly = false;
            campoSaldo.readOnly = true;
        }

        $(document).ready(function(){
        let selector = document.getElementById("telefone");
        Inputmask("(99) 9 9999-9999").mask(selector);
    });
    </script>

    <script>
        function radioCliente(){

            if (document.getElementById("role6").checked) {

                document.getElementById("pix").style.visibility = "visible";
                document.getElementById("telefone").style.visibility = "visible";
                document.getElementById("cpf").style.visibility = "visible";

                document.getElementById("pixL").style.visibility = "visible";
                document.getElementById("telefoneL").style.visibility = "visible";
                document.getElementById("cpfL").style.visibility = "visible";

            }
            else{

                document.getElementById("pix").style.visibility = "hidden";
                //document.getElementById("telefone").style.visibility = "hidden";
                document.getElementById("cpf").style.visibility = "hidden";

                document.getElementById("pixL").style.visibility = "hidden";
                //document.getElementById("telefoneL").style.visibility = "hidden";
                document.getElementById("cpfL").style.visibility = "hidden";

            }
        }

    </script>
@endpush
