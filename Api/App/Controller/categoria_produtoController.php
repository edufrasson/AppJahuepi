<?php

namespace App\Controller;

use App\Model\categoria_produtoModel;
use App\Controller\Controller;

class categoria_produtoControler extends Controller
{
    public static function index()
    {
        $model = new categoria_produtoModel();
        $model->getAllRows();

        parent::setResponseAsJSON($model);
    }

    public static function form()
    {
        $model = new categoria_produtoModel();

        if(isset($_GET['id']))
            $model = $model->getById( (int) $_GET['id']);
        
        //parent::render('categoria_produto/Formcategoria_produto', $model);
    }

    public static function save()
    {
        $categoria_produto = new categoria_produtoModel();

        $categoria_produto->id = $_POST['id'];
        $categoria_produto->descricao = $_POST['categoria_produto'];

        $categoria_produto->save();

        parent::setResponseAsJSON($categoria_produto);
    }

    public static function delete()
    {
        $model = new categoria_produtoModel();

        $model->delete( (int) $_GET['id']);

        parent::setResponseAsJSON($model);
    }
}