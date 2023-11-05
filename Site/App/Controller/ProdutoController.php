<?php

namespace App\Controller;

use App\Model\ProdutoModel;
use App\Controller\Controller;

class ProdutoController extends Controller
{
    public static function getList()
    {
        //parent::isAuthenticated();

        $model = new ProdutoModel();
        $data = $model->getAllRows();

        parent::setResponseAsJSON($data);
    }

    public static function getMaisVendido(){
        $model = new ProdutoModel();

        parent::setResponseAsJSON($model->getMostSaledProduct());
    }

    public static function index()
    {
        //parent::isAuthenticated();

        $model = new ProdutoModel();
        $model->getAllRows();
        $model->getAllCategoria();

        include 'View/modules/Produto/ListarProduto.php';
    }

    public static function getById()
    {
        //parent::isAuthenticated();

        $model = new ProdutoModel();

        parent::setResponseAsJSON($model->getById($_GET['id']));
    }

    public static function save()
    {
        //parent::isAuthenticated();

        $produto = new ProdutoModel();

        $produto->id = $_POST['id'];                          
        $produto->descricao = $_POST['descricao'];     
        $produto->preco = $_POST['preco'];                
        $produto->codigo_barra = $_POST['codigo_barra']; 
        $produto->id_categoria = $_POST['id_categoria'];         

        $produto->save();

       header("Location: /produto");
    }

    public static function edit(){
        $model = new ProdutoModel();
        $dados = $model->getById($_GET['id']);
        $model->getAllCategoria();

        include 'View/modules/Produto/EditarProduto.php';
    }

    public static function delete()
    {
        //parent::isAuthenticated();

        $model = new ProdutoModel();

        $model->delete( (int) $_GET['id']);

        parent::setResponseAsJSON($model);
    }
}