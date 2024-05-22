<div class="row">
    <div class="col-md-12 p-3">
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
        <script>
            const errors = @json($errors->toArray());
                    toastr["error"](errors.description[0]);

                    if (errors.error[0] === 'oddError') {
                        document.getElementById("myModal").style.display = "block";
                        document.getElementById("errorDescription").innerText = errors.description[0];
                        const numbers = errors.numbers[0].split(',').map(Number);
                        const numbersGrid = document.getElementById('errorNumbers');

                        for (let i = 0; i < numbers.length; i += 4) {
                            const row = document.createElement('div');
                            row.classList.add('row');

                            for (let j = i; j < i + 4 && j < numbers.length; j++) {
                                const col = document.createElement('div');
                                col.classList.add('col-3', 'number');
                                col.textContent = numbers[j];
                                row.appendChild(col);
                            }

                            numbersGrid.appendChild(row);
                        }
                    }

                    function formatCurrency(valueInCents) {
                    return valueInCents.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
}
        </script>
        @endpush
        @enderror
    </div>
    <div class="col-md-10">
        <div class="card card-info col-md-12 pr-4 pl-4 pt-2">
            <div>
                <div class="card-header d-flex justify-content-around align-items-center top-head">
                    <h3 class="card-title" style="font-weight: bold; text-transform:uppercase;">{{$typeGame->name}}</h3>
                    <h4 class="card-title" style="font-size:15px;">Tipo: {{$typeGame->name}}</h4>
                    <h4 class="card-title" style="font-size:15px;">Concurso: {{$typeGame->competitions->last()->number}}
                    </h4>
                    <h4 class="card-title" style="font-size:15px;">Data do Sorteio:
                        {{\Carbon\Carbon::parse($typeGame->competitions->last()->sort_date)->format('d/m/Y H:i:s')}}
                    </h4>
                </div>
                <div class="container-fluid" style="padding:0px;">
                    <img src="{{ $typeGame->banner_resultados ? asset("storage/{$typeGame->banner_resultados}") :
                    asset('https://i.ibb.co/VWhHF8D/Yys88-SZf-Yy-AI4oo61k-Bd-Fw-Kq-Sl-R0k-Cu-Wd-DDQUVj5.jpg') }}"
                    style="width:100%;max-height:150px;">


                </div>
            </div>
            <div class="">
                @livewire('pages.bets.game.form', [
                'typeGame' => $typeGame ?? null ,
                'clients' => $clients ?? null,
                'game' => $game ?? null,
                'numbers' => $numbers ?? null,
                'values' => $values ?? null
                ])
            </div>
        </div>
    </div>
    <div class="col-md-2 d-md-flex d-none">
        <div class="container" style="padding:0px;">
            <img src="{{ $banner_publicidade->url ? asset("storage/{$banner_publicidade->url}") :
            asset('https://i.ibb.co/zQHhvj2/vertical-background-0ky9f0wy7qxg8h0x.jpg') }}"
            style="width:100%;height:100vh;">
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6 mx-auto mb-3">
        <!-- <a href="{{route('admin.bets.games.index', ['type_game' => $typeGame->id])}}">
            <button type="button" class="btn btn-block btn-info">{{ trans('admin.back-to-main-page') }}</button>
        </a> -->
        <a href="{{route('homepage')}}">
            <button type="button" class="btn btn-block btn-info">{{ trans('admin.back-to-main-page') }}</button>
        </a>
    </div>

    <!-- O modal -->
    <div id="myModal" class="modal">
        <div class="modal-header">
            <span class="close" onclick="closeModal()">&times;</span>
        </div>

        <div class="modal-content">
            <div class="text-center">
                <h3 class="mb-4">Ops! Aposta inválida</h3>
                <p id="errorDescription" class="mb-4">A descrição do erro será exibida aqui.</p>
                <hr class="mb-4">
                <div class="d-flex justify-content-between">
                    <div class="flex">
                        <h5>Opções:</h5>
                        <div class="flex flex-col justify-content-around mt-5">
                            <div class="flex">
                                <button class="btn btn-primary btn-lg btn-custom" onclick="adjustBet()">Diminuir o valor
                                    da aposta
                                    <span id="suggestedValue" class="ml-2"></span>
                                </button>
                            </div>
                            <div>
                                <button class="btn btn-primary mt-2 btn-lg btn-custom"
                                    onclick="chooseNewGame()">Escolher um novo jogo</button>
                            </div>
                        </div>
                    </div>
                    <div class="flex d-none d-lg-block">
                        <!-- Esta div só será exibida em dispositivos de médio a grandes (a partir de 768px) -->
                        <h5>Jogo:</h5>
                        <div class="game-numbers">
                            <h4>Jogo Escolhido:</h4>
                            <div class="numbers-grid" id="errorNumbers">
                                <!-- Add error numbers here -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true" style="z-index: 999999">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="d-flex container justify-content-between align-items-center">
                        <h5 class="modal-title" id="exampleModalLabel">LTB - Lotinha | Cotaçãoa</h5>
                        <button class="btn-cotacao-download"><i class="fa fa-clipboard" aria-hidden="true"></i>
                            Baixar Cotação</button>
                    </div>

                </div>
                <div class="modal-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Dezena</th>
                                <th scope="col">Multiplicador</th>
                                <th scope="col">Retorno (R$1,00)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>12</td>
                                <td>10x</td>
                                <td>R$:10,00</td>
                            </tr>
                            <tr>
                                <td>13</td>
                                <td>100x</td>
                                <td>R$:100,00</td>
                            </tr>
                            <tr>
                                <td>14</td>
                                <td>200x</td>
                                <td>R$:200,00</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="ModalResultados" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        style="z-index: 999999" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="d-flex container justify-content-between align-items-center">
                        <h5 class="modal-title" id="exampleModalLabel">Ultimos Sorteios</h5>

                    </div>

                </div>
                <div class="modal-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Data do Sorteio</th>
                                <th scope="col">Bolas</th>
                                <th scope="col">Baixar</th>
                            </tr>
                        </thead>
                    
                        
                        <tbody>
                            @foreach($draws as $draw)
                            <tr>
                                <th>{{ \Carbon\Carbon::parse($draw->created_at)->format('d/m/Y h:m') }}</th>
                                <th class="resulttext">
                                    <div class="d-flex overflow-scroll"> <!-- Adicionado overflow-scroll aqui -->

                                    @php
                                        $numbers = explode(',', $draw->numbers);
                                        foreach ($numbers as $number) {
                                            echo '<div class="bol">' . $number . '</div>';
                                        }
                                    @endphp
                                    </div>
                                </th>
                                <th>
                                    <button class="btn btn-secondary">
                                        <i class="fa fa-share-alt-square" aria-hidden="true"></i>
                                    </button>
                                </th>
                            </tr>
                            @endforeach
                        </tbody>
                        
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="ModalCopiacola" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document" style="max-width: 100%;">
            <div class="modal-content copiacontent">
                <div class="modal-header" style="padding: 0px; border:none; padding-top:10px;">
                    <div class="card-header container d-flex justify-content-center align-items-center ">
                        <div class="col-11">
                            <h5 class="modal-title2" id="exampleModalLabel">Multiplos Jogos | Aposte em vários jogos de
                                uma única vez, apenas copiando e colando!</h5>
                        </div>
                        <div class="col-1"> <i onclick="lockmodaloff()" data-dismiss="modal"
                                style="font-size:25px; cursor: pointer;" class="fa fa-times" aria-hidden="true"></i>
                        </div>
                    </div>

                </div>
                <div class="modal-body">
                    @livewire('pages.bets.game.copiacola', ['typeGame' => $typeGame ?? null , 'clients' => $clients ??
                    null])

                </div>

            </div>
        </div>
    </div>
