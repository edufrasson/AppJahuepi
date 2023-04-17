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
        $produto_venda = new ProdutoVendaModel();

        $produto_venda->id = $_POST['id'];                          
        $produto_venda->quantidade = $_POST['quantidade'];     
        $produto_venda->id_produto = $_POST['id_produto'];     
        $produto_venda->id_venda = $_POST['id_venda'];          

        $produto_venda->save();

        parent::setResponseAsJSON($produto_venda);
    }

    public static function delete()
    {
        $model = new ProdutoVendaModel();

        $model->delete( (int) $_GET['id']);

        parent::setResponseAsJSON($model);
    }
}