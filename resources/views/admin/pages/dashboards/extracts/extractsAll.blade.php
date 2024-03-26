@extends('admin.layouts.master')

@section('title', 'Extrato Geral')

@section('content')
    <div class="row bg-white p-3">
        <div class="col-md-12">
            @livewire('pages.dashboards.extract.geral-extracts')
        </div>
    </div>
@endsection


@endsection

@push('scripts')
@endpush
