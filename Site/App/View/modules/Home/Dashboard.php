<?php
/*session_start();

if(!isset($_SESSION['user_logged'])){
    header("Location: /login"); // Redireciona para a página de login se o usuário não estiver autenticado
    exit;
}*/

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'View/includes/css_config.php' ?>
    <link rel="stylesheet" href="View/modules/Home/home.css">
    <title>Dashboard - JahuEPI</title>
    <?php include 'View/js/graphics.php' ?>
</head>

<body>
    <?php include 'View/includes/navbar.php' ?>

    <div class="main-container">
        <div class="container-card">
            <div class="header-card">
                <div class="dashboard-label">
                    <div class="head-label">
                        Saldo
                    </div>
                    <div class="body-label" id="label-saldo">
                        <p>
                            R$ <?= ($saldo->total_saldo != 0) ? $saldo->total_saldo : '0,00' ?>
                        </p>
                    </div>
                </div>
                <div class="dashboard-label">
                    <div class="head-label">
                        Total de Entradas
                    </div>
                    <div class="body-label" id="label-entrada">
                        <p>
                            R$ <?= ($entrada->total_entrada != 0) ? $entrada->total_entrada : '0,00' ?>
                        </p>
                    </div>
                </div>
                <div class="dashboard-label">
                    <div class="head-label">
                        Total de Saídas
                    </div>
                    <div class="body-label" id="label-saida">
                        <p>
                            R$ <?= ($saida->total_saida != 0) ? $saida->total_saida : '0,00' ?>
                        </p>
                    </div>
                </div>
                <div class="dashboard-label">
                    <div class="head-label">
                        Total Pendente no Mês
                    </div>
                    <div class="body-label" id="label-pendente">
                        <p>
                            R$ <?= ($pendente->total_pendente != 0) ? $pendente->total_pendente : '0,00' ?>
                        </p>
                    </div>
                </div>
            </div>
            <div class="main-card">
                <div class="graphic-bar-container">
                    <div class="text-container-label">
                        <label for="faturamneto-mes">Faturamento por Mês</label>
                    </div>

                    <div id="faturamento-mes" class="chart-style"></div>
                </div>
                <div class="graphic-pie-container">
                    <div class="text-container-label">
                        <label for="mais-vendido">Produtos mais vendidos</label>
                    </div>
                    <div id="mais-vendido"></div>
                </div>
            </div>
        </div>
    </div>



    <?php include 'View/includes/js_config.php' ?>
    <script src="View/js/src/jquery.categoria.js"></script>


</body>

</html>