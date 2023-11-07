<?php

namespace App\Controller;

use App\DAO\LoginDAO;
use App\Model\LoginModel;
use FFI\Exception as FFIException;

require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception as PHPMailerException;

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
        } catch (FFIException $e) {
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

            // Inicializando o PHPMailer
            $mail = new PHPMailer();

            // Configurando o servidor SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'mateusgabrielmoreno321@gmail.com';
            $mail->Password = 'mateus555';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Remetente e destinatário
            $mail->setFrom('mateusgabrielmoreno321@gmail.com', 'Sistema JahuEPI');
            $mail->addAddress($email);
            $mail->Subject = $assunto;
            $mail->Body = $mensagem;

            // Enviando o e-mail
            if ($mail->send()) {
                $retorno = "Caso seu email esteja em nosso sistema, você acaba de receber um nova senha.";
            } else {
                $retorno = "Erro: " . $mail->ErrorInfo;
                throw new FFIException("Desculpe, ocorreu um erro ao enviar o email, tente novamente mais tarde.");
            }
        } catch (FFIException $e) {
            var_dump($retorno);
            $retorno = $e->getMessage();
        }

        include 'View/modules/Login/EsqueciSenha.php';
    }
}
