<?php

namespace App\Controller;

use App\Model\ProdutoModel;
use App\Controller\Controller;

class ProdutoController extends Controller
{
    public static function index()
    {
        $model = new ProdutoModel();
        $model->getAllRows();

        parent::setResponseAsJSON($model);
    }

    public static function form()
    {
        $model = new ProdutoModel();

        if(isset($_GET['id']))
            $model = $model->getById( (int) $_GET['id']);
        
    }

    public static function save()
    {
        $produto = new ProdutoModel();

        $produto->id = $_POST['id'];                          
        $produto->descricao = $_POST['descricao'];     
        $produto->preco = $_POST['preco'];     
        $produto->codigo_barra = $_POST['validade']; 
        $produto->id_categoria = $_POST['id_categoria'];         

        $produto->save();

        parent::setResponseAsJSON($produto);
    }

    public static function delete()
    {
        $model = new ProdutoModel();

        $model->delete( (int) $_GET['id']);

        parent::setResponseAsJSON($model);
    }
}