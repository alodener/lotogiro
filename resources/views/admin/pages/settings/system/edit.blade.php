@extends('admin.layouts.master')

@section('title', 'Editar Configurações')

@section('content')


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
        <div class="card card-danger">
            <div class="card-header">
                <h3 class="card-title"> Editar Configuração</h3>
            </div>

    <form action="{{route('admin.settings.systems.update', ['system' => $system->id])}}" method="POST" enctype="multipart/form-data">
        @method('PUT')
                @csrf    
                <div class="card-body">
     
                    <div class="form-row" >
                        <div class="col-md-6">
                            <label for="file">Nome da configuração:</label>
                                <br>

                            <label for="file">{{$system->nome_config}}</label>
                                <br>
 
                            @if ($system->nome_config == "Logo do Sistema")
                                <img src="{{ url("storage/{$system->value}")}}"
                                 class="brand-image  elevation-3"
                                style="opacity: .8">
                            @endif    

                        </div>
                        @if ($system->nome_config == "Accesstoken MercadoPago")
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="alias">Valor</label> 
                                    <input type="text" name="token" class="form-control ">
                                    @error('text')
                                    <span class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </div>
                            </div>     
                            @endif           
                            
                            @if ($system->nome_config == "Plano de Carreira")
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="alias"><h5><b>Plano de Carreira</b></h5></label>
                                    <div class="form-check">
                                        @if ($system->value == "Desativado" )

                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="Ativado" >
                                                    <label class="form-check-label" for="exampleRadios1">
                                                    <b>   Ativar </b>
                                                    </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="Desativado"checked>
                                                    <label class="form-check-label" for="exampleRadios2">
                                                        <b>   Desativar </b>
                                                    </label>
                                            </div>
                                            @endif 

                                    @if ($system->value == "Ativado" )
                                    
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="Ativado" checked>
                                        <label class="form-check-label" for="exampleRadios1">
                                        <b>  Ativar </b>
                                        </label>
                                      </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="Desativado">
                                            <label class="form-check-label" for="exampleRadios2">
                                                <b>   Desativar </b>
                                            </label>
                                      </div>
                                   @endif
                                    </div>
                                </div>
                            </div>     
                            @endif    

                            @if ($system->nome_config == "E-mail/Remetente")
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="alias">E-mail</label> 
                                    <input type="text" name="mail" class="form-control ">
                                    <br>
                                    <label for="alias">Remetente</label>
                                    <input type="text" name="remetente" class="form-control ">
                                    @error('text')
                                    <span class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </div>
                            </div>     
                            @endif       

                            @if ($system->nome_config == "Bichao")
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="alias"><h5><b>Bichão</b></h5></label>
                                    <div class="form-check">
                                        @if ($system->value == "Desativado" )

                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="Ativado" >
                                                    <label class="form-check-label" for="exampleRadios1">
                                                    <b>   Ativar </b>
                                                    </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="Desativado"checked>
                                                    <label class="form-check-label" for="exampleRadios2">
                                                        <b>   Desativar </b>
                                                    </label>
                                            </div>
                                            @endif 

                                    @if ($system->value == "Ativado" )
                                    
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="Ativado" checked>
                                        <label class="form-check-label" for="exampleRadios1">
                                        <b>  Ativar </b>
                                        </label>
                                      </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="Desativado">
                                            <label class="form-check-label" for="exampleRadios2">
                                                <b>   Desativar </b>
                                            </label>
                                      </div>
                                   @endif
                                    </div>
                                </div>
                            </div>     
                            @endif 
                                                           
              
                        @if ($system->nome_config == "Logo do Sistema")
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="alias">Anexar arquivo</label> 
                                <input type="file"  name="image" class="form-control ">
                                @error('file')
                                    <span class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </span>
                                @enderror   
                            </div>
                        </div>
                        @endif

                        @if ($system->nome_config == "TelegramUrlBot")
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="alias">Valor</label> 
                                    <input type="text" name="telegrambot" class="form-control ">
                                    @error('text')
                                    <span class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </div>
                            </div>     
                            @endif    
                            
                            @if ($system->nome_config == "TelegramChatId")
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="alias">Valor</label> 
                                    <input type="text" name="telegramchatid" class="form-control ">
                                    @error('text')
                                    <span class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </div>
                            </div>     
                            @endif           
                            
                        
                         </div>
                </div>    
        </div>
    
    </div>
</div>
    <div class="row">
                        <div class="col-md-6 mb-3">
                            <a href="{{route('admin.settings.systems.index')}}">
                                <button type="button" class="btn btn-block btn-info">Voltar a tela principal</button>
                            </a>
                        </div>
                        <div class="col-md-6 mb-3">       
                            <button type="submit" class="btn btn-block btn-success">  
                                    Salvar Configuração </button>
                            
                        </div>
                    </div>
                   
                </form>   

@endsection