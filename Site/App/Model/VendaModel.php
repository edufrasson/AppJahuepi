<?php

namespace App\Model;

use App\DAO\ProdutoDAO;
use App\DAO\TaxaDAO;
use App\DAO\VendaDAO;

class VendaModel extends Model
{
    public $id, $data_venda, $data_da_venda;
    public $id_venda, $id_pagamento, $total_bruto, $total_liquido, $parcelas, $valor_total, $valor_liquido;
    public $arr_produtos, $arr_taxas, $valor_taxa;
    public $lista_produtos, $lista_parcelas, $forma_pagamento;

    public function save()
    {
        $dao = new VendaDAO();
        
        if(empty($this->id))        
            return $dao->insert($this);
        else
            $dao->update($this);
        
    }

    public function getAllRows()
    {
        $dao = new VendaDAO();

        $this->rows = $dao->select();
    }

    public function getById(int $id)
    {
        $dao = new VendaDAO();

        $obj = $dao->selectById($id);

        return ($obj) ? $obj : new VendaModel();
    }

    public function delete(int $id)
    {
        $dao = new VendaDAO();

        $dao->delete($id);
    }

    public function getAllProdutos(){
        $dao = new ProdutoDAO();

        $this->arr_produtos = $dao->select();
    }

    public function getByAno($ano){

        $dao = new VendaDAO();

        $this->rows = $dao->selectByAno($ano);
    }

    
    public function getByAnoAndMes($ano, $mes){
        
        $dao = new VendaDAO();

        $this->rows = $dao->selectByAnoAndMes($ano, $mes);
    }
    
    public function getAllTaxas(){
        $dao = new TaxaDAO();

        $this->arr_taxas = $dao->select();
    }
}