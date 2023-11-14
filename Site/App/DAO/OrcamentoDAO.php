<?php

namespace App\DAO;

use App\Model\OrcamentoModel;
use \PDO;

class OrcamentoDAO extends DAO
{
    public function __construct()
    {
        parent::__construct();
    }

    public function insert(OrcamentoModel $model)
    {
        $sql = "INSERT INTO orcamento (valor_total, nome_cliente, numero, data_orcamento) VALUE (?, ?, ?, ?)";

        $stmt = parent::getConnection()->prepare($sql);

        $stmt->bindValue(1, $model->valor_total);
        $stmt->bindValue(2, $model->nome_cliente);
        $stmt->bindValue(3, $model->numero);
        $stmt->bindValue(4, $model->data_orcamento);

        $stmt->execute();
        
        $model_retorno = $model;
        $model_retorno->id = parent::getConnection()->lastInsertId();
        return $model_retorno;
    }

    public function update(OrcamentoModel $model)
    {
        $sql = "UPDATE orcamento SET valor_total = ?, nome_cliente = ?, numero = ?, data_orcamento = ? WHERE id=?";

        $stmt = parent::getConnection()->prepare($sql);
        $stmt->bindValue(1, $model->valor_total);
        $stmt->bindValue(2, $model->nome_cliente);
        $stmt->bindValue(3, $model->numero);
        $stmt->bindValue(4, $model->data_orcamento);
        $stmt->bindValue(5, $model->id);

        $stmt->execute();
    }

    public function select()
    {
        $sql = "SELECT o.*,
                 date_format(o.data_orcamento, '%d/%m/%Y') as data,
                 FORMAT(o.valor_total, 2, 'de_DE') as total_orcamento    
        FROM orcamento o
        WHERE ativo = 'S'";

        $stmt = parent::getConnection()->prepare($sql);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    public function selectById(int $id)
    {
        $sql = "SELECT * 
        
        FROM orcamento WHERE id = ? AND ativo = 'S'";

        $stmt = parent::getConnection()->prepare($sql);
        $stmt->bindValue(1, $id);

        $stmt->execute();

        return $stmt->fetchObject("App\Model\OrcamentoModel");
        
    }

    public function confirmVenda($id){

        $sql = "UPDATE orcamento SET venda_registrada = 'S' WHERE id = ?";

        $stmt = parent::getConnection()->prepare($sql);
        $stmt->bindValue(1, $id);

        $stmt->execute();
    }

    public function delete(int $id)
    {
        $sql = "UPDATE orcamento SET ativo = 'N' WHERE id = ?";

        $stmt = parent::getConnection()->prepare($sql);
        $stmt->bindValue(1, $id);

        $stmt->execute();
    }
}