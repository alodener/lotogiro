@extends('admin.layouts.master')

@section('title', 'Relatório - Pontos por Usuário')

@section('content')
    <div class="row  p-3">
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

            <div class="table-responsive extractable-cel">
                <table class="table table-striped table-hover table-sm" id="user_table">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>{{ trans('admin.pagesF.name') }}</th>
                        <th>{{ trans('admin.pagesF.email') }}</th>
                        <th>{{ trans('admin.pagesF.nivel') }}</th>
                        <th>{{ trans('admin.pagesF.pontosP') }}</th>
                        <th>{{ trans('admin.pagesF.pontosE') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            var table = $('#user_table').DataTable({
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
                ajax: "{{ route('admin.reports.points-by-user') }}",
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'email', name: 'email'},
                    {data: 'level', name: 'level'},
                    {data: 'personal_balance', name: 'personal_balance'},
                    {data: 'group_balance', name: 'group_balance'},
                    // {data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                dom: 'Bfrtip',
                buttons: [
                    'pdf', 'csv', 'excel'
                ]
            });
        });
    </script>

@endpush
