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
    <link rel="stylesheet" href="View/modules/CategoriaProduto/categoria.css">
    <title>Dashboard - JahuEPI</title>
</head>

<body>
    <?php include 'View/includes/navbar.php' ?>

    <div class="main-container">
        <div class="container-card">
            <div class="header-card">
                <div class="text-container-header-card">
                    <p>Dashboard </p>
                </div>
            </div>
            <div class="main-card">
                
            </div>
        </div>
    </div>


    
    <?php include 'View/includes/js_config.php' ?>
    <script src="View/js/src/jquery.categoria.js"></script>


</body>

</html>