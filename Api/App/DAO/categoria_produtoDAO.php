<?php

namespace App\DAO;

use App\Model\categoria_produtoModel;
use \PDO;

class categoria_produtoDAO extends DAO
{
    public function __construct()
    {
        parent::__construct();
    }

    public function insert(categoria_produtoModel $model)
    {
        $sql = "INSERT INTO categoria_produto (descricao) VALUE (?)";

        $stmt = $this->conexao->prepare($sql);

        $stmt->bindValue(1, $model->descricao);

        $stmt->execute();
    }

    public function update(categoria_produtoModel $model)
    {
        $sql = "UPDATE categoria_produto SET descricao=? WHERE id=?";

        $stmt = $this->conexao->prepare($sql);
        $stmt->bindValue(1, $model->descricao);
        $stmt->bindValue(2, $model->id);

        $stmt->execute();
    }

    public function select()
    {
        $sql = "SELECT * FROM categoria_produto";

        $stmt = $this->conexao->prepare($sql);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    public function selectById(int $id)
    {
        $sql = "SELECT * FROM categoria_produto WHERE id = ?";

        $stmt = $this->conexao->prepare($sql);
        $stmt->bindValue(1, $id);

        $stmt->execute();

        return $stmt->fetchObject("App\Model\categoria_produtoModel");
        
    }

    public function delete(int $id)
    {
        $sql = "DELETE FROM categoria_produto WHERE id = ?";

        $stmt = $this->conexao->prepare($sql);
        $stmt->bindValue(1, $id);

        $stmt->execute();
    }
}