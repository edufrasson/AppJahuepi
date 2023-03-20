<?php

namespace App\Controller;

use App\Controller\Controller;
use App\Model\ParcelaModel;

class ParcelaController extends Controller
{
    public static function index()
    {
        $model = new ParcelaModel();
        $model->getAllRows();

        parent::setResponseAsJSON($model);
    }

    public static function form()
    {
        $model = new ParcelaModel();

        if(isset($_GET['id']))
            $model = $model->getById( (int) $_GET['id']);
        
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

        $model->delete( (int) $_GET['id']);

        parent::setResponseAsJSON($model);
    }
}