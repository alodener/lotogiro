<?php

namespace App\Http\Controllers;

use App\Models\BichaoModalidades;
use CreateBichaoGamesTable;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;
use App\Models\BichaoResultados; 
use App\Models\BichaoGames; 
use App\Models\BichaoGamesVencedores; 
use App\Models\BichaoAnimals; 
use Illuminate\Support\Facades\DB;


class ScrapingController extends Controller
{
    //função base do scrapping
    public function scrape(Request $request)
    {
        // Obtém o UF (sigla do estado) do pedido
        $uf = $request->estado;
        $data = date('Y-m-d', strtotime($request->data));
    
        // Obtém o ID do estado com base no UF
        $estado = DB::table('bichao_estados')
                    ->where('uf', $uf)
                    ->value('id');
    
        if (!$estado) {
            return response()->json(['error' => 'Estado não encontrado'], 404);
        }
    
        // Obtém todos os horários de sorteio para esse estado com seus respectivos nomes de banca
        $horarios = DB::table('bichao_horarios')
                    ->select('id', 'banca', DB::raw("CONCAT(banca, ' (', DATE_FORMAT(horario, '%H:%i'), ')') AS horario"))
                    ->where('estado_id', $estado)
                    ->get();
    
        if ($horarios->isEmpty()) {
            return response()->json(['error' => 'Nenhum horário de sorteio encontrado para este estado'], 404);
        }
    
        // Inicializa um array para armazenar os resultados formatados
        $todosResultados = [];
    
        // Para cada horário de sorteio, buscar os resultados correspondentes na tabela de resultados
        foreach ($horarios as $horario) {
            $resultados = DB::table('bichao_resultados')
                            ->where('horario_id', $horario->id)
                            ->whereDate('data_sorteio', $data)
                            ->first();
    
            // Verifica se há resultados para esse horário e data
            if ($resultados) {
                // Formata os resultados conforme o exemplo esperado
                $formattedResults = [];
                $formattedResults[] = [
                    'lugar' => "1º",
                    'numero' => $resultados->premio_1,
                    'grupo' => $this->getGroupAndAnimal($resultados->premio_1)['grupo'],
                    'animal' => $this->getGroupAndAnimal($resultados->premio_1)['animal']
                ];
                $formattedResults[] = [
                    'lugar' => "2º",
                    'numero' => $resultados->premio_2,
                    'grupo' => $this->getGroupAndAnimal($resultados->premio_2)['grupo'],
                    'animal' => $this->getGroupAndAnimal($resultados->premio_2)['animal']
                ];
                $formattedResults[] = [
                    'lugar' => "3º",
                    'numero' => $resultados->premio_3,
                    'grupo' => $this->getGroupAndAnimal($resultados->premio_3)['grupo'],
                    'animal' => $this->getGroupAndAnimal($resultados->premio_3)['animal']
                ];
                $formattedResults[] = [
                    'lugar' => "4º",
                    'numero' => $resultados->premio_4,
                    'grupo' => $this->getGroupAndAnimal($resultados->premio_4)['grupo'],
                    'animal' => $this->getGroupAndAnimal($resultados->premio_4)['animal']
                ];
                $formattedResults[] = [
                    'lugar' => "5º",
                    'numero' => $resultados->premio_5,
                    'grupo' => $this->getGroupAndAnimal($resultados->premio_5)['grupo'],
                    'animal' => $this->getGroupAndAnimal($resultados->premio_5)['animal']
                ];
    
                // Adiciona os resultados formatados ao array principal
                $todosResultados[$horario->horario] = $formattedResults;
            }
        }
    
        if (empty($todosResultados)) {
            return response()->json(['error' => 'Nenhum resultado encontrado para os horários e data especificados'], 404);
        }
    
        // Retorna os resultados do banco de dados
        return response()->json($todosResultados);
    }
     
    private function getGroupAndAnimal($number)
    {
        // Obtém o grupo e o animal com base no número fornecido
        $animal = DB::table('bichao_animais')
                    ->where('value_1', 'like', '%' . substr($number, -2) . '%')
                    ->orWhere('value_2', 'like', '%' . substr($number, -2) . '%')
                    ->orWhere('value_3', 'like', '%' . substr($number, -2) . '%')
                    ->orWhere('value_4', 'like', '%' . substr($number, -2) . '%')
                    ->first();
    
        if ($animal) {
            return [
                'grupo' => (int) $animal->id,
                'animal' => $animal->name
            ];
        } else {
            return null;
        }
    }

