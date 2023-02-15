@extends('admin.layouts.master')

@section('title', trans('admin.customers.page-title'))

@section('content')
    <div class="row bg-white p-3">
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
            @can('create_client')
                <div class="new-client">
                    <a href="{{route('admin.bets.clients.create')}}">
                        <button class="btn btn-info my-2">{{ trans('admin.customers.new-customer') }}</button>
                    </a> 
                </div>
            @endcan
            <div class="table-responsive extractable-cel">
                <table class="table table-striped table-hover table-sm" id="client_table">
                    <thead>
                    <tr>
                        <th>{{ trans('admin.customers.table-id-header') }}</th>
                        <th>{{ trans('admin.customers.table-name-header') }}</th>
                        <th>{{ trans('admin.customers.table-email-header') }}</th>
                        <th>{{ trans('admin.customers.table-creation-header') }}</th>
                        <th style="width: 80px">{{ trans('admin.customers.table-actions-header') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_delete_client" data-backdrop="static" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">{{ trans('admin.customers.remove-customer-modal-title') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{ trans('admin.exclude-game-text') }}
                </div>
                <div class="modal-footer">
                    <form id="destroy" action="" method="POST">
                        @method('DELETE')
                        @csrf
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('admin.exclude-game-cancel') }}</button>
                        <button type="submit" class="btn btn-danger">{{ trans('admin.exclude-game-confirm') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')

    <script type="text/javascript">

        $(document).on('click', '#btn_delete_client', function () {
            var client = $(this).attr('client');
            var url = '{{ route("admin.bets.clients.destroy", ":client") }}';
            url = url.replace(':client', client);
            $("#destroy").attr('action', url);
        });

        $(document).ready(function () {
            var table = $('#client_table').DataTable({
                language: {
                    url: '{{asset('admin/layouts/plugins/datatables-bs4/language/pt_Br.json')}}'
                },
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.bets.clients.index') }}",
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'email', name: 'email'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });
        });
    </script>

@endpush
