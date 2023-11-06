<?php

namespace App\Model;

use App\DAO\ProdutoCompraDAO;

class ProdutoCompraModel extends Model
{
    public $id, $quantidade, $id_produto, $id_compra, $valor_unit;
    public $lista_produtos = array();
    public $old_quantidade, $new_quantidade;

    public function save()
    {
        $dao = new ProdutoCompraDAO();
        
        if(empty($this->id))        
            return $dao->insert($this);
        else
            $dao->update($this);
        
    }

    public function getProdutos($id){
        $dao = new ProdutoCompraDAO();     

        return $dao->selectById($id);
    }

    public function baixaEstoque($arr_produtos){
        $dao = new ProdutoCompraDAO();

        return $dao->baixaEstoque($arr_produtos);
    }

    public function getAllRows()
    {
        $dao = new ProdutoCompraDAO();

        $this->rows = $dao->select();
    }

    public function getById(int $id)
    {
        $dao = new ProdutoCompraDAO();

        $obj = $dao->selectById($id);

        return ($obj) ? $obj : new ProdutoCompraModel();
    }

    public function delete(int $id)
    {
        $dao = new ProdutoCompraDAO();

        $dao->delete($id);
    }
}