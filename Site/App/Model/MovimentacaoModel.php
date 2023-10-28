<?php

namespace App\Model;

use App\DAO\MovimentacaoDAO;

class MovimentacaoModel extends Model
{
    public $id, $valor, $descricao, $data_movimentacao, $id_parcela;

    public function save()
    {
        $dao = new MovimentacaoDAO();
        
        if(empty($this->id))
        {
            $dao->insert($this);
        }
        else
        $dao->update($this);
        
    }

    public function getAllRows()
    {
        $dao = new MovimentacaoDAO();

        $this->rows = $dao->select();
    }

    public function getById(int $id)
    {
        $dao = new MovimentacaoDAO();

        $obj = $dao->selectById($id);

        return ($obj) ? $obj : new MovimentacaoModel();
    }

    public function getSaldo()
    {
        $dao = new MovimentacaoDAO();

        return $dao->getSaldo();        
    }
    public function getTotalEntrada()
    {
        $dao = new MovimentacaoDAO();

        return $dao->getTotalEntrada();  
    }
    public function getTotalSaida()
    {
        $dao = new MovimentacaoDAO();

        return $dao->getTotalSaida();  
    }

    public function getFaturamentoMes(){
        $dao = new MovimentacaoDAO();

        return $dao->getTotalEntradaByMonth();  
    }

    public function delete(int $id)
    {
        $dao = new MovimentacaoDAO();

        $dao->delete($id);
    }
}