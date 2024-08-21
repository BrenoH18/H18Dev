<?php
    if(isset($_POST['submit'])){
        include_once('db.php');

        $nome = htmlspecialchars(trim($_POST['nome']));
        $sobrenome = htmlspecialchars(trim($_POST['sobrenome']));
        $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
        $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

        // Verificar se o email já está registrado no banco de dados
        $email_exists_query = $db->prepare("SELECT * FROM usuarios WHERE email = ?");
        $email_exists_query->bind_param('s', $email);
        $email_exists_query->execute();
        $result = $email_exists_query->get_result();

        if ($result->num_rows > 0) {
            header('Location: ../templates/cadastro.html?alert=Email já está cadastrado, informe outro email!');
            exit();
        } elseif($_POST['senha'] !== $_POST['c-senha']) {
            header('Location: ../templates/cadastro.html?alert=As senhas não coincidem, tente novamente!');
            exit();
        } else {
            $stmt = $db->prepare("INSERT INTO usuarios(nome, sobrenome, email, senha) VALUES (?, ?, ?, ?)");
            $stmt->bind_param('ssss', $nome, $sobrenome, $email, $senha);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                header('Location: ../templates/login.html?alert=Cadastro efetuado com sucesso!');
            } else {
                header('Location: ../templates/cadastro.html?alert=Erro ao cadastrar usuário, tente novamente!');
            }
            $stmt->close();
        }
        $db->close();
    }
?>