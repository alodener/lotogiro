@extends('admin.layouts.master')

@section('title', trans('admin.points.page-title'))

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
                    {{ trans('admin.points.page-header') }}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{number_format($balances['personal_balance'],2,',','.')}}</h3>
                        <p>{{ trans('admin.dashboard.personal-points') }}</p>
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
                        <p>{{ trans('admin.dashboard.group-points') }}</p>
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
                        <p>{{ trans('admin.dashboard.total-points') }}</p>
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
                            <p>{{ trans('admin.dashboard.your-qualification') }}<?php if (!is_null($goalCalculation)) : ?><br />{{ trans('admin.dashboard.personal-points-used') }} ( {{$goalCalculation['personalPoints']}} ) / {{ trans('admin.dashboard.group-points-used') }} ( {{$goalCalculation['groupPoints']}} )<?php endif; ?></p>
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
                                <p>{{ trans('admin.dashboard.points-next-qualification') }}<br />{{ trans('admin.dashboard.personal-points-used') }} ( {{$nextGoal['personalPoints']}} ) / {{ trans('admin.dashboard.group-points-used') }} ( {{$nextGoal['groupPoints']}} )</p>
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
                                <h3>{{ trans('admin.dashboard.max-points-title') }}</h3>
                                <p>{{ trans('admin.dashboard.max-points-text') }}<br />&nbsp;</p>
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
                                <th>{{ trans('admin.points.table-id-header') }}</th>
                                <th>{{ trans('admin.points.table-description-header') }}</th>
                                <th>{{ trans('admin.points.table-origin-header') }}</th>
                                <th>{{ trans('admin.points.table-level-header') }}</th>
                                <th>{{ trans('admin.points.table-points-header') }}</th>
                                <th>{{ trans('admin.points.table-creation-header') }}</th>
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
                                    {{ trans('admin.entries-not-found') }}
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="20">
                                    <div class="clearfix">
                                        <div class="float-left">{{$pagination->getTotal()}} {{ trans('admin.found-entries') }}.</div>
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