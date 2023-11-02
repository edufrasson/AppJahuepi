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
    <?php include 'View/includes/navbar.php' ?>


    <div class="main-container">
        <div class="container-card">
            <div class="header-card">
                <div class="text-container-header-card d-flex justify-content-center">
                    <h4>Cadastro de Vendas</h4>
                </div>
            </div>
            <div class="main-card">
                <div class="containers-card buttons-container">
                    <form class="form-add-product" method="post">
                        <div class="input-container">
                            <label for="txtDataVenda">Data da Venda: </label><br>
                            <input class="form-control" type="date" name="data_venda" id="data_venda">
                        </div>
                        <div class="input-container select-container">
                            <label for="id_produto">Produto:</label><br>
                            <select class="selectpicker bg-light" name="id_produto" id="id_produto">
                                <option value="">Selecione um produto!</option>
                                <?php if ($model->arr_produtos == null) : ?>
                                    <option value="">Cadastre um produto primeiro!</option>
                                <?php endif; ?>

                                <?php foreach ($model->arr_produtos as $produto) : ?>
                                    <option value="<?= $produto->id ?>"><?= $produto->descricao ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="input-container">
                            <label for="quantidade">Quantidade: </label><br>
                            <input class="form-control p-1" type="number" name="quantidade" id="quantidade">
                        </div>
                        <div class="input-container">
                            <button type="button" class="btn" style="background-color: #f4c71e;" id="adicionarProduto">Salvar Registro</button>
                        </div>
                    </form>
                </div>


                <div class="containers-card table-container">
                    <div class="container-table">
                        <table id="tableProduto" class="table-produto table table-bordered ">
                            <thead class="thead-produto">
                                <tr>
                                    <th>Descricao</th>
                                    <th>Preço</th>
                                    <th>Quantidade</th>
                                    <th>Código de Barras</th>
                                    <th>Categoria</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody class="tbody-produto">
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="containers-card action-container">
                    <div class="final-actions">
                        <button class="btn btn-pagamento" data-bs-toggle="modal" data-bs-target="#modalPagamento">Método de Pagamento</button>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <?php include 'View/includes/js_config.php' ?>
    <?php include 'View/modules/Venda/ModalPagamento.php' ?>
    <script src="View/js/src/jquery.venda.js"></script>
</body>

</html>