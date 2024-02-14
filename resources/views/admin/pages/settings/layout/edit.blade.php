@extends('admin.layouts.master')

@section('title', 'Carousel Grande')

@section('content')

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

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
        <div class="card mt-5">
            <div class="card-header">
                <h3 class="card-title"> Editando {{$layout->nome_config}}</h3>
            </div>

            <form action="{{route('admin.settings.layout.update', ['layout' => $layout->id])}}" method="POST"
                enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="">
                    <div class="form-row">
                        @if ($layout->nome_config == "Botões")
                        <div class="container d-flex flex-md-row flex-column">
                            <input type="hidden" name="nome_config" class="" value="{{$layout->nome_config}}">

                            @php $count = 1; @endphp
                            @foreach ($layout_button as $layout)
                            <div class="col-md-6 d-flex align-items-center card-button-edit mr-md-4 mb-4 mb-md-0">
                                <div class="form-group">
                                    <div class="d-flex justify-content-between">
                                        <div class="d-flex flex-column">
                                            <label for="alias">Visibilidade</label>

                                            <div class="form-check">
                                                <input class="form-check-input" type="radio"
                                                    name="visivel_btn{{$count}}" id="exampleRadios1_{{$count}}"
                                                    value="1" @if($layout->visivel == 1) checked @endif>
                                                <label class="form-check-label" for="exampleRadios1_{{$count}}">
                                                    <b> {{ trans('admin.pagesF.ativar') }} </b>
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio"
                                                    name="visivel_btn{{$count}}" id="exampleRadios2_{{$count}}"
                                                    value="0" @if($layout->visivel == 0) checked @endif>
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
                                            <input type="text" name="first_text_btn{{$count}}" class="form-control"
                                                value="{{$layout->first_text}}">
                                        </div>
                                        <div>
                                            <label for="alias">Embed Icon</label>
                                            <input type="text" name="second_text_btn{{$count}}" class="form-control "
                                                value="{{$layout->second_text}}">

                                        </div>
                                    </div>
                                    <label class="mt-3" for="alias">Link</label>
                                    <input type="text" name="link_btn{{$count}}" class="form-control "
                                        value="{{$layout->link}}">

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


                    </div>
                    @if ($layout->nome_config == "Carousel Grande")

                    <div class="container  d-flex flex-md-row flex-column">

                        <div class="col-md-6 mx-auto d-flex flex-column align-items-center card-button-edit ">
                            <h4 class="mb-4">Insira um novo Background</h4>

                            <div class="form-group">

                                <div class="d-flex justify-content-between">
                                    <div class="d-flex flex-column">
                                        <label for="alias">Visibilidade</label>

                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="visivel_btn"
                                                id="exampleRadios1_" value="1" checked>
                                            <label class="form-check-label" for="exampleRadios1_">
                                                <b> {{ trans('admin.pagesF.ativar') }} </b>
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="visivel_btn"
                                                id="exampleRadios2_" value="0">
                                            <label class="form-check-label" for="exampleRadios2_">
                                                <b> {{ trans('admin.pagesF.desativar') }} </b>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="d-flex flex-column">

                                    <div class="d-flex justify-content-around">
                                        <div class="mr-3">
                                            <label for="alias">Nome</label>
                                            <input type="text" name="nome" class="form-control"
                                                value="{{$layout->first_text}}">
                                        </div>

                                    </div>
                                    <div class="d-flex justify-content-around">
                                        <div class="mr-3">
                                            <label for="alias">Link</label>
                                            <input type="text" name="link" class="form-control"
                                                value="{{$layout->first_text}}">
                                        </div>

                                    </div>
