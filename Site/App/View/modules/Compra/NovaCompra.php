<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'View/includes/css_config.php' ?>
    <link rel="stylesheet" href="View/modules/Compra/compra.css">
    <title>Cadastro de Compras</title>
</head>

<body>
    <?php include 'View/includes/navbar.php' ?>


    <div class="main-container">
        <div class="container-card">
            <div class="header-card">
                <div class="checkbox-container d-flex justify-content-start gap-2 ">
                    <input class="form-check-input mr-2" type="checkbox" id="usar_leitor">
                    <label class="form-check-label ml-2" for="usarLeitor">
                        Usar Leitor
                    </label>

                </div>
                <div class="text-container-header-card d-flex justify-content-center">
                    <h4>Cadastro de Compras</h4>
                </div>
            </div>
            <div class="main-card">
                <div class="containers-card buttons-container">
                    <form class="form-add-product" method="post">
                        <div class="input-container select-container">
                            <label for="id_fornecedor">Fornecedor:</label><br>
                            <select class="selectpicker bg-light" data-live-search="true" name="id_fornecedor" id="id_fornecedor">
                                <option value="">Selecione um fornecedor!</option>
                                <?php if ($model->lista_fornecedores == null) : ?>
                                    <option value="">Cadastre um fornecedor primeiro!</option>
                                <?php endif; ?>

                                <?php foreach ($model->lista_fornecedores as $fornecedor) : ?>
                                    <option value="<?= $fornecedor->id ?>"><?= $fornecedor->descricao ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="input-container select-container-produto">
                            <label for="id_produto">Produto:</label><br>
                            <select class="selectpicker bg-light" data-live-search="true" name="id_produto" id="id_produto">
                                <option value="">Selecione um produto!</option>
                                <?php if ($model->lista_produtos == null) : ?>
                                    <option value="">Cadastre um produto primeiro!</option>
                                <?php endif; ?>

                                <?php foreach ($model->lista_produtos as $produto) : ?>
                                    <option value="<?= $produto->id ?>"><?= $produto->descricao ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="input-container container-codigo-barra d-none">
                            <label for="codigo_barra">Código de Barra: </label><br>
                            <input class="form-control p-1" type="number" name="codigo_barra" id="codigo_barra">
                        </div>
                        <div class="input-container">
                            <label for="valor_unitario">Valor de Compra (R$): </label><br>
                            <input class="form-control p-1" type="number" name="valor_unitario" id="valor_unitario">
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
                        <button class="btn btn-pagamento" data-bs-toggle="modal" data-bs-target="#modalPagamentoCompra">Pagamento da Compra</button>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="modal fade" id="modalPagamentoCompra" tabindex="-1" role="dialog" aria-labelledby="modalPagamentoCompraTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-between">
                    <box-icon size="md" class="d-none" name='left-arrow-circle' id="botaoVoltar"></box-icon>
                    <h5 class="modal-title" id="modalPagamentoCompraTitle">Cadastrar Pagamento da Compra</h5>
                    <h5 class="modal-title title-parcelas d-none" id="modalPagamentoCompraTitle2">Ajuste de Parcelas</h5>

                </div>
                <div class="form">
                    <div class="modal-body modal-boleto " id="modal-boleto">
                        <div class="initial-values">
                            <div class="input-row input-container-value ">
                                <input class="form-control" type="hidden" name="id" id="id">
                                <div class="input-container">
                                    <label for="txtDataVenda">Data da compra: </label><br>
                                    <input class="form-control" type="date" name="data_compra" id="data_compra">
                                </div>
                                <div class="input-container">
                                    <label for="qnt_parcelas">Quantidade de parcelas: </label><br>
                                    <input class="form-control p-1" type="number" name="qnt_parcelas" id="qnt_parcelas" min="1" max="12">
                                </div>
                            </div>

                            <hr class="hr">
                            <div class="d-flex justify-content-center">
                                Detalhes
                            </div>
                            <hr class="hr">
                            <div class="input-row mb-3">
                                <div class="input-container">
                                    <label for="valor_total">Valor total (R$): </label><br>
                                    <input disabled class="form-control p-1 valor_total" type="text" name="valor_total" id="valor_total">
                                </div>
                                <div class="input-container pagamento-details">
                                    <label for="valor_parcela">Valor por Parcela (R$): </label><br>
                                    <input disabled class="form-control p-1 valor_parcela" type="text" name="valor_parcela" id="valor_parcela">
                                </div>
                            </div>
                        </div>
                        <div class="ajustes-parcela d-none">
                            <div class="container-parcelas">

                            </div>
                        </div>

                    </div>


                    <div class="modal-footer d-flex justify-content-between">
                        <button type="button" class="btn btn-fechar" data-bs-dismiss="modal">Fechar</button>
                        <button type="button" class="btn btn-salvar" id="ajustarParcelas">Ajustar Parcelas</button>
                        <button type="button " class="btn d-none" style="background-color: #f4c71e;" id="adicionarCompra">Salvar Registro</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include 'View/includes/js_config.php' ?>

    <script src="View/js/src/jquery.compra.js"></script>
</body>

</html>