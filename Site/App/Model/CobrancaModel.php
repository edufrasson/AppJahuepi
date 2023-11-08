<?php

namespace App\Model;

use App\DAO\CobrancaDAO;

class CobrancaModel extends Model
{
    public $id, $valor_cobranca, $data_cobranca, $status, $indice, $id_compra;
    public $lista_cobrancas;

    public function save()
    {
        $dao = new CobrancaDAO();
        
        if(empty($this->id))
        {
            return $dao->insert($this);
        }
        else
        $dao->update($this);
        
    }

    public function getByIdCompra(int $id)
    {
        $dao = new CobrancaDAO();

        return $dao->getByIdCompra($id);
    }

    public function getTotalPendenteOfCurrentMonth(){
        $dao = new CobrancaDAO();

        return $dao->getTotalPendenteOfCurrentMonth();
    }

    public function confirmCobranca(int $id){
        $dao = new CobrancaDAO();

        return $dao->confirmCobranca($id); 
    }

    public function checkCobrancas(){
        $dao = new CobrancaDAO();

        return $dao->checkCondicoesCobranca(); 
    }

    public function getAllRows()
    {
        $dao = new CobrancaDAO();

        $this->rows = $dao->select();
    }

    public function getById(int $id)
    {
        $dao = new CobrancaDAO();

        $obj = $dao->getById($id);

        return ($obj) ? $obj : new CobrancaModel();
    }

    public function delete(int $id)
    {
        $dao = new CobrancaDAO();

        $dao->delete($id);
    }
}