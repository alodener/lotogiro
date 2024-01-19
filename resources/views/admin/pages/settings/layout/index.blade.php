@extends('admin.layouts.master')

@section('title', 'Alteração de Layout')

@section('content')
<div class="row p-3" >
    <div class="container col-md-12">
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
            <div class="table-responsive extractable-cel">
                <table class="table table-striped table-hover table-sm" id="system_table">
                    <thead>
                    <tr>
                        <th>{{ trans('admin.pagesF.config') }}</th>
                        <th class="acoes">{{ trans('admin.pagesF.acoes') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($layout as $layout)
                        <tr>
                            <td> {{$layout->nome_config}} </td>
                            
                            <td> <a href="{{route('admin.settings.layout.edit', ['layout' => $layout->id ])}}">
                                        <button class="btn btn-sm btn-warning" title="Editar"><i class="far fa-edit"></i></button>
                                </a>   
                            </td>
                        </tr>
                        @endforeach                      
                    </tbody>
                </table>
            </div>
         
    </div>
</div>

@endsection











