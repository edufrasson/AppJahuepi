<?php

namespace App\Controller;

use App\Model\ProdutoVendaModel;
use App\Controller\Controller;

class ProdutoVendaController extends Controller
{
    public static function index()
    {
        $model = new ProdutoVendaModel();
        $model->getAllRows();

        parent::setResponseAsJSON($model);
    }

    public static function getById()
    {
        $model = new ProdutoVendaModel();

        parent::setResponseAsJSON($model->getById($_GET['id']));
    }

    public static function save()
    { 
        $arr_produtos = json_decode($_POST['lista_produtos']);
        $model = new ProdutoVendaModel();
        $model->id_venda = $_POST['id_venda'];     
        $model->lista_produtos = $arr_produtos;
        $res = $model->save();      

        parent::setResponseAsJSON($res);
    }

    public static function delete()
    {
        $model = new ProdutoVendaModel();

        $model->delete( (int) $_GET['id']);

        parent::setResponseAsJSON($model);
    }
}