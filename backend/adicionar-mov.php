<?php

session_start(); // Inicia a sessão

if(isset($_POST['submit'])){
    include_once('db.php'); // Inclui o arquivo de conexão com o banco de dados

    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Consulta para buscar os dados do usuário com base no email fornecido
    $sql = "SELECT * FROM usuarios WHERE email = '$email' LIMIT 1";
    $result = $db->query($sql) or die($db->error);
    $user_data = mysqli_fetch_assoc($result);
    
    $id = $user_data['id'];

    $empresa = $user_data['empresa'];

    // Gera o nome da tabela de caixa com base no nome da empresa
    $tabelaCaixa = "caixa_" . strtolower(str_replace(' ', '_', $user_data['empresa']));
    
    // Consulta para verificar o status do caixa da empresa
    $sqlCaixa = "SELECT * FROM $tabelaCaixa WHERE empresa = '$empresa' and statusCaixa = 'A'";
    $sqlCaixa_result = $db->query($sqlCaixa);
    $caixaData = mysqli_fetch_assoc($sqlCaixa_result);

    // Captura dados do caixa
    $totalMovAntigo = $caixaData['totalMov']; 
    $idCaixa = $caixaData['id']; 
    $statusCaixa = $caixaData['statusCaixa'];

    $descMov = $_POST['descMov']; // Descrição do movimento
    $valorMov = $_POST['valorMov']; // Valor do movimento
    $totalMov = $totalMovAntigo + $valorMov; // Soma o movimento atual ao total de movimentos anteriores

    // Define o fuso horário de Brasília e obtém a data e hora atuais
    date_default_timezone_set('America/Sao_Paulo');
    $dataAtual = DATE("Y-m-d");
    $horaAtual = DATE("H:i:s");

    // Verifica se a senha está correta e se o usuário possui as permissões necessárias
    if ((password_verify($senha, $user_data['senha']) and $_SESSION['email'] == $email) and ($user_data['permissao'] == 'admin' or $user_data['permissao'] == 'dev')) {
        // Insere o movimento na tabela de movimentos e atualiza o total de movimentos no caixa
        $result = mysqli_query($db, "INSERT INTO $tabelaMov (usuario, empresa, descMov, valorMov, dataMov, horaMov, idCaixa, statusCaixa) VALUES ('$email', '$empresa', '$descMov', '$valorMov', '$dataAtual', '$horaAtual', '$idCaixa', '$statusCaixa')");
        $result2 = mysqli_query($db, "UPDATE $tabelaCaixa SET totalMov='$totalMov' WHERE statusCaixa='A'");

        // Redireciona para a página do caixa com uma mensagem de sucesso
        header("Location: ../templates/caixa.php?id=$id&alert=caixa_alert&mensagem=Movimentação adicionada com sucesso!");
    } elseif ((password_verify($senha, $user_data['senha']) and $_SESSION['email'] != $email) or ($user_data['permissao'] != 'admin' and $user_data['permissao'] != 'dev')) {
        // Redireciona para a página do caixa com uma mensagem de erro se o usuário não tiver permissão
        header("Location: ../templates/caixa.php?id=$id&alert=caixa_alert&mensagem=Usuário não tem permissão para alterar o caixa ou não existe!");
    }
} else {
    // Redireciona para a página do caixa com uma mensagem de erro se o formulário não foi submetido corretamente
    header("Location: ../templates/caixa.php?id=$id&alert=caixa_alert&mensagem=Não existe $_POST[submit]!");
}
?>