@extends('admin.layouts.master')

@section('title', 'Relatório - Concursos')

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

            <div class="table-responsive extractable-cel">
                <table class="table table-striped table-hover table-sm" id="competition_table">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>{{ trans ('admin.used-dozensB.number') }} </th>
                        <th>{{ trans ('admin.used-dozensB.typegame') }}  </th>
                        <th>{{ trans ('admin.used-dozensB.date') }}   </th>
                        <th>{{ trans ('admin.used-dozensB.creation') }}    </th>
                        <th class="acoes">{{ trans ('admin.used-dozensB.actions') }} </th>
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

    <script type="text/javascript">
        $(document).ready(function () {
            var table = $('#competition_table').DataTable({
                language: {
                    "lengthMenu": "{{ trans ('admin.language.lengthMenu') }}",
                    "zeroRecords": "{{ trans ('admin.language.zeroRecords') }}",
                    "info": "{{ trans ('admin.language.info') }}",
                    "infoEmpty":  "{{ trans ('admin.language.infoEmpty') }}",
                    "infoFiltered": "{{ trans ('admin.language.infoFiltered') }}",
                    "search": "{{ trans ('admin.language.search') }}",
                "paginate": {
                    "next": "{{ trans ('admin.language.next') }}",
                    "previous": "{{ trans ('admin.language.previous') }}"
                }
                },
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.reports.used.dozens') }}",
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'number', name: 'number'},
                    {data: 'type_game', name: 'type_game'},
                    {data: 'sort_date', name: 'sort_date'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });
        });
    </script>

@endpush
