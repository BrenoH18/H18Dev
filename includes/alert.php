<div class="alert">
    <?php
        if (isset($_GET["alert"])) {
            $alert = $_GET['alert'];
            $mensagem = $_GET['mensagem'];
            $token = $_GET['token'];

            if($alert == 'email_alert'){
                echo "<script>alert('$mensagem');</script>";
                echo "<meta http-equiv='refresh' content='0;url=cadastro.php'>";
            }elseif($alert == 'login_alert'){
                echo "<script>alert('$mensagem');</script>";
                echo "<meta http-equiv='refresh' content='0;url=login.php'>";
            }elseif($alert == 'email-env'){
                echo "<script>alert('$mensagem');</script>";
                echo "<meta http-equiv='refresh' content='0;url=login.php'>";
            }elseif($alert == 'token_alert'){
                echo "<script>alert('$mensagem');</script>";
                echo "<meta http-equiv='refresh' content='0;url=login.php'>";
            }elseif($alert == 'senha_alert'){
                echo "<script>alert('$mensagem');</script>";
                echo "<meta http-equiv='refresh' content='0;url=rec-senha.php?token=$token'>";
            }elseif($alert == 'referencia_alert'){
                echo "<script>alert('$mensagem');</script>";
                echo "<meta http-equiv='refresh' content='0;url=cadastro-produtos.php?id=$'>";
            }elseif($alert == 'caixa_alert'){
                echo "<script>alert('$mensagem');</script>";
                echo "<meta http-equiv='refresh' content='0;url=caixa.php?id=$id'>";
            }
        }
    ?>
</div>