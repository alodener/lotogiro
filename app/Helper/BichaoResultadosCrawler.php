<?php

namespace App\Helper;
use DOMDocument;

class BichaoResultadosCrawler {
    private static $lotteries = [
        'RJ' => [
            '11:00' => [
                'lottery' => 'PTM-RIO',
                'time' => 11.2
            ],
            '14:20' => [
                'lottery' => 'PT-RIO',
                'time' => 14.2
            ],
            '16:00' => [
                'lottery' => 'PTV-RIO',
                'time' => 16.2
            ],
            '18:20' => [
                'lottery' => 'PTN-RIO',
                'time' => 18.2
            ],
            '21:20' => [
                'lottery' => 'CORUJA-RIO',
                'time' => 21.2
            ],
        ],
        'SP' => [
            '10hs' => [
                'lottery' => 'PT-SP',
                'time' => 10
            ],
            '13hs' => [
                'lottery' => 'PT-SP',
                'time' => 13
            ],
            '15:30' => [
                'lottery' => 'BANDEIRANTES',
                'time' => 16
            ],
            '20hs' => [
                'lottery' => 'PTN-SP',
                'time' => 20
            ],
        ],
        'GO' => [
            '11h' => [
                'lottery' => 'LOOK',
                'time' => 11.2
            ],
            '14h' => [
                'lottery' => 'LOOK',
                'time' => 14.2
            ],
            '16h' => [
                'lottery' => 'LOOK',
                'time' => 16.2
            ],
            '18h' => [
                'lottery' => 'LOOK',
                'time' => 18.2
            ],
            '21h' => [
                'lottery' => 'LOOK',
                'time' => 21.2
            ],
        ],
        'MG' => [
            '12h' => [
                'lottery' => 'ALVORADA',
                'time' => 12
            ],
            '15h' => [
                'lottery' => 'MINAS-DIA',
                'time' => 15
            ],
        ],
        'BA' => [
            '10h' => [
                'lottery' => 'BA',
                'time' => 10
            ],
            '12h' => [
                'lottery' => 'BA',
                'time' => 12
            ],
            '15h' => [
                'lottery' => 'BA',
                'time' => 15
            ],
            '21h' => [
                'lottery' => 'BA',
                'time' => 21
            ],
        ],
        'PB' => [
            '10:45' => [
                'lottery' => 'LOTEP',
                'time' => 10.45
            ],
            '12:45' => [
                'lottery' => 'LOTEP',
                'time' => 12.45
            ],
            '15:45h' => [
                'lottery' => 'LOTEP',
                'time' => 15.45
            ],
            '18h' => [
                'lottery' => 'LOTEP',
                'time' => 18
            ],
        ],
        'DF' => [
            '10h' => [
                'lottery' => 'LBR',
                'time' => 10
            ],
            '12H' => [
                'lottery' => 'LBR',
                'time' => 12.4
            ],
            '15:00' => [
                'lottery' => 'LBR',
                'time' => 15
            ],
            '17:00' => [
                'lottery' => 'LBR',
                'time' => 17
            ],
            '19:00' => [
                'lottery' => 'LBR',
                'time' => 19
            ],
        ],
        'CE' => [
            '11:00' => [
                'lottery' => 'LOTECE',
                'time' => 11
            ],
            '14:00' => [
                'lottery' => 'LOTECE',
                'time' => 14
            ],
            '19:00' => [
                'lottery' => 'LOTECE',
                'time' => 19
            ],
        ],
    ];

