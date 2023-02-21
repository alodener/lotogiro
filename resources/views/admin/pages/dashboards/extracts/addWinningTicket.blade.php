@extends('admin.layouts.master')

@section('title', trans('admin.sidebar.extract-sales'))

@section('content')
    <div class="row bg-white p-3">
        <div class="col-md-12">
            @livewire('pages.dashboards.extract.add-winning-ticket')
        </div>
    </div>
@endsection

@push('scripts')
@endpush
