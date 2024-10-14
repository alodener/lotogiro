@extends('admin.layouts.master')

@section('title', 'Usuários')

@section('content')
    <div class="row  p-3">
        <div class="col-md-12">
            @livewire('pages.dashboards.user.refill-volume') 
        </div>
    </div>
@endsection

@push('scripts')
@endpush