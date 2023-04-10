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

        include 'View/modules/Produto/ListarProduto.php';
    }

    public static function save()
    {
        $produto = new ProdutoModel();

        $produto->id = $_POST['id'];                          
        $produto->descricao = $_POST['descricao'];     
        $produto->preco = $_POST['preco'];     
        $produto->codigo_barra = $_POST['codigo_barra']; 
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