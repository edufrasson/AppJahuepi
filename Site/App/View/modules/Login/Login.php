<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="View/modules/Login/login.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'View/includes/css_config.php' ?>
    <title>Login - Gestão Jahuepi</title>
</head>

<body>
    <main class="container">
        <section class="image-container">
            <img src="View/assets/logo.png" id="imgLogo" alt="logo-Jahuepi">
        </section>
        <section class="input-container">
            <form class="form" action="/login/auth" method="POST">
                <label for="email">Endereço de E-mail:</label><br>
                <input type="email" class="form-control" name="email" id="email"><br>

                <label for="senha">Senha de Acesso:</label>
                <div class="input-password">
                    <input type="password" class="form-control" name="senha" id="senha">
                    <box-icon name='show' id="verSenha"></box-icon>
                </div>

                <div class="action-pass">
                    <a href="">Esqueceu a senha?</a>                 
                </div>

                <section class="btn-container">
                    <button type="submit" class="btn btn-warning">Entrar</button>
                </section>
            </form>
        </section>
    </main>

    <?php include 'View/includes/js_config.php' ?>
    <script src="View/js/src/jquery.login.js"></script>
</body>

</html>