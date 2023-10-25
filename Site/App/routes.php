<?php

use App\Controller\{
    PagamentoController,
    ParcelaController,
    VendaController,
    ProdutoController,
    ProdutoVendaController,
    LoginController,
    TaxaController,
    CategoriaProdutoController,
    DashboardController,
    MovimentacaoController
};
use App\DAO\CategoriaProdutoDAO;

$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

switch ($url) {

        /* Produto */

    case '/produto':
        ProdutoController::index();
        break;
    case '/produto/listar':
        ProdutoController::getList();
        break;
    case '/produto/save':
        ProdutoController::save();
        break;
    case '/produto/get-by-id':
        ProdutoController::getById();
        break;
    case '/produto/delete':
        ProdutoController::delete();
        break;

        /* Login*/
    case '/login':
        LoginController::form();
        break;
    case '/login/auth':
        LoginController::auth();
        break;
    case '/logout':
        LoginController::logout();
        break;
    case '/usuario':
        LoginController::index();
        break;
    case '/login/save':
        LoginController::save();
        break;

    case '/login/get-all':
        LoginController::getAll();
        break;

    case '/login/get-by-id':
        LoginController::getById();
        break;

    case '/login/delete':
        LoginController::delete();
        break;

        /* movimentacao*/
    case '/movimentacao':
        MovimentacaoController::index();
        break;
    case '/movimentacao/save':
        MovimentacaoController::save();
        break;
    case '/movimentacao/get-all':
        MovimentacaoController::getAll();
        break;
    case '/movimentacao/get-by-id':
        MovimentacaoController::getById();
        break;
    case '/movimentacao/delete':
        MovimentacaoController::delete();
        break;

        /* Parcela */

    case '/parcela':
        ParcelaController::index();
        break;
    case '/parcela/save':
        ParcelaController::save();
        break;
    case '/parcela/get-by-id':
        ParcelaController::getById();
        break;
    case '/parcela/delete':
        ParcelaController::delete();
        break;

        /* Pagamento*/

    case '/pagamento':
        PagamentoController::index();
        break;

    case '/pagamento/save':
        PagamentoController::save();
        break;

    case '/pagamento/get-by-id':
        PagamentoController::getById();
        break;
    case '/pagamento/delete':
        PagamentoController::delete();
        break;

        /* Categoria do Produto */
    case '/categoria_produto':
        CategoriaProdutoController::index();
        break;
    case '/categoria_produto/get-all':
        CategoriaProdutoController::getAll();
        break;
    case '/categoria_produto/save':
        CategoriaProdutoController::save();
        break;
    case '/categoria_produto/get-by-id':
        CategoriaProdutoController::getById();
        break;

    case '/categoria_produto/delete':
        CategoriaProdutoController::delete();
        break;

        /* Venda*/
    case '/venda':
        VendaController::index();
        break;
    case '/venda/save':
        VendaController::save();
        break;
    case '/venda/get-by-id':
        VendaController::getById();
        break;
    case '/venda/delete':
        VendaController::delete();
        break;
    case '/venda/get-produtos':
        ProdutoVendaController::getProdutos();
        break;
    case '/venda/get-parcelas':
        ParcelaController::getByIdVenda();
        break;
    case '/venda/confirm-parcelas':
        ParcelaController::getByIdVenda();
        break;
    case '/relatorio':
        VendaController::relatorio();
        break;

        /* Taxa*/
    case '/taxa':
        TaxaController::index();
        break;
    case '/taxa/save':
        TaxaController::save();
        break;
    case '/taxa/get-by-id':
        TaxaController::getById();
        break;
    case '/taxa/delete':
        TaxaController::delete();
        break;

        /* Produto_Venda*/
    case '/produto_venda':
        ProdutoVendaController::index();
        break;
    case '/produto_venda/save':
        ProdutoVendaController::save();
        break;
    case '/produto_venda/delete':
        ProdutoVendaController::delete();
        break;
    case '/produto_venda/baixa_estoque':
        ProdutoVendaController::baixaEstoque();
        break;

        /* Outros */
    case '/home':
        DashboardController::index();
        break;

    default:
        header('Location: /login');
        break;
}
