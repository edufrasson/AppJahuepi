<?php

namespace App\Model;

use App\DAO\PagamentoDAO;

class PagamentoModel extends Model
{
    public $id, $valor_total, $qnt_parcelas, $forma_pagamento, $id_venda;
    public $lista_parcelas;

    public function save()
    {
        $dao = new PagamentoDAO();
        
        if(empty($this->id))        
            return $dao->insert($this);
        else
            $dao->update($this);
        
    }

    public function getAllRows()
    {
        $dao = new PagamentoDAO();

        $this->rows = $dao->select();
    }

    public function getById(int $id)
    {
        $dao = new PagamentoDAO();

        $obj = $dao->selectById($id);

        return ($obj) ? $obj : new PagamentoModel();
    }

    public function delete(int $id)
    {
        $dao = new PagamentoDAO();

        $dao->delete($id);
    }
}