</div>

<script>
    function lockmodaloff(){
        localStorage.setItem('copiaecolalock', false);

    }
</script>


@push('scripts')

<script src="{{asset('admin/layouts/plugins/inputmask/jquery.inputmask.min.js')}}"></script>
<script>
    var formID = document.getElementById("form_game");
        var send = $("#button_game");

        $(formID).submit(function(event){
            if (formID.checkValidity()) {
                send.attr('disabled',$ 'disabled');
            }
        });

        $(document).ready(function () {
            $('#cpf').inputmask("999.999.999-99");
            $('#phone').inputmask("(99) 9999[9]-9999");
        });

        function closeModal() {
            document.getElementById("myModal").style.display = "none";
        }

        window.onclick = function(event) {
            var modal = document.getElementById("myModal");
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
</script>

@endpush

@push('styles')
<style>
    #ModalCopiacola {
        width: 100%;
    }

    .modal-title2 {
        font-size: 17px;
        margin: 0px;
    }

    .bol {
    margin: 0px 5px !important;
    border-radius: 100%;
    border: 1px solid #75baff;
    background: #636363;
    display: flex;
    width: 30px !important;
    height: 30px !important;
    align-items: center;
    justify-content: center;
    padding: 4px;
    margin: 0px;
}

    .copiacontent {
        padding: 0px !important;
        border: none !important;
        margin-top: 60px !important;
    }.overflow-scroll {
    overflow-x: auto;
    white-space: nowrap;
    width: 100px;}

    /* Estilo do modal */
    .modal {
        display: none;
        position: fixed;
        z-index: 9999;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgb(0, 0, 0);
        background-color: rgba(0, 0, 0, 0.4);
    }

    .card {
        background: #212425;
        border: 6px solid #303536;
    }

    .modal-content {
        background-color: #fefefe;
        max-width: 100%;
        margin: auto;
        border: 1px solid #888;
        width: 100%;
        color: #000;
    }

    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }

    .btn-custom {
        padding: 0.25rem 0.5rem;
        font-size: 1rem;
    }

    @media (max-width: 768px) {
        .btn-custom {
            padding: 0.25rem 0.5rem;
            font-size: 0.6rem;
        }
    }

    @media (max-width: 992px) {
        .top-head h4 {
            font-size: 10px !important;
            text-align: center;
        }

        .top-head h3 {
            font-size: 12px !important;
            text-align: center;
        }
    }
</style>
@endpush