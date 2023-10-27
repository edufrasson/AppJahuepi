<?php

namespace App\Controller;

use App\Model\MovimentacaoModel;
use App\Controller\Controller;

class MovimentacaoController extends Controller
{
    public static function index()
    {
        //parent::isAuthenticated();

        $model = new MovimentacaoModel();
        $model->getAllRows();

        include 'View/modules/Movimentacao/ListarMovimentacao.php';
    }

    public static function getAll()
    {
        //parent::isAuthenticated();

        $model = new MovimentacaoModel();
        $model->getAllRows();
       
        parent::setResponseAsJSON($model->rows);
    }

    public static function getById()
    {
        //parent::isAuthenticated();

        $model = new MovimentacaoModel();

        parent::setResponseAsJSON($model->getById($_GET['id']));
    }

    public static function save()
    {
        //parent::isAuthenticated();

        $Movimentacao = new MovimentacaoModel();

        $Movimentacao->id = $_POST['id'];
        $Movimentacao->valor = $_POST['valor'];
        $Movimentacao->dataMovimentacao = $_POST['dataMovimentacao'];

        $Movimentacao->save();

        header("Location: /movimentacao");
    }

    public static function delete()
    {
        //parent::isAuthenticated();

        $model = new MovimentacaoModel();

        $model->delete( (int) $_GET['id']);

        parent::setResponseAsJSON($model);
    }
}