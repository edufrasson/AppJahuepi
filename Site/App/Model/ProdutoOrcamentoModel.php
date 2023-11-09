<?php

namespace App\Model;

use App\DAO\ProdutoOrcamentoDAO;

class ProdutoOrcamentoModel extends Model
{
    public $id, $quantidade, $id_produto, $id_orcamento, $valor_unit;
    public $lista_produtos = array();
    public $old_quantidade, $new_quantidade;

    public function save()
    {
        $dao = new ProdutoOrcamentoDAO();
        
        if(empty($this->id))        
            return $dao->insert($this);
        else
            $dao->update($this);
        
    }

    public function getProdutos($id){
        $dao = new ProdutoOrcamentoDAO();     

        return $dao->selectById($id);
    }

    public function getAllRows()
    {
        $dao = new ProdutoOrcamentoDAO();

        $this->rows = $dao->select();
    }

    public function getById(int $id)
    {
        $dao = new ProdutoOrcamentoDAO();

        $obj = $dao->selectById($id);

        return ($obj) ? $obj : new ProdutoOrcamentoModel();
    }

    public function delete(int $id)
    {
        $dao = new ProdutoOrcamentoDAO();

        $dao->delete($id);
    }
}