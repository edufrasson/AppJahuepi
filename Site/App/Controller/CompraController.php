<?php

namespace App\Controller;

use App\Model\CompraModel;
use App\Controller\Controller;
use App\Model\ParcelaModel;
use App\Model\ProdutoModel;
use App\Model\ProdutoVendaModel;
use DateTime;

class CompraController extends Controller
{
    public static function index()
    {
        //parent::isAuthenticated();

        $model = new CompraModel();
        $model->getAllRows();

        parent::setResponseAsJSON($model);
    }

    public static function getById()
    {
        //parent::isAuthenticated();

        $model = new CompraModel();

        parent::setResponseAsJSON($model->getById($_GET['id']));
    }

    public static function save()
    {
        //parent::isAuthenticated();

        $compra = new CompraModel();
        $compra->id = $_POST['id'];
        $compra->qnt_parcela = $_POST['qnt_parcela'];
        $compra->valor_compra = $_POST['valor_compra'];
        $compra->data_compra = $_POST['data_compra'];        
        $compra->id_fornecedor = $_POST['id_fornecedor'];       

        $compra->save();
        
        header("Location: /compra");
    }

    public static function update()
    {
    }

    public static function delete()
    {
        //parent::isAuthenticated();

        $model = new CompraModel();

        $model->delete((int) $_GET['id']);

        parent::setResponseAsJSON($model);
    }
}
