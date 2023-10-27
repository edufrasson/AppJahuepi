<?php

namespace App\Controller;

use App\Model\MovimentacaoModel;
use App\Controller\Controller;

class MovimentacaoController extends Controller
{
    public static function index()
    {
        parent::checkParcelas();

        $model = new MovimentacaoModel();
        $model->getAllRows();

        include 'View/modules/Movimentacao/ListarMovimentacao.php';
    }

    public static function getAll(){
        $model = new MovimentacaoModel();
        $model->getAllRows();
       
        parent::setResponseAsJSON($model->rows);
    }

    public static function getById()
    {
        $model = new MovimentacaoModel();

        parent::setResponseAsJSON($model->getById($_GET['id']));
    }

    public static function save()
    {
        $movimentacao = new MovimentacaoModel();

        $movimentacao->id = $_POST['id'];
        ($_POST['tipo'] == "ENTRADA") ? $movimentacao->valor = $_POST['valor'] :  $movimentacao->valor = -$_POST['valor'];
        $movimentacao->descricao = $_POST['descricao'];
        $movimentacao->data_movimentacao = $_POST['data_movimentacao'];

        $movimentacao->save();

        header("Location: /movimentacao");
    }

    public static function delete()
    {
        $model = new MovimentacaoModel();

        $model->delete( (int) $_GET['id']);

        parent::setResponseAsJSON($model);
    }
}