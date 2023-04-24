<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'View/includes/css_config.php' ?>
    <link rel="stylesheet" href="View/modules/Extrato/extrato.css">
    <title>Cadastro de Extrato</title>
</head>
<body>
    
    <div class="content-container">
        <div class="navbar">
            <?php include 'View/includes/navbar.php' ?>
        </div>
        <div class="content">
            <div class="main-container">
                <div class="text-container">
                    <h4>Cadastro de Extrato</h4>
                </div>
                <div class="table-container">
                    <div class="button-container">
                        <button id="adicionar" class="btn" style="background-color: #f4c71e;" data-bs-toggle="modal" data-bs-target="#modalExtrato">Adicionar</button>
                    </div>

                    <div class="container-table">
                        <div class="loading-container d-flex justify-content-center">
                            <div class="spinner-border" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                        <table id="tableExtrato" class="table table-bordered table-style">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Valor</th>
                                    <th>Data</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($model->rows !== null) : ?>
                                    <?php foreach ($model->rows as $extrato) : ?>
                                        <tr>
                                            <td><?= $extrato->id ?></td>
                                            <td><?= $extrato->valor ?></td>
                                            <td><?= $extrato->data_extrato ?></td>
                                            <td class="actions-list">
                                                <box-icon name="edit" color="#e8ac07" id="<?=$extrato->id?>"data-bs-toggle="modal" data-bs-target="#modalExtrato" class="btn-icon btn-edit"></box-icon>
                                                <box-icon name="trash" color="#e8ac07" id="<?=$extrato->id?>" class="btn-icon btn-delete"></box-icon>
                                            </td>
                                        </tr>
                                    <?php endforeach ?>
                                <?php else : ?>
                                    Nenhum registro.
                                <?php endif ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalExtrato" tabindex="-1" role="dialog" aria-labelledby="modalExtratoTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalExtratoTitle">Cadastrar Extrato</h5>
                    <!--<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>-->
                    </button>
                </div>
                <form method="post" action="/extrato/save">
                    <div class="modal-body">
                        <input type="hidden" name="id" id="id">
                        <label for="txtValor">Valor:</label>
                        <input type="number" name="valor" class="form-control" id="txtValor" required>
                        <label for="txtData">Data extrato:</label>
                        <input type="date" name="data_extrato" class="form-control" id="txtData" required>
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
    <script src="View/js/src/jquery.extrato.js"></script>


</body>
</html>