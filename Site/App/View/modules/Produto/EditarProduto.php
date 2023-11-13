<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="View/modules/Produto/edit.css">

    <?php include 'View/includes/css_config.php' ?>
    <title>Produto - Gestão</title>
</head>

<body>
    <?php include 'View/includes/navbar.php' ?>

    <div class="main-container">
        <div class="container-card">
            <div class="header-card mb-5">
                <div class="text-container-header-card">
                    <p>Editar Produto</p>
                </div>
            </div>
            <div class="main-card">
                <div class="form-edit-container">
                    <form class="form form-edit" action="/produto/save" method="POST">
                        <input type="hidden" name="id" id="id" value="<?= $dados->id ?>">
                        <div class="mb-5 d-flex justify-content-around">
                            <div class="input-container-edit">
                                <label for="data_registro">Id:</label><br>
                                <input class="form-control" type="number" name="" id="" value="<?= $dados->id ?>" disabled>
                            </div>
                            <div class="input-container-edit">
                                <label for="descricao">Descrição:</label>
                                <input type="text" name="descricao" value="<?= $dados->descricao ?>" class="form-control" id="descricao" required maxlength="90">
                            </div>


                        </div>
                        <div class="mb-5 d-flex justify-content-around">
                            <div class="input-container-edit">
                                <label for="preco">Preço:</label><br>
                                <input class="form-control" value="<?= abs($dados->preco) ?>" type="number" min="0" name="preco" id="preco">
                            </div>                         


                        </div>
                        <div class="mb-5 d-flex justify-content-around">

                            <div class="input-container-edit">
                                <label for="codigo_barra">Código de Barras:</label><br>
                                <input class="form-control" value="<?= abs($dados->codigo_barra) ?>" type="number" min="0" name="codigo_barra" id="codigo_barra">
                            </div>
                            <div class="input-container-edit">
                                <label for="id_categoria">Categoria:</label><br>
                                <select class="selectpicker" data-style="border border-secondary" data-live-search="true" data-width="300px" name="id_categoria" id="id_categoria">
                                    <?php if ($model->lista_categoria == null) : ?>
                                        <option class="option-categoria" value="">Cadastre uma categoria primeiro!</option>
                                    <?php else : ?>
                                        <?php foreach ($model->lista_categoria as $categoria) :
                                            $selected = ($categoria->id == $dados->id_categoria) ? "selected" : "";
                                        ?>
                                            <option <?= $selected ?> class="option-categoria" value=<?= $categoria->id ?>><?= $categoria->descricao ?></option>
                                        <?php endforeach ?>
                                    <?php endif ?>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 d-flex justify-content-around">

                        </div>
                        <div class="m-5 button-container d-flex justify-content-center">
                            <button class="btn btn-salvar" type="submit">Salvar</button>
                        </div>
                    </form>
                </div>


            </div>

        </div>

    </div>


    <?php include 'View/includes/js_config.php' ?>
    <script src="View/js/src/jquery.movimentacao.js"></script>
</body>

</html>