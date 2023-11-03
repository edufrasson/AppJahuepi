<?php

namespace App\DAO;

use App\Model\ProdutoVendaModel;
use \PDO;

class ProdutoVendaDAO extends DAO
{
    public function __construct()
    {
        parent::__construct();
    }

    public function insert(ProdutoVendaModel $model)
    {
        parent::getConnection()->beginTransaction();

        foreach ($model->lista_produtos as $produto) {
            $sql = "INSERT INTO produto_venda (quantidade, id_produto, id_venda, valor_unit) VALUE (?, ?, ?, ?)";

            $stmt = parent::getConnection()->prepare($sql);

            $stmt->bindValue(1, $produto->quantidade);
            $stmt->bindValue(2, $produto->id_produto);
            $stmt->bindValue(3, $model->id_venda);
            $stmt->bindValue(4, $produto->valor_unit);

            $stmt->execute();
        }

        return (parent::getConnection()->commit()) ? true : false;
    }

    public function update(ProdutoVendaModel $model)
    {
        $sql = "UPDATE produto_venda SET quantidade = ?, id_produto = ?, id_venda = ?, valor_unit = ? WHERE id = ?";

        $stmt = parent::getConnection()->prepare($sql);

        $stmt->bindValue(1, $model->quantidade);
        $stmt->bindValue(2, $model->id_produto);
        $stmt->bindValue(3, $model->id_venda);
        $stmt->bindValue(4, $model->valor_unit);
        $stmt->bindValue(5, $model->id);

        $stmt->execute();
    }

    public function baixaEstoque($arr_produtos)
    {
        parent::getConnection()->beginTransaction();
        $sql = "UPDATE Produto SET quantidade = ? WHERE id = ?";

        $stmt = parent::getConnection()->prepare($sql);

        foreach ($arr_produtos as $produto) {
            $stmt->execute(array(
                ($produto->old_quantidade - $produto->new_quantidade),
                $produto->id_produto
            ));
        }

        return (parent::getConnection()->commit()) ? true : null;
    }

    public function select()
    {
        $sql = "SELECT * FROM produto_venda WHERE ativo = 'S'";

        $stmt = parent::getConnection()->prepare($sql);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    public function selectById(int $id)
    {
        $sql = "SELECT  pv.id_produto AS id_produto,
                        p.quantidade AS old_quantidade,
                        pv.quantidade AS new_quantidade,
                        pv.quantidade as quantidade,
                        p.descricao as descricao,
                        pv.valor_unit as valor_unit,
                        pv.id_venda as id_venda        
                FROM produto_venda pv
                JOIN produto p ON p.id = pv.id_produto
                WHERE pv.id_venda = ? AND pv.ativo = 'S' AND p.ativo = 'S';";

        $stmt = parent::getConnection()->prepare($sql);
        $stmt->bindValue(1, $id);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    public function delete(int $id)
    {
        $sql = "UPDATE Produto_Venda SET ativo = 'N' WHERE id_venda = ?";

        $stmt = parent::getConnection()->prepare($sql);
        $stmt->bindValue(1, $id);

        $stmt->execute();
    }
}
