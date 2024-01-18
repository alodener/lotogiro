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
                <h3 class="card-title"> {{ trans('admin.pagesF.editConfig') }} </h3>
            </div>

            <form action="{{route('admin.settings.layout.update', ['layout' => $layout->id])}}" method="POST"
                enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="card-body">
                    <div class="form-row"> 
                        @if ($layout->nome_config == "Botões")
                        <div class="container d-flex flex-md-row flex-column">
                        @php $count = 1; @endphp    
                        @foreach ($layout_button as $layout)
                        {{$layout->id}}
                        <div class="col-md-6 d-flex align-items-center card-button-edit mr-md-4 mb-4 mb-md-0">
                                <div class="form-group">
                                    <div class="d-flex justify-content-between">
                                        <div class="d-flex flex-column">
                                            <label for="alias">Visibilidade</label>
                            
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="visivel_btn{{$count}}"
                                                    id="exampleRadios1_{{$count}}" value="1" @if($layout->visivel == 1) checked @endif>
                                                <label class="form-check-label" for="exampleRadios1_{{$count}}">
                                                    <b> {{ trans('admin.pagesF.ativar') }} </b>
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="visivel_btn{{$count}}"
                                                    id="exampleRadios2_{{$count}}" value="0"  @if($layout->visivel == 0) checked @endif>
                                                <label class="form-check-label" for="exampleRadios2_{{$count}}">
                                                    <b> {{ trans('admin.pagesF.desativar') }} </b>
                                                </label>
                                            </div>
                                        </div>
                                        <div>
                                        </div>

                                        <label for="cor_btn{{$count}}">
                                            <label>Cor do Botão</label>
                                            <div style="background:{{$layout->cor}}" id="areaCor{{$count}}"></div>
                                            <input type="color" id="cor_btn{{$count}}" name="cor_btn{{$count}}"
                                                class="form-control d-none" value="{{$layout->cor}}">

                                        </label>

                                    </div>
                                    <div class="d-flex justify-content-around">
                                        <div class="mr-3">
                                            <label for="alias">Texto do Botão</label>
                                            <input type="text" name="first_text_btn{{$count}}" class="form-control"  value="{{$layout->first_text}}">
                                        </div>
                                        <div>
                                            <label for="alias">Embed Icon</label>
                                            <input type="text" name="second_text_btn{{$count}}" class="form-control "  value="{{$layout->second_text}}">

                                        </div>
                                    </div>
                                    <label for="alias">Link</label>
                                    <input type="text" name="link_btn{{$count}}" class="form-control "  value="{{$layout->link}}">

                                    @error('text')
                                    <span class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            
                            @php $count++; @endphp
                        @endforeach      
                        </div>
                        @endif


                        @if ($layout->nome_config == "Logo do Sistema")
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="alias">{{ trans('admin.pagesF.anexArq') }}</label>
                                <input type="file" name="image" class="form-control ">
                                @error('file')
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
        <a href="{{route('admin.settings.layout.index')}}">
            <button type="button" class="btn btn-block btn-info">{{ trans('admin.pagesF.voltTela') }}</button>
        </a>
    </div>
    <div class="col-md-6 mb-3">
        <button type="submit" class="btn btn-block btn-success">
            {{ trans('admin.pagesF.salvConfig') }} </button>

    </div>
</div>

</form>


<script>
        // Adiciona um ouvinte de evento para detectar mudanças na cor selecionada
        document.getElementById('cor_btn1').addEventListener('input', function() {
            // Obtém o valor da cor selecionada
            var corSelecionada = this.value;

            // Atualiza a cor da área de exibição
            document.getElementById('areaCor1').style.backgroundColor = corSelecionada;
        });
        document.getElementById('cor_btn2').addEventListener('input', function() {
            // Obtém o valor da cor selecionada
            var corSelecionada = this.value;

            // Atualiza a cor da área de exibição
            document.getElementById('areaCor2').style.backgroundColor = corSelecionada;
        });
</script>

@endsection