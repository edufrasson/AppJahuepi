<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'View/includes/css_config.php' ?>
    <link rel="stylesheet" href="View/modules/Compra/compra.css">
    <title>Relatório de Compras</title>
</head>

<body>
    <?php include 'View/includes/navbar.php' ?>

    <div class="main-container">
        <div class="container-card">
            <div class="header-card">
                <div class="text-container-header-card">
                    <p>Relatório de Compras</p>
                </div>
            </div>
            <div class="main-card">
                <div class="containers-card">
                    <div class="container-table">
                        <div class="loading-container d-flex justify-content-center">
                            <div class="spinner-border" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                        <table id="tableCompra" class="table  table-style off">
                            <thead>
                                <tr>
                                    <th>Data</th>  
                                    <th>Fornecedor da Compra</th>                                
                                    <th>Total da Dívida</th>                                    
                                    <th>Ver Produtos</th>
                                    <th>Ver Parcelas</th>
                                    <!--<th>Ações</th>-->
                                </tr>
             
                            </thead>
                            <tbody>
                                <?php if ($model->rows !== null) : ?>
                                    <?php foreach ($model->rows as $compra) : ?>
                                        <tr>
                                            <td><?= $compra->data ?></td>                                           
                                            <td><?= $compra->fornecedor ?></td>
                                            <td>R$ <?= $compra->total_compra ?></td>
                                            <td><button id="<?= $compra->id ?>" class="btn open-produtos" data-bs-toggle="modal" data-bs-target="#modalProdutos">Produtos</button></td>
                                            <td><button id="<?= $compra->id ?>" class="btn open-parcelas" data-bs-toggle="modal" data-bs-target="#modalParcelas">Parcelas</button></td>
                                            <!--<td class="actions-list">
                                                <box-icon name="edit" color="blue" id="<?= $compra->id ?>" data-bs-toggle="modal" data-bs-target="#modalCompra" class="btn-icon btn-edit"></box-icon>
                                                <box-icon name="trash" color="red" id="<?= $compra->id ?>" class="btn-icon btn-delete"></box-icon>
                                            </td>-->
                                        </tr>
                                    <?php endforeach ?>
                                <?php else : ?>
                                    Nenhum registro.
                                <?php endif ?>
                            </tbody>
                        </table>
                    </div>

                </div>

                <div class="containers-card action-table-container">

                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Produtos  -->
    <div class="modal fade" id="modalProdutos" tabindex="-1" role="dialog" aria-labelledby="modalProdutosTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalProdutosTitle">Lista de Produtos na Compra</h5>
                    <!--<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>-->
                    </button>
                </div>
                <form method="post">
                    <div class="modal-body">
                        <div class="table-container">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Descrição</th>
                                        <th>Valor Unitário</th>
                                        <th>Quantidade</th>
                                    </tr>
                                </thead>
                                <tbody id="tableProdutos">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal de Parcelas  -->
    <div class="modal fade" id="modalParcelas" tabindex="-1" role="dialog" aria-labelledby="modalParcelasTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalParcelasTitle">Lista de Cobranças da Compra</h5>
                    <!--<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>-->
                    </button>
                </div>
                <form method="post">
                    <div class="modal-body">
                        <div class="table-container">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Índice</th>
                                        <th>Valor (R$)</th>
                                        <th>Data da Cobrança</th>                                        
                                        <th>Status</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody id="tableParcelas">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php include 'View/includes/js_config.php' ?>
    <script src="View/js/src/jquery.cobranca.js"></script>


</body>

</html>