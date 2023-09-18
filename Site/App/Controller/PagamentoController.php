<?php

namespace App\Controller;

use App\Model\PagamentoModel;
use App\Controller\Controller;
use App\Model\ParcelaModel;
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

        $pagamento = $pagamento->save();

      
        $data_parcela = new DateTime($_POST['data_venda']);
        
        for($i = 1; $i <= $pagamento->qnt_parcelas; $i++){      
            $parcela = new ParcelaModel();      
            $parcela->indice = $i;
            $parcela->id_pagamento = $pagamento->id;
            $parcela->valor = $_POST['valor_total'] / $pagamento->qnt_parcelas;
            $parcela->data_parcela = $data_parcela->format('Y-m-d');
            $model_parcela->lista_parcelas[] = $parcela;

            $data_parcela = $data_parcela->modify("+1 month");
        }
        
        $model_parcela->save();
  
        parent::setResponseAsJSON($model_parcela);
    }

    public static function delete()
    {
        $model = new PagamentoModel();

        $model->delete( (int) $_GET['id']);

        parent::setResponseAsJSON($model);
    }
}