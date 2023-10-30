<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'View/includes/css_config.php' ?>
    <link rel="stylesheet" href="View/modules/Produto/produto.css">
    <title>Cadastro de Produtos</title>
</head>

<body>

    <?php include 'View/includes/navbar.php' ?>

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
                                    <th>Quantidade</th>
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
                                            <td><?= $produto->quantidade ?></td>
                                            <td><?= $produto->codigo_barra ?></td>
                                            <td class="actions-list">
                                                <box-icon name="edit" color="blue" id="<?= $produto->id ?>" data-bs-toggle="modal" data-bs-target="#modalProduto" class="btn-icon btn-edit"></box-icon>
                                                <box-icon name="trash" color="red" id="<?= $produto->id ?>" class="btn-icon btn-delete"></box-icon>
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
                <form method="post" action="/produto/save">
                    <div class="modal-body">
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
                            <label for="quantidade">Quantidade:</label>
                            <input type="text" name="quantidade" class="form-control" id="txtQuantidade" required maxlength="90">
                        </div>
                        <div class="mb-3">
                            <label for="codigo_barra">Código de barra:</label>
                            <input type="number" name="codigo_barra" class="form-control" id="txtCodigo_Barra" required maxlength="90">
                        </div>
                        <div class="mb-3">
                            <label for="id_categoria">Categoria:</label><br>
                            <select class="selectpicker border border-black" data-live-search="true" name="id_categoria" id="id_categoria">

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
    <script src="View/js/src/jquery.categoria.js"></script>


</body>

</html>