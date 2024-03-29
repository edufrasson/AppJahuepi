<?php

namespace App\DAO;

use App\Model\MovimentacaoModel;
use App\Model\CobrancaModel;
use \PDO;

class CobrancaDAO extends DAO
{
    public function __construct()
    {
        parent::__construct();
    }

    public function insert(CobrancaModel $model)
    {
        parent::getConnection()->beginTransaction();

        foreach ($model->lista_cobrancas as $cobranca) {
            $sql = "INSERT INTO cobranca (valor_cobranca, data_cobranca, id_compra, indice) VALUE (?, ?, ?, ?)";

            $stmt = parent::getConnection()->prepare($sql);

            $stmt->bindValue(1, $cobranca->valor_cobranca);
            $stmt->bindValue(2, $cobranca->data_cobranca);
            $stmt->bindValue(3, $model->id_compra);
            $stmt->bindValue(4, $cobranca->indice);           

            $stmt->execute();
        }

        return (parent::getConnection()->commit()) ? true : null;
    }

    public function update(CobrancaModel $model)
    {
        $sql = "UPDATE cobranca SET valor = ?, data_cobranca = ?, id_compra = ?, indice = ?, status = ? WHERE id = ?";

        $stmt = parent::getConnection()->prepare($sql);
        $stmt->bindValue(1, $model->valor_cobranca);
        $stmt->bindValue(2, $model->data_cobranca);
        $stmt->bindValue(3, $model->id_compra);
        $stmt->bindValue(4, $model->indice);
        $stmt->bindValue(5, $model->status);
        $stmt->bindValue(6, $model->id);

        $stmt->execute();
    }

    public function select()
    {
        $sql = "SELECT * FROM cobranca WHERE ativo = 'S'";

        $stmt = parent::getConnection()->prepare($sql);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    public function checkCondicoesCobranca()
    {
        $sql = "SELECT p.id as id_Cobranca
        FROM cobranca p
        JOIN compra com ON com.id = p.id_pagamento        
        ;";

        $stmt = parent::getConnection()->prepare($sql);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    public function confirmCobranca($id)
    {
        $sql = "UPDATE cobranca SET status = 'CONFIRMADO' WHERE id = ?";

        $stmt = parent::getConnection()->prepare($sql);
        $stmt->bindValue(1, $id);

        $stmt->execute();


        return $this->getById($id);
    }

    public function getById(int $id)
    {
        $sql = "SELECT * FROM cobranca WHERE id = ? AND ativo = 'S'";

        $stmt = parent::getConnection()->prepare($sql);
        $stmt->bindValue(1, $id);

        $stmt->execute();

        return $stmt->fetchObject("App\Model\CobrancaModel");
    }

    public function getTotalPendenteOfCurrentMonth()
    {
        $sql = "SELECT 
                    FORMAT(sum(c.valor_cobranca), 2, 'de_DE') as total_pendente
                FROM cobranca c
                WHERE 
                    month(c.data_recebimento) = month(CURRENT_TIMESTAMP())
                AND
                    c.status = 'PENDENTE'
                AND 
                    c.ativo = 'S'    
                ";

        $stmt = parent::getConnection()->prepare($sql);       

        $stmt->execute();

        return $stmt->fetchObject();
    }

    public function getTotalPendenteOfMonth($month)
    {
        $sql = "SELECT 
                    sum(c.valor_cobranca)
                FROM cobranca c
                WHERE 
                month(c.data_recebimento) = ?
                AND
                    c.status = 'PENDENTE'
                AND c.ativo = 'S'    
                    ";

        $stmt = parent::getConnection()->prepare($sql);  
        $stmt->bindValue(1, $month);     

        $stmt->execute();

        return $stmt->fetchObject();
    }

    public function getByIdCompra(int $id)
    {
        $sql = "SELECT 
                c.id as id,
                com.valor_compra as valor_compra,
                f.descricao as fornecedor,
		        c.indice as indice,
		        c.valor_cobranca as valor_cobranca,
	            date_format(c.data_cobranca, '%d/%m/%Y') as data_cobranca,	            
                c.status as status      
        FROM cobranca c 
        JOIN compra com ON com.id = c.id_compra       
        JOIN fornecedor f ON f.id = com.id_fornecedor
        WHERE com.id = ? AND c.ativo = 'S' AND com.ativo = 'S' AND f.ativo = 'S'
        ORDER BY c.indice ASC";

        $stmt = parent::getConnection()->prepare($sql);
        $stmt->bindValue(1, $id);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    public function delete(int $id)
    {
        $sql = "UPDATE cobranca SET ativo = 'N' WHERE id = ?";

        $stmt = parent::getConnection()->prepare($sql);
        $stmt->bindValue(1, $id);

        $stmt->execute();
    }
}
