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

    case '/categoria_produto':
        CategoriaProdutoController::index();
        break;

    case '/venda':
        VendaController::index();
        break;

    case '/produto_venda':
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

    case '/categoria_produto/save':
        CategoriaProdutoController::save();
        break;

    case '/venda/save':
        VendaController::save();
        break;

    case '/produto_venda/save':
        ProdutoVendaController::save();
        break;


    /* GET-BY-ID */

    case '/produto/get-by-id':
        ProdutoController::getById();
        break;

    case '/extrato/get-by-id':
        ExtratoController::getById();
        break;

    case '/parcela/get-by-id':
        ParcelaController::getById();
        break;

    case '/pagamento/get-by-id':
        PagamentoController::getById();
        break;

    case '/categoria_produto/get-by-id':
        CategoriaProdutoController::getById();
        break;

    case '/venda/get-by-id':
        VendaController::getById();
        break;

    case '/categoria_produto/get-by-id':
        CategoriaProdutoController::getById();
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

    case '/categoria_produto/delete':
        CategoriaProdutoController::delete();
        break;

    case '/venda/delete':
        VendaController::delete();
        break;

    case '/produto_venda/delete':
        ProdutoVendaController::delete();
        break;


        /* OUTROS */
    
    case '/login/auth':
        LoginController::auth();
        break;   
    case '/home':
        CategoriaProdutoController::index();
        break;

    default:
        header('Location: /login');
        break;    
}
