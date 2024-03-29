<?php

namespace App\DAO;

use App\Model\ProdutoModel;
use \PDO;

class ProdutoDAO extends DAO
{
    public function __construct()
    {
        parent::__construct();
    }

    public function insert(ProdutoModel $model)
    {
        $sql = "INSERT INTO produto (descricao, preco, codigo_barra, id_categoria) VALUE (?, ?, ?, ?)";

        $stmt = parent::getConnection()->prepare($sql);

        $stmt->bindValue(1, $model->descricao);
        $stmt->bindValue(2, $model->preco);
        $stmt->bindValue(3, $model->codigo_barra);
        $stmt->bindValue(4, $model->id_categoria);


        $stmt->execute();
    }

    public function update(ProdutoModel $model)
    {

        $sql = "UPDATE produto SET descricao=?, preco=?, codigo_barra=?, id_categoria = ? WHERE id=?";

        $stmt = parent::getConnection()->prepare($sql);
        $stmt->bindValue(1, $model->descricao);
        $stmt->bindValue(2, $model->preco);
        $stmt->bindValue(3, $model->codigo_barra);
        $stmt->bindValue(4, $model->id_categoria);
        $stmt->bindValue(5, $model->id);

        $stmt->execute();
    }

    public function select()
    {
        $sql = "SELECT p.*,
                         FORMAT(p.preco, 2, 'de_DE') as valor_produto,
                         sum(e.quantidade) as saldo_estoque,
                         c.descricao AS categoria
                FROM produto p
                JOIN categoria_produto c ON (c.id = p.id_categoria)
                LEFT JOIN estoque e ON (p.id = e.id_produto)
                WHERE p.ativo = 'S' AND c.ativo = 'S'
                GROUP BY p.id";

        $stmt = parent::getConnection()->prepare($sql);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    public function selectById(int $id)
    {
        $sql = "SELECT p.*,
                    sum(e.quantidade) as saldo_estoque,
                    c.descricao AS categoria
                FROM produto p
                JOIN categoria_produto c ON (c.id = p.id_categoria)
                LEFT JOIN estoque e ON (p.id = e.id_produto)
                WHERE p.id = ? AND p.ativo = 'S' AND c.ativo = 'S'
                GROUP BY e.id_produto";

        $stmt = parent::getConnection()->prepare($sql);
        $stmt->bindValue(1, $id);

        $stmt->execute();

        return $stmt->fetchObject("App\Model\ProdutoModel");
    }

    public function selectByCodigo($codigo)
    {
        $sql = "SELECT p.*,
                    sum(e.quantidade) as saldo_estoque,
                    c.descricao AS categoria
                FROM produto p
                JOIN categoria_produto c ON (c.id = p.id_categoria)
                LEFT JOIN estoque e ON (p.id = e.id_produto)
                WHERE p.codigo_barra = ? AND p.ativo = 'S' AND c.ativo = 'S'
                GROUP BY e.id_produto";

        $stmt = parent::getConnection()->prepare($sql);
        $stmt->bindValue(1, $codigo);

        $stmt->execute();

        return $stmt->fetchObject("App\Model\ProdutoModel");
    }

    public function selectCountByCodigo($codigo)
    {
        $sql = "SELECT		
                count(p.descricao) AS produtos
            FROM produto p
            JOIN categoria_produto c ON (c.id = p.id_categoria)
            WHERE p.codigo_barra = ? AND p.ativo = 'S' AND c.ativo = 'S'
        ";

        $stmt = parent::getConnection()->prepare($sql);
        $stmt->bindValue(1, $codigo);

        $stmt->execute();

        return $stmt->fetchObject("App\Model\ProdutoModel");
    }

    public function getRelatorioOfCurrentMonth()
    {
        $sql = "SELECT 
            DATE_FORMAT(m.data_movimentacao, '%d/%m/%Y') as data_movimentacao,
            year(m.data_movimentacao) as ano,
            monthname(m.data_movimentacao) as mes,   
            pp.id as id_produto,
            pp.descricao as produto,
            (SELECT sum(m.valor) as total_entrada
            FROM movimentacao m
            JOIN parcela par ON par.id = m.id_parcela
            JOIN pagamento pgt ON pgt.id = par.id
            JOIN venda v ON v.id = pgt.id_venda
            JOIN produto_venda pv ON pv.id_venda = v.id
            WHERE pv.id_produto = pp.id
            ) as total_entrada,            
            (SELECT sum(m.valor) as total_saida
            FROM movimentacao m
            JOIN cobranca co ON co.id = m.id_cobranca
            JOIN compra c ON c.id = co.id_compra
            JOIN produto_compra pc ON pc.id_compra = c.id
            WHERE pc.id_produto = pp.id) as total_saida,
            
            (SELECT sum(m.valor) as total_entrada
            FROM movimentacao m
            JOIN cobranca co ON co.id = m.id_cobranca
            JOIN compra c ON c.id = co.id_compra
            JOIN produto_compra pc ON pc.id_compra = c.id
            WHERE pc.id_produto = pp.id) 
                    +
            (SELECT sum(m.valor) as total_entrada
            FROM movimentacao m
            JOIN parcela par ON par.id = m.id_parcela
            JOIN pagamento pgt ON pgt.id = par.id
            JOIN venda v ON v.id = pgt.id_venda
            JOIN produto_venda pv ON pv.id_venda = v.id
            WHERE pv.id_produto = pp.id
            ) as saldo
        FROM produto pp
        JOIN produto_venda pv ON pv.id_produto = pp.id
        JOIN venda v ON v.id = pv.id_venda
        JOIN pagamento pgt ON pgt.id_venda = v.id
        JOIN parcela par ON par.id_pagamento = pgt.id
        JOIN movimentacao m ON m.id_parcela = par.id
        WHERE month(m.data_movimentacao) = month(current_timestamp()) AND year(m.data_movimentacao) =  year(current_timestamp())
        GROUP BY pp.id";

        $stmt = parent::getConnection()->prepare($sql);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    public function getRelatorioByMonthAndYear($mes, $ano)
    {
        $sql = "SELECT 
        year(m.data_movimentacao) as ano,
        monthname(m.data_movimentacao) as mes,   
        pp.id as id_produto,
        pp.descricao as produto,
        (SELECT sum(m.valor) as total_entrada 
         FROM produto p
                JOIN produto_venda pv ON pv.id_produto = p.id
                JOIN venda v ON v.id = pv.id_venda
                JOIN pagamento pgt ON pgt.id_venda = v.id
                JOIN parcela par ON par.id_pagamento = pgt.id
                JOIN movimentacao m ON m.id_parcela = par.id
                WHERE month(m.data_movimentacao) = :mes AND year(m.data_movimentacao) = :ano AND pv.id_produto = pp.id
        ) as total_entrada,            
        (SELECT sum(m.valor) as total_saida 
        FROM produto p
        JOIN produto_compra pc ON pc.id_produto = p.id
        JOIN compra c ON c.id = pc.id_compra
        JOIN cobranca co ON co.id_compra = c.id
        JOIN movimentacao m ON m.id_cobranca = co.id
        WHERE month(m.data_movimentacao) = :mes AND year(m.data_movimentacao) = :ano AND pc.id_produto = pp.id) 
        as total_saida,            
        (SELECT sum(m.valor) as total_saida 
        FROM produto p
        JOIN produto_compra pc ON pc.id_produto = p.id
        JOIN compra c ON c.id = pc.id_compra
        JOIN cobranca co ON co.id_compra = c.id
        JOIN movimentacao m ON m.id_cobranca = co.id
        WHERE month(m.data_movimentacao) = :mes AND year(m.data_movimentacao) = :ano AND pc.id_produto = pp.id) 
                        +
        (SELECT sum(m.valor) as total_saida 
        FROM produto p
        JOIN produto_venda pv ON pv.id_produto = p.id
        JOIN venda v ON v.id = pv.id_venda
        JOIN pagamento pgt ON pgt.id_venda = v.id
        JOIN parcela par ON par.id_pagamento = pgt.id
        JOIN movimentacao m ON m.id_parcela = par.id
        WHERE month(m.data_movimentacao) = :mes AND year(m.data_movimentacao) = :ano AND pv.id_produto = pp.id
        ) as saldo
    FROM produto pp
    JOIN produto_venda pv ON pv.id_produto = pp.id
    JOIN venda v ON v.id = pv.id_venda
    JOIN pagamento pgt ON pgt.id_venda = v.id
    JOIN parcela par ON par.id_pagamento = pgt.id
    JOIN movimentacao m ON m.id_parcela = par.id
    WHERE month(m.data_movimentacao) = :mes AND year(m.data_movimentacao) = :ano    
    GROUP BY pp.id";

        $stmt = parent::getConnection()->prepare($sql);
        $stmt->bindValue(':mes', $mes);
        $stmt->bindValue(':ano', $ano);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    public function getRelatorioByYear($ano)
    {
        $sql = "SELECT 
            DATE_FORMAT(m.data_movimentacao, '%d/%m/%Y') as data_movimentacao,
            year(m.data_movimentacao) as ano,
            monthname(m.data_movimentacao) as mes,   
            pp.id as id_produto,
            pp.descricao as produto,
            (SELECT sum(m.valor) as total_entrada
            FROM movimentacao m
            JOIN parcela par ON par.id = m.id_parcela
            JOIN pagamento pgt ON pgt.id = par.id
            JOIN venda v ON v.id = pgt.id_venda
            JOIN produto_venda pv ON pv.id_venda = v.id
            WHERE pv.id_produto = pp.id
            ) as total_entrada,            
            (SELECT sum(m.valor) as total_saida
            FROM movimentacao m
            JOIN cobranca co ON co.id = m.id_cobranca
            JOIN compra c ON c.id = co.id_compra
            JOIN produto_compra pc ON pc.id_compra = c.id
            WHERE pc.id_produto = pp.id) as total_saida,
            
            (SELECT sum(m.valor) as total_entrada
            FROM movimentacao m
            JOIN cobranca co ON co.id = m.id_cobranca
            JOIN compra c ON c.id = co.id_compra
            JOIN produto_compra pc ON pc.id_compra = c.id
            WHERE pc.id_produto = pp.id) 
                    +
            (SELECT sum(m.valor) as total_entrada
            FROM movimentacao m
            JOIN parcela par ON par.id = m.id_parcela
            JOIN pagamento pgt ON pgt.id = par.id
            JOIN venda v ON v.id = pgt.id_venda
            JOIN produto_venda pv ON pv.id_venda = v.id
            WHERE pv.id_produto = pp.id
            ) as saldo
        FROM produto pp
        JOIN produto_venda pv ON pv.id_produto = pp.id
        JOIN venda v ON v.id = pv.id_venda
        JOIN pagamento pgt ON pgt.id_venda = v.id
        JOIN parcela par ON par.id_pagamento = pgt.id
        JOIN movimentacao m ON m.id_parcela = par.id
        WHERE year(m.data_movimentacao) = ?
        GROUP BY pp.id";

        $stmt = parent::getConnection()->prepare($sql);
        $stmt->bindValue(1, $ano);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    public function getMostSaledProduct()
    {
        $sql = "SELECT  p.descricao as produto,
                        sum(pv.quantidade) as quantidade        
                FROM produto_venda pv
                JOIN produto p ON p.id = pv.id_produto
                JOIN venda v ON v.id = pv.id_venda
                WHERE p.ativo = 'S' AND pv.ativo = 'S' AND v.ativo = 'S'
                GROUP BY pv.id_produto
                LIMIT 5";

        $stmt = parent::getConnection()->prepare($sql);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    public function delete(int $id)
    {
        $sql = "UPDATE produto SET ativo = 'N' WHERE id = ?";

        $stmt = parent::getConnection()->prepare($sql);
        $stmt->bindValue(1, $id);

        $stmt->execute();
    }
}
