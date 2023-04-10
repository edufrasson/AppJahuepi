<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'View/includes/css_config.php' ?>
    <title>Listar Categoria Produto</title>
</head>

<body>

    <div class="content-container">
        <div class="navbar">
            <?php include "View/includes/navbar.php" ?>
        </div>
        <div class="content">
            <div class="main-container">
                <div class="text-container">
                    <h4>Cadastro de Categoria</h4>
                </div>
                <div class="button-container">
                    <button id="adicionar" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCategoria">Adicionar</button>
                </div>

                <div class="container-table">
                    <table class="table table-bordered table-style">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Descricao</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($model->rows !== null) : ?>
                                <?php foreach ($model->rows as $categoria) : ?>
                                    <tr>
                                        <td><?= $categoria->id ?></td>
                                        <td><?= $categoria->descricao ?></td>
                                        <td class="actions-list">
                                            <box-icon name="edit" color="blue" id="<?= $categoria->id ?>" data-bs-toggle="model" data-bs-target="#modalCategoria" class="btn-icon btn-edit"></box-icon>
                                            <box-icon name="trash" color="red" id="<?= $categoria->id ?>" class="btn-icon btn-delete"></box-icon>
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
    
    <div class="modal fade" id="modalCategoria" tabindex="-1" role="dialog" aria-labelledby="modalCategoriaTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCategoriaTitle">Cadastrar Categoria</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="/categoria_produto/save">
                    <div class="modal-body">
                        <input type="hidden" name="id" id="id">
                        <label for="txtDescricao">Descrição:</label>
                        <input type="text" name="descricao" class="form-control" id="txtDescricao" required maxlength="90">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-primary" id="adicionarTipo">Salvar Registro</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <?php include 'View/includes/js_config.php' ?>

</body>

</html>