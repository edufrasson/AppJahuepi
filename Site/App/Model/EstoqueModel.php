<?php

namespace App\Model;

use App\DAO\CategoriaProdutoDAO;
use App\DAO\EstoqueDAO;
use App\DAO\ProdutoDAO;

class EstoqueModel extends Model
{
    public $id, $id_venda, $situacao, $quantidade, $id_produto, $data_registro;

    public $quantidade_venda;

    public $lista_produtos, $produto;

    public function save()
    {
        $dao = new EstoqueDAO();
        
        if(empty($this->id))        
            return $dao->insert($this);
        else
            $dao->update($this);        
    }

    public function getAllRows()
    {
        $dao = new EstoqueDAO();

        $this->rows = $dao->select();
    }   

    public function getAll(){
        $dao = new EstoqueDAO();

        return $dao->select();
    }

    public function getById(int $id)
    {
        $dao = new EstoqueDAO();

        $obj = $dao->selectById($id);

        return ($obj) ? $obj : new EstoqueModel();
    }

    public function getAllProduto(){
        $dao = new ProdutoDAO();

        $this->lista_produtos = $dao->select();
    }

    public function delete(int $id)
    {
        $dao = new EstoqueDAO();

        $dao->delete($id);
    }
}