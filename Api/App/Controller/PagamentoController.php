<?php

namespace App\Controller;

use App\Model\PagamentoModel;
use App\Controller\Controller;

class PagamentoController extends Controller
{
    public static function index()
    {
        $model = new PagamentoModel();
        $model->getAllRows();

        parent::setResponseAsJSON($model);
    }

    public static function form()
    {
        $model = new PagamentoModel();

        if(isset($_GET['id']))
            $model = $model->getById( (int) $_GET['id']);
        
    }

    public static function save()
    {
        $pagamento = new PagamentoModel();

        $pagamento->id = $_POST['id'];                          
        $pagamento->qnt_parcelas = $_POST['qnt_parcelas'];     
        $pagamento->forma_pagamento = $_POST['forma_pagamento'];     
        $pagamento->id_venda = $_POST['id_venda'];          

        $pagamento->save();

        parent::setResponseAsJSON($pagamento);
    }

    public static function delete()
    {
        $model = new PagamentoModel();

        $model->delete( (int) $_GET['id']);

        parent::setResponseAsJSON($model);
    }
}