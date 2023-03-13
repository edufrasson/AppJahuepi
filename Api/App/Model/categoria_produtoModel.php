<?php

namespace App\Model;

use App\DAO\categoria_produtoDAO;

class categoria_produtoModel extends Model
{
    public $id, $descricao;

    public function save()
    {
        $dao = new categoria_produtoDAO();
        
        if(empty($this->id))
        {
            $dao->insert($this);
        }
        else
            $dao->update($this);
        
    }

    public function getAllRows()
    {
        $dao = new categoria_produtoDAO();

        $this->rows = $dao->select();
    }

    public function getById(int $id)
    {
        $dao = new categoria_produtoDAO();

        $obj = $dao->selectById($id);

        return ($obj) ? $obj : new categoria_produtoModel();
    }

    public function delete(int $id)
    {
        $dao = new categoria_produtoDAO();

        $dao->delete($id);
    }
}