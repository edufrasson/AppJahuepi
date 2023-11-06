<?php

namespace App\DAO;

use App\Model\CompraModel;
use \PDO;

class CompraDAO extends DAO
{
    public function __construct()
    {
        parent::__construct();
    }

    public function insert(CompraModel $model)
    {
        $sql = "INSERT INTO Compra (valor_compra, qnt_parcela, data_compra, id_fornecedor) VALUE (?, ?, ?, ?)";

        $stmt = parent::getConnection()->prepare($sql);

        $stmt->bindValue(1, $model->valor_compra);        
        $stmt->bindValue(2, $model->qnt_parcela);        
        $stmt->bindValue(3, $model->data_compra);        
        $stmt->bindValue(4, $model->id_fornecedor);       
           

        $stmt->execute();

        $model->id = parent::getConnection()->lastInsertId();
        return $model;
    }

    public function update(CompraModel $model)
    {
        $sql = "UPDATE Compra SET valor_compra = ?, qnt_parcela = ?, data_compra = ?, id_fornecedor = ? WHERE id = ?";

        $stmt = parent::getConnection()->prepare($sql);
   
        $stmt->bindValue(1, $model->valor_compra);        
        $stmt->bindValue(2, $model->qnt_parcela);        
        $stmt->bindValue(3, $model->data_compra);        
        $stmt->bindValue(4, $model->id_fornecedor);   
        $stmt->bindValue(5, $model->id);

        $stmt->execute();
    }

    public function select()
    {
        $sql = "SELECT * FROM Compra WHERE ativo = 'S'";

        $stmt = parent::getConnection()->prepare($sql);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    public function selectById(int $id)
    {
        $sql = "SELECT * FROM Compra WHERE id = ? AND ativo = 'S'";

        $stmt = parent::getConnection()->prepare($sql);
        $stmt->bindValue(1, $id);

        $stmt->execute();

        return $stmt->fetchObject("App\Model\CompraModel");
    }

    public function delete(int $id)
    {
        $sql = "UPDATE Compra SET ativo = 'N' WHERE id = ?";

        $stmt = parent::getConnection()->prepare($sql);
        $stmt->bindValue(1, $id);

        $stmt->execute();
    }
}