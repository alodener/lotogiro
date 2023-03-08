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
                        </div>

                
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
                        
                        @else                     
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="alias">Valor</label> 
                                    <input type="text" id="guardar" name="guardar" class="form-control ">
                                    @error('alias')
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