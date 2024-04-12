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
    <div class="col-md-12">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Cadastrando novo {{ trans('admin.game') }}</h3>
            </div>
            <div class="card-body">
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
</div>
<div class="row">
    <div class="col-md-6 mb-3">
        <!-- <a href="{{route('admin.bets.games.index', ['type_game' => $typeGame->id])}}">
            <button type="button" class="btn btn-block btn-info">{{ trans('admin.back-to-main-page') }}</button>
        </a> -->
        <a href="{{route('homepage')}}">
            <button type="button" class="btn btn-block btn-info">{{ trans('admin.back-to-main-page') }}</button>
        </a>
    </div>
    <div class="col-md-6 mb-3">
        <button type="submit" id="button_game" onclick="mudarListaNumerosGeral()"
                class="btn btn-block btn-success">@if(request()->is('admin/bets/games/create/'.$typeGame->id))
                {{ trans('admin.games.insert-game-button') }}
                @else
                {{ trans('admin.games.update-game-button') }}
                @endif
            </button>
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
                                <button class="btn btn-primary btn-lg btn-custom" onclick="adjustBet()">Diminuir o valor da aposta
                                    <span id="suggestedValue" class="ml-2" ></span>
                                </button>
                            </div>
                            <div>
                                <button class="btn btn-primary mt-2 btn-lg btn-custom" onclick="chooseNewGame()">Escolher um novo jogo</button>
                            </div>
                        </div>
                    </div>
                    <div class="flex d-none d-lg-block"> <!-- Esta div só será exibida em dispositivos de médio a grandes (a partir de 768px) -->
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
</div>



@push('scripts')

    <script src="{{asset('admin/layouts/plugins/inputmask/jquery.inputmask.min.js')}}"></script>
    <script>
        var formID = document.getElementById("form_game");
        var send = $("#button_game");

        $(formID).submit(function(event){
            if (formID.checkValidity()) {
                send.attr('disabled', 'disabled');
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
        background-color: rgb(0,0,0);
        background-color: rgba(0,0,0,0.4);
    }

    .modal-content {
        background-color: #fefefe;
        max-width: 100%;
        margin: auto;
        padding: 20px;
        border: 1px solid #888;
        width: 50%;
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
    </style>
@endpush
