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

    <div class="body-container">
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

                            <div class="input-container select-container">
                                <label for="id_produto">Produto:</label><br>
                                <select class="selectpicker bg-light" data-live-search="true" name="id_produto" id="id_produto">
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
                                        <?php if (!isset($dados)) : ?>
                                            <th>Ações</th>
                                        <?php endif; ?>
                                    </tr>
                                </thead>
                                <tbody class="tbody-produto">
                                    <?php if (isset($dados)) : ?>
                                        <?php foreach ($dados as $item) : ?>
                                            <tr>
                                                <td><?= $item->descricao ?></td>
                                                <td><?= $item->preco ?></td>
                                                <td><?= $item->quantidade ?></td>
                                                <td><?= $item->codigo_barra ?></td>                                                
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        <input type="hidden" name="id_orcamento" id="id_orcamento" value='<?= (isset($dados)) ? $dados[0]->id_orcamento  : "" ?>'>

                    </div>
                    <div class="containers-card action-container d-flex justify-content-between">
                        <div class="final-actions">
                            <button class="btn btn-pagamento" data-bs-toggle="modal" data-bs-target="#modalPagamento">Método de Pagamento</button>
                        </div>
                        <div class="final-actions">
                            <button class="btn btn-pagamento btn-orcamento" data-bs-toggle="modal" data-bs-target="#modalOrcamento">Gerar Orçamento</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>


    <div class="modal fade" id="modalOrcamento" tabindex="-1" role="dialog" aria-labelledby="modalOrcamentoTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalOrcamentoTitle">Gerar Orçamento</h5>
                    <!--<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>-->
                    </button>
                </div>
                <form method="post" action="/template">
                    <div class="modal-body modal-orcamento " id="modal-orcamento">
                        <div class="input-row input-container-value">
                            <div class="input-container">
                                <label for="nome_cliente">Nome do Cliente: </label><br>
                                <input class="form-control" type="text" name="nome_cliente" id="nome_cliente">
                            </div>
                            <div class="input-container">
                                <label for="numero">Número do Orçamento: </label><br>
                                <input class="form-control p-1" type="number" name="numero" id="numero">
                            </div>
                        </div>

                        <div class="input-row-hidden">
                            <input class="form-control p-1" type="hidden" name="arr_produtos" id="arr_produtos">
                            <input class="form-control p-1" type="hidden" name="valor_total" id="valor_total">
                            <input class="form-control p-1" type="hidden" name="valor_total_formatado" id="valor_total_formatado">
                            <input class="form-control p-1" type="hidden" name="data_dia" id="data_dia">

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn" style="background-color: #f4c71e;" id="gerarPDF">Gerar PDF</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php include 'View/includes/js_config.php' ?>
    <?php include 'View/modules/Venda/ModalPagamento.php' ?>
    <script src="View/js/src/jquery.venda.js"></script>
    <script src="View/js/plugin/gerarOrcamento.js"></script>

</body>

</html>