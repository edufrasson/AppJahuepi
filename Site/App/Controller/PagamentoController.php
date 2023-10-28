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
        //parent::isAuthenticated();

        $model = new PagamentoModel();
        $model->getAllRows();

        parent::setResponseAsJSON($model);
    }

    public static function getById()
    {
        //parent::isAuthenticated();

        $model = new PagamentoModel();

        parent::setResponseAsJSON($model->getById($_GET['id']));
    }

    public static function save()
    {
        //parent::isAuthenticated();

        $pagamento = new PagamentoModel();

        $model_parcela = new ParcelaModel();

        $pagamento->qnt_parcelas = $_POST['qnt_parcelas'];
        $pagamento->valor_total = $_POST['valor_total'];
        $pagamento->forma_pagamento = $_POST['forma_pagamento'];        
        $pagamento->id_venda = $_POST['id_venda'];
        $pagamento->taxa = $_POST['taxa'];
        $pagamento->valor_liquido = $_POST['valor_liquido'];

        $pgt = $pagamento->save();

        // Verificando se o pagamento foi inserido e aplicando loop de inserção de parcelas

        if ($pgt->id != 0 || $pgt->id != null) {
            // Definindo valores bases das datas de parcela e recebimento

            $data_parcela = new DateTime($_POST['data_venda']);
            
            $data_recebimento = new DateTime($_POST['data_venda']);
            $data_recebimento = $data_recebimento->modify("+1 month");
            
            // Loop de inserção de parcelas

            for ($i = 1; $i <= $pgt->qnt_parcelas; $i++) {
                $parcela = new ParcelaModel();

                $parcela->indice = $i;
                $parcela->id_pagamento = $pgt->id;
                $parcela->valor = $_POST['valor_liquido'] / $pgt->qnt_parcelas;
                $parcela->data_parcela = $data_parcela->format('Y-m-d');
                
                // Adaptando as datas de recebimento de acordo com o tipo de pagamento da parcela
                
                ($pgt->forma_pagamento == "BOLETO" || $pgt->forma_pagamento == "DINHEIRO" ) ? $parcela->data_recebimento = $data_parcela->format('Y-m-d') : "";            
                ($pgt->forma_pagamento == "DEBITO") ? $parcela->data_recebimento = $data_parcela->modify("+1 day")->format('Y-m-d') : "";            
                ($pgt->forma_pagamento == "CREDITO") ? $parcela->data_recebimento = $parcela->data_recebimento = $data_recebimento->format('Y-m-d') : "";            

                $model_parcela->lista_parcelas[] = $parcela;

                // Adicionando mais um mês para o próximo item do loop
                $data_parcela = $data_parcela->modify("+1 month");
                $data_recebimento = $data_recebimento->modify("+1 month");
               
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
        //parent::isAuthenticated();

        $model = new PagamentoModel();

        $model->delete((int) $_GET['id']);

        parent::setResponseAsJSON($model);
    }
}
