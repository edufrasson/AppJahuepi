<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'View/includes/css_config.php' ?>
    <link rel="stylesheet" href="View/modules/Estoque/estoque.css">
    <title>Cadastro de Estoque</title>
</head>

<body>

    <?php include 'View/includes/navbar.php' ?>

    <div class="main-container">
        <div class="container-card">
            <div class="header-card">
                <div class="text-container-header-card">
                    <p>Cadastro de Estoque</p>
                </div>
            </div>
            <div class="main-card">
                <div class="containers-card buttons-container ">
                    <button id="adicionar" class="btn" data-bs-toggle="modal" data-bs-target="#modalEstoque">Adicionar</button>
                    <button id="adicionar" class="btn relatorio" data-bs-toggle="modal" data-bs-target="#relatorioEstoque">Relatório</button>
                </div>

                <div class="containers-card">
                    <div class="container-table">
                        <div class="loading-container d-flex justify-content-center">
                            <div class="spinner-border" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                        <table id="tableMovimentacao" class="table table-bordered table-style off">
                            <thead>
                                <tr>
                                    <th>Data</th>
                                    <th>Quantidade</th>
                                    <th>Produto</th>
                                    <th>Situação</th>
                                    <th>Tipo</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($model->rows !== null) : ?>
                                    <?php foreach ($model->rows as $movimentacao) : ?>
                                        <tr>

                                            <td><?= $movimentacao->data ?></td>
                                            <td><?= $movimentacao->quantidade ?></td>
                                            <td><?= $movimentacao->produto ?></td>
                                            <td><?= $movimentacao->situacao ?></td>
                                            <td class="tipo-movimentacao <?= ($movimentacao->quantidade > 0) ? "movimentacao-entrada" : "movimentacao-saida" ?>">
                                                <?= ($movimentacao->quantidade > 0) ? "ENTRADA" : "SAÍDA" ?>
                                            </td>
                                            <td class="actions-list">
                                                <a class="text-decoration-none" href="/editar_movimentacao?id=<?= $movimentacao->id ?>">
                                                    <i class="bx bx-edit btn-icon" id="<?= $movimentacao->id ?>" data-bs-toggle="modal" style="color: blue;"></i>
                                                </a>
                                                <i class='bx bx-trash btn-icon btn-delete' id="<?= $movimentacao->id ?>" style="color: red;"></i>
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

            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEstoque" tabindex="-1" role="dialog" aria-labelledby="modalEstoqueTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEstoqueTitle">Cadastrar Estoque</h5>
                    <!--<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>-->
                    </button>
                </div>
                <form method="post" action="/estoque/save">
                    <div class="modal-body">
                        <input type="hidden" name="id" id="id">
                        <div class="input-row">
                            <div class="input-container mb-3">
                                <label for="situacao">Situação:</label><br>
                                <select class="selectpicker" name="situacao" id="situacao">
                                    <option value="">Selecione uma situação</option>                                    
                                    <option value="DEVOLUCAO">Devolução</option>
                                    <option value="REGISTRO">Registro</option>
                                </select>
                            </div>
                            <div class="imput-container mb-3">
                                <label for="id_produto">Produto:</label><br>
                                <select class="selectpicker " data-live-search="true" name="id_produto" id="id_produto">

                                    <?php if ($model->lista_produtos == null) : ?>
                                        <option class="option-produto" value="">Cadastre um produto primeiro!</option>
                                    <?php else : ?>
                                        <option class="option-produto" value="">Selecione um produto!</option>
                                        <?php foreach ($model->lista_produtos as $produto) : ?>

                                            <option class="option-produto" value=<?= $produto->id ?>><?= $produto->descricao ?></option>
                                        <?php endforeach ?>
                                    <?php endif ?>
                                </select>
                            </div>
                        </div>


                        <div class="input-container">
                            <label for="quantidade">Quantidade:</label>
                            <input type="number" name="quantidade" class="form-control" id="quantidade" required><br>
                        </div>
                        <div class="input-container">
                            <label for="data_registro">Data da Movimentacao:</label><br>
                            <input type="date" name="data_registro" class="form-control" id="data_registro" required><br>
                        </div>
                        <div class="estoque-compra input-row off">
                            <div class="input-container">
                                <label for="valor_compra">Valor da Compra (R$)</label>
                                <input class="form-control" type="number" name="valor_compra" id="valor_compra">
                            </div>
                            <div class="input-container"></div>
                        </div>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-fechar" data-bs-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-salvar" style="background-color: #f4c71e;" id="adicionarMovimentacao">Salvar </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php include 'View/includes/js_config.php' ?>
    <script src="View/js/src/jquery.estoque.js"></script>


</body>

</html>