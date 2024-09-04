@extends('admin.layouts.master')

@section('title', 'Consultores')

@section('content')
    <div class="row  p-3">
        <div class="col-md-12">
            @livewire('pages.dashboards.user.consultores-indicados')
        </div>
    </div>
@endsection

@push('scripts')

@endpush
