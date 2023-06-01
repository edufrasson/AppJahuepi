<?php

namespace App\Model;

use App\DAO\CategoriaProdutoDAO;
use App\DAO\ProdutoDAO;

class ProdutoModel extends Model
{
    public $id, $descricao, $preco, $codigo_barra, $quantidade, $id_categoria;
<<<<<<< HEAD
=======
    public $quantidade_venda;
>>>>>>> 980f975eba9515fabd51a0c2ef08c285ee745f2e
    public $lista_categoria;

    public function save()
    {
        $dao = new ProdutoDAO();
        
        if(empty($this->id))        
            $dao->insert($this);
        else
            $dao->update($this);
        
    }

    public function getAllRows()
    {
        $dao = new ProdutoDAO();

        $this->rows = $dao->select();
    }

    public function getAll(){
        $dao = new ProdutoDAO();

        return $dao->select();
    }

    public function getById(int $id)
    {
        $dao = new ProdutoDAO();

        $obj = $dao->selectById($id);

        return ($obj) ? $obj : new ProdutoModel();
    }

    public function getAllCategoria(){
        $dao = new CategoriaProdutoDAO();

        $this->lista_categoria = $dao->select();
    }

    public function delete(int $id)
    {
        $dao = new ProdutoDAO();

        $dao->delete($id);
    }
}