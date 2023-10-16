<?php
/*session_start();

if(isset($_SESSION['user_logged'])){
    header('Location: /home'); // Redireciona para a página inicial se o usuário já estiver autenticado
    exit;
}
*/
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="View/modules/Login/login.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'View/includes/css_config.php' ?>
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
                    <p class="social-text"><a href="" id="forgotPasswordLink">Esqueceu a senha?</a></p>

                    <div>
                        <?php if ($loginFailed == true) : ?>
                            <h6 class="text-danger">Falha no login, tente novamente!</h6>
                        <?php endif; ?>

                    </div>

                </form>
            </div>
        </div>

        <div class="forms-container" id="form-recoverEmail" style="display: none;">
            <div class="signin-signup">
                <form action="#" class="sign-in-form" method="POST">
                    <h2 class="title">E-mail de verificação</h2>
                    <p>Digite seu e-mail para recuperação</p>
                    <div class="input-field">
                        <i class="fas fa-user"></i>
                        <input type="email" placeholder="Email" name="email" id="email" />
                    </div>
                    <input type="submit" value="Enviar" class="btn-login solid btn-warning" />
                </form>
            </div>
        </div>

        <div class="forms-container" id="form-code" style="display: none;">
            <div class="signin-signup">
                <form action="#" class="sign-in-form" method="POST">
                    <h2 class="title">Informe o código</h2>
                    <p>Digite o código recebido no seu endereço de e-mail</p>

                    <div class="verification-code-container">
                        <input type="text" class="verification-code" maxlength="1" />
                        <input type="text" class="verification-code" maxlength="1" />
                        <input type="text" class="verification-code" maxlength="1" />
                        <input type="text" class="verification-code" maxlength="1" />
                        <input type="text" class="verification-code" maxlength="1" />
                        <input type="text" class="verification-code" maxlength="1" />
                    </div>

                    <input type="submit" value="Prosseguir" class="btn-login solid btn-warning" id="btn-prosseguir" />
                </form>
            </div>
        </div>

        <div class="forms-container" id="form-newPassword" style="display: none;">
            <div class="signin-signup">
                <form action="#" class="sign-in-form" method="POST">
                    <h2 class="title">Informe sua nova senha</h2>
                    <div class="input-field">
                        <i class="fas fa-lock"></i>
                        <input type="password" placeholder="Nova senha" name="nova_senha" id="nova_senha" />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-lock"></i>
                        <input type="password" placeholder="Repita a senha" name="senha_repetida" id="senha_repetida" />
                    </div>
                    <input type="submit" value="Trocar senha" class="btn-login solid btn-warning" />
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

    <script>
        const forgotPasswordLink = document.getElementById("forgotPasswordLink");
        const formLogin = document.getElementById("form-login");
        const formRecoverEmail = document.getElementById("form-recoverEmail");
        const formCode = document.getElementById("form-code");
        const formNewPassword = document.getElementById("form-newPassword");

        forgotPasswordLink.addEventListener("click", function(e) {
            e.preventDefault(); // Impede o comportamento padrão do link
            formLogin.style.display = "none";
            formRecoverEmail.style.display = "block";
        });

        function showContainer2() {
            formRecoverEmail.style.display = "none";
            formCode.style.display = "block";
        }

        function showContainer3() {
            formCode.style.display = "none";
            formNewPassword.style.display = "block";
        }

        // Adicione um evento de clique ao botão "Enviar" no formulário de recuperação de e-mail
        const enviarEmailButton = formRecoverEmail.querySelector(".btn-login");
        enviarEmailButton.addEventListener("click", function(e) {
            e.preventDefault();
            showContainer2(); // Mostra o formulário de código
        });

        // Adicione um evento de clique ao botão "Prosseguir" no formulário de código
        const prosseguirButton = document.querySelector("#btn-prosseguir");
        prosseguirButton.addEventListener("click", function(e) {
            e.preventDefault();
            showContainer3(); // Mostra o formulário de troca de senha
        });


        /* PASSAGEM DE ALGARISMO PARA ALGARISMO APÓS DIGITAR */

        // Obtém todos os campos de dígitos
        const verificationCodeInputs = document.querySelectorAll(".verification-code");

        // Adiciona um evento "input" a cada campo de dígitos
        verificationCodeInputs.forEach((input, index) => {
            input.addEventListener("input", (event) => {
                const currentValue = event.target.value;
                if (currentValue.length === 1 && index < verificationCodeInputs.length - 1) {
                    // Se apenas um caractere foi inserido e não é o último campo, move o foco para o próximo campo
                    verificationCodeInputs[index + 1].focus();
                } else if (currentValue.length === 0 && index > 0) {
                    // Se o campo estiver vazio e não é o primeiro campo, move o foco para o campo anterior ao pressionar o Backspace
                    verificationCodeInputs[index - 1].focus();
                }
            });
        });
    </script>

    <?php include 'View/includes/js_config.php' ?>
    <script src="View/js/src/jquery.login.js"></script>
</body>

</html>