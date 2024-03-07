<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

class ScrapingController extends Controller
{
    public function scrape()
    {
        $url = 'https://www.resultadosnahora.com.br/banca-ptm-rio/';

        $client = new Client();
        $response = $client->get($url);

        $html = $response->getBody()->getContents();

        $crawler = new Crawler($html);

        $targetTable = null;

        $crawler->filter('table')->each(function ($table) use (&$targetTable) {
            $tableContent = $table->html();
            if (strpos($tableContent, 'Resultado Jogo do Bicho 1° ao 7° (PTM-Rio)') !== false) {
                $targetTable = $tableContent;
                return false; // Para parar a iteração quando a tabela desejada for encontrada
            }
        });

        if ($targetTable) {
            // Use DOMDocument para organizar os dados da tabela
            $doc = new \DOMDocument();
            $doc->loadHTML($targetTable);

            $rows = $doc->getElementsByTagName('tr');

            $data = [];

            foreach ($rows as $row) {
                $cols = $row->getElementsByTagName('td');
                $rowData = [];
                foreach ($cols as $col) {
                    $rowData[] = $col->nodeValue;
                }
                $data[] = $rowData;
            }

            // Remova a primeira linha que contém cabeçalhos
            array_shift($data);

            return response()->json($data);
        } else {
            return response()->json(['error' => 'Tabela específica não encontrada'], 404);
        }
    }
}