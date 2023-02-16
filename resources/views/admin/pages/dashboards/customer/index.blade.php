@extends('admin.layouts.master')

@section('title', trans('admin.games.listing-page-title'))

@section('content')
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
        </div>
        <div class="row mt-2">
            <div class="col">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th scope="col"></th>
                            <th scope="col">Nome</th>
                            <th scope="col"></th>
                            <th scope="col">Número</th>
                            <th scope="col"></th>
                            <th scope="col">Email</th>
                            <th scope="col"></th>
                            <th scope="col">Saldo</th>
                            <th scope="col" class="text-center">Comissão</th>
                            <th scope="col"></th>
                            <th scope="col"></th>
                            <th scope="col">Ações</th>
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
                                <td>{{ $user['phone'] }}</td>
                            </th>
                            <th scope="row">
                                <td>{{ $user['email'] }}</td>
                            </th>
                            <th scope="row">
                                @if ($user['balance'] > 0)
                                    <td class="text-success"><?php echo 'R$ '.number_format($user['balance'],2,'.',',');?></td>
                                @else
                                    <td class="text-danger"><?php echo 'R$ '.number_format($user['balance'],2,'.',',');?></td>
                                @endif
                            </th>
                            <th>
                                <form action="{{ route('admin.dashboards.customer.save', ['id'=>$user->id])}}" method="POST">
                                    @method('PUT')
                                    @csrf
                                    <div>
                                        <input type="number" name="commission" value="<?php echo $user['commission'];  ?>"/>
                                        <td><button type="submit" class="btn btn-primary text-light"><i class="bi bi-check2-square"></i></button></td>
                                    </div>
                                </form>
                            </th>
                            <th>
                                @if ($user['is_active'] == 0)
                                    <td><a type="button" href="{{ route('admin.dashboards.customer.unlock', ['id'=>$user->id]) }}" class="btn btn-danger text-light"><i class="bi bi-lock-fill"></i></a></td>
                                @elseif ($user['is_active'] == 1)
                                <td><a type="button" href="{{ route('admin.dashboards.customer.lock', ['id'=>$user->id]) }}" class="btn btn-success text-light"><i class="bi bi-unlock-fill"></i></button></td>
                                @endif
                            </th>
                            <th>
                                @if ($user['contact_made'] == 0)
                                    <td><a type="button" href="{{ route('admin.dashboards.customer.contact.made', ['id'=>$user->id]) }}" class="btn btn-danger text-light"><i class="bi bi-x-square-fill"></i></a></td>
                                @elseif ($user['contact_made'] == 1)
                                <td><a type="button" href="{{ route('admin.dashboards.customer.contact.not.made', ['id'=>$user->id]) }}" class="btn btn-success text-light"><i class="bi bi-check-square-fill"></i></button></td>
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
        crossorigin="anonymous" referrerpolicy="no-referrer" />

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
