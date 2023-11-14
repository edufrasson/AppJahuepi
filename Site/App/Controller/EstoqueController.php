<?php

namespace App\Controller;

use App\Model\EstoqueModel;
use App\Controller\Controller;
use App\Model\MovimentacaoModel;
use App\Model\ProdutoModel;

class EstoqueController extends Controller
{
    public static function getList()
    {
        parent::isAuthenticated();

        $model = new EstoqueModel();
        $data = $model->getAllRows();

        parent::setResponseAsJSON($data);
    }
 

    public static function index()
    {
        parent::isAuthenticated();

        $model = new EstoqueModel();
        $model->getAllRows();
        $model->getAllProduto();

        include VIEWS . 'Estoque/ListarEstoque.php';
    }

    public static function getById()
    {
        //parent::isAuthenticated();

        $model = new EstoqueModel();

        parent::setResponseAsJSON($model->getById($_GET['id']));
    }

    public static function save()
    {
        //parent::isAuthenticated();

        $estoque = new EstoqueModel();

        $estoque->id = $_POST['id'];                          
        (isset($_POST['id_venda'])) ? $estoque->id_venda = $_POST['id_venda'] : '';      
        $estoque->id_produto = $_POST['id_produto'];     
        $estoque->situacao = $_POST['situacao'];     
        $estoque->data_registro = $_POST['data_registro'];     
        $estoque->quantidade = $_POST['quantidade'];         
        $dados = $estoque->save();

        if($_POST['situacao'] == 'COMPRA' && $dados != null){
            $produto = new ProdutoModel();
            $produto = $produto->getById($_POST['id_produto']);

            $movimentacao = new MovimentacaoModel();            
            $movimentacao->valor = -$_POST['valor_compra'];
            $movimentacao->descricao = "Gasto com Estoque - " . $produto->descricao;
            $movimentacao->data_movimentacao = $_POST['data_registro'];
            $movimentacao->save();
        }  

       header("Location: /estoque");
    }

    public static function edit(){
        $model = new EstoqueModel();
        $dados = $model->getById($_GET['id']);
        $model->getAllProduto();

        include VIEWS . 'Estoque/EditarEstoque.php';
    }

    public static function delete()
    {
        //parent::isAuthenticated();

        $model = new EstoqueModel();

        $model->delete( (int) $_GET['id']);

        parent::setResponseAsJSON($model);
    }
}