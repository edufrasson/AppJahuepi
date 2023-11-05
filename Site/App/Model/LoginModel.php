<?php

namespace App\Model;

use App\DAO\LoginDAO;

class LoginModel extends Model
{
    public $id, $email, $senha, $ativo;

    public function save()
    {
        $dao = new LoginDAO();
        
        if(empty($this->id))
            $dao->insert($this);
        else
            $dao->update($this);
        
    }

    public function getByEmailAndSenha($email, $senha)
    {
        $dao = new LoginDAO();

        return $dao->getByEmailAndSenha($email, $senha);
    }

    public function getAllRows()
    {
        $dao = new LoginDAO();

        $this->rows = $dao->getAllRows();
    }

    public function getById(int $id)
    {
        $dao = new LoginDAO();

        $obj = $dao->getById($id);

        return ($obj) ? $obj : new LoginModel();
    }

    public function delete(int $id)
    {
        $dao = new LoginDAO();

        $dao->delete($id);
    }
}