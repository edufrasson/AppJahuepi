<div class="modal fade" id="modalProduto" tabindex="-1" role="dialog" aria-labelledby="modalProdutoTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalProdutoTitle">Cadastrar Categoria</h5>
                <!--<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>-->
                </button>
            </div>
            <form method="post">
                <div class="modal-body">
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
                        <input class="form-control p-1"type="number" name="quantidade" id="quantidade">
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