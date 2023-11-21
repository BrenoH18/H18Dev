<?php 
    include '../includes/alert.php';
    
    $token = $_GET['token'];
    
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>H18 Dev | Recuperar Senha</title>
            <link rel="stylesheet" href="../static/css/reset.css">
            <link rel="stylesheet" href="../static/css/rec-senha.css">
    </head>
    <body>        
        <div class="content">
            <div class="box">
                <div class="box-rec-senha">
                    <fieldset class="fieldset">
                        <br><h1 class="h1" id="h1-rec-senha">Redefinir Senha</h1><br>
                        <form action="../backend/rec-senha.php?token=<?php echo $token ?>" method="POST" class="form" id="form">
                            <input type="password" name="nova-senha" id="nova-senha" placeholder="Nova senha" class="inputUser" required><br>
                            <input type="password" name="c-nova-senha" id="c-nova-senha" placeholder="Nova senha" class="inputUser" required>
                            <input type="hidden" name="token" value="<?php echo $token ?>">
                            <input type="submit" name="submit" id="submit" value="Redefinir" class="inputSubmit">
                        </form>
                    </fieldset>
                </div>
                <div class="box-btn-login">
                    <fieldset class="fieldset" id="fieldset-btn-login">
                        <span>
                            <p>Já tem uma conta? <a href="login.php" class="btn-login">Conecte-se</a></p>
                        </span>
                    </fieldset>
                </div>
            </div>
        </div>
        <?php include '../includes/footer.php';?>
    </body>
</html>
