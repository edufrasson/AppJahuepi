<?php

namespace App\DAO;

use Exception;
use App\Model\LoginModel;
USE \PDO;

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
        $sql = "INSERT INTO Usuario (email, senha) VALUES (?, sha1(?))";

        $stmt = parent::getConnection()->prepare($sql);

        $stmt->bindValue(1, $model->email);
        $stmt->bindValue(2, $model->senha);

        $stmt->execute();
    }

    public function update(LoginModel $model){
        $sql = "UPDATE Usuario SET email = ?, senha = ? WHERE id = ?";

        $stmt = parent::getConnection()->prepare($sql);
        $stmt->bindValue(1, $model->email);
        $stmt->bindValue(2, $model->senha);
        $stmt->bindValue(3, $model->id);

        $stmt->execute();
    }
    
    public function getByEmailAndSenha($e, $s){
        $sql = "SELECT * FROM Usuario WHERE email = ? AND senha = ? AND ativo = 'S'";

        $stmt = parent::getConnection()->prepare($sql);
        $stmt->bindValue(1, $e);
        $stmt->bindValue(2, sha1($s));
        $stmt->execute();

        return $stmt->fetchObject();
    }

    public function getAllRows(){
        $sql = "SELECT * FROM Usuario WHERE ativo = 'S'";

        $stmt = parent::getConnection()->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    public function getById(int $id){
        $sql = "SELECT * FROM Usuario WHERE id = ? AND ativo = 'S'";

        $stmt = parent::getConnection()->prepare($sql);
        $stmt->bindValue(1, $id);

        $stmt->execute();
    }

    public function delete(int $id)
    {
        $sql = "UPDATE Usuario SET ativo = 'N' WHERE id = ?";

        $stmt = parent::getConnection()->prepare($sql);
        $stmt->bindValue(1, $id);

        $stmt->execute();
    }

    public function setNewPassword($email, $newPassword)
    {
        $sql = "UPDATE usuario SET senha = sha1(?) WHERE email = ?";

        $stmt = parent::getConnection()->prepare($sql);
        $stmt->bindValue(1, $newPassword);
        $stmt->bindValue(2, $email);
        $stmt->execute();
    }
}