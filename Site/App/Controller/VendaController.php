<?php

namespace App\Controller;

use App\Model\VendaModel;
use App\Controller\Controller;

class VendaController extends Controller
{
    public static function index()
    {
        $model = new VendaModel();
        $model->getAllRows();

        parent::setResponseAsJSON($model);
    }

    public static function getById()
    {
        $model = new VendaModel();

        parent::setResponseAsJSON($model->getById($_GET['id']));
    }

    public static function save()
    {
        $venda = new VendaModel();

        $venda->id = $_POST['id'];     
        $venda->data_venda = $_POST['data_venda'];

        $venda->save();

        parent::setResponseAsJSON($venda);
    }

    public static function delete()
    {
        $model = new VendaModel();

        $model->delete( (int) $_GET['id']);

        parent::setResponseAsJSON($model);
    }
}