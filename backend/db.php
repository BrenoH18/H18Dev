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

    // SQL para criar a tabela usuarios
    $sqlCreateTableUsuario = "CREATE TABLE IF NOT EXISTS usuarios (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nome VARCHAR(45),
        sobrenome VARCHAR(45),
        email VARCHAR(45),
        senha VARCHAR(255),
        empresa VARCHAR(45),
        permissao VARCHAR(45)
    )";

    if ($db->query($sqlCreateTableUsuario) === FALSE) {
        echo "Erro ao criar a tabela: " . $db->error;
    }

    //SQL para criar tabela produtos
    $tabelaProdutos = "produtos_" . strtolower(str_replace(' ', '_', $user_data['empresa']));
    if($tabelaProdutos != 'produtos_'){
        $sqlCreateTableProdutos = "CREATE TABLE IF NOT EXISTS $tabelaProdutos (
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
            empresa VARCHAR(45),
            data DATE,
            hora TIME
        )";

        if ($db->query($sqlCreateTableProdutos) === FALSE) {
            echo "Erro ao criar a tabela: " . $db->error;
        }

    }
    
    // SQL para criar a tabela solicita_redefinir_senha
    $sqlCreateTableSolicitaRedefinirSenha = "CREATE TABLE IF NOT EXISTS solicita_redefinir_senha (
        id INT AUTO_INCREMENT PRIMARY KEY,
        email VARCHAR(45),
        dataAtual DATE,
        horaAtual TIME,
        token VARCHAR(225)
    )";

    if ($db->query($sqlCreateTableSolicitaRedefinirSenha) === FALSE) {
        echo "Erro ao criar a tabela: " . $db->error;
    }
    
   //SQL para criar tabela caixa
   $tabelaCaixa = "caixa_" . strtolower(str_replace(' ', '_', $user_data['empresa']));
   if($tabelaCaixa != 'caixa_'){
       $sqlCreateTableCaixa = "CREATE TABLE IF NOT EXISTS $tabelaCaixa (
           id INT AUTO_INCREMENT PRIMARY KEY,
           usuario VARCHAR(45),
           empresa VARCHAR(45),
           saldoInicial INT(45),
           saldo INT(45),   
           dataAtual DATE,
           horaAtual TIME
       )";

       if ($db->query($sqlCreateTableCaixa) === FALSE) {
           echo "Erro ao criar a tabela: " . $db->error;
       }

   }
?>  