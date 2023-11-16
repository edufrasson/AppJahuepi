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
        $sql = "INSERT INTO movimentacao (descricao, valor, data_movimentacao, id_parcela, id_cobranca) VALUE (?, ?, ?, ?, ?)";

        $stmt = parent::getConnection()->prepare($sql);

        $stmt->bindValue(1, $model->descricao);
        $stmt->bindValue(2, $model->valor);
        $stmt->bindValue(3, $model->data_movimentacao);
        $stmt->bindValue(4, $model->id_parcela);
        $stmt->bindValue(5, $model->id_cobranca);

        $stmt->execute();
    }

    public function update(MovimentacaoModel $model)
    {
        $sql = "UPDATE movimentacao SET descricao = ?, valor = ?, data_movimentacao = ?, id_parcela = ? WHERE id=?";

        $stmt = parent::getConnection()->prepare($sql);
        $stmt->bindValue(1, $model->descricao);
        $stmt->bindValue(2, $model->valor);
        $stmt->bindValue(3, $model->data_movimentacao);
        $stmt->bindValue(4, $model->id_parcela);
        $stmt->bindValue(5, $model->id);

        $stmt->execute();
    }

    public function getTotalEntradaByProdutoAndDate($mes, $ano)
    {
        $sql = "SELECT 
                p.id AS id_produto,
                p.descricao AS descricao,
                sum(m.valor) AS entrada_produto
            FROM parcela  par
            LEFT JOIN movimentacao m ON par.id = m.id_parcela
            JOIN pagamento pgt ON pgt.id = par.id_pagamento
            JOIN venda v ON v.id = pgt.id_venda
            JOIN produto_venda pv ON pv.id_venda = v.id
            JOIN produto p ON p.id = pv.id_produto
            WHERE month(m.data_movimentacao) = ? and year(m.data_movimentacao) = ?
            group by p.id
        ";

        $stmt = parent::getConnection()->prepare($sql);
        $stmt->bindValue(1, $mes);
        $stmt->bindValue(2, $ano);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }
    public function getTotalSaidaByProdutoAndDate($mes, $ano)
    {
        $sql = "SELECT 
                p.id AS id_produto,
                p.descricao AS descricao,
                sum(m.valor) AS entrada_produto
            FROM parcela  par
            LEFT JOIN movimentacao m ON par.id = m.id_parcela
            JOIN pagamento pgt ON pgt.id = par.id_pagamento
            JOIN venda v ON v.id = pgt.id_venda
            JOIN produto_venda pv ON pv.id_venda = v.id
            JOIN produto p ON p.id = pv.id_produto
            WHERE month(m.data_movimentacao) = ? and year(m.data_movimentacao) = ?
            group by p.id
        ";

        $stmt = parent::getConnection()->prepare($sql);
        $stmt->bindValue(1, $mes);
        $stmt->bindValue(2, $ano);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }
    public function select()
    {
        $sql = "SELECT  m.id as id,
                        m.descricao as descricao,
                        FORMAT(m.valor, 2, 'de_DE') as valor,
                        m.id_parcela as id_parcela,
                        DATE_FORMAT(m.data_movimentacao, '%d/%m/%Y') as data_movimentacao
                FROM movimentacao m WHERE m.ativo = 'S'";

        $stmt = parent::getConnection()->prepare($sql);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    public function selectById(int $id)
    {
        $sql = "SELECT * FROM movimentacao WHERE id = ? AND ativo = 'S'";

        $stmt = parent::getConnection()->prepare($sql);
        $stmt->bindValue(1, $id);

        $stmt->execute();

        return $stmt->fetchObject("App\Model\MovimentacaoModel");
    }

    public function getSaldo()
    {
        $sql = "SELECT  
                    FORMAT(sum(m.valor), 2, 'de_DE') as total_saldo
                FROM movimentacao m 
                WHERE m.ativo = 'S' 
        ";

        $stmt = parent::getConnection()->prepare($sql);

        $stmt->execute();

        return $stmt->fetchObject();
    }
    public function getTotalEntrada()
    {
        $sql = "SELECT  
                    FORMAT(sum(m.valor), 2, 'de_DE') as total_entrada
                FROM movimentacao m
                WHERE m.valor > 0 AND m.ativo = 'S' 
        ";

        $stmt = parent::getConnection()->prepare($sql);

        $stmt->execute();

        return $stmt->fetchObject();
    }
    public function getTotalSaida()
    {
        $sql = "SELECT  
                    FORMAT(sum(m.valor), 2, 'de_DE') as total_saida
                FROM movimentacao m
                WHERE m.valor < 0 AND m.ativo = 'S' 
        ";

        $stmt = parent::getConnection()->prepare($sql);

        $stmt->execute();

        return $stmt->fetchObject();
    }

    public function getSaldoByCurrentMonth()
    {
        $sql = "SELECT  
                FORMAT(sum(m.valor), 2, 'de_DE') as total_saldo
            FROM movimentacao m 
            WHERE m.ativo = 'S' AND month(m.data_movimentacao) = month(CURRENT_TIMESTAMP()) AND year(m.data_movimentacao) = year(CURRENT_TIMESTAMP())
        ";

        $stmt = parent::getConnection()->prepare($sql);

        $stmt->execute();

        return $stmt->fetchObject();
    }
    public function getEntradaByCurrentMonth()
    {
        $sql = "SELECT  
                FORMAT(sum(m.valor), 2, 'de_DE') as total_entrada
            FROM movimentacao m
            WHERE m.valor > 0 AND m.ativo = 'S' AND month(m.data_movimentacao) = month(CURRENT_TIMESTAMP()) AND year(m.data_movimentacao) = year(CURRENT_TIMESTAMP())
        ";

        $stmt = parent::getConnection()->prepare($sql);

        $stmt->execute();

        return $stmt->fetchObject();
    }
    public function getSaidaByCurrentMonth()
    {
        $sql = "SELECT  
                    FORMAT(sum(m.valor), 2, 'de_DE') as total_saida
                FROM movimentacao m
                WHERE m.valor < 0 AND m.ativo = 'S' AND month(m.data_movimentacao) = month(CURRENT_TIMESTAMP()) AND year(m.data_movimentacao) = year(CURRENT_TIMESTAMP())
        ";


        $stmt = parent::getConnection()->prepare($sql);

        $stmt->execute();

        return $stmt->fetchObject();
    }

    public function getTotalEntradaByMonth()
    {
        $sql = "SELECT 
                    monthname(m.data_movimentacao) as mes,
                    month(m.data_movimentacao) as num_mes,
                    sum(m.valor) as total_entrada
                FROM movimentacao m
                WHERE 
                    m.valor > 0 AND m.ativo = 'S'
                GROUP BY monthname(m.data_movimentacao), year(current_timestamp())
                ORDER BY num_mes ASC
                ;    
        ";

        $stmt = parent::getConnection()->prepare($sql);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    public function getTotalSaidaByMonth()
    {
        $sql = "SELECT 
                    monthname(m.data_movimentacao) as num_mes,

                    sum(m.valor) as total_saida
                FROM movimentacao m
                WHERE 
                    m.valor < 0 AND m.ativo = 'S'
                GROUP BY monthname(m.data_movimentacao);    
        ";

        $stmt = parent::getConnection()->prepare($sql);

        $stmt->execute();

        return $stmt->fetchObject();
    }

    public function delete(int $id)
    {
        $sql = "UPDATE movimentacao SET ativo = 'N' WHERE id = ?";

        $stmt = parent::getConnection()->prepare($sql);
        $stmt->bindValue(1, $id);

        $stmt->execute();
    }
}
