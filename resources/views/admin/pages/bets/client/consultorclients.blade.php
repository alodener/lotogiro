@extends('admin.layouts.master')

@section('title', trans('admin.customers.new-customer-page-title'))

@section('content')
    <div class="row 
        <div class="col-md-12">
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
            <div class="new-client">
                <button class="btn btn-info my-1"   onclick="redirectToPage()">{{ trans('admin.customers.new-customer') }}</button>                        
            </div>

    <div class="table-responsive extractable-cel">
        <table class="table table-striped table-hover table-sm" id="client_table">
            <tbody>
                <thead>
                        <tr>
                            <th>{{ trans('admin.customers.table-id-header') }}</th>
                            <th>{{ trans('admin.customers.table-name-header') }}</th>
                            <th>{{ trans('admin.customers.table-email-header') }}</th>
                            <th>{{ trans('admin.customers.table-creation-header') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
  
        </table>
    </div>

    @endsection

    @push('scripts')

<script type="text/javascript">

    function redirectToPage() {
            var url = "{{ env('APP_URL') }}/admin/indicate/{{ auth()->user()->id }}";
            window.location.href = url;
    }

    $(document).ready(function () {
            var table = $('#client_table').DataTable({
                language: {
            "lengthMenu": "{{ trans('admin.pagesF.mostrandoRegs') }}",
            "zeroRecords": "{{ trans('admin.pagesF.ndEncont') }}",
            "info": "{{ trans('admin.pagesF.mostrandoPags') }}",
            "infoEmpty": "{{ trans('admin.pagesF.nhmRegs') }}",
            "infoFiltered": "{{ trans('admin.pagesF.filtrado') }}",
            "search" : "{{ trans('admin.pagesF.search') }}",
            "previous": "{{ trans('admin.pagesF.previous') }}",
            "next": "{{ trans('admin.pagesF.next') }}"
                },
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.bets.consultor') }}",
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'email', name: 'email'},
                    {data: 'created_at', name: 'created_at'},
                ]
            });
        });
    </script>
@endpush


