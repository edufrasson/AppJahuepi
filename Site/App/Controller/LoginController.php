<?php

namespace App\Controller;

use App\Model\LoginModel;
use FFI\Exception;

class LoginController extends Controller
{
    public static function form()
    {
        $loginFailed = false;
        if (isset($_GET['erro'])) {
            if ($_GET['erro'] == true) {
                $loginFailed = true;
            }
        }

        include 'View/modules/Login/Login.php';
    }
    public static function auth()
    {
        try {
            $model = new LoginModel();
            $user = $model->getByEmailAndSenha($_POST['email'], $_POST['senha']);
            if ($user == false) {                
                parent::loginFailed();
                
            } else {
                $_SESSION['user_logged'] = json_encode($user);                
                header('Location: /home');
            }
        } catch (Exception $e) {
            parent::getExceptionAsJSON($e);
        }
    }

    public static function logout()
    {
        unset($_SESSION['user_logged']);
        parent::isAuthenticated();
    }

    public static function index()
    {
        $model = new LoginModel();
        $model->getAllRows();

        include 'View/modules/Login/ListarUsuarios.php';
    }

    public static function getAll()
    {
        $model = new LoginModel();
        $model->getAllRows();

        parent::setResponseAsJSON($model->rows);
    }

    public static function getById()
    {
        $model = new LoginModel();

        parent::setResponseAsJSON($model->getById($_GET['id']));
    }

    public static function save()
    {
        $usuario = new LoginModel();

        $usuario->id = $_POST['id'];
        $usuario->email = $_POST['email'];
        $usuario->senha = $_POST['senha'];

        $usuario->save();

        parent::setResponseAsJSON($usuario);
    }

    public static function delete()
    {
        $model = new LoginModel();

        $model->delete((int) $_GET['id']);

        parent::setResponseAsJSON($model);
    }
}
