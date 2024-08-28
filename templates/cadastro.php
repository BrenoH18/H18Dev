<?php require_once '../includes/alert.php'?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Cadastrar</title>
        <link rel="stylesheet" href="../assets/css/reset.css">
        <link rel="stylesheet" href="../assets/css/cadastro.css">
        <link rel="stylesheet" href="../assets/css/footer.css">
    </head>
    <body>
        <div class="content">
            <div class="box">
                <div class="box-cadastro">
                    <fieldset class="fieldset">
                        <h1 class="h1" id="h1-cadastro">Cadastrar</h1>
                        <form class="form" id="form" action="../backend/cadastrar.php" method="POST">
                            <input type="text" name="nome" id="nome" placeholder="Nome" class="inputUser" class="inputUser" required><br>
                            <input type="text" name="sobrenome" id="sobrenome" placeholder="Sobrenome" class="inputUser" class="inputUser" required><br>
                            <input type="email" name="email" id="email" placeholder="E-mail" class="inputUser" required><br>
                            <input type="password" name="senha" id="senha" placeholder="Senha" class="inputUser" required><br>
                            <input type="password" name="c-senha" id="c-senha" placeholder="Senha" class="inputUser" required>
                            <input type="submit" name="submit" id="submit" value="Cadastre-se" class="inputSubmit">
                        </form>
                    </fieldset>
                </div>
                <div class="box-btn-login">
                    <fieldset class="fieldset" id="fieldset-btn-login">
                        <span>
                            <p>Já tem uma conta? <a href="login.php" class="btn-cadastro">Conecte-se</a></p>
                        </span>
                    </fieldset>
                </div>
            </div>
        </div>
        <?php include '../includes/footer.php'; ?>
    </body>
</html>