    private static function getParams($content, $state, $federal) {
        if ($federal) {
            return [
                'state' => 'PO',
                'lottery' => 'FEDERAL',
                'time' => 19,
            ];
        }

        $response = [
            'state' => $state,
        ];

        if (in_array($state, ['RJ', 'GO', 'MG'])) {
            $check = trim($content[1]);
            if (isset(static::$lotteries[$state][$check])) {
                $getLottery = static::$lotteries[$state][$check];
                $response['lottery'] = $getLottery['lottery'];
                $response['time'] = $getLottery['time'];
            }
        }

        if (in_array($state, ['SP'])) {
            $check = explode('-', $content[1]);
            if (sizeof($check) < 2) return false;
            
            $check = trim($check[0]);
            if (isset(static::$lotteries[$state][$check])) {
                $getLottery = static::$lotteries[$state][$check];
                $response['lottery'] = $getLottery['lottery'];
                $response['time'] = $getLottery['time'];
            }
        }

        if (in_array($state, ['BA'])) {
            $check = explode('Bicho ', $content[0]);
            if (sizeof($check) < 2) return false;
            
            $check = trim(substr($check[1], 0, 3));
            if (isset(static::$lotteries[$state][$check])) {
                $getLottery = static::$lotteries[$state][$check];
                $response['lottery'] = $getLottery['lottery'];
                $response['time'] = $getLottery['time'];
            }
        }

        if (in_array($state, ['PB', 'DF'])) {
            $check = trim(substr($content[1], -7));
            if (isset(static::$lotteries[$state][$check])) {
                $getLottery = static::$lotteries[$state][$check];
                $response['lottery'] = $getLottery['lottery'];
                $response['time'] = $getLottery['time'];
            }
        }

        if (in_array($state, ['CE'])) {
            if (sizeof($content) < 2) return false;
            $check = trim(substr($content[1], 0, 6));
            if (isset(static::$lotteries[$state][$check])) {
                $getLottery = static::$lotteries[$state][$check];
                $response['lottery'] = $getLottery['lottery'];
                $response['time'] = $getLottery['time'];
            }
        }

        if (!isset($response['lottery']) || !isset($response['time'])) return false;
        return $response;
    }

    public static function parseResult($html, $state, $get_federal = false) {
        $dom = new DOMDocument();
        @$dom->loadHTML($html);
        $resultado = [];

        foreach ($dom->getElementsByTagName('h3') as $node) {
            if (str_contains($node->textContent, 'MALUCA')) return false;
            $content = explode(',', $node->textContent);
            $title = $node->textContent;
            $federal = str_contains($node->textContent, 'FEDERAL');
            if (!$get_federal && $federal) continue;
            if ($get_federal && !$federal) continue;
            $content = static::getParams($content, $state, $federal);
            if (!$content) continue;

            $resultado['state'] = $content['state'];
            $resultado['lottery'] = $content['lottery'];
            $resultado['time'] = $content['time'];
        }
        if (!isset($resultado['lottery']) || !isset($resultado['state']) || !isset($resultado['time'])) return false;

        $resultado['placement'] = [];
        if ($state === 'CE' && $resultado['state'] !== 'PO') {
            @$dom->loadHTML($dom->saveHTML($dom->getElementById('container-2')));
        }

        foreach ($dom->getElementsByTagName('tr') as $node) {
            $result = $node->childNodes->item(1)->textContent;
            if ($state === 'BA') $result = $node->childNodes->item(3)->textContent;
            if (intval($result) === 0) continue;
            $resultado['placement'][] = $result;
        }

        if (in_array($state, ['BA', 'CE', 'PB'])) {
            $resultado['placement'] = array_slice($resultado['placement'], 0, 7);
        }

        if (sizeof($resultado['placement']) !== 7) return false;
        $resultado['placement'] = array_slice($resultado['placement'], 0, 5);
        return $resultado;
    }

    private static function get_content($url){
        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Cookie: __goc_session__=tyjuxsczevmfesxsxiyogsdfhahtywli'
            ),
        ));
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }

    public static function getResults($state, $d, $m, $y) {
        $get_federal = $state === 'PO';
        if ($get_federal) $state = 'RJ';
        // $html = @static::get_content("http://resultados.x10.mx/resultado-do-jogo-do-bicho/$state.html");
        $html = @static::get_content("https://www.resultadofacil.com.br/resultado-do-jogo-do-bicho/$state/do-dia/$y-$m-$d");
        if (!$html) return [];
        $dom = new DOMDocument();
        @$dom->loadHTML($html);
        $content = [];

        if ($state === 'CE') {
            $container = $dom->getElementById('container-2');
            if (!$container) {
                $container = $dom->getElementById('container-1');
                if (!$container) return false;
            }

            foreach ($container->childNodes as $child) {
                $result = static::parseResult($dom->saveHTML($child), $state);
                if ($result === false) continue;
                $result['date'] = "$d/$m/$y";
                $content[] = $result;
            }
        } else {
            foreach ($dom->getElementsByTagName('div') as $node) {
                if ($node->getAttribute('class') === 'row collapse in') {
                    foreach ($node->childNodes as $child) {
                        $result = static::parseResult($dom->saveHTML($child), $state, $get_federal);
                        if ($result === false) continue;
                        $result['date'] = "$d/$m/$y";
                        $content[] = $result;
                    }
                }
            };
        }

        return json_decode(json_encode($content));
    }    
}