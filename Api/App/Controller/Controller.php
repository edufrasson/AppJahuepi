<?php

namespace App\Controller;

abstract class Controller{
    /* Retorna um valor como um objeto JSON*/
    protected static function setResponseAsJSON($data, $request_status = true)
    {
        $response = array('response_data' => $data, 'response_successful' => $request_status);

        header("Access-Control-Allow-Origin: *");  
        header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, Content-Type, Accept');      
        header("Content-type: application/json; charset=utf-8");
        header("Cache-Control: no-cache, must-revalidate");
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header("Pragma: public");      
        
        exit(json_encode($response));
    }

    /* Retorna um objeto PHP de um Objeto JSON*/
    protected static function getRequestFromJSON(){
        header("Access-Control-Allow-Origin: *");  
        header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, Content-Type, Accept');      
        header("Content-type: application/json; charset=utf-8");
        header("Cache-Control: no-cache, must-revalidate");
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header("Pragma: public");      
        
        return json_decode(file_get_contents('php://input'));
    }
}