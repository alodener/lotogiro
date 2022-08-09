@extends('admin.layouts.master')

@section('title', 'Relatório - Dezenas Utilizadas por Concurso')

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
                        <th>Dezena</th>
                        <th>Quantidade</th>
                    </tr>
                    </thead>
                    <tbody>
                        @if(! empty($usedDozens))
                            @foreach($usedDozens as $dozen => $times)
                                <tr>
                                    <td>{{ $dozen }}</td>
                                    <td>{{ $times }}</td>
                                </tr>
                            @endforeach
                        @endif
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
            var table = $('#competition_table').DataTable({
                language: {
                    url: '{{asset('admin/layouts/plugins/datatables-bs4/language/pt_Br.json')}}'
                },
                columns: [
                    {data: 'dozen', name: 'dozen'},
                    {data: 'times', name: 'times'},
                ],
                dom: 'Bfrtip',
                buttons: [
                    'pdf', 'csv', 'excel'
                ]
            });
        });
    </script>

@endpush
