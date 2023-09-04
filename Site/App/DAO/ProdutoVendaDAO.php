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
        $sql = "INSERT INTO produto_venda (quantidade, id_produto, id_venda) VALUE (?, ?, ?)";

        $stmt = parent::getConnection()->prepare($sql);

        $stmt->bindValue(1, $model->quantidade);        
        $stmt->bindValue(2, $model->id_produto);        
        $stmt->bindValue(3, $model->id_venda);         

        $stmt->execute();
    }

    public function update(ProdutoVendaModel $model)
    {
        $sql = "UPDATE produto_venda SET quantidade = ?, id_produto = ?, id_venda = ? WHERE id = ?";

        $stmt = parent::getConnection()->prepare($sql);
   
        $stmt->bindValue(1, $model->quantidade);
        $stmt->bindValue(2, $model->id_produto);
        $stmt->bindValue(3, $model->id_venda);
        $stmt->bindValue(4, $model->id);

        $stmt->execute();
    }

    public function select()
    {
        $sql = "SELECT * FROM produto_venda";

        $stmt = parent::getConnection()->prepare($sql);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    public function selectById(int $id)
    {
        $sql = "SELECT * FROM produto_venda WHERE id = ?";

        $stmt = parent::getConnection()->prepare($sql);
        $stmt->bindValue(1, $id);

        $stmt->execute();

        return $stmt->fetchObject("App\Model\ProdutoVendaModel");
    }

    public function delete(int $id)
    {
        $sql = "DELETE FROM produto_venda WHERE id = ?";

        $stmt = parent::getConnection()->prepare($sql);
        $stmt->bindValue(1, $id);
        
        $stmt->execute();
    }
}