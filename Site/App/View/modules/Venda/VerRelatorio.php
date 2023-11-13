<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'View/includes/css_config.php' ?>
    <link rel="stylesheet" href="View/modules/Venda/venda.css">
    <title>Relatório de Vendas</title>
</head>

<body>
    <?php include 'View/includes/navbar.php' ?>

    <div class="main-container">
        <div class="container-card">
            <div class="header-card">
                <div class="text-container-header-card">
                    <p>Relatório de Vendas</p>
                </div>
                <div class="filter-container d-flex justify-content-between mb-5">
                    <div class="select-filter-container">
                        <select class="selectpicker" name="filtro_ano" id="filtro_ano">
                            <option value="">Ano</option>
                            <option value="2023">2023</option>
                            <option value="2022">2022</option>
                            <option value="2021">2021</option>
                            <option value="2020">2020</option>
                            <option value="2019">2019</option>
                            <option value="2018">2018</option>
                            <option value="2017">2017</option>
                            <option value="2016">2016</option>
                            <option value="2015">2015</option>
                            <option value="2014">2014</option>
                        </select>

                        <select class="selectpicker" name="filtro_mes" id="filtro_mes">
                            <option value="">Mês</option>
                            <option value="1">JANEIRO</option>
                            <option value="2">FEVEREIRO</option>
                            <option value="3">MARÇO</option>
                            <option value="4">ABRIL</option>
                            <option value="5">MAIO</option>
                            <option value="6">JUNHO</option>
                            <option value="7">JULHO</option>
                            <option value="8">AGOSTO</option>
                            <option value="9">SETEMBRO</option>
                            <option value="10">OUTUBRO</option>
                            <option value="10">NOVEMBRO</option>
                            <option value="10">DEZEMBRO</option>
                        </select>
                    </div>
                    <div class="button-filter-container">
                        <button class="btn btn-filter">Filtrar </button>
                    </div>
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
                        <table id="tableVenda" class="table  table-style off">
                            <thead>
                                <tr>
                                    <th>Data da Venda</th>
                                    <th>Pagamento</th>
                                    <th>Total Bruto</th>
                                    <th>Total Líquido</th>
                                    <th>Ver Produtos</th>
                                    <th>Ver Parcelas</th>
                                    <th>Ações</th>
                                </tr>

                            </thead>
                            <tbody>
                                <?php if ($model->rows !== null) : ?>
                                    <?php foreach ($model->rows as $venda) : ?>
                                        <tr>
                                            <td><?= $venda->data_venda ?></td>
                                            <td><?= $venda->forma_pagamento ?></td>
                                            <td>R$ <?= $venda->total_bruto ?></td>
                                            <td>R$ <?= $venda->total_liquido ?></td>
                                            <td><button id="<?= $venda->id_venda ?>" class="btn open-produtos" data-bs-toggle="modal" data-bs-target="#modalProdutos">Produtos</button></td>
                                            <td><button id="<?= $venda->id_venda ?>" class="btn open-parcelas" data-bs-toggle="modal" data-bs-target="#modalParcelas">Parcelas</button></td>
                                            <td class="actions-list">
                                                <a href="/editar_venda?id=<?= $venda->id_venda ?>">
                                                    <box-icon name="edit" color="blue" id="<?= $venda->id_venda ?>" data-bs-toggle="modal" data-bs-target="#modalVenda" class="btn-icon btn-edit"></box-icon>
                                                </a>

                                                <box-icon name="trash" color="red" id="<?= $venda->id_venda ?>" class="btn-icon btn-delete"></box-icon>
                                            </td>
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
                    <h5 class="modal-title" id="modalProdutosTitle">Lista de Produtos na Venda</h5>
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
                    <h5 class="modal-title" id="modalParcelasTitle">Lista de Parcelas da Venda</h5>
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
                                        <th>Data da Parcela</th>
                                        <th>Recebimento</th>
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
    <script src="View/js/src/jquery.relatorio.js"></script>


</body>

</html>