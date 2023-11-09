<?php

namespace App\Controller;

use App\Model\VendaModel;
use App\Controller\Controller;
use App\Model\OrcamentoModel;
use App\Model\ProdutoModel;
use App\Model\ProdutoOrcamentoModel;

class VendaController extends Controller
{
    public static $carrinho_produtos = [];

    public static function index()
    {
        parent::isAuthenticated();
        parent::checkParcelas();

        $model = new VendaModel();
        
        $model->getAllProdutos();
        $model->getAllTaxas();

        if(isset($_GET['id_orcamento'])){
            $model_orcamento = new ProdutoOrcamentoModel();
            $dados = $model_orcamento->getProdutos($_GET['id_orcamento']);
        }

        include 'View/modules/Venda/NovaVenda.php';
    }

    public static function relatorio()
    {
        parent::isAuthenticated();
        parent::checkParcelas();

        $model = new VendaModel();
        $model->getAllRows();

        include 'View/modules/Venda/VerRelatorio.php';
    }    

    public static function getById()
    {
        parent::isAuthenticated();

        $model = new VendaModel();

        parent::setResponseAsJSON($model->getById($_GET['id']));
    }

    public static function save()
    {
        parent::isAuthenticated();

        $venda = new VendaModel();

        $venda->id = $_POST['id'];
        $venda->data_venda = $_POST['data_venda'];

        $model_retorno = $venda->save();

        parent::setResponseAsJSON($model_retorno);
    }

    public static function delete()
    {
        parent::isAuthenticated();

        $model = new VendaModel();

        $model->delete((int) $_GET['id']);

        parent::setResponseAsJSON($model);
    }

    public static function getProdutosOnTable()
    {
        parent::setResponseAsJSON(VendaController::$carrinho_produtos);
    }
}
