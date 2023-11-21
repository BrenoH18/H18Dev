<?php 
    include '../includes/alert.php'; 
?>

<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>H18 Dev | Cadastro</title>
        <link rel="stylesheet" href="../static/css/reset.css">
        <link rel="stylesheet" href="../static/css/footer.css">
        <link rel="stylesheet" href="../static/css/cadastro.css">
    </head>
    <body>
        <div class="content">
            <div class="box">
                <div class="box-cadastro">
                    <fieldset class="fieldset">
                        <h1 class="h1" id="h1-cadastro">Cadastre-se</h1>
                        <form action="../backend/cadastrar.php" method="POST" class="form" id="form">
                            <input type="text" name="nome" id="nome" placeholder="Nome" class="inputUser" class="inputUser" required><br>
                            <input type="text" name="sobrenome" id="sobrenome" placeholder="Sobrenome" class="inputUser" class="inputUser" required><br>
                            <input type="email" name="email" id="email" placeholder="Email" class="inputUser" required><br>
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