<?php 
    include '../includes/alert.php'; 
?>

<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>H18 Dev | Redefinir senha</title>
        <link rel="stylesheet" href="../static/css/reset.css">
        <link rel="stylesheet" href="../static/css/solic-rec.css">
    </head>
    <body>
        <div class="content">
            <div class="box">
                <div class="box-rec-senha">
                    <fieldset class="fieldset">
                        <h1 class="h1" id="h1-login">H18 Dev</h1>
                        <h2 class="h2" id="slogan">Transformando visões em realidade!</h2>
                        <p id="slogan">Insira o seu email para enviarmos o link para você voltar a acessar a sua conta.</p><br>
                        <form action="../backend/solic-rec.php" method="POST" class="form" id="form">
                            <input type="email" name="email" placeholder="E-mail" class="inputUser" required><br>
                            <input type="submit" name="submit" value="Enviar" class="inputSubmit">
                        </form>
                    </fieldset>
                </div>
                <div class="box-btn-login">
                    <fieldset class="fieldset" id="fieldset-btn-login">
                        <span>
                            <p>Já tem uma conta? <a href="login.html" class="btn-cadastro">Conecte-se</a></p>
                        </span>
                    </fieldset>
                </div>
            </div>
        </div>
        <?php include '../includes/footer.php'; ?>
    </body>
</html>