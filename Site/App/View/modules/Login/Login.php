<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="App/View/modules/Login/login.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'App/View/includes/css_config.php' ?>
    <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
    <title>Login - Gestão Jahuepi</title>
</head>

<body>

    <div class="container-login">
        <div class="forms-container" id="form-login">
            <div class="signin-signup">
                <form action="/login/auth" class="sign-in-form" method="POST">
                    <h2 class="title">Login</h2>
                    <div class="input-field">
                        <i class="fas fa-user"></i>
                        <input type="email" placeholder="Email" name="email" id="email" />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="senha" id="senha" placeholder="Senha" />
                    </div>
                    <input type="submit" value="Login" class="btn-login solid btn-warning" />
                    <p class="social-text"><a href="/esqueci-senha" id="forgotPasswordLink">Esqueceu a senha?</a></p>

                    <div>
                        <?php if ($loginFailed == true) : ?>
                            <h6 class="text-danger">Falha no login, tente novamente!</h6>
                        <?php endif; ?>

                    </div>

                </form>
            </div>
        </div>
        
        <div class="panels-container">
            <div class="panel left-panel">
                <div class="content-login">
                    <h3>Bem-Vindo!</h3>
                    <p>
                        Este é o nosso sistema de gestão da empresa de epi's JAHUEPI!
                    </p>
                </div>
                <img src="App/View/assets/log.svg" class="image" alt="" />
            </div>
        </div>
    </div>

    <?php include 'App/View/includes/js_config.php' ?>
    <script src="App/View/js/src/jquery.login.js"></script>
</body>

</html>