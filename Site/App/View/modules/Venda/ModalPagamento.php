<div class="modal fade" id="modalPagamento" tabindex="-1" role="dialog" aria-labelledby="modalProdutoTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="input-container">
                    <label for="forma_pagamento">Forma Pagamento:</label>
                    <select class="selectpicker" name="forma_pagamento" id="forma_pagamento">
                        <option value="">Escolha uma opção de pagamento!</option>
                        <option value="CARTAO">Cartão de Crédito</option>
                        <option value="DEBITO">Cartão de Débito</option>
                        <option value="MANUAL">Boleto Bancário</option>
                    </select>
                </div>
            </div>
            <form method="post">
                <!--
                    Modal do crédito
                -->
                <div class="modal-body modal-credito d-none" id="modal-credito">
                    <div class="input-row ">
                        <div class="input-container">
                            <label for="valor_total">Valor total (R$): </label><br>
                            <input class="form-control p-1" type="number" name="valor_total" id="valor_total">
                        </div>
                        <div class="input-container">
                            <label for="qnt_parcelas">Quantidade de parcelas: </label><br>
                            <input class="form-control p-1" type="number" name="qnt_parcelas" id="qnt_parcelas">
                        </div>
                    </div>
                    <div class="input-row d-flex justify-content-center">
                        <div class="input-container">
                            <label for="id_taxa">Taxa do cartão:</label><br>
                            <select class="selectpicker" name="taxa" id="taxa">
                                <option value="">Cadastre um produto primeiro!</option>
                                <?php foreach ($model->arr_taxas as $taxa) : ?>
                                    <option value="<?= $taxa->valor ?>"><?= $taxa->codigo ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="input-row">
                        <div class="input-container pagamento-details ">
                            <label for="valor_taxa">Valor da Taxa: </label><br>
                            <input disabled class="form-control p-1" type="number" name="valor_taxa" id="valor_taxa">
                        </div>
                        <div class="input-container pagamento-details ">
                            <label for="valor_liquido">Valor Líquido: </label><br>
                            <input disabled class="form-control p-1" type="number" name="valor_liquido" id="valor_liquido">
                        </div>
                    </div>
                    <div class="input-row">
                        <div class="input-container pagamento-details">
                            <label for="valor_bruto_parcela">Valor Bruto da Parcela: </label><br>
                            <input disabled class="form-control p-1" type="number" name="valor_bruto_parcela" id="valor_bruto_parcela">
                        </div>
                        <div class="input-container pagamento-details">
                            <label for="valor_liquido_parcela">Valor Líquido da Taxa: </label><br>
                            <input disabled class="form-control p-1" type="number" name="valor_liquido_parcela" id="valor_liquido_parcela">
                        </div>
                    </div>


                </div>
                <!--
                    Modal do débito
                -->
                <div class="modal-body modal-debito d-none" id="modal-debito">
                    <div class="input-container">
                        <label for="id_produto">Produto:</label><br>
                        <select class="selectpicker" name="id_produto" id="id_produto">
                            <option value="">Cadastre um produto primeiro!</option>
                            <?php foreach ($model->arr_produtos as $produto) : ?>
                                <option value="<?= $produto->id ?>"><?= $produto->descricao ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="input-container">
                        <label for="quantidade">Quantidade: </label><br>
                        <input class="form-control p-1" type="number" name="quantidade" id="quantidade">
                    </div>
                </div>
                <!--
                    Modal do boleto
                -->
                <div class="modal-body modal-boleto d-none" id="modal-boleto">
                    <div class="input-container">
                        <label for="id_produto">Produto:</label><br>
                        <select class="selectpicker" name="id_produto" id="id_produto">
                            <option value="">Cadastre um produto primeiro!</option>
                            <?php foreach ($model->arr_produtos as $produto) : ?>
                                <option value="<?= $produto->id ?>"><?= $produto->descricao ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="input-container">
                        <label for="quantidade">Quantidade: </label><br>
                        <input class="form-control p-1" type="number" name="quantidade" id="quantidade">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary " data-bs-dismiss="modal">Fechar</button>
                    <button type="button" class="btn" style="background-color: #f4c71e;" id="adicionarProduto">Salvar Registro</button>
                </div>
            </form>
        </div>
    </div>
</div>