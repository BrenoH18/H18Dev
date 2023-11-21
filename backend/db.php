<?php

    $dbhost = '127.0.0.1:3306';
    $dbUsername = 'root';
    $dbPassword = '';
    $dbName = 'h18dev';

    // Cria uma conexão com o banco de dados
    $db = new mysqli($dbhost, $dbUsername, $dbPassword, $dbName);

    // Verifica a conexão
    if ($db->connect_error) {
        die("Conexão falhou: " . $db->connect_error);
    }

    $email = $_SESSION['email'];

    $sql = "SELECT * FROM usuarios WHERE email = '$email' LIMIT 1";
    $result = $db->query($sql) or die($db->error);
    $user_data = mysqli_fetch_assoc($result);

    // Verifica se a tabela já existe no banco de dados
    $tabelaUsuarios = $db->query("SHOW TABLES LIKE 'usuarios'");

    if ($tabelaUsuarios->num_rows == 0) {
        // SQL para criar a tabela produtos
        $sql = "CREATE TABLE usuarios (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nome VARCHAR(45),
            sobrenome VARCHAR(45),
            email VARCHAR(45),
            senha VARCHAR(255),
            empresa VARCHAR(45),
            permissao VARCHAR(45)
        )";

        // Executa o comando SQL para criar a tabela apenas se ela não existir
        if ($db->query($sql) === FALSE) {
            echo "Erro ao criar a tabela: " . $db->error;
        }
    }

    // Verifica se a tabela já existe no banco de dados
    $empresa = $user_data['empresa'];
    $tabela = "produtos_" . strtolower(str_replace(' ', '_', $empresa));

    if ($tabela != 'produtos_'){

        $tabelaProdutos = $db->query("SHOW TABLES LIKE '$tabela'");

        if ($tabelaProdutos->num_rows == 0) {
            // SQL para criar a tabela produtos
            $sql = "CREATE TABLE $tabela (
                id INT AUTO_INCREMENT PRIMARY KEY,
                referencia VARCHAR(45),
                descricao VARCHAR(45),
                modelo VARCHAR(45),
                marca VARCHAR(45),
                fornecedor VARCHAR(45),
                qtd INT,
                custo DECIMAL(10, 2),
                venda DECIMAL(10, 2),
                lucro DECIMAL(10, 2),
                custoEstoque DECIMAL(10, 2),
                empresa VARCHAR(45)
            )";
        }

        // Executa o comando SQL para criar a tabela apenas se ela não existir
        if ($db->query($sql) === FALSE) {
            echo "Erro ao criar a tabela: " . $db->error;
        }
    }

        // Verifica se a tabela já existe no banco de dados
        $tabelaSolicitaRedefinirS = $db->query("SHOW TABLES LIKE 'solicita_redefinir_senha'");

        if ($tabelaSolicitaRedefinirS->num_rows == 0) {
            // SQL para criar a tabela produtos
            $sql = "CREATE TABLE solicita_redefinir_senha (
                id INT AUTO_INCREMENT PRIMARY KEY,
                email VARCHAR(45),
                dataAtual DATE,
                horaAtual TIME,
                token VARCHAR(225)
            )";
    
            // Executa o comando SQL para criar a tabela apenas se ela não existir
            if ($db->query($sql) === FALSE) {
                echo "Erro ao criar a tabela: " . $db->error;
            }
        }
?>  