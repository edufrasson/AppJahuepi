<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'View/includes/css_config.php' ?>
    <link rel="stylesheet" href="View/modules/Orcamento/orcamento.css">
    <title>Listagem de Orçamentos</title>
</head>

<body>

    <?php include 'View/includes/navbar.php' ?>

    <div class="main-container">
        <div class="container-card">
            <div class="header-card">
                <div class="text-container-header-card">
                    <p>Listagem de Orçamentos</p>
                </div>
            </div>
            <div class="main-card">
                <div class="containers-card">
                    <div class="container-table">
                        <div class="loading-container d-flex justify-content-center">
                            <div class="spinner-border" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                        <table id="tableOrcamentos" class="table table-bordered table-style off">
                            <thead>
                                <tr>
                                    <th>Número</th>
                                    <th>Data</th>
                                    <th>Nome do Cliente</th>
                                    <th>Valor Total</th>
                                    <th>Venda</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($model->rows !== null) : ?>
                                    <?php foreach ($model->rows as $orcamento) : ?>
                                        <tr>

                                            <td><?= $orcamento->numero ?></td>
                                            <td><?= $orcamento->data ?></td>
                                            <td><?= $orcamento->nome_cliente ?></td>
                                            <td>R$ <?= $orcamento->total_orcamento ?></td>                                            
                                            <td>
                                                <?php if ($orcamento->venda_registrada == "S") : ?>
                                                    <p  style="color: green;" >Venda Registrada</p>
                                                <?php else : ?>
                                                    <a class="btn btn-venda" style="background-color: #f4c71;" href="/venda?id_orcamento=<?= $orcamento->id ?>">Registrar Venda</a>
                                                <?php endif ?>
                                            </td>
                                            <td class="actions-list">
                                                <i class="bx bx-edit btn-icon" id="<?= $orcamento->id ?>" data-bs-toggle="modal" style="color: blue;"></i>
                                                <i class='bx bx-trash btn-icon' id="<?= $orcamento->id ?>" style="color: red;"></i>
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


    <?php include 'View/includes/js_config.php' ?>
    <script src="View/js/src/jquery.produto.js"></script>


</body>

</html>