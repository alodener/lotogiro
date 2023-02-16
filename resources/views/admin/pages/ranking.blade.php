@extends('admin.layouts.master')

@section('title', trans('admin.ranking.page-header'))

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
                    {{ trans('admin.ranking.page-header') }}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 extractable-cel">
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-sm" id="game_table">
                        <thead>
                            <tr>
                                <th>{{ trans('admin.ranking.table-id-header') }}</th>
                                <th>{{ trans('admin.ranking.table-name-header') }}</th>
                                <th>{{ trans('admin.ranking.table-qualification-header') }}</th>
                                <th>{{ trans('admin.ranking.table-personal-points-header') }}</th>
                                <th>{{ trans('admin.ranking.table-group-points-header') }}</th>
                                <th>{{ trans('admin.ranking.table-total-points-header') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pagination->getRows() as $row)
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