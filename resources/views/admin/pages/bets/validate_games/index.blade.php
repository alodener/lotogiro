@extends('admin.layouts.master')

@section('title', trans('admin.validate-games.listing-page-title'))

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
            <h4 class="text-center mb-4 validate-msg">
                {{ trans('admin.validate-games.listing-message') }}
            </h4>
            <div class="table-responsive extractable-cel">
                <table class="table table-striped table-hover table-sm" id="bet_table">
                    <thead>
                    <tr>
                        <th>{{ trans('admin.validate-games.table-id-header') }}</th>
                        <th>{{ trans('admin.validate-games.table-client-header') }}</th>
                        <th>{{ trans('admin.validate-games.table-created-header') }}</th>
                        <th style="width: 80px">{{ trans('admin.validate-games.table-actions-header') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_delete_bet" data-backdrop="static" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">{{ trans('admin.validate-games.delete-modal-header') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{ trans('admin.validate-games.delete-modal-body') }}
                </div>
                <div class="modal-footer">
                    <form id="destroy" action="" method="POST">
                        @method('DELETE')
                        @csrf
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('admin.validate-games.exclude-game-cancel') }}</button>
                        <button type="submit" class="btn btn-danger">{{ trans('admin.validate-games.exclude-game-confirm') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')

    <script type="text/javascript">

        $(document).on('click', '#btn_delete_bet', function () {
            var bet = $(this).attr('bet');
            var url = '{{ route("admin.bets.validate-games.destroy", ":bet") }}';
            url = url.replace(':bet', bet);
            $("#destroy").attr('action', url);
        });

        $(document).ready(function () {
            var table = $('#bet_table').DataTable({
                language: {
                    url: '{{asset('admin/layouts/plugins/datatables-bs4/language/pt_Br.json')}}'
                },
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.bets.validate-games.index') }}",
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'client', name: 'client'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });
        });
    </script>

@endpush
