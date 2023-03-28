<?php

namespace App\Controller;
use App\Repository\MedicalsRepository;
use App\Service\HelperService;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SoapMedicalController extends AbstractController
{
    #[Route('/soap/medical', name: 'app_soap_medical')]
    public function index(MedicalsRepository $medicalsRepository): Response
    {
        $url = $this->getParameter('app.url');
        $soap_server_config = array(
            'uri' => $url . 'soap/medical',
        );
        $soap_server = new \SoapServer(null, $soap_server_config);
        $soap_server->setObject($medicalsRepository);
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml; charset=ISO-8859-1');
        ob_start();
        $soap_server->handle();
        $response->setContent(ob_get_clean());
        return $response;
    }

    #[Route('/soap/medical/client/html', name: 'app_soap_html_client')]
    public function soap_html_client(HelperService $helperservice): Response {
        $url = $this->getParameter('app.url');
        $soap_client_config = array(
            'encoding'      => 'UTF-8',
            'soap_version'  =>  SOAP_1_2, 
            'location'      =>  $url . 'soap/medical',
            'uri'           => 'http://test-uri/',
            'cache_wsdl'    =>  0,
            'trace' => 1,
            'exceptions' => true,
            'keep_alive' => false,
            'connection_timeout' => 500000, 
        );
        try {
            $soap_client = new \SoapClient($url .'medical.wsdl', $soap_client_config);
            $soap_result_all = $soap_client->getAllMedicals();
            $response = $soap_client->__getLastResponse();
            
            $nodes = $helperservice->getNodes($response);
            $html = $helperservice->createHtmlTable($nodes);
            
            return new Response($html);
        } catch(\SoapFault $e) {
            return var_dump($e);
        }
    }

     #[Route('/soap/medical/client/json', name: 'app_soap_json_client')]
    public function soap_json_client(HelperService $helperservice): Response {
        $url = $this->getParameter('app.url');
        $soap_client_config = array(
            'encoding'      => 'UTF-8',
            'soap_version'  =>  SOAP_1_2, 
            'location'      =>  $url .'soap/medical',
            'uri'           => 'http://test-uri/',
            'cache_wsdl'    =>  0,
            'trace' => 1,
            'exceptions' => true,
            'keep_alive' => false,
            'connection_timeout' => 500000, 
        );
        try {
            $soap_client = new \SoapClient($url . 'medical.wsdl', $soap_client_config);
            $soap_result_all = $soap_client->getAllMedicals();
            $response = $soap_client->__getLastResponse();

            $nodes = $helperservice->getNodes($response);
            $json = $helperservice->setNamedKeys($nodes);

            return new Response($json);
            
        } catch(\SoapFault $e) {
            return var_dump($e);
        }
    }
}