<?php
    session_start(); // Inicia a sessão para acessar variáveis de sessão

    include_once('db.php'); // Inclui o arquivo de conexão com o banco de dados

    if ($_POST['update']) { // Verifica se o formulário de atualização foi enviado

        $id = $_POST['id']; // Obtém o ID do produto a ser atualizado
        $descricao = strtoupper($_POST['descricao']); // Converte a descrição para maiúsculas
        $modelo = strtoupper($_POST['modelo']); // Converte o modelo para maiúsculas
        $marca = strtoupper($_POST['marca']); // Converte a marca para maiúsculas
        $fornecedor = strtoupper($_POST['fornecedor']); // Converte o fornecedor para maiúsculas
        $qtd = $_POST['qtd']; // Obtém a quantidade do produto
        $custo = $_POST['custo']; // Obtém o custo do produto
        $venda = $_POST['venda']; // Obtém o preço de venda do produto
        $custoEstoque = $qtd * $custo; // Calcula o custo total do estoque
        $lucro = $venda - $custo; // Calcula o lucro por unidade
        
        $email = $_SESSION['email']; // Obtém o email do usuário logado
    
        // Consulta o banco de dados para obter os dados do usuário com base no email
        $consult = "SELECT * FROM usuarios WHERE email = '$email'";
        $consult_result = $db->query($consult);
        $user_data = mysqli_fetch_assoc($consult_result); // Armazena os dados do usuário

        $empresa = $user_data['empresa']; // Obtém o nome da empresa do usuário
        $tabela = "produtos_" . strtolower(str_replace(' ', '_', $empresa)); // Define o nome da tabela de produtos

       // Prepara a consulta SQL para atualizar os dados do produto na tabela correspondente
        $sqlUpdate = "UPDATE $tabela SET descricao=?, modelo=?, marca=?, fornecedor=?, qtd=?, custo=?, venda=?, lucro=?, custoEstoque=? WHERE id=?";

        $stmt = $db->prepare($sqlUpdate); // Prepara a consulta
        $stmt->bind_param("ssssiddiid", $descricao, $modelo, $marca, $fornecedor, $qtd, $custo, $venda, $lucro, $custoEstoque, $id); // Vincula os parâmetros
        $stmt->execute(); // Executa a consulta

        $result = $stmt->affected_rows; // Obtém o número de linhas afetadas

        $stmt->close(); // Fecha a declaração preparada

    }


    // Redireciona o usuário para a página de estoque com parâmetros atualizados
    header("Location: ../templates/estoque.php?empresa=$user_data[empresa]&tipo=todos");
?>