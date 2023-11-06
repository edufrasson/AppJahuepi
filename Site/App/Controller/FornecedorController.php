<?php

namespace App\Controller;

use App\Model\FornecedorModel;
use App\Controller\Controller;

class FornecedorController extends Controller
{
    public static function index()
    {
        parent::isAuthenticated();

        $model = new FornecedorModel();
        $model->getAllRows();

        include 'View/modules/Fornecedor/ListarFornecedor.php';
    }

    public static function getAll()
    {

        parent::isAuthenticated();

        $model = new FornecedorModel();
        $model->getAllRows();
       
        parent::setResponseAsJSON($model->rows);
    }

    public static function getById()
    {
        parent::isAuthenticated();

        $model = new FornecedorModel();

        parent::setResponseAsJSON($model->getById($_GET['id']));
    }


    public static function save()
    {
        parent::isAuthenticated();

        $fornecedor = new FornecedorModel();

        $fornecedor->id = $_POST['id'];
        $fornecedor->descricao = $_POST['descricao'];

        $fornecedor->save();

        header("Location: /fornecedor");
    }

    public static function delete()
    {
        parent::isAuthenticated();

        $model = new FornecedorModel();

        $model->delete( (int) $_GET['id']);

        parent::setResponseAsJSON($model);
    }
}