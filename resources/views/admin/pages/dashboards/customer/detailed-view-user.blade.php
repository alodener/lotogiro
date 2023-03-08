@extends('admin.layouts.master')

@section('title', trans('admin.games.listing-page-title'))

@section('content')
    <div class="col bg-white p-3">
        <div class="row mt-2">
            <div class="col" id="table">
                <h3>Visão Detalhada do Cliente</h3>
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th scope="col"></th>
                            <th scope="col">Concurso</th>
                            <th scope="col"></th>
                            <th scope="col">Tipo de Jogo</th>
                            <th scope="col"></th>
                            <th scope="col">Valor Apostado</th>
                            <th scope="col"></th>
                            <th scope="col">Prêmio</th>
                            <th scope="col"></th>
                            <th scope="col">Data</th>
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
                                    <td>{{ 'R$' . number_format($user['award_game'], 2, '.', ',')  }}</td>
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
        <div class="row">
            <div class="col">
                <a href="{{ route('admin.dashboards.customer.dashboard.winners') }}"><button type="button" class="btn btn-secondary"><i class="bi bi-arrow-left-square-fill"></i></button></a>
                <button onclick="gerar_pdf()" type="button" class="btn btn-danger"><i class="bi bi-filetype-pdf"></i></button>
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

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    function gerar_pdf(){
        const data = document.querySelector('#table');
        const opt = {
            margin:       1,
            filename:     'Relatório - Análise_Detalhada.pdf',
            image:        { type: 'jpeg', quality: 0.98 },
            html2canvas:  { scale: 2 },
            jsPDF:        { unit: 'in', format: 'letter', orientation: 'portrait' }
        };

        html2pdf().set(opt).from(data).save();
    }
</script>
@endpush
