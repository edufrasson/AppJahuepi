<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'App/View/includes/css_config.php' ?>
    <link rel="stylesheet" href="App/View/modules/Movimentacao/movimentacao.css">
    <title>Relatório de Movimentação</title>
</head>

<body>

    <?php include 'App/View/includes/navbar.php' ?>

    <div class="main-container">
        <div class="container-card">
            <div class="header-card">
                <div class="text-container-header-card">
                    <p>Relatório de Movimentação</p>
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
                                <?php if ($model_entrada !== null && $model_saida !== null) : ?>
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
  
    <?php include 'App/View/includes/js_config.php' ?>
    <script src="App/View/js/src/jquery.movimentacao.js"></script>


</body>

</html>