<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <style type="text/css">
        @page { margin: 0cm 0cm; }
        .font { font-family: 'Exo', serif; }
        .text-size-1 { font-size: 14px; }
        .text-size-2 { font-size: 22px; }
        .text-size-3 { font-size: 30px; }
        body { margin: 1.5cm; }
        .page-break { page-break-after: always; }
        .bg-danger { background-color: red; }
        .bg-success { background-color: #28a745; }
        .bg-secondary { background-color: #BCBCBC; }
        .text-danger { color: red; }
        .text-success { color: #28a745; }
        .text-white { color: white; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-left { text-align: left; }
        .border-bottom-dashed { border-bottom: 1px dashed; }
        .border-bottom { border-bottom: 1px solid black; }
        .py-2 { padding-top: 20px; padding-bottom: 20px; }
        .pt-1 { padding-top: 5px; }
        .px-3 { padding-right: 30px; padding-left: 30px; }
        .m-auto { margin: auto; }
        .text-bold { font-weight: bold; }
        .number { width: 50px; height: 50px; }
        .border-radius { border-radius: 25px; }
        .vertical-middle { vertical-align: middle; }
    </style>
</head>
<body>
<div>
    <div class="border-bottom-dashed">
        <p class="text-danger text-center font text-size-2 text-bold">
            RELATÓRIO DE VENDAS <br/>
            BICHÃO DA SORTE
        </p>
    </div>
    <div class="border-bottom-dashed text-size-1">
        <p>
            <span class="font text-bold">EMITIDO EM:</span>
            <span class="font">{{ \Carbon\Carbon::now()->format('d/m/y h:i:s') }}</span>
            <br/>
            <span class="font text-bold">PERÍODO:</span>
            <span class="font">{{ \Carbon\Carbon::parse($dateFilter['dateStart'])->format('d/m/Y') }} ATÉ {{ \Carbon\Carbon::parse($dateFilter['dateEnd'])->format('d/m/Y') }}</span>
            <br/>
            <span class="font text-bold">BANCA:</span>
            <span class="font">{{ env("nome_sistema") }}</span>
        </p>
    </div>

    <div class="border-bottom-dashed py-2">
        @php
            $users = \App\Models\User::pluck('name', 'id');
            $total = 0;
        @endphp

        @foreach($collection as $index => $userGames)
         <!-- <div class="text-size-1">
                <p>
                    <span class="font text-bold">USUÁRIO:</span>
                    <span class="font">{{ $users[$userGames[0]['user_id']] ?? 'Usuário não encontrado' }}</span>
                    <br/>
                    <span class="font text-bold">E-MAIL:</span>
                    <span class="font">{{ $userGames[0]['user']['email'] }}</span>
                </p>
            </div> -->

            <table style="width: 100%">
                <tr class="bg-secondary">
                    <th class="text-size-1 text-left">ID</th>
                    <th class="text-size-1 text-left">CRIAÇÃO</th>
                    <th class="text-size-1 text-left">LOTERIA</th>
                    <th class="text-size-1 text-left">PRÊMIO</th>
                    <th class="text-size-1 text-left">MODALIDADE</th>
                    <th class="text-size-1 text-left">APOSTA</th>
                    <th class="text-size-1 text-left">POSIÇÃO</th>
                    <th class="text-size-1 text-left">VALOR</th>
                </tr>

                @php
                    $subtotal = 0;
                @endphp

                @foreach($userGames as $game)
            @php
                $games = array_filter([$game['game_1'], $game['game_2'], $game['game_3']]);
                $premios = array_filter([
                    $game['premio_1'] == 1 ? 1 : null,
                    $game['premio_2'] == 1 ? 2 : null,
                    $game['premio_3'] == 1 ? 3 : null,
                    $game['premio_4'] == 1 ? 4 : null,
                    $game['premio_5'] == 1 ? 5 : null,
                    
                ]);
                
                $modalidadeNome = $modalidades[$game['modalidade_id']] ?? 'Modalidade não encontrada';

                // Aqui você acessa a modalidade do jogo
                $modalidade = $game['modalidade'];

                // Calcule o prêmio máximo
                $premioMaximo = $game['valor'] * $modalidade['multiplicador'] / (sizeof($premios) > 0 ? sizeof($premios) : 1);
            @endphp

            <tr class="border-bottom">
                <td class="font text-size-1 border-bottom">{{ $game['id'] }}</td>
                <td class="font text-size-1 border-bottom">{{ \Carbon\Carbon::parse($game['created_at'])->format('d/m/Y') }}</td>
                <td class="font text-size-1 border-bottom">{{ date('H\hi', strtotime($game['horario']['horario'])) }} - {{ $game['horario']['banca'] }}</td>
                <td class="font text-size-1 border-bottom">R$ {{ number_format($premioMaximo, 2, ',', '.') }}</td>
                <td class="font text-size-1 border-bottom">
                    {{ $modalidade ? $modalidade['nome'] : 'Modalidade não encontrada' }}
                </td>
                <td class="font text-size-1 border-bottom">{{ str_pad(join(' - ', $games), 2, 0, STR_PAD_LEFT) }}</td>
                <td class="font text-size-1 border-bottom">{{ join('°, ', $premios) }}°</td>
                <td class="font text-size-1 border-bottom">R$ {{ $game['valor'] }}</td>
                @php
                    $subtotal += $game['valor'];
                @endphp
            </tr>
        @endforeach


                <tr class="bg-secondary">
                    <th colspan="5" class="text-left">SUBTOTAL</th>
                    <th class="text-left">R${{ \App\Helper\Money::toReal($subtotal) }}</th>
                    @php
                        $total += $subtotal;
                    @endphp
                </tr>
            </table>
        @endforeach

</div>
