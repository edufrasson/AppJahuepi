<?php

namespace App\DAO;

use App\Model\VendaModel;
use \PDO;

class VendaDAO extends DAO
{
    public function __construct()
    {
        parent::__construct();
    }

    public function insert(VendaModel $model)
    {
        $sql = "INSERT INTO Venda (data_venda) VALUE (?)";

        $stmt = $this->conexao->prepare($sql);

        $stmt->bindValue(1, $model->data_venda);

        $stmt->execute();

        $model_retorno = new VendaModel();
        $model_retorno->id = $this->conexao->lastInsertId();
        return $model_retorno;
    }

    public function update(VendaModel $model)
    {
        $sql = "UPDATE Venda SET data_venda = ? WHERE id = ?";

        $stmt = $this->conexao->prepare($sql);

        $stmt->bindValue(1, $model->data_venda);
        $stmt->bindValue(2, $model->id);

        $stmt->execute();
    }

    public function select()
    {
        $sql = "SELECT * FROM Venda";

        $stmt = $this->conexao->prepare($sql);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    public function selectById(int $id)
    {
        $sql = "SELECT * FROM Venda WHERE id = ?";

        $stmt = $this->conexao->prepare($sql);
        $stmt->bindValue(1, $id);

        $stmt->execute();

        return $stmt->fetchObject("App\Model\VendaModel");
    }

    public function delete(int $id)
    {
        $sql = "DELETE FROM Venda WHERE id = ?";

        $stmt = $this->conexao->prepare($sql);
        $stmt->bindValue(1, $id);

        $stmt->execute();
    }
}
