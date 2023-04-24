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

        include 'View/modules/Extrato/ListarExtrato.php';
    }

    public static function getAll(){
        $model = new ExtratoModel();
        $model->getAllRows();
       
        parent::setResponseAsJSON($model->rows);
    }

    public static function getById()
    {
        $model = new ExtratoModel();

        parent::setResponseAsJSON($model->getById($_GET['id']));
    }

    public static function save()
    {
        $extrato = new ExtratoModel();

        $extrato->id = $_POST['id'];
        $extrato->valor = $_POST['valor'];
        $extrato->dataExtrato = $_POST['data_extrato'];

        $extrato->save();

        header("Location: /extrato");
    }

    public static function delete()
    {
        $model = new ExtratoModel();

        $model->delete( (int) $_GET['id']);

        parent::setResponseAsJSON($model);
    }
}