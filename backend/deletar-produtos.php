<?php
    session_start(); // Inicia a sessão para acessar variáveis globais de sessão

    if (!empty($_GET['id'])) { // Verifica se o ID foi passado via URL

        include_once('db.php'); // Inclui o arquivo de conexão com o banco de dados

        // Determina o nome da tabela de produtos baseada na empresa do usuário
        $empresa = $user_data['empresa'];
        $tabela = "produtos_" . strtolower(str_replace(' ', '_', $empresa));
        
        $id = $_GET['id']; // Obtém o ID do produto a ser excluído

        // Prepara a consulta para selecionar o produto com o ID fornecido
        $sqlSelect = "SELECT * FROM $tabela WHERE id=$id";
        $result = $db->query($sqlSelect); // Executa a consulta

        if ($result->num_rows > 0) { // Verifica se o produto existe
            // Prepara e executa a consulta para deletar o produto
            $sqlDelete = "DELETE FROM $tabela WHERE id=$id";
            $resultDelete = $db->query($sqlDelete);
        }
    }

    // Obtém o email do usuário logado e consulta seus dados
    $email = $_SESSION['email'];
    $consult = "SELECT * FROM usuarios WHERE email = '$email'";
    $consult_result = $db->query($consult);
    $user_data = mysqli_fetch_assoc($consult_result);

    // Redireciona o usuário para a página de estoque da empresa
    header("Location: ../templates/estoque.php?empresa=$user_data[empresa]&tipo=todos");
?>