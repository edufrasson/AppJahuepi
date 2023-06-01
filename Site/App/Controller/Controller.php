<?php

namespace App\Controller;

use FFI\Exception;

abstract class Controller{
    
    protected static function loginFailed(){
        header('Location: /login?erro=true');
    }
    /* Verifica se o usuário está logado. */
    protected static function isAuthenticated(){
        if(!isset($_SESSION['user_logged']))
            header('Location: /login');
    }
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

     /* Retorna um valor como um objeto JSON*/
     protected static function getResponseAsJSON($data, $request_status = true)
     {
         header("Access-Control-Allow-Origin: *");  
         header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
         header('Access-Control-Allow-Headers: Origin, Content-Type, Accept');      
         header("Content-type: application/json; charset=utf-8");
         header("Cache-Control: no-cache, must-revalidate");
         header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
         header("Pragma: public");      
         
         exit(json_encode($data));
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

    protected static function getExceptionAsJSON(Exception $e)
    {
        $exception = [
            'message' => $e->getMessage(),
            'code' => $e->getCode(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'traceAsString' => $e->getTraceAsString(),
            'previous' => $e->getPrevious()
        ];

        http_response_code(400);

        header("Acess-Control-Allow-Origin: *");
        header("Content-type: application/json; charset=utf-8");
        header("Cache-Control: no-cache, must-revalidate");
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header("Pragma: public");

        exit(json_encode($exception));
    }

    protected static function isGet()
    {
        if($_SERVER['REQUEST_METHOD'] !== 'GET')
            throw new Exception("O método da requisição deve ser GET");
    }

    protected static function  isPost()
    {
        if($_SERVER['REQUEST_METHOD'] !== 'POST')
            throw new Exception("O método da requisição deve de POST");
    }

    protected static function getIntFromUrl($var_get, $var_name = null) : int
    {
        self::isGet();

        if(!empty($var_get))
            return (int) $var_get;
        else
            throw new Exception("Variável $var_name não identificada.");
    }

    protected static function getStringFromUrl($var_get, $var_name = null) : string
    {
        self::isGet();

        if(!empty($var_get))
            return (string) $var_get;
        else
            throw new Exception("Variável $var_name não identificada.");
    }
}