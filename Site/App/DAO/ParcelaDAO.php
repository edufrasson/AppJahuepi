<?php

namespace App\DAO;

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
            $sql = "INSERT INTO Parcela (valor, data_parcela, id_pagamento, indice) VALUE (?, ?, ?, ?)";

            $stmt = parent::getConnection()->prepare($sql);
    
            $stmt->bindValue(1, $parcela->valor);
            $stmt->bindValue(2, $parcela->data_parcela);          
            $stmt->bindValue(3, $parcela->id_pagamento);
            $stmt->bindValue(4, $parcela->indice);
    
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
        $sql = "SELECT * FROM Parcela";

        $stmt = parent::getConnection()->prepare($sql);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    public function getById(int $id)
    {
        $sql = "SELECT * FROM Parcela WHERE id = ?";

        $stmt = parent::getConnection()->prepare($sql);
        $stmt->bindValue(1, $id);

        $stmt->execute();

        return $stmt->fetchObject("App\Model\ParcelaModel");
    }

    public function getByIdVenda(int $id){
        $sql = "SELECT 
		        p.indice as indice,
		        p.valor as valor_parcela,
	            date_format(p.data_parcela, '%d/%m/%Y') as data_parcela,
                p.status as status      
        FROM Parcela p 
        JOIN Pagamento pgt ON pgt.id = p.id_pagamento
        JOIN Venda v ON v.id = pgt.id_venda
        WHERE v.id = ?
        ORDER BY p.indice ASC";

        $stmt = parent::getConnection()->prepare($sql);
        $stmt->bindValue(1, $id);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    public function delete(int $id)
    {
        $sql = "DELETE FROM Parcela WHERE id = ?";

        $stmt = parent::getConnection()->prepare($sql);
        $stmt->bindValue(1, $id);
        
        $stmt->execute();
    }
}