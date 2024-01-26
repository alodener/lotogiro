@extends('admin.layouts.master')

@section('title', 'Sistema')

@section('content')
<div class="row bg-white p-3">
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
            <div class="table-responsive extractable-cel">
                <table class="table table-striped table-hover table-sm" id="system_table">
                    <thead>
                    <tr>
                        <th>{{ trans('admin.pagesF.config') }}</th>
                        <th>{{ trans('admin.pagesF.valor') }}</th>
                        <th class="acoes">{{ trans('admin.pagesF.acoes') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($system as $system)
                        <tr>
                            <td> {{$system->nome_config}} </td>
                            <td> {{$system->value}} </td>
                            
                            <td> <a href="{{route('admin.settings.systems.edit', ['system' => $system->id ])}}">
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











