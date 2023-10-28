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
        $sql = "INSERT INTO Movimentacao (descricao, valor, data_movimentacao, id_parcela) VALUE (?, ?, ?, ?)";

        $stmt = parent::getConnection()->prepare($sql);

        $stmt->bindValue(1, $model->descricao);
        $stmt->bindValue(2, $model->valor);
        $stmt->bindValue(3, $model->data_movimentacao);
        $stmt->bindValue(4, $model->id_parcela);

        $stmt->execute();
    }

    public function update(MovimentacaoModel $model)
    {
        $sql = "UPDATE Movimentacao SET valor = ?, data_movimentacao = ?, id_parcela = ? WHERE id=?";

        $stmt = parent::getConnection()->prepare($sql);
        $stmt->bindValue(1, $model->descricao);
        $stmt->bindValue(2, $model->valor);
        $stmt->bindValue(3, $model->data_movimentacao);
        $stmt->bindValue(4, $model->id_parcela);
        $stmt->bindValue(5, $model->id);

        $stmt->execute();
    }

    public function select()
    {
        $sql = "SELECT  m.id as id,
                        m.descricao as descricao,
                        FORMAT(m.valor, 2, 'de_DE') as valor,
                        m.id_parcela as id_parcela,
                        DATE_FORMAT(m.data_movimentacao, '%d/%m/%Y') as data_movimentacao
                FROM Movimentacao m";

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

    public function getSaldo()
    {
        $sql = "SELECT  
                    FORMAT(sum(m.valor), 2, 'de_DE') as total_saldo
                FROM Movimentacao m";

        $stmt = parent::getConnection()->prepare($sql);

        $stmt->execute();

        return $stmt->fetchObject();
    }
    public function getTotalEntrada()
    {
        $sql = "SELECT  
                    FORMAT(sum(m.valor), 2, 'de_DE') as total_entrada
                FROM Movimentacao m
                WHERE m.valor > 0
        ";

        $stmt = parent::getConnection()->prepare($sql);

        $stmt->execute();

        return $stmt->fetchObject();
    }
    public function getTotalSaida()
    {
        $sql = "SELECT  
                    FORMAT(sum(m.valor), 2, 'de_DE') as total_saida
                FROM Movimentacao m
                WHERE m.valor < 0
        ";

        $stmt = parent::getConnection()->prepare($sql);

        $stmt->execute();

        return $stmt->fetchObject();
    }

    public function delete(int $id)
    {
        $sql = "DELETE FROM Movimentacao WHERE id = ?";

        $stmt = parent::getConnection()->prepare($sql);
        $stmt->bindValue(1, $id);

        $stmt->execute();
    }
}
