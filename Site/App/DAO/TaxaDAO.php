<?php

namespace App\DAO;

use App\Model\TaxaModel;
use \PDO;

class TaxaDAO extends DAO
{
    public function __construct()
    {
        parent::__construct();
    }

    public function insert(TaxaModel $model)
    {
        $sql = "INSERT INTO taxa (codigo, valor) VALUE (?, ?)";

        $stmt = $this->conexao->prepare($sql);

        $stmt->bindValue(1, $model->codigo);
        $stmt->bindValue(2, $model->valor);

        $stmt->execute();
    }

    public function update(TaxaModel $model)
    {
        $sql = "UPDATE taxa SET codigo=?, valor = ? WHERE id=?";

        $stmt = $this->conexao->prepare($sql);
        $stmt->bindValue(1, $model->codigo);
        $stmt->bindValue(2, $model->valor);
        $stmt->bindValue(3, $model->id);

        $stmt->execute();
    }

    public function select()
    {
        $sql = "SELECT * FROM taxa";

        $stmt = $this->conexao->prepare($sql);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    public function selectById(int $id)
    {
        $sql = "SELECT * FROM taxa WHERE id = ?";

        $stmt = $this->conexao->prepare($sql);
        $stmt->bindValue(1, $id);

        $stmt->execute();

        return $stmt->fetchObject("App\Model\TaxaModel");
        
    }

    public function delete(int $id)
    {
        $sql = "DELETE FROM taxa WHERE id = ?";

        $stmt = $this->conexao->prepare($sql);
        $stmt->bindValue(1, $id);

        $stmt->execute();
    }
}