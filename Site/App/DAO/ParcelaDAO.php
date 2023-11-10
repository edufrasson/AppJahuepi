<?php

namespace App\DAO;

use App\Model\MovimentacaoModel;
use App\Model\ParcelaModel;
use \PDO;

class ParcelaDAO extends DAO
{
    public function __construct()
    {
        parent::__construct();
    }

    public function insert(ParcelaModel $model)
    {
        parent::getConnection()->beginTransaction();

        foreach ($model->lista_parcelas as $parcela) {
            $sql = "INSERT INTO Parcela (valor, data_parcela, data_recebimento, id_pagamento, indice) VALUE (?, ?, ?, ?, ?)";

            $stmt = parent::getConnection()->prepare($sql);

            $stmt->bindValue(1, $parcela->valor);
            $stmt->bindValue(2, $parcela->data_parcela);
            $stmt->bindValue(3, $parcela->data_recebimento);
            $stmt->bindValue(4, $parcela->id_pagamento);
            $stmt->bindValue(5, $parcela->indice);

            $stmt->execute();
        }

        return (parent::getConnection()->commit()) ? true : null;
    }

    public function update(ParcelaModel $model)
    {
        $sql = "UPDATE Parcela SET valor=?, data_parcela=?, status = ?, id_pagamento = ? WHERE id=?";

        $stmt = parent::getConnection()->prepare($sql);
        $stmt->bindValue(1, $model->valor);
        $stmt->bindValue(2, $model->data_parcela);
        $stmt->bindValue(3, $model->status);
        $stmt->bindValue(4, $model->id_pagamento);
        $stmt->bindValue(5, $model->id);

        $stmt->execute();
    }

    public function select()
    {
        $sql = "SELECT * FROM Parcela WHERE ativo = 'S'";

        $stmt = parent::getConnection()->prepare($sql);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    public function checkCondicoesParcela()
    {
        $sql = "SELECT p.id as id_parcela
        FROM parcela p
        JOIN pagamento pgt ON pgt.id = p.id_pagamento
        WHERE 
            p.status = 'PENDENTE' AND p.ativo = 'S' AND pgt.ativo = 'S'
        AND 
            p.data_recebimento <= current_date() 
        AND 
            pgt.forma_pagamento = 'CREDITO' OR pgt.forma_pagamento = 'DEBITO' AND p.status = 'PENDENTE' AND p.data_recebimento <= current_date() AND p.ativo = 'S' AND pgt.ativo = 'S'
        OR  
            pgt.forma_pagamento = 'DINHEIRO' AND p.status = 'PENDENTE' AND p.ativo = 'S' AND pgt.ativo = 'S'
        ;";

        $stmt = parent::getConnection()->prepare($sql);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    public function confirmParcela($id)
    {
        $sql = "UPDATE Parcela SET status = 'CONFIRMADO' WHERE id = ?";

        $stmt = parent::getConnection()->prepare($sql);
        $stmt->bindValue(1, $id);

        $stmt->execute();


        return $this->getById($id);
    }

    public function getById(int $id)
    {
        $sql = "SELECT * FROM Parcela WHERE id = ? AND ativo = 'S'";

        $stmt = parent::getConnection()->prepare($sql);
        $stmt->bindValue(1, $id);

        $stmt->execute();

        return $stmt->fetchObject("App\Model\ParcelaModel");
    }

    public function getTotalPendenteOfCurrentMonth()
    {
        $sql = "SELECT 
                    FORMAT(sum(P.valor), 2, 'de_DE') as total_pendente
                FROM Parcela p
                WHERE 
                month(p.data_recebimento) = month(CURRENT_TIMESTAMP())
                AND
                    p.status = 'PENDENTE'
                AND 
                    p.ativo = 'S'    
                ";

        $stmt = parent::getConnection()->prepare($sql);       

        $stmt->execute();

        return $stmt->fetchObject();
    }

    public function getTotalPendenteOfMonth($month)
    {
        $sql = "SELECT 
                    sum(p.valor)
                FROM Parcela p
                WHERE 
                month(p.data_recebimento) = ?
                AND
                    p.status = 'PENDENTE'
                AND p.ativo = 'S'    
                    ";

        $stmt = parent::getConnection()->prepare($sql);  
        $stmt->bindValue(1, $month);     

        $stmt->execute();

        return $stmt->fetchObject();
    }

    public function getByIdVenda(int $id)
    {
        $sql = "SELECT 
                p.id as id,
                p.id as id_parcela,
                pgt.forma_pagamento as tipo_parcela,
		        p.indice as indice,
		        TRUNCATE(p.valor, 2) as valor_parcela,
	            date_format(p.data_parcela, '%d/%m/%Y') as data_parcela,
                p.data_parcela as date_parcela,
                p.data_recebimento as date_recebimento,
	            date_format(p.data_recebimento, '%d/%m/%Y') as data_recebimento,
                p.status as status      
        FROM Parcela p 
        JOIN Pagamento pgt ON pgt.id = p.id_pagamento
        JOIN Venda v ON v.id = pgt.id_venda
        WHERE v.id = ? AND p.ativo = 'S'AND pgt.ativo = 'S' AND v.ativo = 'S'
        ORDER BY p.indice ASC";

        $stmt = parent::getConnection()->prepare($sql);
        $stmt->bindValue(1, $id);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    public function delete(int $id)
    {
        $sql = "UPDATE Parcela SET ativo = 'N' WHERE id = ?";

        $stmt = parent::getConnection()->prepare($sql);
        $stmt->bindValue(1, $id);

        $stmt->execute();
    }
}
