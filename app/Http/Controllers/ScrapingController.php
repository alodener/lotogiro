<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

class ScrapingController extends Controller
{
    public function scrape(Request $request)
    {
        // Obtém o estado e a data da URL
        $estado = $request->estado;
        $data = $request->data;

        // Verifica se a data está no formato correto
        if (!preg_match('/^\d{2}-\d{2}-\d{4}$/', $data)) {
            return response()->json(['error' => 'Formato de data inválido. Use dd-mm-yyyy'], 400);
        }
    
        $data = str_replace('-', '/', $data);

        $urls = [
            'RJ' => [
                'PTM' => [
                    'url' => 'https://www.resultadosnahora.com.br/banca-ptm-rio/',
                    'phrase' => '(PTM-Rio) 11:00 Hoje ' . $data,
                    'id' => 1,
                ],
                'PT' => [
                    'url' => 'https://www.resultadosnahora.com.br/pt-riopt-rio/',
                    'phrase' => '(PT-Rio) 14:00 Hoje ' . $data,
                    'id' => 2,
                ],
                'PTV' => [
                    'url' => 'https://www.resultadosnahora.com.br/banca-ptv-rio/',
                    'phrase' => '(PTV-Rio) 16:00 Hoje ' . $data,
                    'id'=> 3,
                ],
                'PTN' => [
                    'url' => 'https://www.resultadosnahora.com.br/banca-ptn-rio/',
                    'phrase' => '(PTN-Rio) 18:00 Hoje ' . $data,
                    'id'=> 4,
                ],
                'COR' => [
                    'url' => 'https://www.resultadosnahora.com.br/banca-coruja/',
                    'phrase' => '(Coruja-Rio) 21:00 Hoje ' . $data,
                    'id'=> 5,
                ]
            ],
            'SP' => [
                'PT-SP' => [
                    'url' => null, // Esta bancas parece não existir na fonte de dados fornecida
                    'phrase' => '(Pt-Sp) 13:20 Hoje ' . $data,
                    'id'=> 6,
                ],
                'Bandeirantes' => [
                    'url' => 'https://www.resultadosnahora.com.br/banca-bandeirante/',
                    'phrase' => '(Bandeirante-Sp) 15:20 Hoje ' . $data,
                    'id'=> 7,
                ],
                'PTN' => [
                    'url' => 'https://www.resultadosnahora.com.br/banca-ptn-sp/',
                    'phrase' => '(Ptn-Sp) 20:20 Hoje ' . $data,
                    'id'=> 8,
                ]
            ],
            'GO' => [
                'Look (11:20)' => [
                    'url' => 'https://www.resultadosnahora.com.br/banca-look/',
                    'phrase' => '(Look-Goias) 11:20 Hoje ' . $data,
                    'id'=> 9,
                ],
                'Look (14:20)' => [
                    'url' => 'https://www.resultadosnahora.com.br/banca-look/',
                    'phrase' => '(Look-Goias) 14:20 Hoje ' . $data,
                    'id'=> 10,
                ],
                'Look (16:20)' => [
                    'url' => 'https://www.resultadosnahora.com.br/banca-look/',
                    'phrase' => '(Look-Goias) 16:20 Hoje ' . $data,
                    'id'=> 11,
                ],
                'Look (18:20)' => [
                    'url' => 'https://www.resultadosnahora.com.br/banca-look/',
                    'phrase' => '(Look-Goias) 18:20 Hoje ' . $data,
                    'id'=> 12,
                ],
                'Look (21:20)' => [
                    'url' => 'https://www.resultadosnahora.com.br/banca-look/',
                    'phrase' => '(Look-Goias) 21:20 Hoje ' . $data,
                    'id'=> 13,
                ]
            ],
            'MG' => [
                'Alvorada' => [
                    'url' => 'https://www.resultadosnahora.com.br/banca-alvorada-minas/',
                    'phrase' => '(Minas Gerais) 12:00 Hoje ' . $data,
                    'id'=> 14,
                ],
                'Minas-dia' => [
                    'url' => 'https://www.resultadosnahora.com.br/banca-minas-dia/',
                    'phrase' => '(Minas Gerais) 15:00 Hoje ' . $data,
                    'id'=> 15,
                ],
                'Minas-noite' => [
                    'url' => 'https://www.resultadosnahora.com.br/banca-minas-noite/',
                    'phrase' => '(Minas Gerais) 19:00 Hoje ' . $data,
                    'id'=> 16,
                ]
            ],
            'BA' => [
                // 'BA (10:00)' => [
                //     'url' => 'https://www.resultadosnahora.com.br/banca-bahia/',
                //     'phrase' => '(Bahia) 10:00 Hoje ' . $data,
                //     'id'=> 17,
                // ],
                'BA (12:00)' => [
                    'url' => 'https://www.resultadosnahora.com.br/banca-bahia/',
                    'phrase' => '(Bahia) 12:00 Hoje ' . $data,
                    'id'=> 17,
                ],
                'BA (15:00)' => [
                    'url' => 'https://www.resultadosnahora.com.br/banca-bahia/',
                    'phrase' => '(Bahia) 15:00 Hoje ' . $data,
                    'id'=> 18,
                ],
                'BA (19:00)' => [
                    'url' => 'https://www.resultadosnahora.com.br/banca-bahia/', 
                    'phrase' => 'Federal (Bahia) 19:00 Hoje ' . $data,
                    'id'=> 19,
                ],
                'BA (21:00)' => [
                    'url' => 'https://www.resultadosnahora.com.br/banca-bahia/',
                    'phrase' => '(Bahia) 21:00 Hoje ' . $data,
                    'id'=> 20,
                ]
            ],
            'PB' => [
                'LOTEP (10:45)' => [
                    'url' => 'https://www.resultadosnahora.com.br/banca-lotep/',
                    'phrase' => '(Lotep Paraíba) 10:45 Hoje ' . $data,
                    'id'=> 21,
                ],
                'LOTEP (12:45)' => [
                    'url' => 'https://www.resultadosnahora.com.br/banca-lotep/',
                    'phrase' => '(Lotep Paraíba) 12:45 Hoje ' . $data,
                    'id'=> 22,
                ],
                'LOTEP (15:45)' => [
                    'url' => 'https://www.resultadosnahora.com.br/banca-lotep/',
                    'phrase' => '(Lotep Paraíba) 15:45 Hoje ' . $data,
                    'id'=> 23,
                ],
                'LOTEP (18:00)' => [
                    'url' => 'https://www.resultadosnahora.com.br/banca-lotep/',
                    'phrase' => '(Lotep Paraíba) 18:00 Hoje ' . $data,
                    'id'=> 24,
                ],
            ]
        ];
    
        // Verifica se o estado é válido
        if (!array_key_exists($estado, $urls)) {
            return response()->json(['error' => 'Estado inválido'], 400);
        }
    
        $resultados = [];
    
        // Itera sobre as URLs disponíveis para o estado fornecido
        foreach ($urls[$estado] as $banca => $config) {
            $url = $config['url'];
            $phrase = $config['phrase'];
    
            if ($url) {
                $client = new Client();
                $response = $client->get($url);
                $html = $response->getBody()->getContents();
                $crawler = new Crawler($html);
    
                $crawler->filter('table')->each(function ($table) use (&$resultados, $phrase, $banca) {
                    // dd($phrase);
                    $tableContent = $table->html();
                    if (strpos($tableContent, $phrase) !== false) {
                        // Use DOMDocument para organizar os dados da tabela
                        $doc = new \DOMDocument();
                        $doc->loadHTML($tableContent);
    
                        $rows = $doc->getElementsByTagName('tr');
    
                        $bancaData = [];
    
                        foreach ($rows as $row) {
                            $cols = $row->getElementsByTagName('td');
                            $rowData = [];
                            foreach ($cols as $col) {
                                $rowData[] = $col->nodeValue;
                            }
                            $bancaData[] = $rowData;
                        }
    
                        // Remova a primeira linha que contém cabeçalhos
                        array_shift($bancaData);
    
                        // Adiciona os resultados dessa banca aos resultados gerais
                        $resultados[$banca] = $bancaData;
    
                        return false; // Para parar a iteração quando a tabela desejada for encontrada
                    }
                });
            }
        }
    
        if (!empty($resultados)) {
            return response()->json($resultados);
        } else {
            return response()->json(['error' => 'Nenhum resultado encontrado'], 404);
        }
    }
    
