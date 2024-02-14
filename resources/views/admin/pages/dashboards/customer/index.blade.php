@extends('admin.layouts.master')

@section('title', trans('admin.games.listing-page-title'))

@push('styles')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
@endpush

@section('content')
    <div class="col  p-3 overflow-auto">
        <div class="row">
            <div class="col">
                <h2>{{ trans('admin.pagesF.saldoCliente') }}</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <p>{{ trans('admin.pagesF.controle') }}</p>
            </div>
            <div class="col-md-6 col-12">
                <div class="row busca-container">
                    <div class="col-2">
                        <select class="change-busca form-control" name="busca-per-page" data-busca-param="perPage">
                            <option value="10" {{ $perPage == '10' ? 'selected' : '' }} >10</option>
                            <option value="20" {{ $perPage == '20' ? 'selected' : '' }} >20</option>
                            <option value="50" {{ $perPage == '50' ? 'selected' : '' }} >50</option>
                            <option value="100" {{ $perPage == '100' ? 'selected' : '' }} >100</option>
                        </select>
                    </div>
                    <div class="col-2">
                        <select class="change-busca form-control" name="busca-intervalo" data-busca-param="intervalo">
                            <option value="30" {{ $intervalo == '30' ? 'selected' : '' }} >30 {{ trans('admin.pagesF.dias') }}</option>
                            <option value="60" {{ $intervalo == '60' ? 'selected' : '' }} >60 {{ trans('admin.pagesF.dias') }}</option>
                            <option value="90" {{ $intervalo == '90' ? 'selected' : '' }} >90 {{ trans('admin.pagesF.dias') }}</option>
                        </select>
                    </div>
                    <div class="col-4">
                        <input type="text" class="form-control" name="user_name" placeholder="Buscar..." id="busca-autocomplete" />
                        <input type="hidden" id="busca-autocomplete-id">
                    </div>
                    <div class="col-2">
                        <button type="button" class="btn btn-success" id="busca-limpar">{{ trans('admin.pagesF.limpar') }}</button>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-12">
                <div class="row">
                    <div class="col border-left border-top">
                        <p>{{ trans('admin.pagesF.visaoDet') }}<br><a href="{{ route('admin.dashboards.customer.dashboard.winners') }}">{{ trans('admin.pagesF.cliqueaqq') }}</a></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th scope="col"></th>
                            <th scope="col">{{ trans('admin.pagesF.name') }}</th>
                            <th scope="col"></th>
                            <th scope="col">{{ trans('admin.pagesF.lastname') }}</th>
                            <th scope="col"></th>
                            <th scope="col">{{ trans('admin.pagesF.numeros') }}</th>
                            <th scope="col"></th>
                            <th scope="col">{{ trans('admin.pagesF.email') }}</th>
                            <th scope="col"></th>
                            <th scope="col">{{ trans('admin.pagesF.jogosfeitos') }} <br />{{ trans('admin.pagesF.quantidade') }}</th>
                            <th scope="col">{{ trans('admin.pagesF.valorApost') }}</th>
                            <th scope="col">{{ trans('admin.pagesF.premiosReceb') }}</th>
                            <th scope="col"></th>
                            <th scope="col">{{ trans('admin.pagesF.lucro') }}/<br />{{ trans('admin.pagesF.prejuizo') }}</th>
                            <th scope="col">{{ trans('admin.pagesF.clientede') }}<br />{{ trans('admin.pagesF.risco') }}</th>
                            <th scope="col" class="text-center">{{ trans('admin.pagesF.comissao') }}</th>
                            <th scope="col"></th>
                            <th scope="col"></th>
                            <th scope="col">{{ trans('admin.pagesF.bloquear') }}/<br>{{ trans('admin.pagesF.desbloquear') }}</th>
                            <th scope="col"></th>
                            <th scope="col">{{ trans('admin.pagesF.contatoRealiz') }}</th>
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
                                <td>{{ $user['total_jogos'] }}</td>
                                <td>R$ {{ number_format($user['total_apostado'], 2, '.', ',') }}</td>
                                <td>R$ {{ number_format($user['total_soma_premios'], 2, '.', ',') }}</td>
                                <td>
                                    @if ($user['lucro_prejuizo'] > 0)
                                        <td class="text-danger">R$ {{ number_format($user['lucro_prejuizo'], 2, '.', ',') }}</td>
                                    @elseif ($user['lucro_prejuizo'] == 0)
                                        <td>R$ {{ number_format($user['lucro_prejuizo'], 2, '.', ',') }}</td>
                                    @else
                                        <td class="text-success">R$ {{ number_format(abs($user['lucro_prejuizo']), 2, '.', ',') }}</td>
                                    @endif

                                    @if ($user['lucro_prejuizo'] <= (2 * $user['total_apostado']))
                                        <td><button type="button" class="btn btn-success disabled"><i
                                                    class="bi bi-check-square-fill"></i></button></td>
                                    @elseif ($user['lucro_prejuizo'] > (2 * $user['total_apostado']) && $user['lucro_prejuizo'] <= (3 * $user['total_apostado']))
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
                @if ($users->withQueryString()->links()->paginator->hasPages())
                    <div class="mt-4 p-4 box has-text-centered">
                        {{ $users->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.13.3/css/selectize.min.css"
    integrity="sha512-bkB9w//jjNUnYbUpATZQCJu2khobZXvLP5GZ8jhltg7P/dghIrTaSJ7B/zdlBUT0W/LXGZ7FfCIqNvXjWKqCYA=="
    crossorigin="anonymous" referrerpolicy="no-referrer"
    />
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

        .busca-container {
            height: 100%;
            align-items: flex-end;
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
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script>
    $('.change-busca').change(function() {
        const value = $(this).val();
        const param = $(this).attr('data-busca-param');
        const newUrl = new URL(window.location.href);
        
        newUrl.searchParams.set(param, value);
        if (param === 'perPage') newUrl.searchParams.set('page', 1);

        window.location.href = newUrl.toString();
    });

    $('#busca-limpar').click(function() {
        const url = window.location.href.split('?');
        let params = '';

        if (url[1]) {
            params = url[1].split('&').filter((i) => !i.includes('user')).join('&');
            params = `?${params}`;
        }

        window.location.href = url[0]+params;
    });

    $('#busca-autocomplete').autocomplete({
        source: function(request, response) {
            $.ajax({
                url: `{{url('/')}}/users/winners?busca=${$('#busca-autocomplete').val()}`,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    response(Object.values(data).map((i) => ({ label: `${i.name} ${i.last_name} | ${i.email}`, value: i.id })));
                }
            });
        },
        select: function (event, ui) {
            $("#busca-autocomplete").val(ui.item.label);

            const newUrl = new URL(window.location.href);

            newUrl.searchParams.set('user', ui.item.value);
            window.location.href = newUrl.toString();

            return false;
        }
    });
</script>
@endpush
