<?php

namespace App\DAO;

use App\Model\ProdutoModel;
use \PDO;

class ProdutoDAO extends DAO
{
    public function __construct()
    {
        parent::__construct();
    }

    public function insert(ProdutoModel $model)
    {
        $sql = "INSERT INTO produto (descricao, preco, validade, id_categoria) VALUE (?, ?, ?, ?)";

        $stmt = $this->conexao->prepare($sql);

        $stmt->bindValue(1, $model->descricao);
        $stmt->bindValue(2, $model->preco);
        $stmt->bindValue(3, $model->validade);
        $stmt->bindValue(4, $model->id_categoria);

        $stmt->execute();
    }

    public function update(ProdutoModel $model)
    {
        $sql = "UPDATE produto SET descricao=?, preco=?, validade=?, id_categoria=? WHERE id=?";

        $stmt = $this->conexao->prepare($sql);
        $stmt->bindValue(1, $model->descricao);
        $stmt->bindValue(2, $model->preco);
        $stmt->bindValue(3, $model->validade);
        $stmt->bindValue(4, $model->id_categoria);

        $stmt->execute();
    }

    public function select()
    {
        $sql = "SELECT p.id, p.descricao, p.preco, p.validade, c.descricao AS categoria
                FROM produto p
                JOIN categoria_produto c ON (c.id = p.id_categoria)";

        $stmt = $this->conexao->prepare($sql);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    public function selectById(int $id)
    {
        $sql = "SELECT p.id, p.descricao, p.preco, p.validade, c.descricao AS categoria
        FROM produto p
        JOIN categoria_produto c ON (c.id = p.id_categoria)
        WHERE p.id=?";

        $stmt = $this->conexao->prepare($sql);
        $stmt->bindValue(1, $id);

        $stmt->execute();

        return $stmt->fetchObject("App\Model\ProdutoModel");
    }

    public function delete(int $id)
    {
        $sql = "DELETE FROM produto WHERE id = ?";

        $stmt = $this->conexao->prepare($sql);
        $stmt->bindValue(1, $id);
        
        $stmt->execute();
    }
}