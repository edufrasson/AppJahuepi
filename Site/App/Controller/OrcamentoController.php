<?php

namespace App\Controller;

use App\Model\VendaModel;
use App\Controller\Controller;
use App\Model\OrcamentoModel;
use App\Model\ProdutoModel;
use App\Model\ProdutoOrcamentoModel;

class OrcamentoController extends Controller
{
    public static function template()
    {
        parent::isAuthenticated();

        $dados = new OrcamentoModel();

        $dados->nome_cliente = $_POST['nome_cliente'];
        $dados->data_orcamento = date("Y-m-d");
        $dados->data_dia = $_POST['data_dia'];
        $dados->numero = $_POST['numero'];
        $dados->arr_produtos = json_decode($_POST['arr_produtos']);
        $dados->valor_total = $_POST['valor_total'];
        $dados->valor_total_formatado = $_POST['valor_total_formatado'];
        $res = $dados->save();

        if ($res->id != false) {
            $model = new ProdutoOrcamentoModel();
            $model->id_orcamento = $res->id;
            $model->lista_produtos = $dados->arr_produtos;
            $model->save();
        }

        
        include 'View/modules/Orcamento/templateOrcamento.php';
    }

    public static function index(){
        parent::isAuthenticated();

        $model = new OrcamentoModel();
        $model->getAllRows();

        include 'View/modules/Orcamento/ListarOrcamento.php';
    }

    public static function confirmVenda(){
        parent::isAuthenticated();

        $model = new OrcamentoModel();
        $model->confirmVenda($_POST['id']);
    }
}
