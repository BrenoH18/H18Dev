<div class="alert">
    <?php
        if (isset($_GET["alert"])) {
            $alert = $_GET['alert'];
            $mensagem = $_GET['mensagem'];
            $id = $_GET['id'];
            if(isset($token)){
                $token = $_GET['token'];
            }

            if($alert == 'cadastro_alert'){
                echo "<script>alert('$mensagem');</script>";
                echo "<meta http-equiv='refresh' content='0;url=cadastro.php'>";
            }elseif($alert == 'login_alert'){
                echo "<script>alert('$mensagem');</script>";
                echo "<meta http-equiv='refresh' content='0;url=login.php'>";
            }elseif($alert == 'index_alert'){
                echo "<script>alert('$mensagem');</script>";
                echo "<meta http-equiv='refresh' content='0;url=index.php?id=$user_data[id]'>";
            }elseif($alert == 'solic-rec_alert'){
                echo "<script>alert('$mensagem');</script>";
                echo "<meta http-equiv='refresh' content='0;url=solic-rec.php'>";
            }elseif($alert == 'rec-senha_alert'){
                echo "<script>alert('$mensagem');</script>";
                echo "<meta http-equiv='refresh' content='0;url=rec-senha.php?token=$token'>";
            }elseif($alert == 'cadastro-produtos_alert'){
                echo "<script>alert('$mensagem');</script>";
                echo "<meta http-equiv='refresh' content='0;url=cadastro-produtos.php?id=$'>";
            }elseif($alert == 'caixa_alert'){
                echo "<script>alert('$mensagem');</script>";
                echo "<meta http-equiv='refresh' content='0;url=caixa.php?id=$id'>";
            }
        }
    ?>
</div>