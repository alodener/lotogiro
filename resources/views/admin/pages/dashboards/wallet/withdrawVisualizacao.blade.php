@extends('admin.layouts.master')

@section('title', 'Carteira - Solicitação de Saque')

@section('content')
    <div class="row bg-white p-3">
        <div class="col-md-12">
            @livewire('pages.dashboards.wallet.withdraw.admin-with')
        </div>
    </div>
@endsection

@push('scripts')

@endpush