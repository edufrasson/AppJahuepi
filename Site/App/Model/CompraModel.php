<?php

namespace App\Model;

use App\DAO\CompraDAO;

class CompraModel extends Model
{
    public $id, $data_compra, $valor_compra, $qnt_parcela, $id_fornecedor;
    public $lista_cobranca;

    public function save()
    {
        $dao = new CompraDAO();
        
        if(empty($this->id))        
            return $dao->insert($this);
        else
            $dao->update($this);
        
    }

    public function getAllRows()
    {
        $dao = new CompraDAO();

        $this->rows = $dao->select();
    }

    public function getById(int $id)
    {
        $dao = new CompraDAO();

        $obj = $dao->selectById($id);

        return ($obj) ? $obj : new CompraModel();
    }

    public function delete(int $id)
    {
        $dao = new CompraDAO();

        $dao->delete($id);
    }
}