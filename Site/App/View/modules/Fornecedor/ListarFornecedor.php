<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'View/includes/css_config.php' ?>
    <link rel="stylesheet" href="View/modules/Fornecedor/fornecedor.css">
    <title>Cadastro de Fornecedor</title>
</head>

<body>
    <?php include 'View/includes/navbar.php' ?>

    <div class="main-container">
        <div class="container-card">
            <div class="header-card">
                <div class="text-container-header-card">
                    <p>Cadastro de Fornecedor</p>
                </div>
            </div>
            <div class="main-card">
                <div class="containers-card buttons-container">
                    <button id="adicionar" class="btn" data-bs-toggle="modal" data-bs-target="#modalFornecedor">Adicionar</button>
                </div>
                <div class="containers-card">
                    <div class="container-table">
                        <div class="loading-container d-flex justify-content-center">
                            <div class="spinner-border" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                        <table id="tableFornecedor" class="table  table-bordered table-style off">
                            <thead>
                                <tr>                                    
                                    <th>Descricao</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($model->rows !== null) : ?>
                                    <?php foreach ($model->rows as $fornecedor) : ?>
                                        <tr>                                            
                                            <td><?= $fornecedor->descricao ?></td>
                                            <td class="actions-list">
                                                <i class="bx bx-edit btn-edit btn-icon" id="<?= $fornecedor->id ?>" data-bs-toggle="modal" data-bs-target="#modalFornecedor" style="color: blue;"></i>
                                                <i class='bx bx-trash btn-delete btn-icon' id="<?= $fornecedor->id ?>" style="color: red;"></i>
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


    <div class="modal fade" id="modalFornecedor" tabindex="-1" role="dialog" aria-labelledby="modalFornecedorTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalFornecedorTitle">Cadastrar Fornecedor</h5>
                    <!--<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>-->
                    </button>
                </div>
                <form method="post" action="/fornecedor/save">
                    <div class="modal-body">
                        <input type="hidden" name="id" id="id">
                        <label for="txtNome">Descrição:</label>
                        <input type="text" name="descricao" class="form-control" id="txtNome" required maxlength="90">
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
    <script src="View/js/src/jquery.fornecedor.js"></script>


</body>

</html>