<?php
    $dbhost = '127.0.0.1:3306';
    $dbUsername = 'root';
    $dbPassword = '';
    $dbName = 'credenciais';

    // Cria uma conexão com o banco de dados
    $db = new mysqli($dbhost, $dbUsername, $dbPassword, $dbName);

    // Verifica a conexão
    if ($db->connect_error) {
        die("Conexão falhou: " . $db->connect_error);
    }
?>