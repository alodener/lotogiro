<!DOCTYPE html>
<html lang="pt-br">
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <link rel="preconnect" href="https://fonts.gstatic.com">

    <style type="text/css">
        @page {
            margin: 0cm 0cm;
        }

        .font {
            font-family: 'Roboto', serif;

        }

        .text-size-1 {
            font-size: 10px;
        }

        .text-size-2 {
            font-size: 22px;
        }

        .text-size-3 {
            font-size: 30px;
        }

        .text-size-4 {
            padding-top:0%;
            font-size: 45px;
        }

        body {
            margin-top: 1.5cm;
            margin-left: 1.5cm;
            margin-right: 1.5cm;
            margin-bottom: 1.5cm;
            background-color: {{$typeGame->color}};
        }

        .page-break {
            page-break-after: always;
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

        .border-bottom-dashed {
            padding-top: 5px;
            padding-bottom: 5px;
            border-bottom: 1px dashed;
        }

        .py-2 {
            padding-top: 1px;
            padding-bottom: 1px;
        }

        .pt-1 {
            padding-top: 1px;
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

        .wrapper{
        max-width: 1080px;
        width: 100%;
        max-height: 1080px;
        height: 100%;
        margin: 0 auto;
        }


    </style>
</head>
<body class="wrapper">

<div class="">
    <div class="border-bottom-dashed py-2">
        <p class="text-center font text-size-3 text-bold text-white">

            BICHÃO DA SORTE

        </p>
        @if($prize == 1)
            <p class="text-success text-center font text-size-4 text-bold py-2">
                BILHETE PREMIADO
            </p>
        @endif
    </div>
<center>
    <div class="border-bottom-dashed px-3">
        <p class="text-right text-white text-size-2">
            <span class="font text-bold">NÚMERO DO BILHETE: </span>
            <span class="font">{{$game->id}}°</span>
        </p>
        <p class="text-white text-size-2">
            <span class="font text-bold">EMITIDO EM:</span>
            <span class="font">{{\Carbon\Carbon::parse($game->criado_em)->format('d/m/Y H:i:s')}}</span>
        </p>
        <p class="text-white text-size-2">
            <span class="font text-bold">PARTICIPANTE:</span>
            <span class="font">{{mb_strtoupper($game->cliente_nome . ' ' . $game->cliente_sobrenome, 'UTF-8') }}</span>
        </p>
        <p class="text-white text-size-2">
            <span class="font text-bold">DATA SORTEIO:</span>
            <span class="font">{{\Carbon\Carbon::parse($game->horario)->format('H:i:s')}}</span>
        </p>
        <p class="text-white text-size-2">
            <span class="font text-bold">HORA SORTEIO:</span>
            <span class="font">{{\Carbon\Carbon::parse($game->competition->sort_date)->format('H:i:s') }}</span>
        </p>
        <h2 class="font text-bold text-center text-white">{{mb_strtoupper($game->modalidade_nome, 'UTF-8')}}</h2>
    </div>
</center>
    <center>
    <div class="py-2 px-3 text-white">
        <p>
            <span class="font text-bold">APOSTA: </span>
            <span class="font">{{ $aposta }}</span>
        </p>
        <p>
            <span class="font text-bold">PRÊMIOS: </span>
            <span class="font">{{ $premios }}°</span>
        </p>
        <p class="">
            <span class="font text-bold">VALOR APOSTADO: </span>
            <span class="font">R${{\App\Helper\Money::toReal($game->valor)}}</span>
        </p>
        <p class="">
            <span class="font text-bold">GANHO MÁXIMO: </span>
            <span class="font">R${{\App\Helper\Money::toReal($game->valor * $game->multiplicador)}}</span>
        </p>
    </div>
</center>
</div>
</body>
</html>
