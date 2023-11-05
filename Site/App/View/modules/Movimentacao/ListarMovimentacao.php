<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'View/includes/css_config.php' ?>
    <link rel="stylesheet" href="View/modules/Movimentacao/movimentacao.css">
    <title>Cadastro de Movimentação</title>
</head>

<body>

    <?php include 'View/includes/navbar.php' ?>

    <div class="main-container">
        <div class="container-card">
            <div class="header-card">
                <div class="text-container-header-card">
                    <p>Cadastro de Movimentação</p>
                </div>
            </div>
            <div class="main-card">
                <div class="containers-card buttons-container">
                    <button id="adicionar" class="btn" data-bs-toggle="modal" data-bs-target="#modalMovimentacao">Adicionar</button>
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
                                    <th>Descrição</th>
                                    <th>Valor</th>
                                    <th>Tipo</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($model->rows !== null) : ?>
                                    <?php foreach ($model->rows as $movimentacao) : ?>
                                        <tr>
                                            <td><?= $movimentacao->data_movimentacao ?></td>
                                            <td><?= $movimentacao->descricao ?></td>
                                            <td>R$ <?= $movimentacao->valor ?></td>
                                            <td class="tipo-movimentacao <?= ($movimentacao->valor > 0) ? "movimentacao-entrada" : "movimentacao-saida" ?>">
                                                <?= ($movimentacao->valor > 0) ? "ENTRADA" : "SAÍDA" ?>
                                            </td>
                                            <td class="actions-list">
                                                <a class="text-decoration-none" href="/editar_movimentacao?id=<?= $movimentacao->id ?>">
                                                    <i class="bx bx-edit btn-icon" id="<?= $movimentacao->id ?>" data-bs-toggle="modal" style="color: blue;"></i>
                                                </a>
                                                <i class='bx bx-trash btn-icon' id="<?= $movimentacao->id ?>" style="color: red;"></i>
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

    <div class="modal fade" id="modalMovimentacao" tabindex="-1" role="dialog" aria-labelledby="modalMovimentacaoTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalMovimentacaoTitle">Cadastrar Movimentação</h5>
                    <!--<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>-->
                    </button>
                </div>
                <form method="post" action="/movimentacao/save">
                    <div class="modal-body">
                        <input type="hidden" name="id" id="id">
                        <div class="input-container">
                            <label for="descricao">Descrição:</label>
                            <input type="text" name="descricao" class="form-control" id="descricao" required maxlength="45"><br>
                        </div>
                        <div class="input-container">
                            <label for="valor">Valor:</label>
                            <input type="number" name="valor" class="form-control" id="valor" required><br>
                        </div>
                        <div class="input-container">
                            <label for="data_movimentacao">Data da Movimentacao:</label><br>
                            <input type="date" name="data_movimentacao" class="form-control" id="data_movimentacao" required><br>
                        </div>



                        <label for="tipo">Tipo</label><br>
                        <select class="selectpicker" name="tipo" id="tipo">
                            <option value="ENTRADA">Entrada</option>
                            <option value="SAIDA">Saída</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn" style="background-color: #f4c71e;" id="adicionarMovimentacao">Salvar </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php include 'View/includes/js_config.php' ?>
    <script src="View/js/src/jquery.movimentacao.js"></script>


</body>

</html>