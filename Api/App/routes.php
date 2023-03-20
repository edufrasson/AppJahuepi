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

$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

switch ($url) {
    case '/produto':
        ProdutoController::index();
        break;

    case '/extrato':
        ExtratoController::index();
        break;

    case '/parcela':
        ParcelaController::index();
        break;

    case '/auth':
        LoginController::auth();
        break;   
}
