<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="View/modules/Movimentacao/edit.css">

    <?php include 'View/includes/css_config.php' ?>
    <title>Movimentações - Gestão</title>
</head>

<body>
    <?php include 'View/includes/navbar.php' ?>

    <div class="main-container">
        <div class="container-card">
            <div class="header-card mb-5">
                <div class="text-container-header-card">
                    <p>Editar Movimentação</p>
                </div>
            </div>
            <div class="main-card">
                <div class="form-edit-container">
                    <form class="form form-edit" action="/movimentacao/save" method="POST">
                        <input type="hidden" name="id" id="id" value="<?= $dados->id ?>">
                        <div class="mb-5 d-flex justify-content-around">
                            <div class="input-container-edit">
                                <label for="descricao">Descrição:</label>
                                <input type="text" name="descricao" value="<?= $dados->descricao ?>" class="form-control" id="descricao" required maxlength="90">
                            </div>

                            <div class="input-container-edit">
                                <label for="valor">Valor:</label><br>
                                <input class="form-control" value="<?= abs($dados->valor) ?>" type="number" min="0" name="valor" id="valor">
                            </div>
                        </div>
                        <div class="mb-5 d-flex justify-content-around">

                            <div class="input-container-edit">
                                <label for="data_registro">Data do Registro:</label><br>
                                <input size="50" class="form-control" type="date" value="<?= $dados->data_movimentacao ?>" name="data_movimentacao" id="data_movimentacao" value="<?= date('Y-m-d') ?>">
                            </div>
                            <div class="input-container-edit">
                                <label for="tipo">Tipo de movimentação: </label><br>
                                <select class="selectpicker" data-style="border border-secondary" data-width="300px"name="tipo" id="tipo">
                                    <option value="ENTRADA" <?= ($dados->valor > 0) ? "selected" : "" ?>>Entrada</option>
                                    <option value="SAIDA" <?= ($dados->valor < 0) ? "selected" : "" ?>>Saída</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 d-flex justify-content-around">
                                              
                        </div>
                        <div class="m-5 button-container d-flex justify-content-center">
                            <button class="btn btn-warning" type="submit">Salvar</button>
                        </div>
                    </form>
                </div>


            </div>

        </div>

    </div>


    <?php include 'View/includes/js_config.php' ?>
    <script src="View/js/src/jquery.movimentacao.js"></script>
</body>

</html>