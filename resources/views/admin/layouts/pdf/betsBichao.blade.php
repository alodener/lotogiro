<!DOCTYPE html>
<html lang="pt-br">
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    {{--    <link href="https://fonts.googleapis.com/css2?family=Exo&display=swap" rel="stylesheet">--}}
    {{--    <link href="https://fonts.googleapis.com/css2?family=Exo:wght@700&display=swap" rel="stylesheet">--}}
    <style type="text/css">

        @page {
            margin: 0cm 0cm;
        }

        .font {
            font-family: 'Exo', serif;
        }

        .text-size-1 {
            font-size: 14px;
        }

        .text-size-2 {
            font-size: 22px;
        }

        .text-size-3 {
            font-size: 30px;
        }

        body {
            margin-top: 1.5cm;
            margin-left: 1.5cm;
            margin-right: 1.5cm;
            margin-bottom: 1.5cm;
        }

        .page-break {
            page-break-after: always;
        }

        .bg-danger {
            background-color: red;
        }

        .bg-success {
            background-color: #28a745;
        }

        .bg-secondary{
            background-color: #BCBCBC;
        }

        .text-danger {
            color: red;
        }

        .text-success {
            color: #28a745;
        }

        .text-white {
            color: white;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .text-left {
            text-align: left;
        }

        .border-bottom-dashed {
            border-bottom: 1px dashed;
        }

        .border-bottom {
            border-bottom: 1px solid black;
        }

        .py-2 {
            padding-top: 20px;
            padding-bottom: 20px;
        }

        .pt-1 {
            padding-top: 5px;
        }


        .px-3 {
            padding-right: 30px;
            padding-left: 30px;
        }

        .m-auto {
            margin: auto;
        }

        .text-bold {
            font-weight: bold;
        }

        .number {
            width: 50px;
            height: 50px;
        }

        .border-radius {
            border-radius: 25px;
        }

        .vertical-middle {
            vertical-align: middle;
        }


    </style>
</head>
<body>
<div class="">
    <div class="border-bottom-dashed">
        <p class="text-danger text-center font text-size-2 text-bold">
            RELATÓRIO DE APOSTAS <br/>
            BICHÃO DA SORTE
        </p>
    </div>
    <div class="border-bottom-dashed text-size-1">
        <p class="">
            <span class="font text-bold">EMITIDO EM:</span>
            <span class="font">{{\Carbon\Carbon::now()->format('d/m/y h:i:s')}}</span>
            <br/>
            <span class="font text-bold">PERÍODO:</span>
            <span class="font">{{\Carbon\Carbon::parse($startAt)->format('d/m/Y')}} até {{\Carbon\Carbon::parse($endAt)->format('d/m/Y')}}</span>
            <br/>
            <span class="font text-bold">BANCA:</span>
            <span class="font">{{env("nome_sistema")}}</span>
        </p>
    </div>

    <div class="border-bottom-dashed py-2">
        <table style="width: 100%">
            <tr class="bg-secondary">
                <th class="text-left">ID</th>
                <th class="text-left">{{ trans('admin.bichao.client') }}</th>
                <th class="text-left">{{ trans('admin.bichao.value') }}</th>
                <th class="text-left">{{ trans('admin.bichao.loteria') }}</th>
                <th class="text-left">{{ trans('admin.bichao.modalidade') }}</th>
                <th class="text-left">{{ trans('admin.bichao.aposta') }}</th>
                <th class="text-left">{{ trans('admin.bichao.premios') }}</th>
                <th class="text-left">{{ trans('admin.bichao.criadoem') }}</th>
            </tr>
            @foreach ($apostas as $aposta)
                <tr class="border-bottom">
                    <td class="font border-bottom">
                        {{ $aposta['id'] }}
                    </td>
                    <td class="font border-bottom">{{ $aposta['cliente_nome'] }} {{ $aposta['cliente_sobrenome'] }}</td>
                    <td class="font border-bottom">{{ number_format($aposta['valor'], 2, ',', '.') }}</td>
                    <td class="font border-bottom">{{ date('H\hi', strtotime($aposta['horario'])) }} - {{ $aposta['banca'] }}</td>
                    <td class="font border-bottom">{{ $aposta['modalidade_nome'] }}</td>
                    <td class="font border-bottom">
                        <?php
                            $games = [];
                            if (strval($aposta['game_1']) > 0) $games[] = $aposta['game_1'];
                            if (strval($aposta['game_2']) > 0) $games[] = $aposta['game_2'];
                            if (strval($aposta['game_3']) > 0) $games[] = $aposta['game_3'];
                        ?>
                        {{ str_pad(join(' - ', $games), 2, 0, STR_PAD_LEFT) }}
                    </td>
                    <td class="font border-bottom">
                        <?php
                            $premios = [];
                            if ($aposta['premio_1'] == 1) $premios[] = 1;
                            if ($aposta['premio_2'] == 1) $premios[] = 2;
                            if ($aposta['premio_3'] == 1) $premios[] = 3;
                            if ($aposta['premio_4'] == 1) $premios[] = 4;
                            if ($aposta['premio_5'] == 1) $premios[] = 5;

                            $premioMaximo = $aposta['valor'] * $aposta['multiplicador'] / sizeof($premios);

                            if ($aposta['modalidade_id'] == 8 || $aposta['modalidade_id'] == 9) {
                                $premioMaximo = $aposta['valor'] * $aposta['multiplicador'];
                            }
                            if ($aposta['modalidade_id'] == 6 || $aposta['modalidade_id'] == 7) {
                                $premioMaximo = sizeof($premios) == 3 ? $aposta['valor'] * $aposta['multiplicador'] : $aposta['valor'] * $aposta['multiplicador_2'];
                            }
                        ?>
                        {{ join('°, ', $premios) }}°
                    </td>
                    <td class="font border-bottom">{{ date('d/m/Y H:i', strtotime($aposta['created_at'])) }}</td>
                </tr>
            @endforeach
        </table>
    </div>


</div>
</body>
</html>
