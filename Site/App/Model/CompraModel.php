<?php

namespace App\Model;

use App\DAO\CompraDAO;
use App\DAO\FornecedorDAO;
use App\DAO\ProdutoDAO;

class CompraModel extends Model
{
    public $id, $data_compra, $valor_compra, $qnt_parcela, $id_fornecedor;
    public $lista_produtos;
    public $lista_fornecedores;

    public function save()
    {
        $dao = new CompraDAO();
        
        if(empty($this->id))        
            return $dao->insert($this);
        else
            $dao->update($this);
        
    }

    public function getAllRows()
    {
        $dao = new CompraDAO();

        $this->rows = $dao->select();
    }
    
    public function getAllFornecedores(){
        $dao = new FornecedorDAO();

        $this->lista_fornecedores = $dao->select();
    }

    public function getAllProdutos(){
        $dao = new ProdutoDAO();

        $this->lista_produtos = $dao->select();
    }
    public function getByAno($ano){

        $dao = new CompraDAO();

        $this->rows = $dao->selectByAno($ano);
    }

    
    public function getByAnoAndMes($ano, $mes){
        
        $dao = new CompraDAO();

        $this->rows = $dao->selectByAnoAndMes($ano, $mes);
    }
    

    public function getById(int $id)
    {
        $dao = new CompraDAO();

        $obj = $dao->selectById($id);

        return ($obj) ? $obj : new CompraModel();
    }

    public function delete(int $id)
    {
        $dao = new CompraDAO();

        $dao->delete($id);
    }
}