<?php
    session_start(); // Inicia a sessão para acessar as variáveis de sessão existentes
    session_destroy(); // Destroi a sessão atual, encerrando a autenticação do usuário
    
    header("Location: ../templates/login.html"); // Redireciona o usuário para a página de login
?>