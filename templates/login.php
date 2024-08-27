<?php require_once '../includes/alert.php'?>

<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>H18 Dev | Login</title>
        <link rel="stylesheet" href="../static/css/reset.css">
        <link rel="stylesheet" href="../static/css/login.css">
        <link rel="stylesheet" href="../static/css/footer.css">
    </head>
    <body>
        <div class="content">
            <div class="box">
                <div class="box-login">
                    <fieldset class="fieldset">
                        <h1 class="h1" id="h1-login">H18 Dev</h1>
                        <h2 class="h2" id="slogan">Transformando visões em realidade!</h2>
                        <form action="../backend/autenticacao.php" method="POST" class="form" id="form">
                            <input type="email" name="email" placeholder="E-mail" class="inputUser" required><br>
                            <input type="password" name="senha" placeholder="Senha" id="senha" class="inputUser" required><br>
                            <input type="submit" name="submit" value="Entrar" class="inputSubmit">
                        </form>
                        <p>Esqueceu a senha? <a class="btn" href="solic-rec.php">Redefina aqui</a></p>
                    </fieldset>
                </div>
                <div class="box-btn-cadastro">
                    <fieldset class="fieldset" id="fieldset-btn-cadastro">
                        <span>
                            <p>Não tem uma conta? <a href="cadastro.php" class="btn-cadastro">Cadastre-se</a></p>
                        </span>
                    </fieldset>
                </div>
            </div>
        </div>
        <?php include '../includes/footer.php'; ?>
    </body>
</html>