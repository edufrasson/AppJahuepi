<?php

namespace App\DAO;

use App\Model\CategoriaProdutoModel;
use \PDO;

class CategoriaProdutoDAO extends DAO
{
    public function __construct()
    {
        parent::__construct();
    }

    public function insert(CategoriaProdutoModel $model)
    {
        $sql = "INSERT INTO categoria_produto (descricao) VALUE (?)";

        $stmt = parent::getConnection()->prepare($sql);

        $stmt->bindValue(1, $model->descricao);

        $stmt->execute();
    }

    public function update(CategoriaProdutoModel $model)
    {
        $sql = "UPDATE categoria_produto SET descricao=? WHERE id=?";

        $stmt = parent::getConnection()->prepare($sql);
        $stmt->bindValue(1, $model->descricao);
        $stmt->bindValue(2, $model->id);

        $stmt->execute();
    }

    public function select()
    {
        $sql = "SELECT * FROM categoria_produto";

        $stmt = parent::getConnection()->prepare($sql);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    public function selectById(int $id)
    {
        $sql = "SELECT * FROM categoria_produto WHERE id = ?";

        $stmt = parent::getConnection()->prepare($sql);
        $stmt->bindValue(1, $id);

        $stmt->execute();

        return $stmt->fetchObject("App\Model\CategoriaProdutoModel");
        
    }

    public function delete(int $id)
    {
        $sql = "DELETE FROM categoria_produto WHERE id = ?";

        $stmt = parent::getConnection()->prepare($sql);
        $stmt->bindValue(1, $id);

        $stmt->execute();
    }
}