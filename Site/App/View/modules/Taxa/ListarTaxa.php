<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'View/includes/css_config.php' ?>
    <link rel="stylesheet" href="View/modules/CategoriaProduto/categoria.css">
    <title>Cadastro de Taxa</title>
</head>

<body>

    <?php include 'View/includes/navbar.php' ?>

    <div class="main-container">
        <div class="container-card">
            <div class="header-card">
                <div class="text-container-header-card">
                    <p>Cadastro de Taxa</p>
                </div>
            </div>
            <div class="main-card">
                <div class="containers-card buttons-container">
                    <button id="adicionar" class="btn" data-bs-toggle="modal" data-bs-target="#modalTaxa">Adicionar</button>
                </div>

                <div class="containers-card">
                    <div class="container-table">
                        <div class="loading-container d-flex justify-content-center">
                            <div class="spinner-border" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                        <table id="tableTaxa" class="table table-bordered table-style off">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Código</th>
                                    <th>Valor</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($model->rows !== null) : ?>
                                    <?php foreach ($model->rows as $Taxa) : ?>
                                        <tr>
                                            <td><?= $Taxa->id ?></td>
                                            <td><?= $Taxa->codigo ?></td>
                                            <td><?= $Taxa->valor * 100 ?>%</td>
                                            <td class="actions-list">
                                                <box-icon name="edit" color="#e8ac07" id="<?= $Taxa->id ?>" data-bs-toggle="modal" data-bs-target="#modalTaxa" class="btn-icon btn-edit-taxa"></box-icon>
                                                <box-icon name="trash" color="#e8ac07" id="<?= $Taxa->id ?>" class="btn-icon btn-delete-taxa"></box-icon>
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

    <div class="modal fade" id="modalTaxa" tabindex="-1" role="dialog" aria-labelledby="modalTaxaTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTaxaTitle">Cadastrar Taxa</h5>
                </div>
                <form method="post" action="/taxa/save">
                    <div class="modal-body">
                        <input type="hidden" name="id" id="id">
                        <div class="mb-3">
                            <label for="txtCodigo">Código:</label>
                            <input type="text" name="codigo" class="form-control" id="txtCodigo" required maxlength="90">
                        </div>
                        <div class="mb-3">
                            <label for="txtValor">Valor (em %):</label>
                            <input type="number" name="valor" class="form-control" id="txtValor" required maxlength="90">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn" style="background-color: #f4c71e;" id="adicionarTipo">Salvar Registro</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php include 'View/includes/js_config.php' ?>
    <script src="View/js/src/jquery.taxa.js"></script>


</body>

</html>