    //dados formatados
    public function scrape0 (Request $request)
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
                'PTM - RIO (11:20)' => [
                    'url' => 'https://www.resultadosnahora.com.br/banca-ptm-rio/',
                    'phrase' => '(PTM-Rio) 11:00 Hoje ' . $data,
                    'id' => 1,
                ],
                'PT - RIO  (14:20)' => [
                    'url' => 'https://www.resultadosnahora.com.br/pt-riopt-rio/',
                    'phrase' => '(PT-Rio) 14:00 Hoje ' . $data,
                    'id' => 2,
                ],
                'PTV - RIO (16:20)' => [
                    'url' => 'https://www.resultadosnahora.com.br/banca-ptv-rio/',
                    'phrase' => '(PTV-Rio) 16:00 Hoje ' . $data,
                    'id'=> 3,
                ],
                'PTN - RIO (18:20)' => [
                    'url' => 'https://www.resultadosnahora.com.br/banca-ptn-rio/',
                    'phrase' => '(PTN-Rio) 18:00 Hoje ' . $data,
                    'id'=> 4,
                ],
                'CORUJA - RIO (21:20)' => [
                    'url' => 'https://www.resultadosnahora.com.br/banca-coruja/',
                    'phrase' => '(Coruja-Rio) 21:00 Hoje ' . $data,
                    'id'=> 5,
                ]
            ],
            'SP' => [
                'PT-SP (13:00)' => [
                    'url' => 'https://www.resultadosnahora.com.br/banca-pt-sp/', // Esta bancas parece não existir na fonte de dados fornecida
                    'phrase' => '(Pt-Sp) 13:20 Hoje ' . $data,
                    'id'=> 6,
                ],
                'Bandeirantes (16:00)' => [
                    'url' => 'https://www.resultadosnahora.com.br/banca-bandeirante/',
                    'phrase' => '(Bandeirante-Sp) 15:20 Hoje ' . $data,
                    'id'=> 7,
                ],
                'PTN - SP (20:00)' => [
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
                'Alvorada (12:00)' => [
                    'url' => 'https://www.resultadosnahora.com.br/banca-alvorada-minas/',
                    'phrase' => '(Minas Gerais) 12:00 Hoje ' . $data,
                    'id'=> 14,
                ],
                'Minas-dia (15:00)' => [
                    'url' => 'https://www.resultadosnahora.com.br/banca-minas-dia/',
                    'phrase' => '(Minas Gerais) 15:00 Hoje ' . $data,
                    'id'=> 15,
                ],
                'Minas-noite (19:00)' => [
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
                'LOTEP (18:45)' => [
                    'url' => 'https://www.resultadosnahora.com.br/banca-lotep/',
                    'phrase' => '(Lotep Paraíba) 18:00 Hoje ' . $data,
                    'id'=> 24,
                ],
            ],
            'DF' => [
                'LBR (12:40)' => [
                    'url' => 'https://www.resultadosnahora.com.br/banca-lbr/',
                    'phrase' => '(Lbr-Brasilia) 12:40 Hoje ' . $data,
                    'id'=> 25,
                ],
                'LBR (15:00)' => [
                    'url' => 'https://www.resultadosnahora.com.br/banca-lbr/',
                    'phrase' => '(Lbr-Brasilia) 15:30 Hoje ' . $data,
                    'id'=> 26,
                ],
                'LBR (17:00)' => [
                    'url' => 'https://www.resultadosnahora.com.br/banca-lbr/',
                    'phrase' => '(Lbr-Brasilia) 17:30 Hoje ' . $data,
                    'id'=> 27,
                ],
                'LBR (19:00)' => [
                    'url' => 'https://www.resultadosnahora.com.br/banca-lbr/',
                    'phrase' => '(Lbr-Brasilia) 19:30 Hoje ' . $data,
                    'id'=> 28,
                ],
                
            ],
            'CE' => [
                'LOTOCE (11:00)' => [
                    'url' => 'https://www.resultadosnahora.com.br/banca-lotece/',
                    'phrase' => '(Lotece-Ceará) 11:20 Hoje ' . $data,
                    'id'=> 29,
                ],
                'LOTOCE (14:00)' => [
                    'url' => 'https://www.resultadosnahora.com.br/banca-lotece/',
                    'phrase' => '(Lbr-Brasilia) 14:00 Hoje ' . $data,
                    'id'=> 30,
                ],
                'LOTOCE (19:00)' => [
                    'url' => 'https://www.resultadosnahora.com.br/banca-lotece/',
                    'phrase' => '(Lbr-Brasilia) 19:00 Hoje ' . $data,
                    'id'=> 31,
                ],
                
            ],
            'FED' => [
                'Loteria Federal do Brasil (19:00)' => [
                    'url' => 'https://www.resultadosnahora.com.br/loteria-federal/',
                    'phrase' => '19:00 Hoje ' . $data,
                    'id'=> 32,
                ],
            ],


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
    
    //insere no banco
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
        $dataFormatada = date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $data)));

    
        $urls = [
            'RJ' => [
                'PTM - RIO (11:20)' => [
                    'url' => 'https://www.resultadosnahora.com.br/banca-ptm-rio/',
                    'phrase' => '(PTM-Rio) 11:00 Hoje ' . $data,
                    'id' => 1,
                ],
                'PT - RIO  (14:20)' => [
                    'url' => 'https://www.resultadosnahora.com.br/pt-riopt-rio/',
                    'phrase' => '(PT-Rio) 14:00 Hoje ' . $data,
                    'id' => 2,
                ],
                'PTV - RIO (16:20)' => [
                    'url' => 'https://www.resultadosnahora.com.br/banca-ptv-rio/',
                    'phrase' => '(PTV-Rio) 16:00 Hoje ' . $data,
                    'id'=> 3,
                ],
                'PTN - RIO (18:20)' => [
                    'url' => 'https://www.resultadosnahora.com.br/banca-ptn-rio/',
                    'phrase' => '(PTN-Rio) 18:00 Hoje ' . $data,
                    'id'=> 4,
                ],
                'CORUJA - RIO (21:20)' => [
                    'url' => 'https://www.resultadosnahora.com.br/banca-coruja/',
                    'phrase' => '(Coruja-Rio) 21:00 Hoje ' . $data,
                    'id'=> 5,
                ]
            ],
            'SP' => [
                'PT-SP (13:00)' => [
                    'url' => 'https://www.resultadosnahora.com.br/banca-pt-sp/', // Esta bancas parece não existir na fonte de dados fornecida
                    'phrase' => '(Pt-Sp) 13:20 Hoje ' . $data,
                    'id'=> 6,
                ],
                'Bandeirantes (16:00)' => [
                    'url' => 'https://www.resultadosnahora.com.br/banca-bandeirante/',
                    'phrase' => '(Bandeirante-Sp) 15:20 Hoje ' . $data,
                    'id'=> 7,
                ],
                'PTN - SP (20:00)' => [
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
                'Alvorada (12:00)' => [
                    'url' => 'https://www.resultadosnahora.com.br/banca-alvorada-minas/',
                    'phrase' => '(Minas Gerais) 12:00 Hoje ' . $data,
                    'id'=> 14,
                ],
                'Minas-dia (15:00)' => [
                    'url' => 'https://www.resultadosnahora.com.br/banca-minas-dia/',
                    'phrase' => '(Minas Gerais) 15:00 Hoje ' . $data,
                    'id'=> 15,
                ],
                'Minas-noite (19:00)' => [
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
                'LOTEP (18:45)' => [
                    'url' => 'https://www.resultadosnahora.com.br/banca-lotep/',
                    'phrase' => '(Lotep Paraíba) 18:00 Hoje ' . $data,
                    'id'=> 24,
                ],
            ],
            'DF' => [
                'LBR (12:40)' => [
                    'url' => 'https://www.resultadosnahora.com.br/banca-lbr/',
                    'phrase' => '(Lbr-Brasilia) 12:40 Hoje ' . $data,
                    'id'=> 25,
                ],
                'LBR (15:00)' => [
                    'url' => 'https://www.resultadosnahora.com.br/banca-lbr/',
                    'phrase' => '(Lbr-Brasilia) 15:30 Hoje ' . $data,
                    'id'=> 26,
                ],
                'LBR (17:00)' => [
                    'url' => 'https://www.resultadosnahora.com.br/banca-lbr/',
                    'phrase' => '(Lbr-Brasilia) 17:30 Hoje ' . $data,
                    'id'=> 27,
                ],
                'LBR (19:00)' => [
                    'url' => 'https://www.resultadosnahora.com.br/banca-lbr/',
                    'phrase' => '(Lbr-Brasilia) 19:30 Hoje ' . $data,
                    'id'=> 28,
                ],
                
            ],
            'CE' => [
                'LOTOCE (11:00)' => [
                    'url' => 'https://www.resultadosnahora.com.br/banca-lotece/',
                    'phrase' => '(Lotece-Ceará) 11:20 Hoje ' . $data,
                    'id'=> 29,
                ],
                'LOTOCE (14:00)' => [
                    'url' => 'https://www.resultadosnahora.com.br/banca-lotece/',
                    'phrase' => '(Lbr-Brasilia) 14:00 Hoje ' . $data,
                    'id'=> 30,
                ],
                'LOTOCE (19:00)' => [
                    'url' => 'https://www.resultadosnahora.com.br/banca-lotece/',
                    'phrase' => '(Lbr-Brasilia) 19:00 Hoje ' . $data,
                    'id'=> 31,
                ],
                
            ],
            'FED' => [
                'Loteria Federal do Brasil (19:00)' => [
                    'url' => 'https://www.resultadosnahora.com.br/loteria-federal/',
                    'phrase' => '19:00 Hoje ' . $data,
                    'id'=> 32,
                ],
            ],


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
                        if (!isset($resultados[$banca])) {
                            $resultados[$banca] = [];
                        }
                        $resultados[$banca][] = $bancaData;
                        
                        return false; // Para parar a iteração quando a tabela desejada for encontrada
                    }
                });
            }
        }

        if (!empty($resultados)) {
            // Agora vamos salvar os resultados no banco de dados
            foreach ($resultados as $banca => $dados) {
                foreach ($dados as $resultado) {
                    $bichaoResultados = new BichaoResultados();
                    $bichaoResultados->horario_id = $resultado[0];
                    $bichaoResultados->premio_1 = $resultado[1];
                    $bichaoResultados->premio_2 = $resultado[2];
                    $bichaoResultados->premio_3 = $resultado[3];
                    $bichaoResultados->premio_4 = $resultado[4];
                    $bichaoResultados->premio_5 = $resultado[5];
                    $bichaoResultados->data_sorteio = $dataFormatada;

                    // Verifica se já existe um registro com o mesmo horário_id e data_sorteio
                    $existente = BichaoResultados::where('horario_id', $resultado[0])
                        ->where('data_sorteio', $dataFormatada)
                        ->exists();
                    
                    if (!$existente) {
                        $bichaoResultados->save();
                    } else {
                        \Log::info('Registro duplicado: ' . json_encode($resultado));
                    }
                }
            }
            
            return response()->json(['success' => true]);
        } else {
            return response()->json(['error' => 'Nenhum resultado encontrado'], 404);
        }
    }
    public function scrapeAllStates(Request $request)
    {
        // Lista de estados
        $estados = ['RJ', 'SP', 'GO', 'MG', 'BA', 'PB', 'DF', 'CE', 'FED'];
    
        // Obtém a data atual formatada no formato dd-mm-yyyy
        $dataAtual = now()->format('d-m-Y');
    
        // Array para armazenar os resultados de todos os estados
        $resultadosTotais = [];
    
        // Itera sobre os estados
        foreach ($estados as $estado) {
            // Chama a função scrape2 para obter os resultados do estado atual com a data atual
            $resultadosEstado = $this->scrape2($request->merge(['estado' => $estado, 'data' => $dataAtual]));
            
            // Adiciona os resultados do estado atual ao array de resultados totais
            $resultadosTotais[$estado] = $resultadosEstado->original;
        }
    
        // Retorna os resultados totais de todos os estados
        return response()->json($resultadosTotais);
    }


    // $data = '2024-03-21';

    public function getWinners($data){

    // $data = '2024-03-25';

        if (!$data) {
            return response()->json(['error' => 'Data não fornecida'], 400);
        }
    
        $jogos = BichaoGames::whereDate('created_at', $data)->get();
        $animais = BichaoAnimals::get()->toArray();

        $vencedores = [];
    
        foreach ($jogos as $jogo) {
            $resultado = BichaoResultados::where('horario_id', $jogo->horario_id)
                              ->whereDate('created_at', $data)
                              ->first();

            
            if ($resultado) {
                $premios_quantia = 0;
                for ($i = 1; $i <= 5; $i++) {
                    if ($jogo->{'premio_' . $i} == 1) {
                        $premios_quantia++;
                    }
                }

    
                $valor_premio = $jogo->valor * $jogo->modalidade->multiplicador / $premios_quantia;
                $game_winner = false;

                // Modalidade "Milhar" -> VALIDADO
                if ($jogo->modalidade_id == 1) { 
                    $winner = false;
                    if ($jogo->premio_1 == 1 && $resultado->premio_1 === $jogo->game_1) $winner = true;
                    if ($jogo->premio_2 == 1 && $resultado->premio_2 === $jogo->game_1) $winner = true;
                    if ($jogo->premio_3 == 1 && $resultado->premio_3 === $jogo->game_1) $winner = true;
                    if ($jogo->premio_4 == 1 && $resultado->premio_4 === $jogo->game_1) $winner = true;
                    if ($jogo->premio_5 == 1 && $resultado->premio_5 === $jogo->game_1) $winner = true;
                    if ($winner) $game_winner = true;
                }

                //Modalidade "Milhar Invertida" -> BLOCKED
                if ($jogo->modalidade_id == 13) {
                    $divider = static::getFatorialInvertidoMilhar($jogo->game_1);
                    $valor_premio = ($jogo->valor / $divider) * $jogo->multiplicador / $premios_quantia;
    
                    $winner = 0;
                    if ($jogo->premio_1 == 1 && static::checkInvertidaWinner($jogo->game_1, $resultado->premio_1)) $winner += 1;
                    if ($jogo->premio_2 == 1 && static::checkInvertidaWinner($jogo->game_1, $resultado->premio_2)) $winner += 1;
                    if ($jogo->premio_3 == 1 && static::checkInvertidaWinner($jogo->game_1, $resultado->premio_3)) $winner += 1;
                    if ($jogo->premio_4 == 1 && static::checkInvertidaWinner($jogo->game_1, $resultado->premio_4)) $winner += 1;
                    if ($jogo->premio_5 == 1 && static::checkInvertidaWinner($jogo->game_1, $resultado->premio_5)) $winner += 1;
                    if ($winner > 0) {
                        $game_winner = true;
                        $valor_premio = number_format($valor_premio * $game_winner, 2, ".", "");
                    }
                }

                // Modalidade "Centena" -> VALIDADO
                if ($jogo->modalidade_id == 2) { 
                    $winner = false;
                    // dd($resultado->premio_1);
                    if ($jogo->premio_1 == 1 && substr($resultado->premio_1, 1) === $jogo->game_1) $winner = true;
                    if ($jogo->premio_1 == 1 && substr($resultado->premio_2, 1) === $jogo->game_1) $winner = true;
                    if ($jogo->premio_1 == 1 && substr($resultado->premio_3, 1) === $jogo->game_1) $winner = true;
                    if ($jogo->premio_1 == 1 && substr($resultado->premio_4, 1) === $jogo->game_1) $winner = true;
                    if ($jogo->premio_1 == 1 && substr($resultado->premio_5, 1) === $jogo->game_1) $winner = true;
                    if ($winner) $game_winner = true;
                }

                // Centena Invertida -> BLOCKED
                if ($jogo->modalidade_id == 14) {
                    $divider = static::getFatorialInvertidoCentena($jogo->game_1);
                    $valor_premio = ($jogo->valor / $divider) * $jogo->multiplicador / $premios_quantia;

                    $game_winner = 0;
                    if ($jogo->premio_1 == 1 && static::checkInvertidaWinner($jogo->game_1, substr($resultado->premio_1, 1))) $game_winner += 1;
                    if ($jogo->premio_2 == 1 && static::checkInvertidaWinner($jogo->game_1, substr($resultado->premio_2, 1))) $game_winner += 1;
                    if ($jogo->premio_3 == 1 && static::checkInvertidaWinner($jogo->game_1, substr($resultado->premio_3, 1))) $game_winner += 1;
                    if ($jogo->premio_4 == 1 && static::checkInvertidaWinner($jogo->game_1, substr($resultado->premio_4, 1))) $game_winner += 1;
                    if ($jogo->premio_5 == 1 && static::checkInvertidaWinner($jogo->game_1, substr($resultado->premio_5, 1))) $game_winner += 1;

                    if ($game_winner > 0) {
                        $game_winner = true;
                        $valor_premio = number_format($valor_premio * $game_winner, 2, ".", "");
                    }
                }



                // Verificação para a modalidade "Dezena" -> VALIDADO
                if ($jogo->modalidade_id == 3) {
                    $winner = false;
                    if ($jogo->premio_1 == 1 && substr($resultado->premio_1, 2) === $jogo->game_1) $winner = true;
                    if ($jogo->premio_2 == 1 && substr($resultado->premio_2, 2) === $jogo->game_1) $winner = true;
                    if ($jogo->premio_3 == 1 && substr($resultado->premio_3, 2) === $jogo->game_1) $winner = true;
                    if ($jogo->premio_4 == 1 && substr($resultado->premio_4, 2) === $jogo->game_1) $winner = true;
                    if ($jogo->premio_5 == 1 && substr($resultado->premio_5, 2) === $jogo->game_1) $winner = true;
                    if ($winner) $game_winner = true;
                }

                // Verificação para a modalidade "Unidade" -> VALIDADO 
                if ($jogo->modalidade_id == 12) {
                    $winner = false;
                    if ($jogo->premio_1 == 1 && substr($resultado->premio_1, 3) === $jogo->game_1) $winner = true;
                    if ($jogo->premio_2 == 1 && substr($resultado->premio_2, 3) === $jogo->game_1) $winner = true;
                    if ($jogo->premio_3 == 1 && substr($resultado->premio_3, 3) === $jogo->game_1) $winner = true;
                    if ($jogo->premio_4 == 1 && substr($resultado->premio_4, 3) === $jogo->game_1) $winner = true;
                    if ($jogo->premio_5 == 1 && substr($resultado->premio_5, 3) === $jogo->game_1) $winner = true;
                    if ($winner) $game_winner = true;

                }

                // Verificação para a modalidade "Grupo" -> VALIDADO
                if ($jogo->modalidade_id == 4) {
                    $animal = array_values(array_filter($animais, function ($animal) use ($jogo) {
                        return $animal['id'] == $jogo->game_1;
                    }));
                    
                    if (sizeof($animal) == 0) continue;
                    $animal = $animal[0];
                    
                    $winner = false;
                    if ($jogo->premio_1 == 1 && substr($resultado->premio_1, 2) >= $animal['value_1'] && substr($resultado->premio_1, 2) <= $animal['value_4']) $winner = true;
                    if ($jogo->premio_2 == 1 && substr($resultado->premio_2, 2) >= $animal['value_1'] && substr($resultado->premio_2, 2) <= $animal['value_4']) $winner = true;
                    if ($jogo->premio_3 == 1 && substr($resultado->premio_3, 2) >= $animal['value_1'] && substr($resultado->premio_3, 2) <= $animal['value_4']) $winner = true;
                    if ($jogo->premio_4 == 1 && substr($resultado->premio_4, 2) >= $animal['value_1'] && substr($resultado->premio_4, 2) <= $animal['value_4']) $winner = true;
                    if ($jogo->premio_5 == 1 && substr($resultado->premio_5, 2) >= $animal['value_1'] && substr($resultado->premio_5, 2) <= $animal['value_4']) $winner = true;
                    if ($winner) $game_winner = true;

                }

                //Modalidade Terno de Dezena ->VALIDADO
                if ($jogo->modalidade_id == 6) {
                    $multiplicador = $premios_quantia == 3 ? $jogo->multiplicador : $jogo->multiplicador_2;
                
                    $valor_premio = $jogo->valor * $multiplicador;
                    $game_winner = 0;
                    $gameResults = [$jogo->game_1, $jogo->game_2, $jogo->game_3];
                    // dd($gameResults, $resultado->premio_1, $jogo->game_3, $winner);

                    if (in_array(substr($resultado->premio_1, 2), $gameResults)) unset($gameResults[array_search(substr($resultado->premio_1, 2), $gameResults)]);
                    if (in_array(substr($resultado->premio_2, 2), $gameResults)) unset($gameResults[array_search(substr($resultado->premio_2, 2), $gameResults)]);
                    if (in_array(substr($resultado->premio_3, 2), $gameResults)) unset($gameResults[array_search(substr($resultado->premio_3, 2), $gameResults)]);
                    if (in_array(substr($resultado->premio_4, 2), $gameResults)) unset($gameResults[array_search(substr($resultado->premio_4, 2), $gameResults)]);
                    if (in_array(substr($resultado->premio_5, 2), $gameResults)) unset($gameResults[array_search(substr($resultado->premio_5, 2), $gameResults)]);
                    if (count($gameResults) === 0) $game_winner = true;

                }

                // Quina de Grupo --> Valiado
                if ($jogo->modalidade_id == 11) {
                    $animals = array_values(array_filter($animais, function ($animal) use ($jogo) {
                        return in_array($animal['id'], [$jogo->game_1, $jogo->game_2, $jogo->game_3, $jogo->game_4, $jogo->game_5]);
                    }));
                    if (sizeof($animals) == 0) continue;

                    $multiplicador = $premios_quantia == 3 ? $jogo->multiplicador : $jogo->multiplicador_2;
                    $valor_premio = $jogo->valor * $multiplicador;
                    
                    $winner = 0;
                    foreach ($animals as $animal) {
                        $subWinner = false;
                        if ($jogo->premio_1 == 1 && substr($resultado->premio_1, 2) >= $animal['value_1'] && substr($resultado->premio_1, 2) <= $animal['value_4']) $subWinner = true;
                        if ($jogo->premio_2 == 1 && substr($resultado->premio_2, 2) >= $animal['value_1'] && substr($resultado->premio_2, 2) <= $animal['value_4']) $subWinner = true;
                        if ($jogo->premio_3 == 1 && substr($resultado->premio_3, 2) >= $animal['value_1'] && substr($resultado->premio_3, 2) <= $animal['value_4']) $subWinner = true;
                        if ($jogo->premio_4 == 1 && substr($resultado->premio_4, 2) >= $animal['value_1'] && substr($resultado->premio_4, 2) <= $animal['value_4']) $subWinner = true;
                        if ($jogo->premio_5 == 1 && substr($resultado->premio_5, 2) >= $animal['value_1'] && substr($resultado->premio_5, 2) <= $animal['value_4']) $subWinner = true;
                        if ($subWinner) $winner = $winner + 1;
                    }
                    
                    if ($winner === 5) $game_winner = true;

                }

                // Quadra de Grupo --> VALIDADO
                if ($jogo->modalidade_id == 10) {
                    $animals = array_values(array_filter($animais, function ($animal) use ($jogo) {
                        return in_array($animal['id'], [$jogo->game_1, $jogo->game_2, $jogo->game_3, $jogo->game_4]);
                    }));
                    if (sizeof($animals) == 0) continue;

                    $multiplicador = $premios_quantia == 3 ? $jogo->multiplicador : $jogo->multiplicador_2;
                    $valor_premio = $jogo->valor * $multiplicador;
                    
                    $winner = 0;
                    foreach ($animals as $animal) {
                        $subWinner = false;
                        if ($jogo->premio_1 == 1 && substr($resultado->premio_1, 2) >= $animal['value_1'] && substr($resultado->premio_1, 2) <= $animal['value_4']) $subWinner = true;
                        if ($jogo->premio_2 == 1 && substr($resultado->premio_2, 2) >= $animal['value_1'] && substr($resultado->premio_2, 2) <= $animal['value_4']) $subWinner = true;
                        if ($jogo->premio_3 == 1 && substr($resultado->premio_3, 2) >= $animal['value_1'] && substr($resultado->premio_3, 2) <= $animal['value_4']) $subWinner = true;
                        if ($jogo->premio_4 == 1 && substr($resultado->premio_4, 2) >= $animal['value_1'] && substr($resultado->premio_4, 2) <= $animal['value_4']) $subWinner = true;
                        if ($jogo->premio_5 == 1 && substr($resultado->premio_5, 2) >= $animal['value_1'] && substr($resultado->premio_5, 2) <= $animal['value_4']) $subWinner = true;
                        if ($subWinner) $winner = $winner + 1;
                    }
                    
                    if ($winner === 4) $game_winner = true;

                }

                // Terno de Grupo -- > VALIDADO
                if ($jogo->modalidade_id == 7) {
                    $animals = array_values(array_filter($animais, function ($animal) use ($jogo) {
                        return in_array($animal['id'], [$jogo->game_1, $jogo->game_2, $jogo->game_3]);
                    }));
                    if (sizeof($animals) == 0) continue;

                    $multiplicador = $premios_quantia == 3 ? $jogo->multiplicador : $jogo->multiplicador_2;
                    $valor_premio = $jogo->valor * $multiplicador;
                    
                    $winner = 0;
                    foreach ($animals as $animal) {
                        $subWinner = false;
                        if ($jogo->premio_1 == 1 && substr($resultado->premio_1, 2) >= $animal['value_1'] && substr($resultado->premio_1, 2) <= $animal['value_4']) $subWinner = true;
                        if ($jogo->premio_2 == 1 && substr($resultado->premio_2, 2) >= $animal['value_1'] && substr($resultado->premio_2, 2) <= $animal['value_4']) $subWinner = true;
                        if ($jogo->premio_3 == 1 && substr($resultado->premio_3, 2) >= $animal['value_1'] && substr($resultado->premio_3, 2) <= $animal['value_4']) $subWinner = true;
                        if ($jogo->premio_4 == 1 && substr($resultado->premio_4, 2) >= $animal['value_1'] && substr($resultado->premio_4, 2) <= $animal['value_4']) $subWinner = true;
                        if ($jogo->premio_5 == 1 && substr($resultado->premio_5, 2) >= $animal['value_1'] && substr($resultado->premio_5, 2) <= $animal['value_4']) $subWinner = true;
                        if ($subWinner) $winner = $winner + 1;
                    }
                    
                    if ($winner === 3) $game_winner = true;
                    // dd($animals, $jogo->premio_1, $resultado->premio_1, $resultado->premio_2, $resultado->premio_3, $resultado->premio_4, $resultado->premio_5, $jogo->game_1, $winner);

                }
                
                // Duque de Dezena
                if ($jogo->modalidade_id == 8) {
                    $valor_premio = $jogo->valor * $jogo->multiplicador;
                    $winner = 0;
                    $gameResults = [$jogo->game_1, $jogo->game_2];
                    if (in_array(substr($resultado->premio_1, 2), $gameResults)) unset($gameResults[array_search(substr($resultado->premio_1, 2), $gameResults)]);
                    if (in_array(substr($resultado->premio_2, 2), $gameResults)) unset($gameResults[array_search(substr($resultado->premio_2, 2), $gameResults)]);
                    if (in_array(substr($resultado->premio_3, 2), $gameResults)) unset($gameResults[array_search(substr($resultado->premio_3, 2), $gameResults)]);
                    if (in_array(substr($resultado->premio_4, 2), $gameResults)) unset($gameResults[array_search(substr($resultado->premio_4, 2), $gameResults)]);
                    if (in_array(substr($resultado->premio_5, 2), $gameResults)) unset($gameResults[array_search(substr($resultado->premio_5, 2), $gameResults)]);
                    if (count($gameResults) === 0) $game_winner = true;
                }

                // Duque de Grupo -- >VALIADO
                if ($jogo['modalidade_id'] == 9) {
                    $animals = array_values(array_filter($animais, function ($animal) use ($jogo) {
                        return in_array($animal['id'], [$jogo['game_1'], $jogo['game_2']]);
                    }));

                    
                    if (sizeof($animals) == 0) continue;
                    
                    $valor_premio = $jogo['valor'] * $jogo['multiplicador'];
                    $game_winner = 0;
                    
                    foreach ($animals as $animal) {
                        $subWinner = false;
                        if ($jogo->premio_1 == 1 && substr($resultado->premio_1, 2) >= $animal['value_1'] && substr($resultado->premio_1, 2) <= $animal['value_4']) $subWinner = true;

                        if ($jogo->premio_2 == 1 && substr($resultado->premio_2, 2) >= $animal['value_1'] && substr($resultado->premio_2, 2) <= $animal['value_4']) $subWinner = true;
                        if ($jogo->premio_3 == 1 && substr($resultado->premio_3, 2) >= $animal['value_1'] && substr($resultado->premio_3, 2) <= $animal['value_4']) $subWinner = true;
                        if ($jogo->premio_4 == 1 && substr($resultado->premio_4, 2) >= $animal['value_1'] && substr($resultado->premio_4, 2) <= $animal['value_4']) $subWinner = true;
                        if ($jogo->premio_5 == 1 && substr($resultado->premio_5, 2) >= $animal['value_1'] && substr($resultado->premio_5, 2) <= $animal['value_4']) $subWinner = true;
                        if ($subWinner) $game_winner = $game_winner + 1;
                    }

                    if ($game_winner != 2) $game_winner = false;
                }


                if ($game_winner) {
                    // Adicionar informações sobre o vencedor ao array
                    $gameExistente = BichaoGamesVencedores::where('game_id', $jogo->id)->exists();

                    // Se o game_id já existir, pule para o próximo item
                    if (!$gameExistente) {
                        // Adicionar informações sobre o vencedor ao array
                        $vencedores[] = [
                            'game_id' => $jogo->id, 
                            'valor_premio' => $valor_premio,
                            'resultado_id' => $resultado->id,
                            'created_at'=> now(),
                            'updated_at'=> now()
                        ];
                    }
                    

                }
            }

        }

        BichaoGamesVencedores::insert($vencedores);

        return response()->json($vencedores);
    }
    

    //Funções de suporte: 
    private static function permutations($pool, $r = null) {
        $n = count($pool);
    
        if ($r == null) {
            $r = $n;
        }
    
        if ($r > $n) {
            return;
        }
    
        $indices = range(0, $n - 1);
        $cycles = range($n, $n - $r + 1, -1); // count down
    
        yield array_slice($pool, 0, $r);
    
        if ($n <= 0) {
            return;
        }
    
        while (true) {
            $exit_early = false;
            for ($i = $r;$i--;$i >= 0) {
                $cycles[$i]-= 1;
                if ($cycles[$i] == 0) {
                    // Push whatever is at index $i to the end, move everything back
                    if ($i < count($indices)) {
                        $removed = array_splice($indices, $i, 1);
                        array_push($indices, $removed[0]);
                    }
                    $cycles[$i] = $n - $i;
                } else {
                    $j = $cycles[$i];
                    // Swap indices $i & -$j.
                    $i_val = $indices[$i];
                    $neg_j_val = $indices[count($indices) - $j];
                    $indices[$i] = $neg_j_val;
                    $indices[count($indices) - $j] = $i_val;
                    $result = [];
                    $counter = 0;
                    foreach ($indices as $indx) {
                        array_push($result, $pool[$indx]);
                        $counter++;
                        if ($counter == $r) break;
                    }
                    yield $result;
                    $exit_early = true;
                    break;
                }
            }
            if (!$exit_early) {
                break; // Outer while loop
            }
        }
    }
    
    private static function checkInvertidaWinner($game, $resultado) {
        $game = str_split($game);
        $resultado = str_split($resultado);
        foreach ($game as $game) {
            $key = array_search($game, $resultado);
            if ($key !== false) unset($resultado[$key]);
        }
        return count($resultado) === 0;
    }

    private static function getFatorialInvertidoCentena($game) {
        $result = iterator_to_array(static::permutations(str_split($game), 3));
        $response = [];
        foreach ($result as $row) {
            if (!in_array($row, $response)) array_push($response, $row);
        }

        return count($response);
    }

    private static function getFatorialInvertidoMilhar($game) {
        $result = iterator_to_array(static::permutations(str_split($game), 4));
        $response = [];
        foreach ($result as $row) {
            if (!in_array($row, $response)) array_push($response, $row);
        }

        return count($response);
    }
    
}