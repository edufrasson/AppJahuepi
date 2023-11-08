<?php

namespace App\Controller;

use App\Model\CompraModel;
use App\Controller\Controller;
use App\Model\CobrancaModel;
use App\Model\ProdutoModel;
use App\Model\ProdutoCompraModel;
use DateTime;

class CompraController extends Controller
{
    public static function index()
    {
        parent::isAuthenticated();

        $model = new CompraModel();
        $model->getAllProdutos();
        $model->getAllFornecedores();

        include 'View/modules/Compra/NovaCompra.php';
    }

    public static function relatorio(){
        parent::isAuthenticated();

        $model = new CompraModel();
        $model->getAllRows();

        include 'View/modules/Compra/ListarCompra.php';
    }

    public static function getById()
    {
        parent::isAuthenticated();

        $model = new CompraModel();

        parent::setResponseAsJSON($model->getById($_GET['id']));
    }

    public static function save()
    {
        parent::isAuthenticated();
        $cobranca = new CobrancaModel();
        $compra = new CompraModel();
        $compra->id = $_POST['id'];
        $compra->qnt_parcela = $_POST['qnt_parcela'];
        $compra->valor_compra = $_POST['valor_compra'];
        $compra->data_compra = $_POST['data_compra'];
        $compra->id_fornecedor = $_POST['id_fornecedor'];

        $compra_inserida = $compra->save();

        if ($compra_inserida->id != 0 || $compra_inserida->id != null && isset($_POST['arr_parcelas'])) {
            $cobranca->id_compra = $compra_inserida->id;
            $cobranca->lista_cobrancas = json_decode($_POST['arr_parcelas']);
            $res = $cobranca->save();
            if($res == false)
                parent::setResponseAsJSON(false);
            parent::setResponseAsJSON($compra_inserida);
        } else {
            parent::setResponseAsJSON($compra_inserida);
        }
    }

    public static function update()
    {
    }

    public static function delete()
    {
        parent::isAuthenticated();

        $model = new CompraModel();

        $model->delete((int) $_GET['id']);

        parent::setResponseAsJSON($model);
    }
}
