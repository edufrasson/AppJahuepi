<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!--<link rel="stylesheet" href="View/modules/Login/login.css">-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
    <title>Login - Gestão Jahuepi</title>
</head>

<body>

    <div class="container-login">
        <div class="forms-container" id="form-login">
            <div class="signin-signup">
                <form action="/enviar-nova-senha" class="sign-in-form" method="POST">

                    

                    <h2 class="title">Recuperar Senha</h2>
                    <p>Digite seu e-mail para nova senha</p>
                    <div class="input-field">
                        <i class="fas fa-user"></i>
                        <input type="email" placeholder="Email" name="email" id="email" />
                    </div>

                    <input type="submit" value="Nova Senha" class="btn-login solid btn-warning" />

                    <?php if(isset($retorno)): ?>
                    <h6 class="text-danger">
                        <?= $retorno ?>
                    </h6>
                    <?php endif ?>

                </form>
            </div>
        </div>

        <!--<div class="panels-container">
            <div class="panel left-panel">
                <div class="content-login">
                    <h3>Bem-Vindo!</h3>
                    <p>
                        Este é o nosso sistema de gestão da empresa de epi's JAHUEPI!
                    </p>
                </div>
                <img src="View/assets/log.svg" class="image" alt="" />
            </div>
        </div>-->
    </div>

    <?php include 'View/includes/js_config.php' ?>
    <script src="View/js/src/jquery.login.js"></script>
</body>

</html>