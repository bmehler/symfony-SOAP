<?php

namespace App\Service;

class HelperService {

    public function getNodes($lastResponse) {
        $dom = new \DOMDocument;
        $dom->loadXML($lastResponse);
        $nodes = [];
        foreach($dom->getElementsByTagName('item') as $item){
            foreach ($item->childNodes as $node)   {
                if (trim($node->textContent)) {
                    $nodes[] = $node->textContent;
                }
            }
        }

        $chunks = array_chunk($nodes, 7);

        return $chunks;
    }

    public function createHtmlTable($nodes) {
        $html = '<!DOCTYPE html><html><head></head><body><table border="1">';
        $html .= '<thead>
                    <tr>
                        <th>ID</th>
                        <th>Arznei</th>
                        <th>PZN</th>
                        <th>Darreichung</th>
                        <th>Firma</th>
                        <th>Einnahme</th>
                        <th>Preis</th>
                    </tr>
                </thead><tbody>';
        foreach($nodes as $val) {
            $html .= '<tr><td>' . $val[0] . '</td>';
            $html .= '<td>' . $val[1] . '</td>';
            $html .= '<td>' . $val[2] . '</td>';
            $html .= '<td>' . $val[3] . '</td>';
            $html .= '<td>' . $val[4] . '</td>';
            $html .= '<td>' . $val[5] . '</td>';
            $html .= '<td>' . $val[6] . '</td></tr>';
        }

        $html .='</tbody></table>';

        return $html;
    }

    public function setNamedKeys($nodes) {
        $i = 0;
        $a = array(
            'id',
            'name',
            'pzn',
            'darreichung',
            'marke',
            'details',
            'preis'
        );

        for($j=0;$j<2;$j++) {
            $newArr[] = array_combine($a, $nodes[$j]);
        }

        $toJson = json_encode($newArr, JSON_UNESCAPED_UNICODE);

        return $toJson;
    }

}