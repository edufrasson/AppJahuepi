<?php

namespace App\DAO;

use App\Model\ProdutoCompraModel;
use \PDO;

class ProdutoCompraDAO extends DAO
{
    public function __construct()
    {
        parent::__construct();
    }

    public function insert(ProdutoCompraModel $model)
    {
        parent::getConnection()->beginTransaction();

        foreach ($model->lista_produtos as $produto) {
            $sql = "INSERT INTO produto_compra (quantidade, id_produto, id_compra, valor_unit) VALUE (?, ?, ?, ?)";

            $stmt = parent::getConnection()->prepare($sql);

            $stmt->bindValue(1, $produto->quantidade);
            $stmt->bindValue(2, $produto->id_produto);
            $stmt->bindValue(3, $model->id_compra);
            $stmt->bindValue(4, $produto->valor_unit);

            $stmt->execute();
        }

        return (parent::getConnection()->commit()) ? true : false;
    }

    public function update(ProdutoCompraModel $model)
    {
        $sql = "UPDATE produto_compra SET quantidade = ?, id_produto = ?, id_compra = ?, valor_unit = ? WHERE id = ?";

        $stmt = parent::getConnection()->prepare($sql);

        $stmt->bindValue(1, $model->quantidade);
        $stmt->bindValue(2, $model->id_produto);
        $stmt->bindValue(3, $model->id_compra);
        $stmt->bindValue(4, $model->valor_unit);
        $stmt->bindValue(5, $model->id);

        $stmt->execute();
    }

    public function baixaEstoque($arr_produtos)
    {
        parent::getConnection()->beginTransaction();
        $sql = "INSERT INTO estoque (situacao, quantidade, id_compra, id_produto, data_registro) VALUES (?, ?, ?, ?, ?)";

        $stmt = parent::getConnection()->prepare($sql);

        foreach ($arr_produtos as $produto) {
            $stmt->execute(array(
                "COMPRA",
                $produto->quantidade,
                $produto->id_compra,
                $produto->id_produto,
                $produto->data_compra
            ));
        }

        return (parent::getConnection()->commit()) ? true : null;
    }

    public function select()
    {
        $sql = "SELECT * FROM produto_compra WHERE ativo = 'S'";

        $stmt = parent::getConnection()->prepare($sql);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    public function selectById(int $id)
    {
        $sql = "SELECT  pv.id_produto AS id_produto,                        
                        pv.quantidade as quantidade,
                        p.descricao as descricao,
                        pv.valor_unit as valor_unit,
                        pv.id_compra as id_compra,
                        c.data_compra as data_compra      
                FROM produto_compra pv
                JOIN produto p ON p.id = pv.id_produto
                JOIN compra c ON c.id = pv.id_compra
                WHERE pv.id_compra = ? AND pv.ativo = 'S' AND p.ativo = 'S' AND c.ativo = 'S';";

        $stmt = parent::getConnection()->prepare($sql);
        $stmt->bindValue(1, $id);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    public function delete(int $id)
    {
        $sql = "UPDATE produto_compra SET ativo = 'N' WHERE id_compra = ?";

        $stmt = parent::getConnection()->prepare($sql);
        $stmt->bindValue(1, $id);

        $stmt->execute();
    }
}
