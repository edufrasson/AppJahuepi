<?php

namespace App\Controller;

use App\Controller\Controller;
use App\Model\MovimentacaoModel;
use App\Model\ParcelaModel;

class ParcelaController extends Controller
{
    public static function index()
    {
        $model = new ParcelaModel();
        $model->getAllRows();

        parent::setResponseAsJSON($model);
    }

    public static function getById()
    {
        $model = new ParcelaModel();

        parent::setResponseAsJSON($model->getById($_GET['id']));
    }

    public static function checkParcelas()
    {
        $model = new ParcelaModel();

        $arr_ids_parcela = $model->checkParcelas();

        foreach ($arr_ids_parcela as $id) {

            $model->confirmParcela($id->id_parcela);

            $parcela = $model->getById($id->id_parcela);

            $movimentacao = new MovimentacaoModel();
            $movimentacao->valor = $parcela->valor;
            $movimentacao->descricao = "Recebimento de Parcela";
            $movimentacao->data_movimentacao = $parcela->data_recebimento;
            $movimentacao->id_parcela = $parcela->id;
            $movimentacao->save();          
        }
    }

    public static function getByIdVenda()
    {
        $model = new ParcelaModel();

        parent::setResponseAsJSON($model->getByIdVenda($_GET['id']));
    }

    public static function confirmParcela()
    {
        $model = new ParcelaModel();

        $model->confirmParcela($_GET['id']);

        header('Location: /relatorio');
    }

    public static function save()
    {
        $parcela = new ParcelaModel();

        $parcela->id = $_POST['id'];
        $parcela->valor = $_POST['valor'];
        $parcela->data_parcela = $_POST['data_parcela'];
        $parcela->status = $_POST['status'];
        $parcela->id_pagamento = $_POST['id_pagamento'];

        $parcela->save();

        parent::setResponseAsJSON($parcela);
    }

    public static function delete()
    {
        $model = new ParcelaModel();

        $model->delete((int) $_GET['id']);

        parent::setResponseAsJSON($model);
    }
}
