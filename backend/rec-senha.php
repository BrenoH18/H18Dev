<?php
    if(isset($_POST['submit'])){
        
        include_once('db.php');
        
        $nova_senha = password_hash($_POST['nova-senha'], PASSWORD_DEFAULT);
        
        $token = $_POST['token'];
        
        $consult_token = "SELECT email FROM solicita_redefinir_senha WHERE token = '$token'";
        $consult_token_result = $db->query($consult_token);
        $token_data = mysqli_fetch_assoc($consult_token_result);

        $email_token = $token_data['email'];
        
        $consult = "SELECT * FROM usuarios WHERE email = '$email_token'";
        $consult_result = $db->query($consult);
        $user_data = mysqli_fetch_assoc($consult_result);

        $email = $user_data['email'];

        // Verificar se o email já está registrado no banco de dados
        $email_exists_query = mysqli_query($db, "SELECT * FROM 	usuarios WHERE email='$email'");
        if($_POST['nova-senha'] !== $_POST['c-nova-senha']){
            header("Location: ../templates/rec-senha.php?token=$token&alert=senha_alert&mensagem=As senhas não coincidem. Por favor, tente novamente.");
        }elseif(mysqli_num_rows($email_exists_query) > 0) {
            $result = mysqli_query($db, "UPDATE usuarios SET senha='$nova_senha' WHERE email='$email'");

            $result2 = mysqli_query($db, "DELETE FROM solicita_redefinir_senha WHERE email='$email'");
            header('Location: ../templates/login.php?alert=token_alert&mensagem=Senha redefinida com sucesso!');
        }elseif(mysqli_num_rows($email_exists_query) == 0){
            header('Location: ../templates/login.php?alert=token_alert&mensagem=A senha já foi alterada por este link!');
        }
    }
?>