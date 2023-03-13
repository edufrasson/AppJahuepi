<?php

namespace App\Controller;

use App\Model\CategoriaProdutoModel;
use App\Controller\Controller;

class CategoriaProdutoController extends Controller
{
    public static function index()
    {
        $model = new CategoriaProdutoModel();
        $model->getAllRows();

        parent::setResponseAsJSON($model);
    }

    public static function form()
    {
        $model = new CategoriaProdutoModel();

        if(isset($_GET['id']))
            $model = $model->getById( (int) $_GET['id']);
        
        //parent::render('categoria_produto/Formcategoria_produto', $model);
    }

    public static function save()
    {
        $categoria_produto = new CategoriaProdutoModel();

        $categoria_produto->id = $_POST['id'];
        $categoria_produto->descricao = $_POST['descricao'];

        $categoria_produto->save();

        parent::setResponseAsJSON($categoria_produto);
    }

    public static function delete()
    {
        $model = new CategoriaProdutoModel();

        $model->delete( (int) $_GET['id']);

        parent::setResponseAsJSON($model);
    }
}