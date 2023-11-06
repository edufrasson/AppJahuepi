<?php

namespace App\Controller;

use App\Model\ProdutoVendaModel;
use App\Controller\Controller;

class ProdutoVendaController extends Controller
{
    public static function index()
    {
       parent::isAuthenticated();

        $model = new ProdutoVendaModel();
        $model->getAllRows();

        parent::setResponseAsJSON($model);
    }

    public static function getProdutos()
    {
       parent::isAuthenticated();

        $model = new ProdutoVendaModel(); 

        parent::setResponseAsJSON($model->getProdutos($_GET['id']));
    }

    public static function getById()
    {
       parent::isAuthenticated();
        
        $model = new ProdutoVendaModel();

        parent::setResponseAsJSON($model->getById($_GET['id']));
    }

    public static function save()
    { 
       parent::isAuthenticated();

        $arr_produtos = json_decode($_POST['lista_produtos']);
        $model = new ProdutoVendaModel();
        $model->id_venda = $_POST['id_venda'];     
        $model->lista_produtos = $arr_produtos;
        $res = $model->save();      

        parent::setResponseAsJSON($res);
    }

    public static function baixaEstoque()
    {
       parent::isAuthenticated();

        $model = new ProdutoVendaModel();       
        
        parent::setResponseAsJSON($model->baixaEstoque($model->getById($_POST['id_venda'])));
    }

    public static function delete()
    {
       parent::isAuthenticated();

        $model = new ProdutoVendaModel();

        $model->delete( (int) $_GET['id']);

        parent::setResponseAsJSON($model);
    }
}