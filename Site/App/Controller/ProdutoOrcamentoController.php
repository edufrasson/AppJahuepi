<?php

namespace App\Controller;

use App\Model\ProdutoOrcamentoModel;
use App\Controller\Controller;

class ProdutoOrcamentoController extends Controller
{
    public static function index()
    {
       parent::isAuthenticated();

        $model = new ProdutoOrcamentoModel();
        $model->getAllRows();

        parent::setResponseAsJSON($model);
    }

    public static function getProdutos()
    {
       parent::isAuthenticated();

        $model = new ProdutoOrcamentoModel(); 

        parent::setResponseAsJSON($model->getProdutos($_GET['id']));
    }

    public static function getById()
    {
       parent::isAuthenticated();
        
        $model = new ProdutoOrcamentoModel();

        parent::setResponseAsJSON($model->getById($_GET['id']));
    }

    public static function save()
    { 
       parent::isAuthenticated();

        $arr_produtos = json_decode($_POST['lista_produtos']);
        $model = new ProdutoOrcamentoModel();
        $model->id_orcamento = $_POST['id_orcamento'];     
        $model->lista_produtos = $arr_produtos;
        $res = $model->save();      

        parent::setResponseAsJSON($res);
    }   

    public static function delete()
    {
       parent::isAuthenticated();

        $model = new ProdutoOrcamentoModel();

        $model->delete( (int) $_GET['id']);

        parent::setResponseAsJSON($model);
    }
}