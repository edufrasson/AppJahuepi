<?php

namespace App\DAO;

use App\Model\ParcelaModel;
use \PDO;

class ParcelaDAO extends DAO
{
    public function __construct()
    {
        parent::__construct();
    }

    public function insert(ParcelaModel $model)
    {
        $sql = "INSERT INTO Parcela (valor, data_parcela) VALUE (?, ?)";

        $stmt = $this->conexao->prepare($sql);

        $stmt->bindValue(1, $model->valor);
        $stmt->bindValue(2, $model->data_parcela);

        $stmt->execute();
    }

    public function update(ParcelaModel $model)
    {
        $sql = "UPDATE Parcela SET valor=?, data_parcela=? WHERE id=?";

        $stmt = $this->conexao->prepare($sql);
        $stmt->bindValue(1, $model->valor);
        $stmt->bindValue(2, $model->data_parcela);
        $stmt->bindValue(3, $model->id);

        $stmt->execute();
    }

    public function select()
    {
        $sql = "SELECT * FROM Parcela";

        $stmt = $this->conexao->prepare($sql);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    public function selectById(int $id)
    {
        $sql = "SELECT * FROM Parcela WHERE id = ?";

        $stmt = $this->conexao->prepare($sql);
        $stmt->bindValue(1, $id);

        $stmt->execute();

        return $stmt->fetchObject("App\Model\ParcelaModel");
    }

    public function delete(int $id)
    {
        $sql = "DELETE FROM Parcela WHERE id = ?";

        $stmt = $this->conexao->prepare($sql);
        $stmt->bindValue(1, $id);
        
        $stmt->execute();
    }
}