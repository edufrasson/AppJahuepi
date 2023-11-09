<?php

namespace App\Model;

use App\DAO\OrcamentoDAO;

class OrcamentoModel extends Model
{
    public $id, $nome_cliente, $numero, $data_orcamento, $data_dia, $arr_produtos, $valor_total, $valor_total_formatado;

    public function save(){
        $dao = new OrcamentoDAO();
        
        if(empty($this->id))
        {
            return $dao->insert($this);
        }
        else
            $dao->update($this);
    }

    public function confirmVenda($id){
        $dao = new OrcamentoDAO();

         return $dao->confirmVenda($id);
    }

    public function getAllRows(){
        $dao = new OrcamentoDAO();

        $this->rows = $dao->select();
    }
}