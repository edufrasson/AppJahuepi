<?php

namespace App\Controller;

use App\Model\ProdutoModel;
use App\Controller\Controller;

class ProdutoController extends Controller
{
    public static function getList()
    {
        parent::isAuthenticated();

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
        parent::isAuthenticated();

        $model = new ProdutoModel();
        $model->getAllRows();
        $model->getAllCategoria();

        include VIEWS . 'Produto/ListarProduto.php';
    }

    public static function getById()
    {
        parent::isAuthenticated();

        $model = new ProdutoModel();

        parent::setResponseAsJSON($model->getById($_GET['id']));
    }
    
    public static function getByCodigo()
    {
        parent::isAuthenticated();

        $model = new ProdutoModel();

        parent::setResponseAsJSON($model->getByCodigo($_GET['codigo']));
    }

    public static function getCountByCodigo()
    {
        parent::isAuthenticated();

        $model = new ProdutoModel();

        parent::setResponseAsJSON($model->getCountByCodigo($_GET['codigo']));
    }

    public static function save()
    {
        parent::isAuthenticated();

        $produto = new ProdutoModel();

        $produto->id = $_POST['id'];                          
        $produto->descricao = $_POST['descricao'];     
        $produto->preco = $_POST['preco'];                
        $produto->codigo_barra = $_POST['codigo_barra']; 
        $produto->id_categoria = $_POST['id_categoria'];         

        parent::setResponseAsJSON($produto->save());

       
    }

    public static function edit(){
        parent::isAuthenticated();

        $model = new ProdutoModel();
        $dados = $model->getById($_GET['id']);
        $model->getAllCategoria();

        include VIEWS . 'Produto/EditarProduto.php';
    }

    public static function delete()
    {
        parent::isAuthenticated();

        $model = new ProdutoModel();

        $model->delete( (int) $_GET['id']);

        parent::setResponseAsJSON($model);
    }
}