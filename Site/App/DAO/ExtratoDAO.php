<?php

namespace App\DAO;

use App\Model\ExtratoModel;
use \PDO;

class ExtratoDAO extends DAO
{
    public function __construct()
    {
        parent::__construct();
    }

    public function insert(ExtratoModel $model)
    {
        $sql = "INSERT INTO extrato (valor, data_extrato) VALUE (?, ?)";

        $stmt = $this->conexao->prepare($sql);

        $stmt->bindValue(1, $model->valor);
        $stmt->bindValue(2, $model->dataExtrato);

        $stmt->execute();
    }

    public function update(ExtratoModel $model)
    {
        $sql = "UPDATE extrato SET valor=?, data_extrato=? WHERE id=?";

        $stmt = $this->conexao->prepare($sql);
        $stmt->bindValue(1, $model->valor);
        $stmt->bindValue(2, $model->dataExtrato);
        $stmt->bindValue(3, $model->id);

        $stmt->execute();
    }

    public function select()
    {
        $sql = "SELECT * FROM extrato";

        $stmt = $this->conexao->prepare($sql);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    public function selectById(int $id)
    {
        $sql = "SELECT * FROM extrato WHERE id = ?";

        $stmt = $this->conexao->prepare($sql);
        $stmt->bindValue(1, $id);

        $stmt->execute();

        return $stmt->fetchObject("App\Model\ExtratoModel");
    }

    public function delete(int $id)
    {
        $sql = "DELETE FROM extrato WHERE id = ?";

        $stmt = $this->conexao->prepare($sql);
        $stmt->bindValue(1, $id);
        
        $stmt->execute();
    }
}