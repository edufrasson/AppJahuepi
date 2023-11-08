<?php

namespace App\Model;

use App\DAO\TaxaDAO;

class TaxaModel extends Model
{
    public $id, $bandeira, $valor_credito, $valor_debito;

    public function save()
    {
        $dao = new TaxaDAO();
        
        if(empty($this->id))
        {
            $dao->insert($this);
        }
        else
            $dao->update($this);
        
    }

    public function getAllRows()
    {
        $dao = new TaxaDAO();

        $this->rows = $dao->select();
    }

    public function getById(int $id)
    {
        $dao = new TaxaDAO();

        $obj = $dao->selectById($id);

        return ($obj) ? $obj : new TaxaModel();
    }

    public function delete(int $id)
    {
        $dao = new TaxaDAO();

        $dao->delete($id);
    }
}