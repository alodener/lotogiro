COMPROVANTE DE APOSTA

@if($prize == 1)
PREMIADO

@endif
NÚMERO DO BILHETE: {{$game->id}}°

EMITIDO EM: {{\Carbon\Carbon::parse($game->created_at)->format('d/m/Y H:i:s')}}

VALIDO ATÉ: {{\Carbon\Carbon::parse($game->created_at)->addDays(4)->format('d/m/Y')}}

BANCA: {{env("nome_sistema")}}

LOCAL DE SORTEIO: {{$game->banca}}

PARTICIPANTE: {{mb_strtoupper($game->cliente_nome . ' ' . $game->cliente_sobrenome, 'UTF-8') }}

E-MAIL: {{$game->cliente_email}}

DATA SORTEIO: {{\Carbon\Carbon::parse($game->created_at)->format('d/m/Y')}}

HORA SORTEIO: {{\Carbon\Carbon::parse($game->horario)->format('H:i:s')}}

{{mb_strtoupper($game->modalidade_nome, 'UTF-8')}}

APOSTA: {{ $aposta }}

PRÊMIOS: {{ $premios }}°

VALOR APOSTADO: R${{\App\Helper\Money::toReal($game->valor)}}

GANHO MÁXIMO: R${{\App\Helper\Money::toReal($premio_maximo)}}


