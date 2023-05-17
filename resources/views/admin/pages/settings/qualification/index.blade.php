@extends('admin.layouts.master')

@section('title', 'Qualificações')

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
            @can('create_user')
                <a href="{{route('admin.settings.qualifications.create')}}">
                    <button class="btn btn-info my-2"> {{ trans ('admin.qualificationIndex.newQ') }} </button>

                </a>
            @endcan
            <div class="table-responsive extractable-cel">
                <table class="table table-striped table-hover table-sm" id="user_table">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>{{ trans ('admin.qualificationIndex.name') }} </th>
                        <th> {{ trans ('admin.qualificationIndex.metaP') }}  </th>
                        <th>{{ trans ('admin.qualificationIndex.aprovP') }} (%)</th>
                        <th>{{ trans ('admin.qualificationIndex.aprovG') }} (%)</th>
                        <th class="acoes">{{ trans ('admin.qualificationIndex.actions') }} </th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_delete_qualification" data-backdrop="static" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">{{ trans ('admin.qualificationIndex.excluiQ') }} </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                {{ trans ('admin.qualificationIndex.actionrevert') }} 
                </div>
                <div class="modal-footer">
                    <form id="destroy" action="" method="POST">
                        @method('DELETE')
                        @csrf
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans ('admin.qualificationIndex.cancel') }}  </button>
                        <button type="submit" class="btn btn-danger"> {{ trans ('admin.qualificationIndex.exclui') }}  </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')

    <script type="text/javascript">

        $(document).on('click', '#btn_delete_qualification', function () {
            var qualification = $(this).attr('qualification');
            var url = '{{ route("admin.settings.qualifications.destroy", ":qualification") }}';
            url = url.replace(':qualification', qualification);
            $("#destroy").attr('action', url);
        });

        $(document).ready(function () {
            var table = $('#user_table').DataTable({
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
                ajax: "{{ route('admin.settings.qualifications.index') }}",
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'description', name: 'description'},
                    {data: 'goal', name: 'goal'},
                    {data: 'personal_percentage', name: 'personal_percentage'},
                    {data: 'group_percentage', name: 'group_percentage'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });
        });
    </script>

@endpush
