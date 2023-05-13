<?php

namespace App\Helper;

use GuzzleHttp\Client;
class MensagemTelegram
{
    public function enviarMensagemTelegram($chatId, $valor, $urlBanca) {
        $url = $urlBanca;
        $chatId = $chatId;
        $texto = 'Valor Recebido R$' . $valor;
        $data = ['chat_id' => $chatId, 'text' => $texto];

        $client = new Client();
        $response = $client->request('POST', $url, ['json' => $data]);

        return $response->getBody()->getContents();
    }
}
