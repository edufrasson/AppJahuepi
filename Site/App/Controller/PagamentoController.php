<?php

namespace App\Controller;

use App\Model\PagamentoModel;
use App\Controller\Controller;
use App\Model\ParcelaModel;

class PagamentoController extends Controller
{
    public static function index()
    {
        $model = new PagamentoModel();
        $model->getAllRows();

        parent::setResponseAsJSON($model);
    }

    public static function getById()
    {
        $model = new PagamentoModel();

        parent::setResponseAsJSON($model->getById($_GET['id']));
    }

    public static function save()
    {
        $pagamento = new PagamentoModel();
        $parcela = new ParcelaModel();

        $pagamento->id = $_POST['id'];                          
        $pagamento->qnt_parcelas = $_POST['qnt_parcelas'];     
        $pagamento->forma_pagamento = $_POST['forma_pagamento'];     
        $pagamento->id_venda = $_POST['id_venda'];          

        $pagamento->save();

        for($i = 1; $i <= $pagamento->qnt_parcelas; $i++){
            $parcela->indice = $i;
            $parcela->valor = $_POST['valor_total'] / $pagamento->qnt_parcelas;
        }

        parent::setResponseAsJSON($pagamento);
    }

    public static function delete()
    {
        $model = new PagamentoModel();

        $model->delete( (int) $_GET['id']);

        parent::setResponseAsJSON($model);
    }
}