@extends('admin.layouts.master')

@section('title', trans('admin.games.listing-page-title'))

@section('content')
<div class="card card-danger">
    <div class="card-header">
        <h3 class="card-title">Configurar Bichão da sorte</h3>
    </div>
    <div class="card-body">
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <a class="nav-item nav-link active" id="nav-settings-estados" data-toggle="tab" href="#nav-estados" role="tab" aria-controls="nav-estados" aria-selected="true">Estados</a>
                <a class="nav-item nav-link" id="nav-settings-cotacoes" data-toggle="tab" href="#nav-cotacoes" role="tab" aria-controls="nav-cotacoes" aria-selected="true">Cotações</a>
            </div>
        </nav>
        <div class="tab-content p-4" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-estados" role="tabpanel" aria-labelledby="nav-settings-estados">
                @foreach($estados as $estado)
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="estado_{{$estado->id}}" value="{{$estado->id}}" name="settings-bichao-estado" @if($estado->active == 1) checked @endif>
                        <label class="custom-control-label" for="estado_{{$estado->id}}">{{$estado->nome}}</label>
                    </div>
                @endforeach
            </div>
            <div class="tab-pane fade show" id="nav-cotacoes" role="tabpanel" aria-labelledby="nav-settings-cotacoes">
                <div class="row">
                    @foreach($cotacoes as $cotacao)
                        <div class="col-4">
                            <div class="form-group">
                                <label for="name">{{ $cotacao->nome }}</label>
                                <input 
                                    type="text" 
                                    class="form-control settings-bichao-cotacao"
                                    data-id="{{ $cotacao->id }}"
                                    id="campo-{{ $cotacao->id }}" 
                                    name="campo-{{ $cotacao->id }}" 
                                    placeholder="{{ $cotacao->nome }}"
                                    value="{{ $cotacao->multiplicador ?? null }}"
                                >
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6"></div>
    <div class="col-md-6 mb-3">
        <button type="button" id="settings-atualizar-bichao" class="btn btn-block btn-success">Atualizar informações</button>
    </div>
</div>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.13.3/css/selectize.min.css"
        integrity="sha512-bkB9w//jjNUnYbUpATZQCJu2khobZXvLP5GZ8jhltg7P/dghIrTaSJ7B/zdlBUT0W/LXGZ7FfCIqNvXjWKqCYA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        #filterForm {
            margin-top: 30px;
            margin-bottom: 30px;
        }

        #filterForm .form-row {
            justify-content: flex-end;
            align-items: flex-end;
            margin: 0;
        }

        @media(max-width: 467px) {
            #filterForm .form-row {
                flex-direction: column;
            }
        }
    </style>
@endpush

@push('scripts')
<script>
    $('#settings-atualizar-bichao').click(function() {
        const estados = [];
        const cotacoes = [];
        
        $('input[name=settings-bichao-estado]').each(function() {
            estados.push({ id: $(this).val(), active: $(this).is(':checked') ? 1 : 0 });
        });

        $('.settings-bichao-cotacao').each(function() {
            cotacoes.push({ id: $(this).attr('data-id'), value: $(this).val() });
        });

        $.ajax({
            url: '{{url('/')}}/admin/bets/bichao/save/settings',
            type: 'POST',
            dataType: 'json',
            data: { estados, cotacoes },
            success: function(data) {
                alert('Configurações salvas com sucesso!');
            }
        });
    });
</script>
@endpush
