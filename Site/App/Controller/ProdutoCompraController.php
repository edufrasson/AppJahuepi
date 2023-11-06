<?php

namespace App\Controller;

use App\Model\ProdutoCompraModel;
use App\Controller\Controller;

class ProdutoCompraController extends Controller
{
    public static function index()
    {
       parent::isAuthenticated();

        $model = new ProdutoCompraModel();
        $model->getAllRows();

        parent::setResponseAsJSON($model);
    }

    public static function getProdutos()
    {
       parent::isAuthenticated();

        $model = new ProdutoCompraModel(); 

        parent::setResponseAsJSON($model->getProdutos($_GET['id']));
    }

    public static function getById()
    {
       parent::isAuthenticated();
        
        $model = new ProdutoCompraModel();

        parent::setResponseAsJSON($model->getById($_GET['id']));
    }

    public static function save()
    { 
       parent::isAuthenticated();

        $arr_produtos = json_decode($_POST['lista_produtos']);
        $model = new ProdutoCompraModel();
        $model->id_compra = $_POST['id_compra'];     
        $model->lista_produtos = $arr_produtos;
        $res = $model->save();      

        parent::setResponseAsJSON($res);
    }

    public static function baixaEstoque()
    {
       parent::isAuthenticated();

        $model = new ProdutoCompraModel();       
        
        parent::setResponseAsJSON($model->baixaEstoque($model->getById($_POST['id_compra'])));
    }

    public static function delete()
    {
       parent::isAuthenticated();

        $model = new ProdutoCompraModel();

        $model->delete( (int) $_GET['id']);

        parent::setResponseAsJSON($model);
    }
}