<?php

namespace App\DAO;

use App\Model\EstoqueModel;
use \PDO;

class EstoqueDAO extends DAO
{
    public function __construct()
    {
        parent::__construct();
    }

    public function insert(EstoqueModel $model)
    {
        $sql = "INSERT INTO estoque (situacao, quantidade, id_venda, id_produto, data_registro) VALUES (?, ?, ?, ?, ?)";

        $stmt = parent::getConnection()->prepare($sql);

        $stmt->bindValue(1, $model->situacao);
        $stmt->bindValue(2, $model->quantidade);
        $stmt->bindValue(3, $model->id_venda);
        $stmt->bindValue(4, $model->id_produto);
        $stmt->bindValue(5, $model->data_registro);
        

        $stmt->execute();

        return parent::getConnection()->lastInsertId();
    }

    public function update(EstoqueModel $model)
    {

        $sql = "UPDATE estoque SET situacao = ?, quantidade = ?, id_venda=?, id_produto = ?, data_registro = ? WHERE id=?";

        $stmt = parent::getConnection()->prepare($sql);
        $stmt->bindValue(1, $model->situacao);
        $stmt->bindValue(2, $model->quantidade);
        $stmt->bindValue(3, $model->id_venda);
        $stmt->bindValue(4, $model->id_produto);
        $stmt->bindValue(5, $model->data_registro);
        $stmt->bindValue(6, $model->id);
      

        $stmt->execute();
    }

    public function select()
    {
        $sql = "SELECT e.*,
                       DATE_FORMAT(e.data_registro, '%d/%m/%Y') as data,
                       p.descricao as produto  
                FROM estoque e
                JOIN produto p ON (p.id = e.id_produto)
                WHERE e.ativo = 'S' AND p.ativo = 'S'
                ";

        $stmt = parent::getConnection()->prepare($sql);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    public function selectById(int $id)
    {
        $sql = "SELECT e.*, p.descricao AS produto
        FROM estoque e
        JOIN produto P ON p.id = e.id_produto
        WHERE e.id=? AND e.ativo = 'S'";

        $stmt = parent::getConnection()->prepare($sql);
        $stmt->bindValue(1, $id);

        $stmt->execute();

        return $stmt->fetchObject("App\Model\EstoqueModel");
    }  

    public function delete(int $id)
    {
        $sql = "UPDATE estoque SET ativo = 'N' WHERE id = ?";

        $stmt = parent::getConnection()->prepare($sql);
        $stmt->bindValue(1, $id);

        $stmt->execute();
    }
}
