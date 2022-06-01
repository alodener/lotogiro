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
                    Resumo
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{number_format($balances['personal_balance'],2,',','.')}}</h3>
                        <p>Pontos Pessoais</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-star"></i>
                    </div>
                    <span class="small-box-footer p-2"></span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="small-box btn-danger">
                    <div class="inner">
                        <h3>{{number_format($balances['group_balance'],2,',','.')}}</h3>
                        <p>Pontos de Grupo</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-star"></i>
                    </div>
                    <span class="small-box-footer p-2"></span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="small-box btn-success">
                    <div class="inner">
                        <h3>{{number_format($balances['total_balance'],2,',','.')}}</h3>
                        <p>Pontos Totais</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-star"></i>
                    </div>
                    <span class="small-box-footer p-2"></span>
                </div>
            </div>
            <?php if ($qualificationAtived) : ?>
                <div class="col-md-6">
                    <div class="small-box btn-primary">
                        <div class="inner">
                            <h3>{{$qualificationAtived->getQualification()->description}}</h3>
                            <p>Sua Qualificação<?php if (!is_null($goalCalculation)) : ?><br />Aproveitamento Pessoal ( {{$goalCalculation['personalPoints']}} ) / Aproveitamento Grupo ( {{$goalCalculation['groupPoints']}} )<?php endif; ?></p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-award"></i>
                        </div>
                        <span class="small-box-footer p-2"></span>
                    </div>
                </div>
                <?php if ($nextGoal !== false) : ?>
                    <div class="col-md-6">
                        <div class="small-box btn-secondary">
                            <div class="inner">
                                <h3>{{$nextGoal['totalDiff']}}</h3>
                                <p>Quanto pontos faltam para o próxima qualificação<br />Aproveitamento Pessoal ( {{$nextGoal['personalPoints']}} ) / Aproveitamento Grupo ( {{$nextGoal['groupPoints']}} )</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-arrow-up"></i>
                            </div>
                            <div class="progress">
                                <div class="progress-bar progress-bar-striped bg-warning" role="progressbar" style="width: {{floor(round($nextGoal['percentage'],0))}}%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">{{floor(round($nextGoal['percentage'],0))}}%</div>
                            </div>
                        </div>
                    </div>
                <?php else : ?>
                    <div class="col-md-6">
                        <div class="small-box btn-secondary">
                            <div class="inner">
                                <h3>Parabéns você esta no topo</h3>
                                <p>Você esta no mais alto nível do plano de carreira<br />&nbsp;</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-trophy"></i>
                            </div>
                            <span class="small-box-footer p-2"></span>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
        <div class="row">
            <div class="col-md-12 extractable-cel">
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-sm" id="game_table">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Descrição</th>
                                <th>Origem</th>
                                <th>Nível</th>
                                <th>Pontos</th>
                                <th>Criação</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pagination->getRows() as $row)
                            <tr>
                                <td>{{ $row->id }}</td>
                                <td>{{ $row->description }}</td>
                                <td>{{ $row->getOrigin()->name }}</td>
                                <td>{{ $row->level }}</td>
                                <td>
                                    {{ number_format($row->total,2,',','.') }}
                                </td>
                                <td>
                                    {{ date('d/m/Y H:i:s',strtotime($row->created_at)) }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td class="text-center" colspan="9">
                                    Nenhum registro encontrado.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="20">
                                    <div class="clearfix">
                                        <div class="float-left">{{$pagination->getTotal()}} registro(s) encontrado(s).</div>
                                        <nav class="float-right">
                                            {!!$pagination->getHtml()!!}
                                        </nav>
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection