<?php

namespace App\DAO;

use App\Model\MovimentacaoModel;
use \PDO;

class MovimentacaoDAO extends DAO
{
    public function __construct()
    {
        parent::__construct();
    }

    public function insert(MovimentacaoModel $model)
    {
        $sql = "INSERT INTO Movimentacao (valor, data_Movimentacao) VALUE (?, ?)";

        $stmt = parent::getConnection()->prepare($sql);

        $stmt->bindValue(1, $model->valor);
        $stmt->bindValue(2, $model->dataMovimentacao);

        $stmt->execute();
    }

    public function update(MovimentacaoModel $model)
    {
        $sql = "UPDATE Movimentacao SET valor=?, data_Movimentacao=? WHERE id=?";

        $stmt = parent::getConnection()->prepare($sql);
        $stmt->bindValue(1, $model->valor);
        $stmt->bindValue(2, $model->dataMovimentacao);
        $stmt->bindValue(3, $model->id);

        $stmt->execute();
    }

    public function select()
    {
        $sql = "SELECT * FROM Movimentacao";

        $stmt = parent::getConnection()->prepare($sql);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    public function selectById(int $id)
    {
        $sql = "SELECT * FROM Movimentacao WHERE id = ?";

        $stmt = parent::getConnection()->prepare($sql);
        $stmt->bindValue(1, $id);

        $stmt->execute();

        return $stmt->fetchObject("App\Model\MovimentacaoModel");
    }

    public function delete(int $id)
    {
        $sql = "DELETE FROM Movimentacao WHERE id = ?";

        $stmt = parent::getConnection()->prepare($sql);
        $stmt->bindValue(1, $id);
        
        $stmt->execute();
    }
}