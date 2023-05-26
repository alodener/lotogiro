@extends('admin.layouts.master')

@section('title', trans('admin.games.listing-page-title'))

@section('content')
    <div class="col bg-white p-3">
        <div class="row">
            <div class="col-md-8 col-12 d-flex justify-content-end container-menu-items">
                <a href="{{ route('admin.bets.bichao.index') }}">
                    <button class="btn btn-info my-2 ml-1">Apostar</button>
                </a>
                <a href="{{ route('admin.bets.bichao.resultados') }}">
                    <button class="btn btn-info my-2 ml-1">Resultados</button>
                </a>
                <a href="{{ route('admin.bets.bichao.minhas.apostas') }}">
                    <button class="btn btn-info my-2 ml-1">Minhas apostas</button>
                </a>
                <a href="{{ route('admin.bets.bichao.cotacao') }}">
                    <button class="btn btn-info my-2 ml-1">Cotação</button>
                </a>
            </div>
        </div>
        <hr />
        <div class="row">
            <div class="col-12">
                <h1>Resultados</h1>
                <p>Acompanhe diariamente os principais resultados do Jogo do Bicho</p>
            </div>
        </div>
        <hr />
        <div class="row">
            <div class="col-md-6 col-12">
                <div class="row">
                    <div class="col-6">
                        <div class="form-group w-100">
                            <label>Escolha uma data</label>
                            <input type="date" name="initial_date" class="form-control" id="initial_date" value="{{date('Y-m-d')}}" max="{{date('Y-m-d')}}">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="selecionar-estado-bichao">Selecione um estado</label>
                            <select class="form-control" id="selecionar-estado-bichao">
                                <option value="RJ" selected>Rio de Janeiro</option>
                                <option value="SP">São Paulo</option>
                                <option value="GO">Goiás</option>
                                <option value="MG">Minas Gerais</option>
                                <option value="BA">Bahia</option>
                                <option value="PB">Paraíba</option>
                                <option value="DF">Brasília</option>
                                <option value="CE">Ceará</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 col-12">
                        <button class="btn btn-success" id="bichao-buscar-resultados" type="button">Buscar resultados</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-5" id="bichao-resultado-busca">
            <div class="col-12">
                <p>Procurando resultados...</p>
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

        .table-header {
            background-color: #32689a;
        }

        .table-body {
            text-align: center;
        }

        .second-header td {
            padding-top: 20px;
            padding-bottom: 20px;  
        }

        @media(max-width: 467px) {
            #filterForm .form-row {
                flex-direction: column;
            }
        }

        @media(max-width: 600px) {
            .container-menu-items {
                flex-wrap: wrap;
            }

            .container-menu-items a {
                flex: 50%;
                width: 100%;
            }

            .container-menu-items a button {
                width: 100%;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            fetchResultados();
        });

        function fetchResultados() {
            const estado = $('#selecionar-estado-bichao').val();
            const data = $('#initial_date').val().split('-');
            if (!estado) return alert('Selecione um estado');

            $('#bichao-resultado-busca').html(`
                <div class="col-12">
                    <p>Procurando resultados...</p>
                </div>
            `);

            $.ajax({
                url: '{{url('/')}}/admin/bets/bichao/get-results-json',
                type: 'POST',
                dataType: 'json',
                data: { data, estado },
                success: function(data) {
                    if (!data.length) {
                        return $('#bichao-resultado-busca').html(`
                            <div class="col-12">
                                <p>Nenhum resultado encontrado.</p>
                            </div>
                        `);
                    }
                    
                    const html = data.map((jogo) => {
                        let subhtml = '';
                        
                        jogo.placement.forEach((placement, index) => {
                            subhtml = subhtml + `
                                <tr>
                                    <td>${index + 1}° Prêmio</td>
                                    <td>${placement.milhar}</td>
                                    <td>${placement.grupo}</td>
                                    <td>${placement.bicho}</td>
                                </tr>
                            `;
                        });
                        
                        if (!jogo.placement.length) {
                            subhtml = '<tr><td colspan="4"><p>Aguardando divulgação de resultados.</p></td></tr>';
                        }

                        return (`
                            <div class="col-md-3 col-12">
                                <table class="table table-striped table-bordered table-dark">
                                    <thead>
                                        <tr class="table-header">
                                            <th class="text-center" colspan="4">${jogo.date} - ${jogo.lottery} - ${jogo.time}</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-body">
                                        <tr class="second-header">
                                            <td>Prêmio</td>
                                            <td>Milhar</td>
                                            <td>Grupo</td>
                                            <td>Bicho</td>
                                        </tr>
                                        ${subhtml}
                                    </tbody>
                                </table>
                            </div>
                        `);
                    });
                    $('#bichao-resultado-busca').html(html);
                }
            });
        }

        $('#bichao-buscar-resultados').click(async function() {
            fetchResultados();
        });
    </script>
@endpush
