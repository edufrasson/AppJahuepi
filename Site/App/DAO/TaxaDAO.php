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
        $sql = "INSERT INTO taxa (bandeira, valor_credito, valor_debito) VALUE (?, ?, ?)";

        $stmt = parent::getConnection()->prepare($sql);

        $stmt->bindValue(1, $model->bandeira);
        $stmt->bindValue(2, $model->valor_credito);
        $stmt->bindValue(3, $model->valor_debito);

        $stmt->execute();
    }

    public function update(TaxaModel $model)
    {
        $sql = "UPDATE taxa SET bandeira=?, valor_credito = ?, valor_debito = ? WHERE id=?";

        $stmt = parent::getConnection()->prepare($sql);
        $stmt->bindValue(1, $model->bandeira);
        $stmt->bindValue(2, $model->valor_credito);
        $stmt->bindValue(3, $model->valor_debito);
        $stmt->bindValue(3, $model->id);

        $stmt->execute();
    }

    public function select()
    {
        $sql = "SELECT * FROM taxa WHERE ativo = 'S'";

        $stmt = parent::getConnection()->prepare($sql);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    public function selectById(int $id)
    {
        $sql = "SELECT * FROM taxa WHERE id = ? AND ativo = 'S'";

        $stmt = parent::getConnection()->prepare($sql);
        $stmt->bindValue(1, $id);

        $stmt->execute();

        return $stmt->fetchObject("App\Model\TaxaModel");
        
    }

    public function delete(int $id)
    {
        $sql = "UPDATE taxa SET ativo = 'N' WHERE id = ?";

        $stmt = parent::getConnection()->prepare($sql);
        $stmt->bindValue(1, $id);

        $stmt->execute();
    }
}