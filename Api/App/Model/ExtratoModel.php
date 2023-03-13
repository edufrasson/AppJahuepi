<?php

namespace App\Model;

use App\DAO\ExtratoDAO;

class ExtratoModel extends Model
{
    public $id, $valor, $data_extrato;

    public function save()
    {
        $dao = new ExtratoDAO();
        
        if(empty($this->id))
        {
            $dao->insert($this);
        }
        else
        $dao->update($this);
        
    }

    public function getAllRows()
    {
        $dao = new ExtratoDAO();

        $this->rows = $dao->select();
    }

    public function getById(int $id)
    {
        $dao = new ExtratoDAO();

        $obj = $dao->selectById($id);

        return ($obj) ? $obj : new ExtratoModel();
    }

    public function delete(int $id)
    {
        $dao = new ExtratoDAO();

        $dao->delete($id);
    }
}