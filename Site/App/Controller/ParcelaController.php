<?php

namespace App\Controller;

use App\Controller\Controller;
use App\Model\ParcelaModel;

class ParcelaController extends Controller
{
    public static function index()
    {
        //parent::isAuthenticated();

        $model = new ParcelaModel();
        $model->getAllRows();

        parent::setResponseAsJSON($model);
    }

    public static function getById()
    {   
        //::isAuthenticated();
        
        $model = new ParcelaModel();

        parent::setResponseAsJSON($model->getById($_GET['id']));
    }

    public static function getByIdVenda()
    {
        //parent::isAuthenticated();

        $model = new ParcelaModel();

        parent::setResponseAsJSON($model->getByIdVenda($_GET['id']));
    }

    public static function confirmParcela()
    {
        //parent::isAuthenticated();

        $model = new ParcelaModel();

        $model->confirmParcela($_GET['id']);

        header('Location: /relatorio');
    }

    public static function save()
    {
        //parent::isAuthenticated();

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
        //parent::isAuthenticated();

        $model = new ParcelaModel();

        $model->delete( (int) $_GET['id']);

        parent::setResponseAsJSON($model);
    }
}