<?php

namespace App\DAO;

use Exception;
use App\Model\LoginModel;

class LoginDAO extends DAO{
    public function __construct()
    {
        try{
            return parent::__construct();
        }catch(Exception $e){
            echo "Erro ao conectar ao banco: " . $e->getMessage();
        }
    }

    public function insert(LoginModel $model){

    }

    public function update(LoginModel $model){

    }
    public function getByEmailAndSenha($e, $s){
        $sql = "SELECT * FROM Usuario WHERE email = ? AND senha = ?";

        $stmt = $this->conexao->prepare($sql);
        $stmt->bindValue(1, $e);
        $stmt->bindValue(2, sha1($s));
        $stmt->execute();

        return $stmt->fetchObject();
    }

    public function getAllRows(){

    }

    public function getById($id){

    }

    public function delete($id){

    }
}