<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'View/includes/css_config.php' ?>
    <link rel="stylesheet" href="View/modules/CategoriaProduto/categoria.css">
    <title>Cadastro de Categoria</title>
</head>

<body>

    <div class="content-container">
        <div class="navbar">
            <?php include 'View/includes/navbar.php' ?>
        </div>
        <div class="content">
            <div class="main-container">
                <div class="text-container">
                    <h4>Cadastro de Usuário</h4>
                </div>
                <div class="table-container">
                    <div class="button-container">
                        <button id="adicionar" class="btn" style="background-color: #f4c71e;" data-bs-toggle="modal" data-bs-target="#modalUsuario">Adicionar</button>
                    </div>

                    <div class="container-table">
                        <div class="loading-container d-flex justify-content-center">
                            <div class="spinner-border" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                        <table id="tableUsuario" class="table table-bordered table-style off">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Email</th>
                                    <th>Senha</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($model->rows !== null) : ?>
                                    <?php foreach ($model->rows as $usuario) : ?>
                                        <tr>
                                            <td><?= $usuario->id ?></td>
                                            <td><?= $usuario->email ?></td>
                                            <td><?= $usuario->senha ?></td>
                                            <td class="actions-list">
                                                <box-icon name="edit" color="#e8ac07" id="<?= $usuario->id ?>" data-bs-toggle="modal" data-bs-target="#modalUsuario" class="btn-icon btn-edit"></box-icon>
                                                <box-icon name="trash" color="#e8ac07" id="<?= $usuario->id ?>" class="btn-icon btn-delete"></box-icon>
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

    <div class="modal fade" id="modalUsuario" tabindex="-1" role="dialog" aria-labelledby="modalUsuarioTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalUsuarioTitle">Cadastrar Categoria</h5>
                    <!--<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>-->
                    </button>
                </div>
                <form method="post" >
                    <div class="modal-body">
                        <input type="hidden" name="id" id="id">
                        <label for="txtEmail">E-mail:</label>
                        <input type="email" name="email" class="form-control" id="txtEmail" required maxlength="90">
                        <label for="txtSenha">Senha:</label>
                        <input type="password" name="senha" class="form-control" id="txtSenha" required>
                        <label for="txtConfirmarSenha">Confirmar Senha:</label>
                        <input type="password" name="confSenha" class="form-control" id="txtConfirmarSenha" required>
                        <span><p class="text-danger" id="error"></p></span>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary " data-bs-dismiss="modal">Fechar</button>
                        <button type="button" class="btn" style="background-color: #f4c71e;" id="adicionarUsuario">Salvar Registro</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php include 'View/includes/js_config.php' ?>
    <script src="View/js/src/jquery.login.js"></script>


</body>
</html>