    public function scrape2(Request $request)
    {
        // Obtém o estado e a data da URL
        $estado = $request->estado;
        $data = $request->data;
    
        // Verifica se a data está no formato correto
        if (!preg_match('/^\d{2}-\d{2}-\d{4}$/', $data)) {
            return response()->json(['error' => 'Formato de data inválido. Use dd-mm-yyyy'], 400);
        }
    
        $data = str_replace('-', '/', $data);
    
        $urls = [
            'RJ' => [
                'PTM' => [
                    'url' => 'https://www.resultadosnahora.com.br/banca-ptm-rio/',
                    'phrase' => '(PTM-Rio) 11:00 Hoje ' . $data,
                    'id' => 1,
                ],
                'PT' => [
                    'url' => 'https://www.resultadosnahora.com.br/pt-riopt-rio/',
                    'phrase' => '(PT-Rio) 14:00 Hoje ' . $data,
                    'id' => 2,
                ],
                'PTV' => [
                    'url' => 'https://www.resultadosnahora.com.br/banca-ptv-rio/',
                    'phrase' => '(PTV-Rio) 16:00 Hoje ' . $data,
                    'id'=> 3,
                ],
                'PTN' => [
                    'url' => 'https://www.resultadosnahora.com.br/banca-ptn-rio/',
                    'phrase' => '(PTN-Rio) 18:00 Hoje ' . $data,
                    'id'=> 4,
                ],
                'COR' => [
                    'url' => 'https://www.resultadosnahora.com.br/banca-coruja/',
                    'phrase' => '(Coruja-Rio) 21:00 Hoje ' . $data,
                    'id'=> 5,
                ]
            ],
            'SP' => [
                'PT-SP' => [
                    'url' => null, // Esta bancas parece não existir na fonte de dados fornecida
                    'phrase' => '(Pt-Sp) 13:20 Hoje ' . $data,
                    'id'=> 6,
                ],
                'Bandeirantes' => [
                    'url' => 'https://www.resultadosnahora.com.br/banca-bandeirante/',
                    'phrase' => '(Bandeirante-Sp) 15:20 Hoje ' . $data,
                    'id'=> 7,
                ],
                'PTN' => [
                    'url' => 'https://www.resultadosnahora.com.br/banca-ptn-sp/',
                    'phrase' => '(Ptn-Sp) 20:20 Hoje ' . $data,
                    'id'=> 8,
                ]
            ],
            'GO' => [
                'Look (11:20)' => [
                    'url' => 'https://www.resultadosnahora.com.br/banca-look/',
                    'phrase' => '(Look-Goias) 11:20 Hoje ' . $data,
                    'id'=> 9,
                ],
                'Look (14:20)' => [
                    'url' => 'https://www.resultadosnahora.com.br/banca-look/',
                    'phrase' => '(Look-Goias) 14:20 Hoje ' . $data,
                    'id'=> 10,
                ],
                'Look (16:20)' => [
                    'url' => 'https://www.resultadosnahora.com.br/banca-look/',
                    'phrase' => '(Look-Goias) 16:20 Hoje ' . $data,
                    'id'=> 11,
                ],
                'Look (18:20)' => [
                    'url' => 'https://www.resultadosnahora.com.br/banca-look/',
                    'phrase' => '(Look-Goias) 18:20 Hoje ' . $data,
                    'id'=> 12,
                ],
                'Look (21:20)' => [
                    'url' => 'https://www.resultadosnahora.com.br/banca-look/',
                    'phrase' => '(Look-Goias) 21:20 Hoje ' . $data,
                    'id'=> 13,
                ]
            ],
            'MG' => [
                'Alvorada' => [
                    'url' => 'https://www.resultadosnahora.com.br/banca-alvorada-minas/',
                    'phrase' => '(Minas Gerais) 12:00 Hoje ' . $data,
                    'id'=> 14,
                ],
                'Minas-dia' => [
                    'url' => 'https://www.resultadosnahora.com.br/banca-minas-dia/',
                    'phrase' => '(Minas Gerais) 15:00 Hoje ' . $data,
                    'id'=> 15,
                ],
                'Minas-noite' => [
                    'url' => 'https://www.resultadosnahora.com.br/banca-minas-noite/',
                    'phrase' => '(Minas Gerais) 19:00 Hoje ' . $data,
                    'id'=> 16,
                ]
            ],
            'BA' => [
                // 'BA (10:00)' => [
                //     'url' => 'https://www.resultadosnahora.com.br/banca-bahia/',
                //     'phrase' => '(Bahia) 10:00 Hoje ' . $data,
                //     'id'=> 17,
                // ],
                'BA (12:00)' => [
                    'url' => 'https://www.resultadosnahora.com.br/banca-bahia/',
                    'phrase' => '(Bahia) 12:00 Hoje ' . $data,
                    'id'=> 17,
                ],
                'BA (15:00)' => [
                    'url' => 'https://www.resultadosnahora.com.br/banca-bahia/',
                    'phrase' => '(Bahia) 15:00 Hoje ' . $data,
                    'id'=> 18,
                ],
                'BA (19:00)' => [
                    'url' => 'https://www.resultadosnahora.com.br/banca-bahia/', 
                    'phrase' => 'Federal (Bahia) 19:00 Hoje ' . $data,
                    'id'=> 19,
                ],
                'BA (21:00)' => [
                    'url' => 'https://www.resultadosnahora.com.br/banca-bahia/',
                    'phrase' => '(Bahia) 21:00 Hoje ' . $data,
                    'id'=> 20,
                ]
            ],
            'PB' => [
                'LOTEP (10:45)' => [
                    'url' => 'https://www.resultadosnahora.com.br/banca-lotep/',
                    'phrase' => '(Lotep Paraíba) 10:45 Hoje ' . $data,
                    'id'=> 21,
                ],
                'LOTEP (12:45)' => [
                    'url' => 'https://www.resultadosnahora.com.br/banca-lotep/',
                    'phrase' => '(Lotep Paraíba) 12:45 Hoje ' . $data,
                    'id'=> 22,
                ],
                'LOTEP (15:45)' => [
                    'url' => 'https://www.resultadosnahora.com.br/banca-lotep/',
                    'phrase' => '(Lotep Paraíba) 15:45 Hoje ' . $data,
                    'id'=> 23,
                ],
                'LOTEP (18:00)' => [
                    'url' => 'https://www.resultadosnahora.com.br/banca-lotep/',
                    'phrase' => '(Lotep Paraíba) 18:00 Hoje ' . $data,
                    'id'=> 24,
                ],
            ]
        ];
    
        // Verifica se o estado é válido
        if (!array_key_exists($estado, $urls)) {
            return response()->json(['error' => 'Estado inválido'], 400);
        }
    
        $resultados = [];
    
        // Itera sobre as URLs disponíveis para o estado fornecido
        foreach ($urls[$estado] as $banca => $config) {
            $url = $config['url'];
            $phrase = $config['phrase'];
            $id = $config['id'];
    
            if ($url) {
                $client = new Client();
                $response = $client->get($url);
                $html = $response->getBody()->getContents();
                $crawler = new Crawler($html);
    
                $crawler->filter('table')->each(function ($table) use (&$resultados, $phrase, $banca, $id) {
                    $tableContent = $table->html();
                    if (strpos($tableContent, $phrase) !== false) {
                        // Use DOMDocument para organizar os dados da tabela
                        $doc = new \DOMDocument();
                        $doc->loadHTML($tableContent);
    
                        $rows = $doc->getElementsByTagName('tr');
    
                        $bancaData = [];
    
                        // Adiciona apenas os primeiros 5 resultados
                        for ($i = 1; $i < 6; $i++) {
                            $rowData = [];
                            $cols = $rows[$i]->getElementsByTagName('td');
                            foreach ($cols as $col) {
                                $rowData[] = $col->nodeValue;
                            }
                            // Adiciona o número
                            $bancaData[] = $rowData[1];
                        }
    
                        // Adiciona o ID da banca em um array separado
                        array_unshift($bancaData, $id);
    
                        // Adiciona os resultados dessa banca aos resultados gerais
                        $resultados[$banca] = [$bancaData];
    
                        return false; // Para parar a iteração quando a tabela desejada for encontrada
                    }
                });
            }
        }
    
        if (!empty($resultados)) {
            return response()->json($resultados);
        } else {
            return response()->json(['error' => 'Nenhum resultado encontrado'], 404);
        }
    }
    
    
    
}