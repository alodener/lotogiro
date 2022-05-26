@extends('admin.layouts.master')

@section('title', 'Relatório de Pontos')

@section('content')
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

@section('content')
<div class="row bg-white p-3">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12">
                <div class="card-header indica-card">
                    Ranking
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 extractable-cel">
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-sm" id="game_table">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Nome</th>
                                <th>Qualificação</th>
                                <th>Pontos Pessoais</th>
                                <th>Pontos de Grupo</th>
                                <th>Pontos Totais</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $row)
                            <tr>
                                <td>{{ $row->id }}</td>
                                <td>{{ $row->name }}</td>
                                <td>{{ $row->getUserQualification()->getQualification()->description }}</td>
                                <td>{{ $row->getUserQualification()->personal_points }}</td>
                                <td>{{ $row->getUserQualification()->group_points }}</td>
                                <td>{{ $row->getUserQualification()->total_points }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td class="text-center" colspan="9">
                                    Nenhum registro encontrado.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection