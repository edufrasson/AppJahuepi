<?php

namespace App\Model;

use App\DAO\ParcelaDAO;

class ParcelaModel extends Model
{
    public $id, $valor, $data_parcela, $data_recebimento, $status, $id_pagamento, $indice;
    public $lista_parcelas;

    public function save()
    {
        $dao = new ParcelaDAO();
        
        if(empty($this->id))
        {
            return $dao->insert($this);
        }
        else
        $dao->update($this);
        
    }

    public function getByIdVenda(int $id)
    {
        $dao = new ParcelaDAO();

        return $dao->getByIdVenda($id);
    }

    public function getTotalPendenteOfCurrentMonth(){
        $dao = new ParcelaDAO();

        return $dao->getTotalPendenteOfCurrentMonth();
    }

    public function confirmParcela(int $id){
        $dao = new ParcelaDAO();

        return $dao->confirmParcela($id); 
    }

    public function checkParcelas(){
        $dao = new ParcelaDAO();

        return $dao->checkCondicoesParcela(); 
    }

    public function getAllRows()
    {
        $dao = new ParcelaDAO();

        $this->rows = $dao->select();
    }

    public function getById(int $id)
    {
        $dao = new ParcelaDAO();

        $obj = $dao->getById($id);

        return ($obj) ? $obj : new ParcelaModel();
    }

    public function delete(int $id)
    {
        $dao = new ParcelaDAO();

        $dao->delete($id);
    }
}