<?php

namespace App\Controller;

use App\Model\MovimentacaoModel;
use App\Controller\Controller;
use App\Model\ProdutoModel;

class MovimentacaoController extends Controller
{
    public static function index()
    {
        parent::checkParcelas();
        parent::isAuthenticated();

        $model = new MovimentacaoModel();
        $model->getAllRows();

        include VIEWS . 'Movimentacao/ListarMovimentacao.php';
    }

    public static function getAll()
    {
        parent::isAuthenticated();

        $model = new MovimentacaoModel();
        $model->getAllRows();
       
        parent::setResponseAsJSON($model->rows);
    }

    public static function relatorio(){
        parent::isAuthenticated();

        $model = new MovimentacaoModel();
        

        if(isset($_GET['ano']) && !isset($_GET['mes'])){
            $model->getRelatorioByYear(($_GET['ano']));
            $ano = $_GET['ano'];
        }

        if(isset($_GET['ano']) && isset($_GET['mes'])){
            $model->getRelatorioByYearAndMonth($_GET['mes'], $_GET['ano']);
            $ano = $_GET['ano'];
            $mes = $_GET['mes'];
        }

        if(!isset($_GET['ano']) && !isset($_GET['mes'])){
            $model->getRelatorio();
        }
        
        

        include VIEWS . 'Movimentacao/RelatorioMovimentacao.php';
    }

    public static function faturamentoMes(){
        $model = new MovimentacaoModel();      
       
        parent::setResponseAsJSON($model->getFaturamentoMes());
    }

    public static function getById()
    {
        parent::isAuthenticated();

        $model = new MovimentacaoModel();

        parent::setResponseAsJSON($model->getById($_GET['id']));
    }

    public static function save()
    {
        $movimentacao = new MovimentacaoModel();
        parent::isAuthenticated();

        $Movimentacao = new MovimentacaoModel();

        $movimentacao->id = $_POST['id'];
        ($_POST['tipo'] == "ENTRADA") ? $movimentacao->valor = $_POST['valor'] :  $movimentacao->valor = -$_POST['valor'];
        $movimentacao->descricao = $_POST['descricao'];
        $movimentacao->data_movimentacao = $_POST['data_movimentacao'];

        $movimentacao->save();

        header("Location: /movimentacao");
    }

    public static function edit(){
        $model = new MovimentacaoModel();
        $dados = $model->getById($_GET['id']);

        include VIEWS . 'Movimentacao/EditarMovimentacao.php';
    }

    public static function delete()
    {
        parent::isAuthenticated();

        $model = new MovimentacaoModel();

        $model->delete( (int) $_GET['id']);

        parent::setResponseAsJSON($model);
    }
}