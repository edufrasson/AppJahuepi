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
        $sql = "INSERT INTO produto (descricao, preco, codigo_barra, quantidade, id_categoria) VALUE (?, ?, ?, ?, ?)";

        $stmt = parent::getConnection()->prepare($sql);

        $stmt->bindValue(1, $model->descricao);
        $stmt->bindValue(2, $model->preco);
        $stmt->bindValue(3, $model->codigo_barra);
        $stmt->bindValue(4, $model->quantidade);
        $stmt->bindValue(5, $model->id_categoria);

        $stmt->execute();
    }

    public function update(ProdutoModel $model)
    {

        $sql = "UPDATE produto SET descricao=?, preco=?, codigo_barra=?, quantidade = ?, id_categoria = ? WHERE id=?";

        $stmt = parent::getConnection()->prepare($sql);
        $stmt->bindValue(1, $model->descricao);
        $stmt->bindValue(2, $model->preco);
        $stmt->bindValue(3, $model->codigo_barra);
        $stmt->bindValue(4, $model->quantidade);
        $stmt->bindValue(5, $model->id_categoria);
        $stmt->bindValue(6, $model->id);

        $stmt->execute();
    }

    public function select()
    {
        $sql = "SELECT p.*,
                         FORMAT(p.preco, 2, 'de_DE') as valor_produto,
                         c.descricao AS categoria
                FROM produto p
                JOIN categoria_produto c ON (c.id = p.id_categoria)
                WHERE p.ativo = 'S' AND c.ativo = 'S'";

        $stmt = parent::getConnection()->prepare($sql);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    public function selectById(int $id)
    {
        $sql = "SELECT p.*, c.descricao AS categoria
        FROM produto p
        JOIN categoria_produto c ON (c.id = p.id_categoria)
        WHERE p.id=? AND p.ativo = 'S' AND c.ativo = 'S'";

        $stmt = parent::getConnection()->prepare($sql);
        $stmt->bindValue(1, $id);

        $stmt->execute();

        return $stmt->fetchObject("App\Model\ProdutoModel");
    }

    public function getMostSaledProduct()
    {
        $sql = "SELECT  p.descricao as produto,
                        sum(pv.quantidade) as quantidade        
                FROM produto_venda pv
                JOIN produto p ON p.id = pv.id_produto
                JOIN venda v ON v.id = pv.id_venda
                WHERE p.ativo = 'S' AND pv.ativo = 'S' AND v.ativo = 'S'
                GROUP BY pv.id_produto
                LIMIT 5";

        $stmt = parent::getConnection()->prepare($sql);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    public function delete(int $id)
    {
        $sql = "UPDATE Produto SET ativo = 'N' WHERE id = ?";

        $stmt = parent::getConnection()->prepare($sql);
        $stmt->bindValue(1, $id);

        $stmt->execute();
    }
}
