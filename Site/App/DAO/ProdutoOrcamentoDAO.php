<?php

namespace App\DAO;

use App\Model\ProdutoOrcamentoModel;
use \PDO;

class ProdutoOrcamentoDAO extends DAO
{
    public function __construct()
    {
        parent::__construct();
    }

    public function insert(ProdutoOrcamentoModel $model)
    {
        parent::getConnection()->beginTransaction();

        foreach ($model->lista_produtos as $produto) {
            $sql = "INSERT INTO produto_orcamento (quantidade, id_produto, id_orcamento, valor_unit) VALUE (?, ?, ?, ?)";

            $stmt = parent::getConnection()->prepare($sql);

            $stmt->bindValue(1, $produto->quantidade);
            $stmt->bindValue(2, $produto->id_produto);
            $stmt->bindValue(3, $model->id_orcamento);
            $stmt->bindValue(4, $produto->valor_unit);

            $stmt->execute();
        }

        return (parent::getConnection()->commit()) ? true : false;
    }

    public function update(ProdutoOrcamentoModel $model)
    {
        $sql = "UPDATE produto_orcamento SET quantidade = ?, id_produto = ?, id_orcamento = ?, valor_unit = ? WHERE id = ?";

        $stmt = parent::getConnection()->prepare($sql);

        $stmt->bindValue(1, $model->quantidade);
        $stmt->bindValue(2, $model->id_produto);
        $stmt->bindValue(3, $model->id_orcamento);
        $stmt->bindValue(4, $model->valor_unit);
        $stmt->bindValue(5, $model->id);

        $stmt->execute();
    }

    public function select()
    {
        $sql = "SELECT * FROM produto_orcamento WHERE ativo = 'S'";

        $stmt = parent::getConnection()->prepare($sql);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    public function selectById(int $id)
    {
        $sql = "SELECT  po.id_produto AS id_produto,                        
                        po.quantidade as quantidade,
                        p.descricao as descricao,
                        p.preco as preco,
                        p.codigo_barra as codigo_barra,
                        po.valor_unit as valor_unit,
                        po.id_orcamento as id_orcamento,
                        o.data_orcamento as data_orcamento,    
                        o.nome_cliente as nome_cliente,
                        po.id_orcamento as id_orcamento      
                FROM produto_orcamento po
                JOIN produto p ON p.id = po.id_produto
                JOIN Orcamento o ON o.id = po.id_orcamento
                WHERE po.id_orcamento = ? AND po.ativo = 'S' AND p.ativo = 'S' AND o.ativo = 'S';";

        $stmt = parent::getConnection()->prepare($sql);
        $stmt->bindValue(1, $id);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    public function delete(int $id)
    {
        $sql = "UPDATE Produto_orcamento SET ativo = 'N' WHERE id_orcamento = ?";

        $stmt = parent::getConnection()->prepare($sql);
        $stmt->bindValue(1, $id);

        $stmt->execute();
    }
}
