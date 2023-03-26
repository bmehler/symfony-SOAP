<?php

namespace App\Controller;
use App\Repository\MedicalsRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SoapMedicalController extends AbstractController
{
    #[Route('/soap/medical', name: 'app_soap_medical')]
    public function index(MedicalsRepository $medicalsRepository): Response
    {
        $soap_server_config = array(
            'uri' => 'http://soap-medical-app.local.com/soap/medical',
        );
        $soap_server = new \SoapServer(null, $soap_server_config);
        #$soap_server = new \SoapServer('http://soap-medical-app.local.com/medical.wsdl', $soap_server_config);
        $soap_server->setObject($medicalsRepository);
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml; charset=ISO-8859-1');
        ob_start();
        $soap_server->handle();
        $response->setContent(ob_get_clean());
        return $response;
    }

    #[Route('/soap/medical/client/html', name: 'app_soap_html_client')]
    public function soap_html_client(): Response {
        $soap_client_config = array(
            'encoding'      => 'UTF-8',
            'soap_version'  =>  SOAP_1_2, 
            'location'      => 'http://soap-medical-app.local.com/soap/medical',
            'uri'           => 'http://test-uri/',
            'cache_wsdl'    =>  0,
            'trace' => 1,
            'exceptions' => true,
            'keep_alive' => false,
            'connection_timeout' => 500000, 
        );
        try {
            #$soap_client = new \SoapClient(null, $soap_client_config);
            $soap_client = new \SoapClient('http://soap-medical-app.local.com/medical.wsdl', $soap_client_config);
            $soap_result_all = $soap_client->getAllMedicals();
            $response = $soap_client->__getLastResponse();
            
            # Parse SOAP Response to Array
            $dom = new \DOMDocument;
            $dom->loadXML($response);
            $arr = [];
            foreach($dom->getElementsByTagName('item') as $item){
                foreach ($item->childNodes as $node)   {
                    if (trim($node->textContent)) {
                        $arr[] = $node->textContent;
                    }
                }
            }
            
            # Divide Array to Chunks of Size 7
            $chunk = array_chunk($arr, 7);
            
            #echo '<pre>';
            #print_r(array_chunk($arr, 7));
            #echo '</pre>';

            # Create DataTable with SOAP Response
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
            foreach($chunk as $val) {
                $html .= '<tr><td>' . $val[0] . '</td>';
                $html .= '<td>' . $val[1] . '</td>';
                $html .= '<td>' . $val[2] . '</td>';
                $html .= '<td>' . $val[3] . '</td>';
                $html .= '<td>' . $val[4] . '</td>';
                $html .= '<td>' . $val[5] . '</td>';
                $html .= '<td>' . $val[6] . '</td></tr>';
            }

            $html .='</tbody></table>';
            return new Response($html);
        } catch(SoapFault $e) {
            return var_dump($e);
        }
    }

     #[Route('/soap/medical/client/json', name: 'app_soap_json_client')]
    public function soap_json_client(): Response {
        $soap_client_config = array(
            'encoding'      => 'UTF-8',
            'soap_version'  =>  SOAP_1_2, 
            'location'      => 'http://soap-medical-app.local.com/soap/medical',
            'uri'           => 'http://test-uri/',
            'cache_wsdl'    =>  0,
            'trace' => 1,
            'exceptions' => true,
            'keep_alive' => false,
            'connection_timeout' => 500000, 
        );
        try {
            #$soap_client = new \SoapClient(null, $soap_client_config);
            $soap_client = new \SoapClient('http://soap-medical-app.local.com/medical.wsdl', $soap_client_config);
            $soap_result_all = $soap_client->getAllMedicals();
            $response = $soap_client->__getLastResponse();
            
            # Parse SOAP Response to Array
            $dom = new \DOMDocument;
            $dom->loadXML($response);
            $arr = [];
            foreach($dom->getElementsByTagName('item') as $item){
                foreach ($item->childNodes as $node)   {
                    if (trim($node->textContent)) {
                        $arr[] = $node->textContent;
                    }
                }
            }
            
            # Divide Array to Chunks of Size 7
            $chunk = array_chunk($arr, 7);

            # Create Json Response
            $i = 0;
            $a = array('id','name','pzn','darreichung', 'marke', 'details', 'preis');
            for($j=0;$j<2;$j++) {
                $newArr[] = array_combine($a, $chunk[$j]);
            }

            $to_utf = json_encode($newArr, JSON_UNESCAPED_UNICODE);
            return new Response($to_utf);
        } catch(SoapFault $e) {
            return var_dump($e);
        }
    }
}
