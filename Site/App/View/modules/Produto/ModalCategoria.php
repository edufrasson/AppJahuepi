<div class="modal fade" id="modalCategoria" tabindex="-1" role="dialog" aria-labelledby="modalCategoriaTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCategoriaTitle">Cadastrar Categoria</h5>
                <!--<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>-->
                </button>
            </div>
            <form method="post" action="/categoria_produto/save">
                <div class="modal-body">
                    <input type="hidden" name="id" id="id">
                    <label for="txtNome">Descrição:</label>
                    <input type="text" name="descricao" class="form-control" id="txtNome" required maxlength="90">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn" style="background-color: #f4c71e;" id="adicionarTipo">Salvar Registro</button>
                </div>
            </form>
        </div>
    </div>
</div>