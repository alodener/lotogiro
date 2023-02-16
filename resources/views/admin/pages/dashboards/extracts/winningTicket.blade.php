@extends('admin.layouts.master')

@section('title', 'Extrato de Vendas')

@section('content')
    <div class="row bg-white p-3">
        <div class="col-md-12">
            @livewire('pages.dashboards.extract.winning-ticket')
        </div>
    </div>
@endsection

@push('scripts')
@endpush
