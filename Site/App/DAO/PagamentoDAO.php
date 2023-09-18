<?php

namespace App\DAO;

use App\Model\PagamentoModel;
use \PDO;

class PagamentoDAO extends DAO
{
    public function __construct()
    {
        parent::__construct();
    }

    public function insert(PagamentoModel $model)
    {
        $sql = "INSERT INTO Pagamento (valor_total, qnt_parcela, forma_pagamento, id_venda) VALUE (?, ?, ?, ?)";

        $stmt = parent::getConnection()->prepare($sql);

        $stmt->bindValue(1, $model->valor_total);        
        $stmt->bindValue(2, $model->qnt_parcelas);        
        $stmt->bindValue(3, $model->forma_pagamento);        
        $stmt->bindValue(4, $model->id_venda);        

        $stmt->execute();

        $model->id = parent::getConnection()->lastInsertId();
        return $model;
    }

    public function update(PagamentoModel $model)
    {
        $sql = "UPDATE Pagamento SET valor_total = ?, qnt_parcela = ?, forma_pagamento = ?, id_venda = ? WHERE id = ?";

        $stmt = parent::getConnection()->prepare($sql);
   
        $stmt->bindValue(1, $model->valor_total);
        $stmt->bindValue(2, $model->qnt_parcelas);
        $stmt->bindValue(3, $model->forma_pagamento);
        $stmt->bindValue(4, $model->id_venda);
        $stmt->bindValue(5, $model->id);

        $stmt->execute();
    }

    public function select()
    {
        $sql = "SELECT * FROM Pagamento";

        $stmt = parent::getConnection()->prepare($sql);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    public function selectById(int $id)
    {
        $sql = "SELECT * FROM Pagamento WHERE id = ?";

        $stmt = parent::getConnection()->prepare($sql);
        $stmt->bindValue(1, $id);

        $stmt->execute();

        return $stmt->fetchObject("App\Model\PagamentoModel");
    }

    public function delete(int $id)
    {
        $sql = "DELETE FROM Pagamento WHERE id = ?";

        $stmt = parent::getConnection()->prepare($sql);
        $stmt->bindValue(1, $id);
        
        $stmt->execute();
    }
}