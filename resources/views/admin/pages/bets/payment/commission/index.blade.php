@extends('admin.layouts.master')

@section('title', 'Pagamentos - Comissões')

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
    <div class="row  p-3">
        <div class="col-md-12">
            @livewire('pages.bets.payments.commission.table')
        </div>
    </div>
@endsection
