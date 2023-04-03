<?php

namespace App\Controller;

use App\Model\ExtratoModel;
use App\Controller\Controller;

class ExtratoController extends Controller
{
    public static function index()
    {
        $model = new ExtratoModel();
        $model->getAllRows();

        parent::setResponseAsJSON($model);
    }

    public static function form()
    {
        $model = new ExtratoModel();

        if(isset($_GET['id']))
            $model = $model->getById( (int) $_GET['id']);

        //parent::render('Extrato/FormExtrato', $model);
    }

    public static function save()
    {
        $extrato = new ExtratoModel();

        $extrato->id = $_POST['id'];
        $extrato->valor = $_POST['valor'];
        $extrato->data_extrato = $_POST['data_extrato'];

        $extrato->save();

        parent::setResponseAsJSON($extrato);
    }

    public static function delete()
    {
        $model = new ExtratoModel();

        $model->delete( (int) $_GET['id']);

        parent::setResponseAsJSON($model);
    }
}