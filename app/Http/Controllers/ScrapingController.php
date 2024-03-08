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
            'rj' => [
                'PTM' => [
                    'url' => 'https://www.resultadosnahora.com.br/banca-ptm-rio/',
                    'phrase' => '(PTM-Rio) 11:00 Hoje ' . $data
                ],
                'PT' => [
                    'url' => 'https://www.resultadosnahora.com.br/pt-riopt-rio/',
                    'phrase' => '(PT-Rio) 14:00 Hoje ' . $data
                ],
                'PTV' => [
                    'url' => 'https://www.resultadosnahora.com.br/banca-ptv-rio/',
                    'phrase' => '(PTV-Rio) 16:00 Hoje ' . $data
                ],
                'PTN' => [
                    'url' => 'https://www.resultadosnahora.com.br/banca-ptn-rio/',
                    'phrase' => '(PTN-Rio) 18:00 Hoje ' . $data
                ],
                'COR' => [
                    'url' => 'https://www.resultadosnahora.com.br/banca-coruja/',
                    'phrase' => '(Coruja-Rio) 21:00 Hoje ' . $data
                ]
            ],
            'sp' => [
                'PT-SP' => [
                    'url' => null, // Esta bancas parece não existir na fonte de dados fornecida
                    'phrase' => '(Pt-Sp) 13:20 Hoje ' . $data
                ],
                'Bandeirantes' => [
                    'url' => 'https://www.resultadosnahora.com.br/banca-bandeirante/',
                    'phrase' => '(Bandeirante-Sp) 15:20 Hoje ' . $data
                ],
                'PTN' => [
                    'url' => 'https://www.resultadosnahora.com.br/banca-ptn-sp/',
                    'phrase' => '(Ptn-Sp) 20:20 Hoje ' . $data
                ]
            ],
            'goias' => [
                'Look' => [
                    'url' => 'https://www.resultadosnahora.com.br/banca-look/',
                    'phrase' => '(Look-Goias) 11:20 Hoje ' . $data
                ]
            ],
            'mg' => [
                'Alvorada' => [
                    'url' => 'https://www.resultadosnahora.com.br/banca-alvorada-minas/',
                    'phrase' => '(Minas Gerais) 12:00 Hoje ' . $data
                ],
                'Minas-dia' => [
                    'url' => 'https://www.resultadosnahora.com.br/banca-minas-dia/',
                    'phrase' => '(Minas Gerais) 15:00 Hoje ' . $data
                ],
                'Minas-noite' => [
                    'url' => 'https://www.resultadosnahora.com.br/banca-minas-noite/',
                    'phrase' => '(Minas Gerais) 19:00 Hoje ' . $data
                ]
            ],
            'ba' => [
                'BA' => [
                    'url' => 'https://www.resultadosnahora.com.br/banca-bahia/',
                    'phrase' => '(Bahia) 10:00 Hoje ' . $data
                ],
                'Federal' => [
                    'url' => 'https://www.resultadosnahora.com.br/banca-bahia/', 
                    'phrase' => 'Federal (Bahia) 19:00 Hoje ' . $data
                ]
            ],
            'pb' => [
                'LOTEP' => [
                    'url' => 'https://www.resultadosnahora.com.br/banca-lotep/',
                    'phrase' => '(Lotep Paraíba) 10:45 Hoje ' . $data
                ]
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
    
    
    
    
}