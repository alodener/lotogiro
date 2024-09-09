@extends('admin.layouts.master')

@section('title', 'Indicados')

@section('content')
    <div class="row  p-3">
        <div class="col-md-12">
            @livewire('pages.dashboards.user.nominees', ['consultorId' => $consultorId])
        </div>
    </div>
@endsection

@push('scripts')

@endpush