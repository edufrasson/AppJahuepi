<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'View/includes/css_config.php' ?>
    <link rel="stylesheet" href="View/modules/Venda/venda.css">
    <title>Cadastro de Vendas</title>
</head>

<body>

    <div class="content-container">
        <div class="navbar">
            <?php include 'View/includes/navbar.php' ?>
        </div>
        <div class="content">
            <div class="main-container">
                <div class="text-container d-flex justify-content-center">
                    <h4>Cadastro de Vendas</h4>
                </div>
                <div class="table-container">
                    <div class="input-container">
                        <label for="txtDataVenda">Data da Venda: </label><br>
                        <input class="form-control" type="date" name="data_venda" id="txtDataVenda">
                    </div>
                    <div class="button-container">
                        <button id="adicionar" class="btn d-flex   align-items-center" style="background-color: #f4c71e;" data-bs-toggle="modal" data-bs-target="#modalProduto"><box-icon name='plus-circle'></box-icon>&nbsp &nbsp &nbsp Produtos</button>
                    </div>

                    <div class="container-table">
                        <div class="loading-container d-flex justify-content-center">
                            <div class="spinner-border" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                        <table id="tableProduto" class="table table-bordered  off">
                            <thead>
                                <tr>
                                
                                    <th>Descricao</th>
                                    <th>Preço</th>
                                    <th>Quantidade</th>
                                    <th>Código de Barras</th>
                                    <th>Categoria</th>
                                    <th>Ações</th>
                                   
                                </tr>
                            </thead>
                            <tbody>
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
    <?php include 'View/modules/Venda/ModalProduto.php' ?>
    <script src="View/js/src/jquery.venda.js"></script>


</body>
</html>