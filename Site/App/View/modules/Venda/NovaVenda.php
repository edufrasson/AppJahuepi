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
                    <div class="input-container">
                        <label for="txtDataVenda">Data da Venda: </label><br>
                        <input class="form-control" type="date" name="data_venda" id="data_venda">
                    </div>
                    <button id="adicionar" class="btn d-flex   align-items-center" style="background-color: #f4c71e;" data-bs-toggle="modal" data-bs-target="#modalProduto">+ Produtos</button>
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
                        <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalPagamento">Método de Pagamento</button>
                    </div>
                </div>
            </div>

        </div>


    </div>


    <?php include 'View/includes/js_config.php' ?>
    <?php include 'View/modules/Venda/ModalProduto.php' ?>
    <?php include 'View/modules/Venda/ModalPagamento.php' ?>
    <script src="View/js/src/jquery.venda.js"></script>


</body>

</html>