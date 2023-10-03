<?php

namespace App\Controller;

use App\Model\PagamentoModel;
use App\Controller\Controller;
use App\Model\ParcelaModel;
use App\Model\ProdutoModel;
use App\Model\ProdutoVendaModel;
use DateTime;

class PagamentoController extends Controller
{
    public static function index()
    {
        $model = new PagamentoModel();
        $model->getAllRows();

        parent::setResponseAsJSON($model);
    }

    public static function getById()
    {
        $model = new PagamentoModel();

        parent::setResponseAsJSON($model->getById($_GET['id']));
    }

    public static function save()
    {
        $pagamento = new PagamentoModel();

        $model_parcela = new ParcelaModel();

        $pagamento->qnt_parcelas = $_POST['qnt_parcelas'];
        $pagamento->valor_total = $_POST['valor_total'];
        $pagamento->forma_pagamento = $_POST['forma_pagamento'];
        $pagamento->id_venda = $_POST['id_venda'];
        $pagamento->taxa = $_POST['taxa'];
        if ($pagamento->taxa <= 1) {
            if ($pagamento->taxa == null || $pagamento->taxa == 0) {
                $pagamento->valor_liquido = $pagamento->valor_total;
            } else
                $pagamento->valor_liquido = $pagamento->valor_total - ((float)$pagamento->valor_total * (int)$pagamento->taxa);
        } else
            $pagamento->valor_liquido = $pagamento->valor_total - $pagamento->taxa;

        $pgt = $pagamento->save();

        if ($pgt->id != 0 || $pgt->id != null) {
            $data_parcela = new DateTime($_POST['data_venda']);

            for ($i = 1; $i <= $pgt->qnt_parcelas; $i++) {
                $parcela = new ParcelaModel();
                $parcela->indice = $i;
                $parcela->id_pagamento = $pgt->id;
                $parcela->valor = $_POST['valor_total'] / $pgt->qnt_parcelas;
                $parcela->data_parcela = $data_parcela->format('Y-m-d');
                $model_parcela->lista_parcelas[] = $parcela;

                $data_parcela = $data_parcela->modify("+1 month");
            }



            parent::setResponseAsJSON($model_parcela->save());
        } else
            parent::setResponseAsJSON(false);


        // false -> erro no pagamento
        // null -> erro na parcela / baixa estoque
    }

    public static function update()
    {
    }

    public static function delete()
    {
        $model = new PagamentoModel();

        $model->delete((int) $_GET['id']);

        parent::setResponseAsJSON($model);
    }
}
