<?php

namespace App\Controller;

use App\Model\CategoriaProdutoModel;
use App\Controller\Controller;

class CategoriaProdutoController extends Controller
{
    public static function index()
    {
        parent::isAuthenticated();

        $model = new CategoriaProdutoModel();
        $model->getAllRows();

        include 'View/modules/CategoriaProduto/ListarCategoria.php';
    }

    public static function getAll()
    {

        parent::isAuthenticated();

        $model = new CategoriaProdutoModel();
        $model->getAllRows();
       
        parent::setResponseAsJSON($model->rows);
    }

    public static function getById()
    {
        parent::isAuthenticated();

        $model = new CategoriaProdutoModel();

        parent::setResponseAsJSON($model->getById($_GET['id']));
    }


    public static function save()
    {
        parent::isAuthenticated();

        $categoria_produto = new CategoriaProdutoModel();

        $categoria_produto->id = $_POST['id'];
        $categoria_produto->descricao = $_POST['descricao'];

        $categoria_produto->save();

        header("Location: /categoria_produto");
    }

    public static function delete()
    {
        parent::isAuthenticated();

        $model = new CategoriaProdutoModel();

        $model->delete( (int) $_GET['id']);

        parent::setResponseAsJSON($model);
    }
}