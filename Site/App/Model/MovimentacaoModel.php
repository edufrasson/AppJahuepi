<?php

namespace App\Model;

use App\DAO\MovimentacaoDAO;

class MovimentacaoModel extends Model
{
    public $id, $valor, $descricao, $data_movimentacao, $id_parcela, $id_cobranca;

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

    public function getRelatorio(){
        $dao = new MovimentacaoDAO();

        $this->rows = $dao->getRelatorio();        
    }

    public function getRelatorioByYear($ano){
        $dao = new MovimentacaoDAO();

        $this->rows = $dao->getRelatorioByYear($ano);        
    }

    public function getRelatorioByYearAndMonth($mes, $ano){
        $dao = new MovimentacaoDAO();

        $this->rows = $dao->getRelatorioByYearAndMonth($mes, $ano);        
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

    public function getSaldoByCurrentMonth()
    {
        $dao = new MovimentacaoDAO();

        return $dao->getSaldoByCurrentMonth();        
    }
    public function getTotalEntradaByCurrentMonth()
    {
        $dao = new MovimentacaoDAO();

        return $dao->getEntradaByCurrentMonth();  
    }
    public function getSaidaByCurrentMonth()
    {
        $dao = new MovimentacaoDAO();

        return $dao->getSaidaByCurrentMonth();  
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

    public function getTotalEntradaByProdutoAndDate($mes, $ano){
        $dao = new MovimentacaoDAO();

        return $dao->getTotalEntradaByProdutoAndDate($mes, $ano);  
    }

    public function getTotalSaidaByProdutoAndDate($mes, $ano){
        $dao = new MovimentacaoDAO();

        return $dao->getTotalSaidaByProdutoAndDate($mes, $ano);  
    }
}