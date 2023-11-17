<?php

namespace App\Model;

use App\DAO\CategoriaProdutoDAO;
use App\DAO\ProdutoDAO;

class ProdutoModel extends Model
{
    public $id, $descricao, $preco, $codigo_barra, $id_categoria, $ativo;
    public $ano, $mes, $total_entrada, $total_saida, $saldo, $data_movimentacao;
    public $quantidade_venda, $saldo_estoque;

    public $lista_categoria, $categoria, $produtos;

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

    public function getMostSaledProduct(){
        $dao = new ProdutoDAO();

        return $dao->getMostSaledProduct();
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
    public function getByCodigo(int $codigo)
    {
        $dao = new ProdutoDAO();

        $obj = $dao->selectByCodigo($codigo);

        return ($obj) ? $obj : new ProdutoModel();
    }

    public function getCountByCodigo($codigo){
        $dao = new ProdutoDAO();

        $obj = $dao->selectCountByCodigo($codigo);

        return ($obj) ? $obj : new ProdutoModel();
    }

    public function getAllCategoria(){
        $dao = new CategoriaProdutoDAO();

        $this->lista_categoria = $dao->select();
    }

  

    public function getRelatorioOfCurrentMonth(){
        $dao = new ProdutoDAO();

        $this->rows = $dao->getRelatorioOfCurrentMonth();
    }

    public function getRelatorioByMonthAndYear($mes, $ano){
        $dao = new ProdutoDAO();

        $this->rows = $dao->getRelatorioByMonthAndYear($mes, $ano);
    }

    public function getRelatorioByYear($ano){
        
    }

    public function delete(int $id)
    {
        $dao = new ProdutoDAO();

        $dao->delete($id);
    }
}