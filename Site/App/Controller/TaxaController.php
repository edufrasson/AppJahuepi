<?php

namespace App\Controller;

use App\Model\TaxaModel;
use App\Controller\Controller;

class TaxaController extends Controller
{
    public static function index()
    {
        //parent::isAuthenticated();

        $model = new TaxaModel();
        $model->getAllRows();

        include 'View/modules/Taxa/ListarTaxa.php';
    }

    public static function getAll()
    {
        //parent::isAuthenticated();

        $model = new TaxaModel();
        $model->getAllRows();
       
        parent::setResponseAsJSON($model->rows);
    }

    public static function getById()
    {
        //parent::isAuthenticated();

        $model = new TaxaModel();

        parent::setResponseAsJSON($model->getById($_GET['id']));
    }


    public static function save()
    {
        //parent::isAuthenticated();

        $taxa = new TaxaModel();

        $taxa->id = $_POST['id'];
        $taxa->codigo = $_POST['codigo'];
        $taxa->valor = $_POST['valor'] / 100;

        $taxa->save();

        header("Location: /taxa");
    }

    public static function delete()
    {
        //parent::isAuthenticated();

        $model = new TaxaModel();

        $model->delete( (int) $_GET['id']);

        parent::setResponseAsJSON($model);
    }
}