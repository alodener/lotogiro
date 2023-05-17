<div class="col bg-white p-3">
    <div id="table" class="row mt-5">
        <div class="col">
            <h2>{{ trans ('admin.customerDashboard.visaoCliente') }} </h2>
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th scope="col"></th>
                        <th aria-controls="widget-options" scope="col">{{ trans ('admin.customerDashboard.concurso') }}  </th>
                        <th scope="col"></th>
                        <th scope="col">{{ trans ('admin.customerDashboard.typeGames') }} </th>
                        <th scope="col"></th>
                        <th scope="col">{{ trans ('admin.customerDashboard.value') }}  </th>
                        <th scope="col"></th>
                        <th scope="col">{{ trans ('admin.customerDashboard.premio') }} </th>
                        <th scope="col"></th>
                        <th scope="col">{{ trans ('admin.customerDashboard.date') }} </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data_to_view as $user)
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
                                <th scope="row">
                                    <td>{{ $user['date_game']  }}</td>
                                </th>
                            </tr>
                        @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
