<?php
    session_start(); // Inicia a sessão

    if(isset($_POST['submit'])){ // Verifica se o formulário foi submetido
        include_once('db.php'); // Inclui o arquivo de conexão com o banco de dados

        $email = $_POST['email']; // Obtém o email do formulário
        $senha = $_POST['senha']; // Obtém a senha do formulário

        // Consulta o banco de dados para encontrar o usuário pelo email
        $sql = "SELECT * FROM usuarios WHERE email = '$email' LIMIT 1";
        $result = $db->query($sql) or die($db->error);
        $user_data = mysqli_fetch_assoc($result); // Recupera os dados do usuário como um array associativo

        if($user_data){ // Verifica se o usuário foi encontrado no banco de dados
    
            if(password_verify($senha, $user_data['senha'])){ // Verifica se a senha informada corresponde à senha no banco de dados
                $_SESSION['logado'] = true; // Define a sessão como logada
                $_SESSION['email'] = $email; // Armazena o email do usuário na sessão
                
                // Redireciona para a página principal com uma mensagem de sucesso
                header("Location: ../templates/index.php?id=$user_data[id]&alert=index_alert&mensagem=Login efetuado com sucesso!");
            }else{
                // Se a senha estiver incorreta, define a sessão como não logada e redireciona para a página de login com uma mensagem de erro
                $_SESSION['logado'] = false;
                header('Location: ../templates/login.php?alert=login_alert&mensagem=E-mail ou senha incorreto, tente novamente!');
            }
        }else{
            // Se o usuário não for encontrado no banco de dados, define a sessão como não logada e redireciona para a página de login com uma mensagem de erro
            $_SESSION['logado'] = false;
            header('Location: ../templates/login.php?alert=login_alert&mensagem=E-mail ou senha incorreto, tente novamente!');
        }
        
    }else{
        // Se o formulário não foi submetido, redireciona para a página de login
        header('Location: ../templates/login.php');
    }
?>