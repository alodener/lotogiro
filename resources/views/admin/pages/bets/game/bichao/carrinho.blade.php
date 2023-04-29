<div style="background-color:#E9ECEF;" class="col-md-4 col-12 h-auto">
    <div class="row align-items-center mt-4">
        <div class="col">
            <h4 class="text-center">Lista de Jogos</h4>
        </div>
    </div>
    <div class="row">
        <div class="col mb-4" id="chart-text">
            @foreach ($chart as $key => $chart)
                <div class="chart-item">
                    <div class="chart-item-number">
                        {{$key + 1}}
                    </div>
                    <div class="chart-item-description">
                        <p><b>{{$chart['modality']}}:</b> {{$chart['game']}}</p>
                        <p><b>Prêmio:</b> {{join('°, ', $chart['award_type'])}}°</p>
                        <p><b>Valor:</b> R${{number_format($chart['value'], 2, ',', '.')}}</p>
                    </div>
                    <div class="chart-item-button"><a class="chart-remove-item" href="#" url="{{url('/')}}/admin/bets/bichao/remove/chart/{{$key}}">X</a></div>
                </div>
            @endforeach
            @if (sizeof($chart) == 0)
                <p class="text-center">Seu carrinho está vazio, faça um jogo para realizar uma aposta.</p>
            @else
                <div class="clear-chart-container">
                    <button class="btn btn-danger" id="clear-all-chart" type="button">Limpar carrinho</button>
                </div>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="form-group text-center">
                <label for="selecionar-estado-bichao">Selecione um estado</label>
                <select class="form-control" id="selecionar-estado-bichao">
                    <option selected disabled>Selecione um estado</option>
                    @foreach ($estados as $estado)
                        <option value="{{ $estado->id }}">{{ $estado->nome }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="row hide" id="estado-sorteio">
        <div class="col estado-sorteio">
            <p class="mb-1"><b>Escolha o sorteio:</b></p>
            <div id="horarios-resultados"></div>
        </div>
    </div>
    <div class="row">
        <div class="col text-center mt-4 p-4">
            <h5><b>Total: R${{ number_format($totalCarrinho, 2, ',', ' ') }}</b></h5>
        </div>
    </div>
    <div class="row">
        <div class="col text-center align-items-end mb-4">
            <button class="btn btn-success" id="cadastrar-jogos" type="button">Cadastrar Jogos</button>
        </div>
    </div>
    <div class="row">
        <div class="col text-center">
            <script language=javascript type="text/javascript">
                now = new Date
                document.write(now.toLocaleString())
                document.write("- Horário de Brasília.")
            </script>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="jogos-realizados" tabindex="-1" role="dialog" aria-labelledby="jogos-realizadosLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="jogos-realizadosLabel">Jogos cadastrados com sucesso!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Valor</th>
                            <th scope="col">Modalidade</th>
                            <th scope="col">Bilhete</th>
                        </tr>
                    </thead>
                    <tbody id="jogos-realizados-table">
                        
                    </tbody>
                  </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
  </div>

@push('styles')
    <style>
        #chart-text {
            display: flex;
            flex-direction: column;
            row-gap: 15px;
        }

        .chart-item {
            display: flex;
            overflow: hidden;
            background-color: #ffffff;
            border-radius: 5px;
        }

        .chart-item-number {
            display: flex;
            align-items: center;
            font-size: 32px;
            padding: 20px 40px;
            font-weight: bold;
        }

        .chart-item-description {
            flex: 1;
            padding: 20px 0;
        }

        .chart-item-description p {
            margin-bottom: 5px !important;
        }

        .chart-item-description p:last-of-type {
            margin-bottom: 0 !important;
        }

        .chart-item-button a {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
            padding: 0px 25px;
            font-size: 18px;
            font-weight: bold;
            background-color: rgba(237,56,44,.75);
            color: #fff;
        }

        .clear-chart-container {
            text-align: right;
        }
    </style>
@endpush
