<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'App/View/includes/css_config.php' ?>
    <link rel="stylesheet" href="App/View/modules/Produto/produto.css">
    <title>Cadastro de Produtos</title>
</head>

<body>

    <?php include 'App/View/includes/navbar.php' ?>

    <div class="main-container">
        <div class="container-card">
            <div class="header-card">
                <div class="text-container-header-card">
                    <p>Cadastro de Produto</p>
                </div>
            </div>
            <div class="main-card">
                <div class="containers-card buttons-container">
                    <button id="adicionar" class="btn" data-bs-toggle="modal" data-bs-target="#modalProduto">Adicionar</button>
                </div>

                <div class="containers-card">
                    <div class="container-table">
                        <div class="loading-container d-flex justify-content-center">
                            <div class="spinner-border" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                        <table id="tableCategoria" class="table table-bordered table-style off">
                            <thead>
                                <tr>
                                    <th>Descricao</th>
                                    <th>Preço</th>
                                    <th>Estoque</th>
                                    <th>Código de Barras</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($model->rows !== null) : ?>
                                    <?php foreach ($model->rows as $produto) : ?>
                                        <tr>
                                            <td><?= $produto->descricao ?></td>
                                            <td>R$ <?= $produto->valor_produto ?></td>
                                            <td><?= $produto->saldo_estoque ?></td>
                                            <td><?= $produto->codigo_barra ?></td>
                                            <td class="actions-list">
                                                <a class="text-decoration-none" href="/editar_produto?id=<?= $produto->id ?>">
                                                    <i class="bx bx-edit btn-icon" id="<?= $produto->id ?>" data-bs-toggle="modal" style="color: blue;"></i>
                                                </a>
                                                <i class='bx bx-trash btn-icon btn-delete' id="<?= $produto->id ?>" style="color: red;"></i>
                                            </td>
                                        </tr>
                                    <?php endforeach ?>
                                <?php else : ?>
                                    Nenhum registro.
                                <?php endif ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="buttons-container">
                        <!--<button id="adicionar" class="btn add-categoria" data-bs-toggle="modal"><a href="/categoria_produto">Categoria</a></button>-->
                    </div>
                </div>
            </div>
            <div class="containers-card action-container">
                <!--<div class="final-actions">
                    <button class="btn btn-warning btn-addCategoria" data-bs-toggle="modal"><a href="/categoria_produto">Adicionar Categoria</a></button>
                </div>-->
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalProduto" tabindex="-1" role="dialog" aria-labelledby="modalProdutoTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalProdutoTitle">Cadastrar Produto</h5>

                    </button>
                </div>
                <div class="form">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="id_categoria">Categoria:</label><br>
                            <select class="selectpicker" data-live-search="true" name="id_categoria" id="id_categoria">

                                <?php if ($model->lista_categoria == null) : ?>
                                    <option class="option-evento" value="">Cadastre uma categoria primeiro!</option>
                                <?php else : ?>
                                    <option class="option-evento" value="">Selecione uma categoria!</option>
                                    <?php foreach ($model->lista_categoria as $categoria) : ?>

                                        <option class="option-evento" value=<?= $categoria->id ?>><?= $categoria->descricao ?></option>
                                    <?php endforeach ?>
                                <?php endif ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <input type="hidden" name="id" id="id">
                            <label for="txtNome">Descrição:</label>
                            <input type="text" name="descricao" class="form-control" id="txtNome" required maxlength="90">
                        </div>
                        <div class="mb-3">
                            <label for="txtPreco">Preço:</label>
                            <input type="text" name="preco" class="form-control" id="txtPreco" required maxlength="90">
                        </div>
                        <div class="mb-3">
                            <label for="codigo_barra">Código de barra:</label>
                            <input type="number" name="codigo_barra" class="form-control" id="txtCodigo_Barra" required maxlength="90">
                        </div>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-fechar" data-bs-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-salvar" id="adicionarProduto">Salvar Registro</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include 'App/View/includes/js_config.php' ?>
    <script src="App/View/js/src/jquery.produto.js"></script>


</body>

</html>