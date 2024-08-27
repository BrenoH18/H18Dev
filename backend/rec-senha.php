<?php
    if (isset($_POST['submit'])) { // Verifica se o formulário foi enviado

        include_once('db.php'); // Inclui o arquivo de conexão com o banco de dados

        $nova_senha = password_hash($_POST['nova-senha'], PASSWORD_DEFAULT); // Cria um hash seguro da nova senha

        $token = $_POST['token']; // Obtém o token de redefinição de senha enviado pelo formulário

        // Busca o email associado ao token na tabela de solicitações de redefinição de senha
        $consult_token = "SELECT email FROM solicita_redefinir_senha WHERE token = '$token'";
        $consult_token_result = $db->query($consult_token);
        $token_data = mysqli_fetch_assoc($consult_token_result);

        $email_token = $token_data['email']; // Armazena o email associado ao token

        // Busca os dados do usuário com o email associado ao token
        $consult = "SELECT * FROM usuarios WHERE email = '$email_token'";
        $consult_result = $db->query($consult);
        $user_data = mysqli_fetch_assoc($consult_result);

        $email = $user_data['email']; // Armazena o email do usuário

        // Verifica se o email existe no banco de dados
        $email_exists_query = mysqli_query($db, "SELECT * FROM usuarios WHERE email='$email'");
        
        // Verifica se as senhas informadas no formulário coincidem
        if ($_POST['nova-senha'] !== $_POST['c-nova-senha']) {
            header("Location: ../templates/rec-senha.php?token=$token&alert=senha_alert&mensagem=As senhas não coincidem. Por favor, tente novamente.");
        } elseif (mysqli_num_rows($email_exists_query) > 0) {
            // Atualiza a senha do usuário no banco de dados
            $result = mysqli_query($db, "UPDATE usuarios SET senha='$nova_senha' WHERE email='$email'");

            // Remove o registro da solicitação de redefinição de senha associada ao email
            $result2 = mysqli_query($db, "DELETE FROM solicita_redefinir_senha WHERE email='$email'");
            
            // Redireciona para a página de login com uma mensagem de sucesso
            header('Location: ../templates/login.php?alert=token_alert&mensagem=Senha redefinida com sucesso!');
        } elseif (mysqli_num_rows($email_exists_query) == 0) {
            // Redireciona para a página de login com uma mensagem de erro caso a senha já tenha sido alterada
            header('Location: ../templates/login.php?alert=token_alert&mensagem=A senha já foi alterada por este link!');
        }
    }
?>