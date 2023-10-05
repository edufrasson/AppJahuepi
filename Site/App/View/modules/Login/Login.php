<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="View/modules/Login/login.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'View/includes/css_config.php' ?>
    <script
      src="https://kit.fontawesome.com/64d58efce2.js"
      crossorigin="anonymous"
    ></script>
    <title>Login - Gestão Jahuepi</title>
</head>

<body>

    <div class="container-login">
        <div class="forms-container">
            <div class="signin-signup">
                <form action="#" class="sign-in-form">
                    <h2 class="title">Login</h2>
                    <div class="input-field">
                        <i class="fas fa-user"></i>
                        <input type="email" placeholder="Email" />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-lock"></i>
                        <input type="password" placeholder="Senha" />
                    </div>
                    <input type="submit" value="Login" class="btn-login solid btn-warning" />
                    <p class="social-text">Esqueceu a senha?</p>
                </form>
            </div>
        </div>

        <div class="panels-container">
            <div class="panel left-panel">
                <div class="content-login">
                    <h3>Bem-Vindo!</h3>
                    <p>
                        Lorem ipsum, dolor sit amet consectetur adipisicing elit. Debitis,
                        ex ratione. Aliquid!
                    </p>
                </div>
                <img src="View/assets/log.svg" class="image" alt="" />
            </div>
        </div>
    </div>

    <!--<div class="container-login">
        <main class="container-white">
            <section class="image-container">
                <img src="View/assets/logo.png" id="imgLogo" alt="logo-Jahuepi">
            </section>
            <section class="input-container">
                <form class="form" action="/login/auth" method="POST">
                    <label for="email">Endereço de E-mail:</label><br>
                    <input type="email" class="form-control" name="email" id="email"><br>

                    <label for="senha">Senha de Acesso:</label>
                    <div class="input-password">
                        <input type="password" class="form-control" name="senha" id="senha"><br>

                    </div>

                    <div class="action-pass">
                        <a href="">Esqueceu a senha?</a>
                        <box-icon name='show' id="verSenha"></box-icon>
                    </div>

                    <div>
                        <?php if ($loginFailed == true) : ?>
                            <h6 class="text-danger">Falha no login, tente novamente!</h6>
                        <?php endif; ?>

                    </div>

                    <section class="btn-container">
                        <button type="submit" class="btn btn-warning">Entrar</button>
                    </section>
                </form>
            </section>
        </main>
    </div>-->



    <?php include 'View/includes/js_config.php' ?>
    <script src="View/js/src/jquery.login.js"></script>
</body>

</html>