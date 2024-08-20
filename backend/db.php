<?php
    // Definições de conexão com o banco de dados
    $dbhost = '127.0.0.1:3306';  // Endereço do servidor de banco de dados
    $dbUsername = 'root';        // Nome de usuário do banco de dados
    $dbPassword = '';            // Senha do banco de dados
    $dbName = 'h18dev';          // Nome do banco de dados

    // Cria uma nova conexão com o servidor MySQL
    $conn = new mysqli($dbhost, $dbUsername, $dbPassword);

    // Verifica se a conexão foi bem-sucedida
    if($conn){
        // Verifica se houve um erro na conexão
        if ($conn->connect_error) {
            die("Erro de conexão com o Servidor: " . $conn->connect_error);  // Exibe mensagem de erro e termina o script
        } else {
            // Cria o banco de dados se ele não existir
            $sqlCreateDB = "
                CREATE DATABASE IF NOT EXISTS h18dev;
            "; 

            // Executa a query para criar o banco de dados
            if ($conn->query($sqlCreateDB) === FALSE) {
                die("Erro ao criar Banco de Dados: " . $conn->error);  // Exibe mensagem de erro e termina o script
            }
            
            // Fecha a conexão inicial
            $conn->close();
            
            // Cria uma nova conexão, agora com o banco de dados específico
            $db = new mysqli($dbhost, $dbUsername, $dbPassword, $dbName);

            // Verifica se a conexão com o banco de dados foi bem-sucedida
            if ($db->connect_error) {
                die("Conexão falhou: " . $db->connect_error);  // Exibe mensagem de erro e termina o script
            } else {
                // Obtém o email da sessão do usuário logado
                $email = $_SESSION['email'];

                // Executa uma consulta SQL para buscar os dados do usuário
                $sql = "SELECT * FROM usuarios WHERE email = '$email' LIMIT 1";
                $result = $db->query($sql) or die($db->error);  // Executa a consulta ou exibe erro
                $user_data = mysqli_fetch_assoc($result);  // Obtém os dados do usuário

                // SQL para criar a tabela de usuários, se ela não existir
                $sqlCreateTableUsuario = "
                    CREATE TABLE IF NOT EXISTS usuarios (
                        id INT AUTO_INCREMENT PRIMARY KEY,
                        nome VARCHAR(45) NOT NULL,
                        sobrenome VARCHAR(45) NOT NULL,
                        email VARCHAR(45) NOT NULL,
                        senha VARCHAR(255) NOT NULL,
                        empresa VARCHAR(45) NOT NULL,
                        permissao VARCHAR(45) NOT NULL DEFAULT 'user'
                    )
                ";

                // Executa a query para criar a tabela de usuários
                if ($db->query($sqlCreateTableUsuario) === FALSE) {
                    die("Erro ao criar a tabela: " . $db->error);  // Exibe mensagem de erro e termina o script
                }

                // SQL para criar a tabela de produtos, com nome baseado na empresa do usuário
                $tabelaProdutos = "produtos_" . strtolower(str_replace(' ', '_', $user_data['empresa']));
                if($tabelaProdutos != 'produtos_'){
                    $sqlCreateTableProdutos = "
                        CREATE TABLE IF NOT EXISTS $tabelaProdutos (
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
                        )
                    ";

                    // Executa a query para criar a tabela de produtos
                    if ($db->query($sqlCreateTableProdutos) === FALSE) {
                        die("Erro ao criar a tabela: " . $db->error);  // Exibe mensagem de erro e termina o script
                    }
                }

                // SQL para criar a tabela de solicitação de redefinição de senha, se ela não existir
                $sqlCreateTableSolicitaRedefinirSenha = "
                    CREATE TABLE IF NOT EXISTS solicita_redefinir_senha (
                        id INT AUTO_INCREMENT PRIMARY KEY,
                        email VARCHAR(45),
                        dataAtual DATE,
                        horaAtual TIME,
                        token VARCHAR(225)
                    )
                ";

                // Executa a query para criar a tabela de solicitação de redefinição de senha
                if ($db->query($sqlCreateTableSolicitaRedefinirSenha) === FALSE) {
                    die("Erro ao criar a tabela: " . $db->error);  // Exibe mensagem de erro e termina o script
                }

                // SQL para criar a tabela de caixa, com nome baseado na empresa do usuário
                $tabelaCaixa = "caixa_" . strtolower(str_replace(' ', '_', $user_data['empresa']));
                if($tabelaCaixa != 'caixa_'){
                    $sqlCreateTableCaixa = "
                        CREATE TABLE IF NOT EXISTS $tabelaCaixa (
                            id INT AUTO_INCREMENT PRIMARY KEY,
                            usuario VARCHAR(45),
                            empresa VARCHAR(45),
                            saldoInicial FLOAT(45),
                            totalMov FLOAT(45),
                            saldo FLOAT(45),   
                            dataAtual DATE,
                            horaAtual TIME,
                            statusCaixa VARCHAR(45)
                        )
                    ";

                    // Executa a query para criar a tabela de caixa
                    if ($db->query($sqlCreateTableCaixa) === FALSE) {
                        die("Erro ao criar a tabela: " . $db->error);  // Exibe mensagem de erro e termina o script
                    }
                }

                // SQL para criar a tabela de movimentações, com nome baseado na empresa do usuário
                $tabelaMov = "movimentacoes_" . strtolower(str_replace(' ', '_', $user_data['empresa']));
                if($tabelaMov != 'movimentacoes_'){
                    $sqlCreateTableMov = "
                        CREATE TABLE IF NOT EXISTS $tabelaMov (
                            id INT AUTO_INCREMENT PRIMARY KEY,
                            usuario VARCHAR(45),
                            empresa VARCHAR(45),
                            descMov VARCHAR(45),
                            valorMov FLOAT(11),
                            dataMov DATE,
                            horaMov TIME,
                            idCaixa VARCHAR(45),
                            statusCaixa VARCHAR(45)
                        )
                    ";

                    // Executa a query para criar a tabela de movimentações
                    if ($db->query($sqlCreateTableMov) === FALSE) {
                        die("Erro ao criar a tabela: " . $db->error);  // Exibe mensagem de erro e termina o script
                    }
                }
            }
        }
    }
?>
