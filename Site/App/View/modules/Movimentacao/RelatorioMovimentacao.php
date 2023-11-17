<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'App/View/includes/css_config.php' ?>
    <link rel="stylesheet" href="App/View/modules/Movimentacao/movimentacao.css">
    <title>Relatório de Movimentação</title>
</head>

<body>

    <?php include 'App/View/includes/navbar.php' ?>

    <div class="main-container">
        <div class="container-card">
            <div class="header-card">
                <div class="text-container-header-card">
                    <p>Relatório de Movimentação</p>
                </div>
                <div class="filter-container d-flex justify-content-between mb-5">
                    <div class="select-filter-container">
                        <select class="selectpicker filtro_ano" name="filtro_ano" id="filtro_ano">
                            <option value="">Ano</option>
                            <option value="2023" <?= (isset($ano) && $ano == 2023) ? 'selected' : '' ?>>2023</option>
                            <option value="2022" <?= (isset($ano) && $ano == 2022) ? 'selected' : '' ?>>2022</option>
                            <option value="2021" <?= (isset($ano) && $ano == 2021) ? 'selected' : '' ?>>2021</option>
                            <option value="2020" <?= (isset($ano) && $ano == 2020) ? 'selected' : '' ?>>2020</option>
                            <option value="2019" <?= (isset($ano) && $ano == 2019) ? 'selected' : '' ?>>2019</option>
                            <option value="2018" <?= (isset($ano) && $ano == 2018) ? 'selected' : '' ?>>2018</option>
                            <option value="2017" <?= (isset($ano) && $ano == 2017) ? 'selected' : '' ?>>2017</option>
                            <option value="2016" <?= (isset($ano) && $ano == 2016) ? 'selected' : '' ?>>2016</option>
                            <option value="2015" <?= (isset($ano) && $ano == 2015) ? 'selected' : '' ?>>2015</option>
                            <option value="2014" <?= (isset($ano) && $ano == 2014) ? 'selected' : '' ?>>2014</option>
                        </select>

                        <select class="selectpicker" name="filtro_mes" id="filtro_mes">
                            <option value="">Mês</option>
                            <option value="1" <?= (isset($mes) && $mes == 1) ? 'selected' : '' ?>>JANEIRO</option>
                            <option value="2" <?= (isset($mes) && $mes == 2) ? 'selected' : '' ?>>FEVEREIRO</option>
                            <option value="3" <?= (isset($mes) && $mes == 3) ? 'selected' : '' ?>>MARÇO</option>
                            <option value="4" <?= (isset($mes) && $mes == 4) ? 'selected' : '' ?>>ABRIL</option>
                            <option value="5" <?= (isset($mes) && $mes == 5) ? 'selected' : '' ?>>MAIO</option>
                            <option value="6" <?= (isset($mes) && $mes == 6) ? 'selected' : '' ?>>JUNHO</option>
                            <option value="7" <?= (isset($mes) && $mes == 7) ? 'selected' : '' ?>>JULHO</option>
                            <option value="8" <?= (isset($mes) && $mes == 8) ? 'selected' : '' ?>>AGOSTO</option>
                            <option value="9" <?= (isset($mes) && $mes == 9) ? 'selected' : '' ?>>SETEMBRO</option>
                            <option value="10" <?= (isset($mes) && $mes == 10) ? 'selected' : '' ?>>OUTUBRO</option>
                            <option value="11" <?= (isset($mes) && $mes == 11) ? 'selected' : '' ?>>NOVEMBRO</option>
                            <option value="12" <?= (isset($mes) && $mes == 12) ? 'selected' : '' ?>>DEZEMBRO</option>
                        </select>
                    </div>
                    <div class="button-filter-container">
                        <a href="#" class="btn btn-filter" id="btnFiltrar">Filtrar </a>
                    </div>
                </div>
            </div>
            <div class="main-card mt-5">

                <div class="containers-card">
                    <div class="container-table">
                        <div class="loading-container d-flex justify-content-center">
                            <div class="spinner-border" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                        <table id="tableMovimentacao" class="table table-bordered table-style off">
                            <thead>
                                <tr>
                                    <th>Ano</th>                                    
                                    <th>Mês</th>                                    
                                    <th>Total Entrada</th>
                                    <th>Total saída</th>
                                    <th>Lucro</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($model !== null) : ?>
                                    <?php foreach ($model->rows as $movimentacao) : ?>
                                        <tr>
                                            <td ><?= $movimentacao->ano ?></td>                                            
                                            <td class="text-mes"><?= $movimentacao->mes ?></td>                                            
                                            <td class="tipo-movimentacao movimentacao-entrada">
                                                R$ <?= ($movimentacao->entrada == null) ? '00,00' : $movimentacao->entrada ?>
                                            </td>
                                            <td class="tipo-movimentacao movimentacao-saida">
                                                R$ <?= $movimentacao->saida ?>
                                            </td>
                                            <?php if ($movimentacao->saldo == null) : ?>
                                                <?php if ($movimentacao->entrada == null) : ?>
                                                    <td>R$ <?= $movimentacao->saida ?></td>
                                                <?php else : ?>
                                                    <td>R$ <?= $movimentacao->entrada ?></td>
                                                <?php endif; ?>

                                            <?php else : ?>
                                                <td>R$ <?= $movimentacao->saldo ?></td>
                                            <?php endif; ?>
                                            
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

    <?php include 'App/View/includes/js_config.php' ?>
    <script src="App/View/js/src/jquery.relatorio_mov.js"></script>


</body>

</html>