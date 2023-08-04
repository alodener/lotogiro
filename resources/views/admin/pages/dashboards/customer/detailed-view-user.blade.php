@extends('admin.layouts.master')

@section('title', trans('admin.games.listing-page-title'))

@section('content')
    <div class="col bg-white p-3">
        <div class="row">
            <div class="col">
                <div class="p-3 bg-body shadow-sm rounded border border-1">
                    <div class="d-flex justify-content-between">
                        <div class="float-start">
                            <h5 class="value">{{ trans('admin.pagesF.totalAposts') }}</h5>
                            <p class="mb-0" style="font-size: 20px;"><b>{{ $total_bets }}</b></p>
                        </div>
                        <div class="float-end d-inline-block bg-light shadow-light rounded-3 p-2">
                            <i style="font-size: 1rem" class="bi bi-file-text-fill"></i>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col">
                <div class="p-3 bg-body shadow-sm rounded border border-1">
                    <div class="d-flex justify-content-between">
                        <div class="float-start">
                            <h5 class="value">{{ trans('admin.pagesF.valorApost') }}</h5>
                            <p class="mb-0" style="font-size: 20px;">{{ 'R$ ' . number_format($total_apostado, 2, '.', ',') }}</p>
                        </div>
                        <div class="float-end d-inline-block bg-light shadow-light rounded-3 p-2">
                            <i class="bi bi-currency-dollar"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="p-2 bg-body shadow-sm rounded border border-1">
                    <div class="d-flex justify-content-between">
                        <div class="float-start">
                            <h4 class="value">{{ trans('admin.pagesF.premioClient') }}</h4>
                            <p class="text-dark" class="mb-0">{{ 'R$' . number_format($total_apostado - $lucro_prejuizo, 2, '.', ',')  }}</p>
                        </div>
                        <div class="float-end d-inline-block bg-light shadow-light rounded-3 p-2">
                            <i class="bi bi-hand-thumbs-up-fill text-success"></i>
                            <i class="bi bi-hand-thumbs-down-fill text-danger"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="p-2 bg-body shadow-sm rounded border border-1">
                    <div class="d-flex justify-content-between">
                        <div class="float-start">
                            <h4 class="value">{{ trans('admin.pagesF.lucropreju') }}</h4>
                            @if ($lucro_prejuizo > 0)
                                <p class="text-success" class="mb-0">{{ 'R$' . number_format($lucro_prejuizo, 2, '.', ',')  }}</p>
                            @elseif ($lucro_prejuizo == 0)
                                <p class="mb-0" style="font-size: 20px;">{{ 'R$' . number_format($lucro_prejuizo, 2, '.', ',')  }}</p>
                            @else
                                <p class="text-danger" class="mb-0" style="font-size: 20px;">{{ 'R$' . number_format($lucro_prejuizo, 2, '.', ',')  }}</p>
                            @endif
                        </div>
                        <div class="float-end d-inline-block bg-light shadow-light rounded-3 p-2">
                            <i class="bi bi-hand-thumbs-up-fill text-success"></i>
                            <i class="bi bi-hand-thumbs-down-fill text-danger"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col">
                <h3>{{ trans('admin.pagesF.visaoDet') }} {{$user->name}} {{$user->last_name}} #{{$user->id}}</h3>
                <table id="table" class="table table-sm">
                    <thead>
                        <tr>
                            <th scope="col"></th>
                            <th aria-controls="widget-options" scope="col">{{ trans('admin.pagesF.concurso') }}</th>
                            <th scope="col"></th>
                            <th scope="col">{{ trans('admin.pagesF.tipoJogo') }}</th>
                            <th scope="col"></th>
                            <th scope="col">{{ trans('admin.pagesF.valorApost') }}</th>
                            <th scope="col"></th>
                            <th scope="col">{{ trans('admin.pagesF.premio') }}</th>
                            <th scope="col"></th>
                            @if ($user_type === 'user_id')
                            <th scope="col">{{ trans('admin.pagesF.client') }}</th>
                            <th scope="col"></th>
                            @endif
                            <th scope="col">{{ trans('admin.pagesF.date') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $user)
                            <tr>
                                <th scope="row">
                                    <td>{{ $user['competition_id'] }}</td>
                                </th>
                                <th scope="row">
                                    <td>{{ $user['type_game'] }}</td>
                                </th>
                                <th scope="row">
                                    <td>{{ 'R$' . number_format($user['value_game'], 2, '.', ',')  }}</td>
                                </th>
                                <th scope="row">
                                    @if ($user['award_game'] != NULL)
                                        <td>{{ 'R$' . number_format($user['award_game'], 2, '.', ',')  }}</td>
                                    @else
                                        <td>R$0,00</td>
                                    @endif
                                </th>
                                @if ($user_type === 'user_id')
                                <th scope="row">
                                    <td>{{ $user['client_name'] == ' ' ? 'Cliente excluído' : $user['client_name'] }}</td>
                                </th>
                                @endif
                                <th scope="row">
                                    <td>{{ $user['date_game']  }}</td>
                                </th>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <a href="{{ route('admin.dashboards.customer.dashboard.winners') }}"><button type="button" class="btn btn-secondary"><i class="bi bi-arrow-left-square-fill"></i></button></a>
                <a href="{{ route('admin.dashboards.customer.get.pdf',['id' => $id_user,'date_initial' => $date_initial, 'date_final' => $date_final]) }}"><button type="button" class="btn btn-danger"><i class="bi bi-filetype-pdf"></i></button></a>
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
