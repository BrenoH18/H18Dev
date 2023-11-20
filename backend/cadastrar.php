<?php
    if(isset($_POST['submit'])){

        include_once('db.php');

        $nome = $_POST['nome'];
        $sobrenome = $_POST['sobrenome'];
        $email = $_POST['email'];
        $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

        // Verificar se o email já está registrado no banco de dados
        $email_exists_query = mysqli_query($db, "SELECT * FROM usuarios WHERE email='$email'");
        if (mysqli_num_rows($email_exists_query) > 0) {
            header('Location: ../templates/cadastro.php?alert=email_alert&mensagem=Este email já está cadastrado. Por favor, escolha outro email!');
        }elseif($_POST['senha'] !== $_POST['c-senha']){
                header('Location: ../templates/cadastro.php?alert=email_alert&mensagem=As senhas não coincidem. Por favor, tente novamente.');
        }else {
            $result = mysqli_query($db, "INSERT INTO usuarios(nome, sobrenome, email, senha) VALUES ('$nome', '$sobrenome', '$email', '$senha')");
            header('Location: ../templates/login.php');
        }
    }
?>
