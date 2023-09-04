<?php

namespace App\Model;

use App\DAO\ProdutoVendaDAO;

class ProdutoVendaModel extends Model
{
    public $id, $quantidade, $id_produto, $id_venda, $valor_unit;
    public $lista_produtos;

    public function save()
    {
        $dao = new ProdutoVendaDAO();
        
        if(empty($this->id))        
            return $dao->insert($this);
        else
            $dao->update($this);
        
    }

    public function getAllRows()
    {
        $dao = new ProdutoVendaDAO();

        $this->rows = $dao->select();
    }

    public function getById(int $id)
    {
        $dao = new ProdutoVendaDAO();

        $obj = $dao->selectById($id);

        return ($obj) ? $obj : new ProdutoVendaModel();
    }

    public function delete(int $id)
    {
        $dao = new ProdutoVendaDAO();

        $dao->delete($id);
    }
}