<?php

namespace App\Model;

use App\DAO\FornecedorDAO;

class FornecedorModel extends Model
{
    public $id, $descricao;

    public function save()
    {
        $dao = new FornecedorDAO();
        
        if(empty($this->id))
        {
            $dao->insert($this);
        }
        else
            $dao->update($this);
        
    }

    public function getAllRows()
    {
        $dao = new FornecedorDAO();

        $this->rows = $dao->select();
    }

    public function getById(int $id)
    {
        $dao = new FornecedorDAO();

        $obj = $dao->selectById($id);

        return ($obj) ? $obj : new FornecedorModel();
    }

    public function delete(int $id)
    {
        $dao = new FornecedorDAO();

        $dao->delete($id);
    }
}