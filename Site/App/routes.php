<?php

use App\Controller\{
    ExtratoController,
    PagamentoController,
    ParcelaController,
    VendaController,
    ProdutoController,
    ProdutoVendaController,
    LoginController,
    CategoriaProdutoController
};
use App\DAO\CategoriaProdutoDAO;

$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

switch ($url) {

    /* INDEX */

    case '/produto':
        ProdutoController::index();
        break;

    case '/login':
        LoginController::form();
        break;    

    case '/extrato':
        ExtratoController::index();
        break;

    case '/parcela':
        ParcelaController::index();
        break;

    case '/pagamento':
        PagamentoController::index();
        break;

    case '/categoria/produto':
        CategoriaProdutoController::index();
        break;

    case '/venda':
        VendaController::index();
        break;

    case '/produto/venda':
        ProdutoVendaController::index();
        break;

    /* SAVE */

    case '/produto/save':
        ProdutoController::save();
        break;

    case '/extrato/save':
        ExtratoController::save();
        break;

    case '/parcela/save':
        ParcelaController::save();
        break;

    case '/pagamento/save':
        PagamentoController::save();
        break;

    case '/categoria/produto/save':
        CategoriaProdutoController::save();
        break;

    case '/venda/save':
        VendaController::save();
        break;

    case '/produto/venda/save':
        ProdutoVendaController::save();
        break;

    /* DELETE */

    case '/produto/delete':
        ProdutoController::delete();
        break;

    case '/extrato/delete':
        ExtratoController::delete();
        break;

    case '/parcela/delete':
        ParcelaController::delete();
        break;

    case '/pagamento/delete':
        PagamentoController::delete();
        break;

    case '/categoria/produto/save/delete':
        CategoriaProdutoController::delete();
        break;

    case '/venda/delete':
        VendaController::delete();
        break;

    case '/produto/venda/delete':
        ProdutoVendaController::delete();
        break;


        /* OUTROS */
    
    case '/auth':
        LoginController::auth();
        break;   

    default:
        header('Location: /login');
        break;    
}
