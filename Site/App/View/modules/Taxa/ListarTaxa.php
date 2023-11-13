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
                                    <th>Bandeira</th>
                                    <th>Valor no Crédito</th>
                                    <th>Valor no Débito</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($model->rows !== null) : ?>
                                    <?php foreach ($model->rows as $taxa) : ?>
                                        <tr>
                                            <td><?= $taxa->bandeira ?></td>
                                            <td><?= $taxa->valor_credito * 100 ?>%</td>
                                            <td><?= $taxa->valor_debito * 100 ?>%</td>
                                            <td class="actions-list">
                                                <i class="bx bx-edit btn-icon btn-edit" id="<?= $taxa->id ?>" data-bs-toggle="modal" data-bs-target="#modalTaxa" style="color: blue;"></i>
                                                <i class='bx bx-trash btn-icon btn-delete' id="<?= $taxa->id ?>" style="color: red;"></i>
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
                            <label for="bandeira">Bandeira:</label>
                            <input type="text" name="bandeira" class="form-control" id="bandeira" required maxlength="90">
                        </div>
                        <div class="mb-3">
                            <label for="valor_credito">Valor no Crédito(em %):</label>
                            <input type="number" name="valor_credito" class="form-control" id="valor_credito" step="0.01" required maxlength="90">
                        </div>
                        <div class="mb-3">
                            <label for="valor_debito">Valor no Débito(em %):</label>
                            <input type="number" name="valor_debito" class="form-control" id="valor_debito" step="0.01" required maxlength="90">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-fechar" data-bs-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-salvar" id="adicionarTipo">Salvar Registro</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php include 'View/includes/js_config.php' ?>
    <script src="View/js/src/jquery.taxa.js"></script>


</body>

</html>