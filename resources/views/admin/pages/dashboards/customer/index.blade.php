@extends('admin.layouts.master')

@section('title', trans('admin.games.listing-page-title'))

@section('content')
    <?php
    use App\Models\Draw;
    use App\Models\Game;
    ?>

    <div class="col bg-white p-3 overflow-auto">
        <div class="row">
            <div class="col">
                <h2>Saldo de Clientes</h2>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <p>Controle o acesso dos clientes por aqui!</p>
            </div>
            <div class="col border-left border-top">
                <p>Para ter uma visão detalhada dos clientes premiados<br><a href="{{ route('admin.dashboards.customer.dashboard.winners') }}">Clique Aqui!</a></p>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col">
                <table id="table" class="table table-sm">
                    <thead>
                        <tr>
                            <th scope="col"></th>
                            <th scope="col">Nome</th>
                            <th scope="col"></th>
                            <th scope="col">Sobrenome</th>
                            <th scope="col"></th>
                            <th scope="col">Número</th>
                            <th scope="col"></th>
                            <th scope="col">Email</th>
                            <th scope="col"></th>
                            <th scope="col">Jogos Feitos <br />(Quantidade)</th>
                            <th scope="col">Valor Apostado</th>
                            <th scope="col">Premios Recebidos</th>
                            <th scope="col"></th>
                            <th scope="col">Lucro/<br />Prejuízo</th>
                            <th scope="col">Cliente de<br />Risco</th>
                            <th scope="col" class="text-center">Comissão</th>
                            <th scope="col"></th>
                            <th scope="col"></th>
                            <th scope="col">Bloquear/<br>Desbloquear</th>
                            <th scope="col"></th>
                            <th scope="col">Contato Realizado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <th scope="row">
                                    <td>{{ $user['name'] }}</td>
                                </th>
                                <th scope="row">
                                    <td>{{ $user['last_name'] }}</td>
                                </th>
                                <th scope="row">
                                    <td>{{ $user['phone'] }}</td>
                                </th>
                                <th scope="row">
                                    <td>{{ $user['email'] }}</td>
                                </th>
                                <th>
                                <td>{{ $total_jogos = Game::where('user_id', $user['id'])->count('value') }}</td>
                                <td><?php $total_apostado = Game::where('user_id', $user['id'])->sum('value'); ?> <?php echo 'R$ ' . number_format($total_apostado, 2, '.', ','); ?></td>
                                <td>
                                    <?php $total_soma_premios = 0; ?>
                                    @foreach ($array_official as $line)
                                        @if ($line[1] == $user['id'])
                                            <?php
                                            $jogo = Game::where('id', $line[0])->first();
                                            $total_premio = $jogo['premio'];
                                            $total_soma_premios += $total_premio;
                                            ?>
                                        @endif
                                    @endforeach
                                    <?php echo 'R$' . number_format($total_soma_premios, 2, '.', ',');
                                    $lucro_prejuizo = $total_soma_premios - $total_apostado;
                                    ?>
                                </td>
                                <td>
                                    @if ($lucro_prejuizo > 0)
                                <td class="text-danger">{{ 'R$' . number_format($lucro_prejuizo, 2, '.', ',') }}</td>
                                @elseif ($lucro_prejuizo == 0)
                                    <td>{{ 'R$' . number_format($lucro_prejuizo, 2, '.', ',') }}</td>
                                @else
                                    <td class="text-success">{{ 'R$' . number_format(abs($lucro_prejuizo), 2, '.', ',') }}</td>
                                @endif

                                @if ($lucro_prejuizo <= 2 * $total_apostado)
                                    <td><button type="button" class="btn btn-success disabled"><i
                                                class="bi bi-check-square-fill"></i></button></td>
                                @elseif ($lucro_prejuizo > 2 * $total_apostado && $lucro_prejuizo <= 3 * $total_apostado)
                                    <td><button type="button" class="btn btn-warning disabled text-light"><i
                                                class="bi bi-exclamation-triangle-fill"></i></button></td>
                                @else
                                    <td><button type="button" class="btn btn-danger disabled text-light"><i
                                                class="bi bi-exclamation-triangle-fill"></i></button></td>
                                @endif
                            </th>
                            <th>
                                <form action="{{ route('admin.dashboards.customer.save', ['id' => $user->id]) }}"
                                    method="POST">
                                    @method('PUT')
                                    @csrf
                                    <div>
                                        <input type="number" name="commission" value="<?php echo $user['commission']; ?>" />
                                        <td><button type="submit" class="btn btn-primary text-light"><i
                                        class="bi bi-check2-square"></i></button></td>
                                    </div>
                                </form>
                            <th>
                                @if ($user['is_active'] == 0)
                                    <td><a type="button" href="{{ route('admin.dashboards.customer.unlock', ['id' => $user->id]) }}"
                                    class="btn btn-danger text-light"><i class="bi bi-lock-fill"></i></a></td>
                                @elseif ($user['is_active'] == 1)
                                    <td><a type="button" href="{{ route('admin.dashboards.customer.lock', ['id' => $user->id]) }}"
                                    class="btn btn-success text-light"><i class="bi bi-unlock-fill"></i></button></td>
                                @endif
                            </th>
                            <th>
                                @if ($user['contact_made'] == 0)
                                    <td><a type="button" href="{{ route('admin.dashboards.customer.contact.made', ['id' => $user->id]) }}"
                                    class="btn btn-danger text-light"><i class="bi bi-x-square-fill"></i></a></td>
                                @elseif ($user['contact_made'] == 1)
                                    <td><a type="button" href="{{ route('admin.dashboards.customer.contact.not.made', ['id' => $user->id]) }}"
                                    class="btn btn-success text-light"><i class="bi bi-check-square-fill"></i></button></td>
                                @endif
                            </th>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.13.3/css/selectize.min.css"
    integrity="sha512-bkB9w//jjNUnYbUpATZQCJu2khobZXvLP5GZ8jhltg7P/dghIrTaSJ7B/zdlBUT0W/LXGZ7FfCIqNvXjWKqCYA=="
    crossorigin="anonymous" referrerpolicy="no-referrer"
    />
    <link href="//cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css" rel="stylesheet">
    <style>
        #filterForm {
            margin-top: 30px;
            margin-bottom: 30px;
        }

        #filterForm .form-row {
            justify-content: flex-end;
            align-items: flex-end;
            margin: 0;
        }

        @media(max-width: 467px) {
            #filterForm .form-row {
                flex-direction: column;
            }
        }
    </style>
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
<script>
    $(document).ready(function(){
        $('#table').DataTable({
              "language": {
                  "search": 'Buscar',
                  "lengthMenu": "Mostrando _MENU_ registros por página",
                  "zeroRecords": "Nada encontrado",
                  "info": "Mostrando página _PAGE_ de _PAGES_",
                  "infoEmpty": "Nenhum registro disponível",
                  "infoFiltered": "(filtrado de _MAX_ registros no total)",
              }
          });
    });
    </script>
@endpush
