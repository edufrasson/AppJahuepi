<?php

namespace App\Controller;

use App\Model\LoginModel;
use FFI\Exception;

class LoginController extends Controller{
    public static function form(){
        include 'View/modules/Login/Login.php';
    }
    public static function auth()
    {
        try{
            $model = new LoginModel(); 

            $user = $model->getByEmailAndSenha($_POST['email'], $_POST['senha']);
    
            if($user == false){
                self::logout();
                parent::setResponseAsJSON(false);       
            } 
            else{
                $_SESSION['user_logged'] = json_encode($user);
                parent::setResponseAsJSON(true);
            }            
        }catch(Exception $e){
            parent::getExceptionAsJSON($e);
        }
        
    }

    public static function logout(){
        unset($_SESSION['user_logged']);
        parent::isAuthenticated();
    }
}