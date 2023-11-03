<?php

namespace App\Controller;

use App\Model\EstoqueModel;
use App\Controller\Controller;

class EstoqueController extends Controller
{
    public static function getList()
    {
        //parent::isAuthenticated();

        $model = new EstoqueModel();
        $data = $model->getAllRows();

        parent::setResponseAsJSON($data);
    }
 

    public static function index()
    {
        //parent::isAuthenticated();

        $model = new EstoqueModel();
        $model->getAllRows();
        $model->getAllProduto();

        include 'View/modules/Estoque/ListarEstoque.php';
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
        $estoque->id_venda = $_POST['id_venda'];     
        $estoque->id_produto = $_POST['id_produto'];     
        $estoque->situacao = $_POST['situacao'];     
        $estoque->quantidade = $_POST['quantidade'];    

        $estoque->save();

       header("Location: /estoque");
    }

    public static function edit(){
        $model = new EstoqueModel();
        $dados = $model->getById($_GET['id']);
        $model->getAllProduto();

        include 'View/modules/Estoque/EditarEstoque.php';
    }

    public static function delete()
    {
        //parent::isAuthenticated();

        $model = new EstoqueModel();

        $model->delete( (int) $_GET['id']);

        parent::setResponseAsJSON($model);
    }
}