COMPROVANTE DE APOSTA

 APOSTA {{ env("nome_sistema") }}

@if($prize == 1)
PREMIADO

@endif
ID APOSTA: {{$game->id}} 

EMITIDO EM: {{\Carbon\Carbon::parse($game->created_at)->format('d/m/Y H:i:s')}} 

CPF: {{\App\Helper\Mask::addMaskCpf($game->client->cpf)}} 

PARTICIPANTE: {{mb_strtoupper($client->name . ' ' . $client->last_name, 'UTF-8') }} 

CONCURSO: {{$game->competition->number }} 

DATA SORTEIO: {{\Carbon\Carbon::parse($game->competition->sort_date)->format('d/m/Y')}} 

HORA SORTEIO: {{\Carbon\Carbon::parse($game->competition->sort_date)->format('H:i:s')}} 

{{mb_strtoupper($typeGame->name, 'UTF-8')}} 

@php
$numbers = []; 

foreach ($matriz as $lines) {
    foreach ($lines as $number) {
        $numbers[] = str_pad($number, 2, '0', STR_PAD_LEFT); 
    }
}

$numbers = array_unique($numbers);
sort($numbers);
@endphp


DEZENAS: {{ implode(', ', $numbers) }}

QTDE DEZENAS: {{$typeGameValue->numbers}} 

VALOR APOSTADO: R${{\App\Helper\Money::toReal($game->value)}} 

GANHO MÁXIMO: R${{\App\Helper\Money::toReal($game->premio)}} 



