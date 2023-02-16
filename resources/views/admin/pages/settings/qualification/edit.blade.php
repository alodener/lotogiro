@extends('admin.layouts.master')

@section('title', 'Editar Qualificação')

@section('content')
<div class="col-md-12">
    <section class="content">
        <form action="{{route('admin.settings.qualifications.update', ['qualification' => $qualification->id])}}" method="POST">
            @csrf
            @method('PUT')
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
                <div class="col-md-12 indica-user">
                    <div class="card card-info pb-5">
                        <div class="card-header">
                            <h3 class="card-title">Qualificação</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="description">Nome</label>
                                    <input type="text" class="form-control @error('description') is-invalid @enderror" id="description" name="description" maxlength="50" value="{{old('description', isset($qualification) ? $qualification->description : null)}}">
                                    @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="goal">Meta de Pontos</label>
                                    <input type="number" class="form-control @error('goal') is-invalid @enderror" id="goal" name="goal" maxlength="50" value="{{old('goal', isset($qualification)? intval($qualification->goal) : 0)}}">
                                    @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="personal_percentage">Aproveitamento Pessoal (%)</label>
                                    <input type="number" class="form-control @error('personal_percentage') is-invalid @enderror" id="personal_percentage" name="personal_percentage" maxlength="50" value="{{old('personal_percentage', isset($qualification) ? intval($qualification->personal_percentage) : 0)}}">
                                    @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="group_percentage">Aproveitamento Grupo (%)</label>
                                    <input type="number" class="form-control @error('group_percentage') is-invalid @enderror" id="group_percentage" name="group_percentage" maxlength="50" value="{{old('group_percentage', isset($qualification) ? intval($qualification->group_percentage) : 0)}}">
                                    @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <a href="{{route('admin.settings.qualifications.index')}}">
                        <button type="button" class="btn btn-block btn-outline-secondary">Voltar a tela principal</button>
                    </a>
                </div>
                <div class="col-md-6 mb-3">
                    <button type="submit" class="btn btn-block btn-outline-success">Alterar</button>
                </div>
            </div>
        </form>
    </section>
</div>
@endsection