<?php

namespace App\Controller;

use App\Controller\Controller;
use App\Model\MovimentacaoModel;
use App\Model\CobrancaModel;

class CobrancaController extends Controller
{
    public static function index()
    {
        parent::isAuthenticated();

        $model = new CobrancaModel();
        $model->getAllRows();

        parent::setResponseAsJSON($model);
    }

    public static function getById()
    {   
        parent::isAuthenticated();
        
        $model = new CobrancaModel();

        parent::setResponseAsJSON($model->getById($_GET['id']));
    }

    public static function checkCobrancas()
    {
        $model = new CobrancaModel();

        $arr_ids_cobranca = $model->checkCobrancas();

        foreach ($arr_ids_cobranca as $id) {

            $model->confirmCobranca($id->id_cobranca);

            $cobranca = $model->getById($id->id_cobranca);

            $movimentacao = new MovimentacaoModel();
            $movimentacao->valor = $cobranca->valor;
            $movimentacao->descricao = "Recebimento de cobranca";
            $movimentacao->data_movimentacao = $cobranca->data_recebimento;
            $movimentacao->id_cobranca = $cobranca->id;
            $movimentacao->save();          
        }
    }

    public static function getByIdVenda()
    {
        parent::isAuthenticated();

        $model = new CobrancaModel();

        parent::setResponseAsJSON($model->getByIdVenda($_GET['id']));
    }

    public static function confirmcobranca()
    {
        parent::isAuthenticated();

        $model = new CobrancaModel();
        

        $model->confirmcobranca($_GET['id']);
        $dados = $model->getById($_GET['id']);

        $model_mov = new MovimentacaoModel();
        $model_mov->descricao = "Recebimento de cobranca";
        $model_mov->data_movimentacao = $dados->data_recebimento;
        $model_mov->valor = $dados->valor;
        $model_mov->id_cobranca = $dados->id_cobranca;
        $model_mov->save();
        

        header('Location: /relatorio');
    }

    public static function save()
    {
        parent::isAuthenticated();

        $cobranca = new CobrancaModel();

        $cobranca->id = $_POST['id'];
        $cobranca->valor_cobranca = $_POST['valor_cobranca'];
        $cobranca->data_cobranca = $_POST['data_cobranca'];
        $cobranca->status = $_POST['status'];
        $cobranca->id_compra = $_POST['id_compra'];

        $cobranca->save();

        parent::setResponseAsJSON($cobranca);
    }

    public static function delete()
    {
        parent::isAuthenticated();

        $model = new CobrancaModel();

        $model->delete((int) $_GET['id']);

        parent::setResponseAsJSON($model);
    }
}
