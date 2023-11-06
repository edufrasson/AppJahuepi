<?php

namespace App\DAO;

use App\Model\FornecedorModel;
use \PDO;

class FornecedorDAO extends DAO
{
    public function __construct()
    {
        parent::__construct();
    }

    public function insert(FornecedorModel $model)
    {
        $sql = "INSERT INTO fornecedor (descricao) VALUE (?)";

        $stmt = parent::getConnection()->prepare($sql);

        $stmt->bindValue(1, $model->descricao);

        $stmt->execute();
    }

    public function update(FornecedorModel $model)
    {
        $sql = "UPDATE fornecedor SET descricao=? WHERE id=?";

        $stmt = parent::getConnection()->prepare($sql);
        $stmt->bindValue(1, $model->descricao);
        $stmt->bindValue(2, $model->id);

        $stmt->execute();
    }

    public function select()
    {
        $sql = "SELECT * FROM fornecedor WHERE ativo = 'S'";

        $stmt = parent::getConnection()->prepare($sql);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    public function selectById(int $id)
    {
        $sql = "SELECT * FROM fornecedor WHERE id = ? AND ativo = 'S'";

        $stmt = parent::getConnection()->prepare($sql);
        $stmt->bindValue(1, $id);

        $stmt->execute();

        return $stmt->fetchObject("App\Model\FornecedorModel");
        
    }

    public function delete(int $id)
    {
        $sql = "UPDATE fornecedor SET ativo = 'N' WHERE id = ?";

        $stmt = parent::getConnection()->prepare($sql);
        $stmt->bindValue(1, $id);

        $stmt->execute();
    }
}