<?php

namespace App\Controller;

use App\DAO\LoginDAO;
use App\Model\LoginModel;
use FFI\Exception;

require_once('src/PHPMailer.php');
require_once('src/SMTP.php');
require_once('src/Exception.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception as PHPMailerException;

require 'vendor/autoload.php';

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

    public static function esqueciSenha()
    {
        include 'View/modules/Login/EsqueciSenha.php';
    }

    public static function enviarNovaSenha()
    {
        try {
            $nova_senha = uniqid();
            $email = $_POST['email'];

            $login_dao = new LoginDAO();
            $login_dao->setNewPassword($email, $nova_senha);

            $assunto = "Nova Senha do Sistema";
            $mensagem = "Sua nova senha é: " . $nova_senha;

            // Inicialize o objeto PHPMailer
            $mail = new PHPMailer();

            // Configuração do servidor SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Substitua pelo seu servidor SMTP
            $mail->SMTPAuth = true;
            $mail->Username = 'email@gmail.com'; // Substitua pelo seu e-mail
            $mail->Password = 'password'; // Substitua pela sua senha
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Use ENCRYPTION_SMTPS para SMTP seguro
            $mail->Port = 587; // Porta SMTP, 587 é comum para STARTTLS, 465 para SMTPS

            // Remetente e destinatário
            $mail->setFrom('email@gmail.com', 'teste'); // Endereço do remetente
            $mail->addAddress($email); // Destinatário
            $mail->Subject = $assunto;
            $mail->Body = $mensagem;

            // Envie o e-mail
            if ($mail->send()) {
                $retorno = "Um email foi enviado contendo sua nova senha.";
            } else {
                throw new Exception("Desculpe, ocorreu um erro ao enviar o email, tente novamente mais tarde.");
            }
        } catch (Exception $e) {
            var_dump($mail);
            $retorno = $e->getMessage();
        }

        include 'View/modules/Login/EsqueciSenha.php';
    }
}
