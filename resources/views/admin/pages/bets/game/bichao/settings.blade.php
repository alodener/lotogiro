@extends('admin.layouts.master')

@section('title', trans('admin.games.listing-page-title'))

@section('content')
<div class="card card-danger">
    <div class="card-header">
    <h3 class="card-title">{{ trans('admin.bichao.confBichao') }}</h3>
    </div>
    <div class="card-body">
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <a class="nav-item nav-link active" id="nav-settings-estados" data-toggle="tab" href="#nav-estados" role="tab" aria-controls="nav-estados" aria-selected="true">{{ trans('admin.pagesF.estados') }}</a>
                <a class="nav-item nav-link" id="nav-settings-cotacoes" data-toggle="tab" href="#nav-cotacoes" role="tab" aria-controls="nav-cotacoes" aria-selected="true">{{ trans('admin.pagesF.cotacoes') }}</a>
                <a class="nav-item nav-link" id="nav-settings-premio_maximo" data-toggle="tab" href="#nav-premio_maximo" role="tab" aria-controls="nav-premio_maximo" aria-selected="true">{{ trans('admin.pagesF.premio_maximo') }}</a>
                <a class="nav-item nav-link" id="nav-settings-invertida_limite" data-toggle="tab" href="#nav-invertida_limite" role="tab" aria-controls="nav-invertida_limite" aria-selected="true">{{ trans('admin.pagesF.invertida_limite') }}</a>
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
                        @if ($cotacao->id == 6 || $cotacao->id == 7 || $cotacao->id == 10 || $cotacao->id == 11)
                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label for="name">{{ $cotacao->nome }} 1 ao 3</label>
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
                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label for="name">{{ $cotacao->nome }} 1 ao 5</label>
                                <input 
                                    type="text" 
                                    class="form-control settings-bichao-cotacao"
                                    data-id="{{ $cotacao->id }}b"
                                    id="campo-{{ $cotacao->id }}b" 
                                    name="campo-{{ $cotacao->id }}b" 
                                    placeholder="{{ $cotacao->nome }}"
                                    value="{{ $cotacao->multiplicador_2 ?? null }}"
                                >
                            </div>
                        </div>
                        @else
                        <div class="col-md-4 col-12">
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
                        @endif
                    @endforeach
                </div>
            </div>
            <div class="tab-pane fade show" id="nav-premio_maximo" role="tabpanel" aria-labelledby="nav-settings-premio_maximo">
                <div class="row">
                    @foreach($cotacoes as $cotacao)
                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label for="name">{{ $cotacao->nome }}</label>
                                <input
                                    type="text" 
                                    class="form-control settings-bichao-premio_maximo"
                                    data-id="{{ $cotacao->id }}"
                                    id="campo-premio-{{ $cotacao->id }}" 
                                    name="campo-premio-{{ $cotacao->id }}" 
                                    placeholder="{{ $cotacao->nome }}"
                                    value="{{ $cotacao->premio_maximo ?? null }}"
                                >
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="tab-pane fade show" id="nav-invertida_limite" role="tabpanel" aria-labelledby="nav-settings-invertida_limite">
                <div class="row">
                    @foreach($cotacoes as $cotacao)
                        <?php if (!str_contains($cotacao->nome, 'Invertida')): continue;endif ?>
                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label for="name">{{ $cotacao->nome }}</label>
                                <input
                                    type="text" 
                                    class="form-control settings-bichao-invertida_limite"
                                    data-id="{{ $cotacao->id }}"
                                    id="campo-premio-{{ $cotacao->id }}" 
                                    name="campo-premio-{{ $cotacao->id }}" 
                                    placeholder="{{ $cotacao->nome }}"
                                    value="{{ $cotacao->bet_limit ?? null }}"
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
        <button type="button" id="settings-atualizar-bichao" class="btn btn-block btn-success">{{ trans('admin.bichao.atInfos') }}</button>
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
        const premio_maximo = [];
        const bet_limit = [];
        
        $('input[name=settings-bichao-estado]').each(function() {
            estados.push({ id: $(this).val(), active: $(this).is(':checked') ? 1 : 0 });
        });

        $('.settings-bichao-cotacao').each(function() {
            cotacoes.push({ id: $(this).attr('data-id'), value: $(this).val() });
        });

        $('.settings-bichao-premio_maximo').each(function() {
            premio_maximo.push({ id: $(this).attr('data-id'), value: $(this).val() });
        });

        $('.settings-bichao-invertida_limite').each(function() {
            bet_limit.push({ id: $(this).attr('data-id'), value: $(this).val() });
        });

        $.ajax({
            url: '{{url('/')}}/admin/bets/bichao/save/settings',
            type: 'POST',
            dataType: 'json',
            data: { estados, cotacoes, premio_maximo, bet_limit },
            success: function(data) {
                alert('Configurações salvas com sucesso!');
            }
        });
    });
</script>
@endpush
