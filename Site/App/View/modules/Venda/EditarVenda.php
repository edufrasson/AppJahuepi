<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="View/modules/Venda/edit.css">

    <?php include 'View/includes/css_config.php' ?>
    <title>Venda - Gestão</title>
</head>

<body>
    <?php include 'View/includes/navbar.php' ?>

    <div class="main-container">
        <div class="container-card">
            <div class="header-card mb-5">
                <div class="text-container-header-card">
                    <p>Editar Venda</p>
                </div>
            </div>
            <div class="main-card">
                <div class="form-edit-container">
                    <div class="form form-edit">
                        <div class="venda-details">
                            <hr class="hr">
                            <h5 class="d-flex justify-content-center">Venda</h6>
                                <hr class="hr">
                                <div class="venda-details-container d-flex justify-content-around">
                                    <div class="input-row">
                                        <input type="hidden" name="id_pagamento" id="id_pagamento" value="<?= $dados->id_pagamento ?>">
                                        <input type="hidden" name="id_venda" id="id_venda" value="<?= $dados->id_venda ?>">
                                        <input type="hidden" name="taxa" id="taxa" value="<?= $dados->taxa ?>">
                                        <div class="input-container">
                                            <label for="data_venda">Data da venda</label>
                                            <input class="form-control" type="date" name="data_venda" id="data_venda" value="<?= $dados->data_da_venda ?>">
                                        </div>
                                        <div class="input-container">
                                            <label for="valor_total">Valor Total</label>
                                            <input class="form-control" type="number" name="valor_total" id="valor_total" value="<?= $dados->valor_total ?>">
                                        </div>
                                        <div class="input-container">
                                            <label for="taxa_formatada">Valor Total</label>
                                            <input class="form-control" type="number" name="taxa_formatada" step="0.01" id="taxa_formatada" value="<?= $dados->taxa * 100?> ">
                                        </div>
                                        <div class="input-container">
                                            <label for="valor_liquido">Valor Líquido</label>
                                            <input class="form-control" type="number" name="valor_liquido" id="valor_liquido" value="<?= $dados->valor_liquido ?>">
                                        </div>
                                        <div class="input-container">
                                            <label for="qnt_parcela">Quantidade de Parcelas</label>
                                            <input class="form-control" type="number" name="qnt_parcela" id="qnt_parcela" value="<?= $dados->parcelas ?>">
                                        </div>
                                    </div>
                                </div>
                        </div>
                        <div class="produto-details">
                            <hr class="hr" />
                            <h5 class="d-flex justify-content-center">Produtos</h6>
                                <hr class="hr" />
                                <div class="produto-details-container">
                                    <div class="buttons-container mb-3">
                                        <button class="btn open-produtos text-bold" type="button" data-bs-toggle="modal" data-bs-target="#modalProduto"><strong>Adicionar Produto</strong></button>
                                    </div>
                                    <table id="tableProduto" class="table-produto table table-bordered ">
                                        <thead class="thead-produto">
                                            <tr>
                                                <th>Descricao</th>
                                                <th>Preço</th>
                                                <th>Quantidade</th>
                                                <th>Código de Barras</th>
                                                <th>Ações</th>
                                            </tr>
                                        </thead>
                                        <tbody class="tbody-produto">
                                            <?php if (isset($dados->lista_produtos)) : ?>
                                                <?php foreach ($dados->lista_produtos as $item) : ?>
                                                    <tr>
                                                        <td><?= $item->descricao ?></td>
                                                        <td><?= $item->preco ?></td>
                                                        <td><?= $item->quantidade ?></td>
                                                        <td><?= $item->codigo_barra ?></td>
                                                        <td class="actions-list-venda d-flex justify-content-center">
                                                            <box-icon name="trash" color="#e8ac07" id="<?= $item->id_produto ?>" class="btn-icon btn-delete-list"></box-icon>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                        </div>
                        <div class="parcela-details">
                            <hr class="hr" />
                            <h5 class="d-flex justify-content-center">Parcelas</h6>
                                <hr class="hr" />
                                <div class="parcela-details-container">
                                    <?php if (isset($dados->lista_parcelas)) : ?>
                                        <?php foreach ($dados->lista_parcelas as $parcela) : ?>
                                            <div class="row-parcelas mb-5">
                                                <div class="label-parcela-container d-flex align-items-center">
                                                    <h5>Parcela nº <?= $parcela->indice ?></h5><br>
                                                </div><br>
                                                <div class="info-container d-flex justify-content-around">
                                                    <div class="input-container">
                                                        <label for="valor_parcela">Valor da Parcela</label>
                                                        <input disabled class="form-control" type="number" name="valor_parcela" id="valor_parcela" value="<?= $parcela->valor_parcela ?>">
                                                    </div>
                                                    <div class="input-container">
                                                        <label for="data_parcela<?= $parcela->indice ?>">Data da Parcela</label>
                                                        <input disabled class="form-control" type="date" name="data_parcela" id="data_parcela" value="<?= $parcela->date_parcela ?>">
                                                    </div>
                                                    <div class="input-container">
                                                        <label for="data_recebimento">Data do Recebimento</label>
                                                        <input class="form-control" type="date" name="data_recebimento" id="data_recebimento" value="<?= $parcela->date_recebimento ?>">
                                                    </div>
                                                    <div class="input-container">
                                                        <label for="status">Status da Parcela</label><br>
                                                        <select class="selectpicker" name="stauts" id="status">
                                                            <option value="CONFIRMADO" <?= ($parcela->status == "CONFIRMADO") ? "selected" : "" ?>>Confirmado</option>
                                                            <option value="PENDENTE" <?= ($parcela->status == "PENDENTE") ? "selected" : "" ?>>Pendente</option>
                                                            <option value="ATRASO" <?= ($parcela->status == "ATRASO") ? "selected" : "" ?>>Atraso</option>
                                                        </select>
                                                    </div>
                                                </div>

                                            </div>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                        </div>
                        <hr class="hr" />
                        <div class="m-5 button-container d-flex justify-content-center">
                            <button class="btn btn-warning" type="submit">Salvar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalProduto" tabindex="-1" role="dialog" aria-labelledby="modalProdutoTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalProdutoTitle">Adicionar Produto</h5>
                </div>
                <form class="form-add-product p-3" method="post">
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
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary " data-bs-dismiss="modal">Fechar</button>

                    <button type="button" class="btn" style="background-color: #f4c71e;" id="adicionarProduto">Adicionar</button>

                </div>
            </div>
        </div>
    </div>


    <?php include 'View/includes/js_config.php' ?>
    <script src="View/js/src/jquery.edit_venda.js"></script>
</body>

</html>