</div>



                                </div>

                                <div class="col-md-12 mt-3">
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

                                <input type="hidden" name="nome_config" class="" value="{{$layout->nome_config}}">

                                @error('text')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>
                        </div>



                    </div>
                    <div class="table-responsive">

                        <table class="table table-striped table-hover table-sm" id="game_table">
                            <thead>
                                <tr>
                                    <th>{{ trans('admin.gains.table-id-header') }}</th>
                                    <th>Preview</th>
                                    <th>Nome</th>
                                    <th>Link</th>
                                    <th>Visivel</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $count = 1; @endphp

                                @foreach ($layout_carousel_grande as $carousel_grande)

                                <tr>
                                    <th>{{$carousel_grande->id}}</th>
                                    <th><img width="90px" src="{{ url("storage/{$carousel_grande->url}")}}" alt="">
                                    </th>
                                    <th>{{$carousel_grande->nome}}</th>
                                    <th>{{$carousel_grande->link}}</th>

                                    <th>
                                        <div class="d-flex flex-column ">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio"
                                                    name="img_visivel_{{$carousel_grande->id}}" id="exampleRadios1_"
                                                    value="1" @if($carousel_grande->visivel == 1)
                                                checked
                                                @endif>
                                                <label class="form-check-label" for="exampleRadios1_">
                                                    <b> {{ trans('admin.pagesF.ativar') }} </b>
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio"
                                                    name="img_visivel_{{$carousel_grande->id}}" id="exampleRadios2_"
                                                    value="0" @if($carousel_grande->visivel == 0)
                                                checked
                                                @endif>
                                                <label class="form-check-label" for="exampleRadios2_">
                                                    <b> {{ trans('admin.pagesF.desativar') }} </b>
                                                </label>
                                            </div>
                                        </div>
                                    </th>

                                    <th>



                                        <button type="button" class="btn btn-sm btn-danger delete-btn"
                                            data-id="{{$carousel_grande->id}}">
                                            <i class="far fa-trash-alt"></i>
                                        </button>

                                    </th>
                                </tr>
                                @php $count++; @endphp
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                    @endif

                    @if ($layout->nome_config == "Icons Sidebar")

                    <div class="container  d-flex flex-md-row flex-column">

                        <div class="col-md-6 mx-auto d-flex flex-column align-items-center card-button-edit ">
                            <h4 class="mb-4">Insira um novo Icon Sidebar</h4>

                            <div class="form-group">

                                <div class="d-flex justify-content-between">


                                    <div class="d-flex justify-content-around mr-3">
                                        <div class="mr-3">
                                            <label for="alias">Nome</label>
                                            <input type="text" name="nome" class="form-control"
                                                value="{{$layout->first_text}}">
                                        </div>
                                    </div>

                                        <div class="form-group d-flex flex-column text-center">
                                        <label for="alias">Nome</label>

                                            <input type="file" name="image_icon_sidebar" class="custom-file-input form-control"
                                                id="fileInput" style="display: none">
                                            <label for="fileInput"><i style="font-size:30px;" class="fa fa-upload" aria-hidden="true"></i>
                                            </label>

                                            @error('file')
                                            <span class="invalid-feedback" role="alert">
                                                {{ $message }}
                                            </span>
                                            @enderror
                                        </div>
                                </div>





                                <input type="hidden" name="nome_config" class="" value="{{$layout->nome_config}}">

                                @error('text')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>
                        </div>



                    </div>
                    <div class="table-responsive">

                        <table class="table table-striped table-hover table-sm" id="game_table">
                            <thead>
                                <tr>
                                    <th>{{ trans('admin.gains.table-id-header') }}</th>
                                    <th>Preview</th>
                                    <th>Nome</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $count = 1; @endphp

                                @foreach ($layout_icons_sidebar as $icons_sidebar)

                                <tr>
                                    <th>{{$icons_sidebar->id}}</th>
                                    <th><img width="90px" src="{{ url("storage/{$icons_sidebar->url}")}}" alt="">
                                    </th>
                                    <th>{{$icons_sidebar->nome}}</th>

                                    <th>
                                     
                                    </th>

                                    <th>



                                        <button type="button" class="btn btn-sm btn-danger delete-btn-icons"
                                            data-id="{{$icons_sidebar->id}}">
                                            <i class="far fa-trash-alt"></i>
                                        </button>

                                    </th>
                                </tr>
                                @php $count++; @endphp
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                    @endif







                </div>

                <div class="d-flex justify-content-center flex-column flex-md-row">
                    <div class="col-md-3 mb-3">
                        <a href="{{route('admin.settings.layout.index')}}">
                            <button type="button" class="btn btn-block btn-info btn-edit">{{
                                trans('admin.pagesF.voltTela')
                                }}</button>
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <button type="submit" class="btn btn-block btn-success btn-edit ">
                            {{ trans('admin.pagesF.salvConfig') }} </button>

                    </div>
                </div>

            </form>

        </div>
    </div>
</div>
<script>

    $('.delete-btn').on('click', function () {
        var layoutId = $(this).data('id'); // Obtém o ID do layout a ser excluído
        $.ajax({
            type: 'DELETE',
            url: "{{route('admin.settings.layout.destroy', ['layout' => $layout->id])}}",
            data: {
                _token: "{{ csrf_token() }}",
                id: layoutId,
                config: 'Carousel Grande',
            },
            success: function () {
                // Executa ações de sucesso, se necessário
                console.log('Exclusão bem-sucedida');
                location.reload();
            },
            error: function (xhr, status, error) {
                // Trata erros, se necessário
                console.error('Erro durante a exclusão:', error);
            }
        });


    });
    
    $('.delete-btn-icons').on('click', function () {
        var layoutId = $(this).data('id'); // Obtém o ID do layout a ser excluído
        $.ajax({
            type: 'DELETE',
            url: "{{route('admin.settings.layout.destroy', ['layout' => $layout->id])}}",
            data: {
                _token: "{{ csrf_token() }}",
                id: layoutId,
                config: 'Icons Sidebar'
            },
            success: function (data) {
                // Executa ações de sucesso, se necessário
                console.log('Exclusão bem-sucedida');
                location.reload();
            },
            error: function (xhr, status, error) {
                // Trata erros, se necessário
                console.error('Erro durante a exclusão:', error);
            }
        });


        // Adiciona um ouvinte de evento para detectar mudase   document.getElementById('cor_btn1').addEventListener('input', function () {
        // Obtém o valor da cor selecionada

        // Atualiza a cor da área de exibição
    });
    var corSelecionada = this.value;
    document.getElementById('areaCor1').style.backgroundColor = corSelecionada;

    document.getElementById('cor_btn2').addEventListener('input', function () {
        // Obtém o valor da cor selecionada
        var corSelecionada = this.value;

        // Atualiza a cor da área de exibição
        document.getElementById('areaCor2').style.backgroundColor = corSelecionada;
    });
</script>

@endsection