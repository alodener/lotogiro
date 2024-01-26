@extends('admin.layouts.master')

@section('title', 'Conversão - Conversão de Bônus para Saldo')

@section('content')
    <div class="row  p-3">
        <div class="col-md-12">
            @livewire('pages.dashboards.wallet.convert')
        </div>
    </div>
@endsection

@push('scripts')

@endpush
