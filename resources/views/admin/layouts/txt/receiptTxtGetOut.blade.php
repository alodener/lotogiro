RELATORIO TXT DE BILHETES - DATA: {{\Carbon\Carbon::now()->format('d/m/Y H:i:s')}}

*** BANCA: {{ env("nome_sistema") }} ***

@foreach ($games as $jogos)
--------------------------------
ID BILHETE: {{$jogos->id}} 
NOME CLIENTE: {{$jogos->nome_cliente}} 
ID USUARIO: {{$jogos->user_id}} 
EMAIL USUARIO: {{$jogos->email}}
TIPO DE JOGO: {{$jogos->name}} 
CONCURSO: {{$jogos->number}} 
VALOR APOSTA:R${{\App\Helper\Money::toReal($jogos->value)}}
VALOR PREMIO: R${{\App\Helper\Money::toReal($jogos->premio)}}
DEZENAS: {{ implode(', ', array_map(function($dezenas) {
    return str_pad($dezenas, 2, '0', STR_PAD_LEFT);
}, explode(',', $jogos->numbers))) }}
CRIADO EM: {{\Carbon\Carbon::parse($jogos->created_at)->format('d/m/Y H:i:s')}}
--------------------------------
@endforeach
