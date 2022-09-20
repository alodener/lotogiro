@extends('admin.layouts.master')

@section('title', 'Jogos')

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
                <a href="{{route('admin.bets.games.create', ['type_game' => $typeGame])}}">
                    <button class="btn btn-info my-2">Novo Jogo</button>
                </a>
            @endcan
            <div class="table-responsive extractable-cel">
                <table class="table table-striped table-hover table-sm" id="game_table">
                    <thead>
                    <tr>
                        <th></th>
                        <th>Id</th>
                        <th>Tipo de Jogo</th>
                        <th>Cpf Cliente</th>
                        <th>Cliente</th>
                        <th>Usuário</th>
                        <th>Criação</th>
                        <th class="acoes">Ações</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>

                <div class="row-actions">
                    <div class="form-group actions-wrapper col-12 col-sm-2">
                        <select name="table-actions" id="tableActions" class="form-control">
                            <option value="">Selecionar</option>
                            <option value="delete">Deletar</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_delete_game" data-backdrop="static" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Deseja excluir este Jogo?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Está ação não pode ser revertida
                </div>
                <div class="modal-footer">
                    <form id="destroy" action="" method="POST">
                        @method('DELETE')
                        @csrf
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-danger">Excluir</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        $('#tableActions').on('change', function() {
            const actionSelector = $(this);

            let selectedGames = $('.game-checkbox:checked');

            if(selectedGames.length > 0) {
                switch(actionSelector.val()) {
                    case 'delete':
                        massDelete(selectedGames);
                        break;
                }
            } else {
                actionSelector.val('');

                Swal.fire({
                    text: 'Selecione ao menos um jogo!',
                    icon: 'error'
                });
            }
        });

        function massDelete(selectedGames) {
            Swal.fire({
                text: 'Tem certeza que deseja deletar os jogos selecionados?',
                confirmButtonText: 'Remover',
                icon: 'question',
                focusConfirm: false,
            }).then((result) => {
                let ids = [];

                $.each(selectedGames, function(i, selectedGame) {
                    ids[i] = selectedGame.value;
                });

                if(result.isConfirmed) {
                    $.ajax({
                        method: 'POST',
                        url: '{{ route("admin.bets.games.massDelete") }}',
                        data: {
                            ids: ids
                        },
                        success: function(response) {
                            if(response.success) {
                                Swal.fire({
                                    text: response.message,
                                    icon: 'success'
                                }).then((result) => {
                                    if(result.isConfirmed || result.isDismissed) {
                                        document.location.reload(true);
                                    }
                                });
                            }
                        },
                        error: function(xhr) {
                            Swal.fire({
                                text: xhr.responseJSON.error,
                                icon: 'error'
                            });
                        }
                    });
                }
            });
        }

        $(document).on('click', '#btn_delete_game', function () {
            var game = $(this).attr('game');
            var url = '{{ route("admin.bets.games.destroy", ":game") }}';
            url = url.replace(':game', game);
            $("#destroy").attr('action', url);
        });

        $('#btn_copy_link').click(function () {
            var link = document.getElementById("link_copy");
            link.select();
            document.execCommand('copy');
        });

        $(document).ready(function () {
            @error('messageHashGame')
            $('#modal_hash_game').modal('show')
            @enderror
            var table = $('#game_table').DataTable({
                language: {
                    url: '{{asset('admin/layouts/plugins/datatables-bs4/language/pt_Br.json')}}'
                },
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.bets.games.index', ['type_game' => $typeGame]) }}",
                columns: [
                    {data: 'mass_action', name: 'mass_action', orderable: false, searchable: false},
                    {data: 'id', name: 'id'},
                    {data: 'type', name: 'type'},
                    {data: 'client_cpf', name: 'client_cpf'},
                    {data: 'client', name: 'client'},
                    {data: 'user', name: 'user'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });
        });
    </script>

@endpush
