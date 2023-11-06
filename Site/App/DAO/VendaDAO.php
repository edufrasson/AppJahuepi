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

        $stmt = parent::getConnection()->prepare($sql);

        $stmt->bindValue(1, $model->data_venda);

        $stmt->execute();

        $model_retorno = new VendaModel();
        $model_retorno->id = parent::getConnection()->lastInsertId();
        return $model_retorno;
    }

    public function update(VendaModel $model)
    {
        $sql = "UPDATE Venda SET data_venda = ? WHERE id = ?";

        $stmt = parent::getConnection()->prepare($sql);

        $stmt->bindValue(1, $model->data_venda);
        $stmt->bindValue(2, $model->id);

        $stmt->execute();
    }

    public function select()
    {
        $sql = "SELECT
                DATE_FORMAT(v.data_venda, '%d/%m/%Y') as data_venda,
                v.id as id_venda,
                FORMAT(p.valor_total, 2, 'de_DE') as total_bruto,
                FORMAT(p.valor_liquido, 2, 'de_DE') as total_liquido,
                p.qnt_parcela as parcelas,
                p.forma_pagamento as forma_pagamento,
                p.id as id_pagamento       
        FROM Venda v
        JOIN Pagamento p ON v.id = p.id_venda
        WHERE v.ativo = 'S'
        ";

        $stmt = parent::getConnection()->prepare($sql);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    public function selectById(int $id)
    {
        $sql = "SELECT * FROM Venda WHERE id = ? AND ativo = 'S'";

        $stmt = parent::getConnection()->prepare($sql);
        $stmt->bindValue(1, $id);

        $stmt->execute();

        return $stmt->fetchObject("App\Model\VendaModel");
    }

    public function delete(int $id)
    {
        $sql = "UPDATE Venda SET ativo = 'N' WHERE id = ?";

        $stmt = parent::getConnection()->prepare($sql);
        $stmt->bindValue(1, $id);

        $stmt->execute();
    }
}
