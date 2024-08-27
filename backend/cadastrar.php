<?php
    if (isset($_POST['submit'])) { // Verifica se o formulário foi enviado

        include_once('db.php'); // Inclui o arquivo de conexão com o banco de dados

        // Sanitiza e valida os dados do formulário
        $nome = htmlspecialchars(trim($_POST['nome'])); // Remove espaços em branco e caracteres especiais do nome
        $sobrenome = htmlspecialchars(trim($_POST['sobrenome'])); // Remove espaços em branco e caracteres especiais do sobrenome
        $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL); // Sanitiza o email removendo caracteres inválidos
        $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT); // Cria um hash seguro da senha

        // Prepara a consulta para verificar se o email já está registrado
        $email_exists_query = $db->prepare("SELECT * FROM usuarios WHERE email = ?");
        $email_exists_query->bind_param('s', $email); // Liga o parâmetro email à consulta
        $email_exists_query->execute(); // Executa a consulta
        $result = $email_exists_query->get_result(); // Obtém o resultado da consulta

        if ($result->num_rows > 0) { // Verifica se o email já existe no banco de dados
            // Redireciona com mensagem de alerta se o email já estiver registrado
            header('Location: ../templates/cadastro.php?alert=cadastro_alert&mensagem=E-mail inválido, informe outro e-mail!');
            exit();
        } elseif ($_POST['senha'] !== $_POST['c-senha']) { // Verifica se as senhas são iguais
            // Redireciona com mensagem de alerta se as senhas não coincidirem
            header('Location: ../templates/cadastro.php?alert=cadastro_alert&mensagem=As senhas não coincidem, tente novamente!');
            exit();
        } else {
            // Prepara e executa a consulta para inserir um novo usuário no banco de dados
            $stmt = $db->prepare("INSERT INTO usuarios(nome, sobrenome, email, senha) VALUES (?, ?, ?, ?)");
            $stmt->bind_param('ssss', $nome, $sobrenome, $email, $senha);
            $stmt->execute();

            if ($stmt->affected_rows > 0) { // Verifica se o cadastro foi bem-sucedido
                // Redireciona com mensagem de sucesso após o cadastro
                header('Location: ../templates/login.php?alert=login_alert&mensagem=Cadastro efetuado com sucesso!');
            } else {
                // Redireciona com mensagem de erro se o cadastro falhar
                header('Location: ../templates/cadastro.php?alert=cadastro_alert&mensagem=Erro ao cadastrar usuário, tente novamente!');
            }
            $stmt->close(); // Fecha o comando preparado
        }
        $db->close(); // Fecha a conexão com o banco de dados
    }
?>