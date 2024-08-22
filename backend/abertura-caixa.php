<?php

session_start();

if(isset($_POST['submit'])){
    include_once('db.php');

    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Busca o usuário no banco de dados pelo email
    $sql = "SELECT * FROM usuarios WHERE email = '$email' LIMIT 1";
    $result = $db->query($sql) or die($db->error);
    $user_data = mysqli_fetch_assoc($result);
    
    // Verifica a senha e permissões do usuário
    if ((password_verify($senha, $user_data['senha']) and $_SESSION['email'] == $email) and ($user_data['permissao'] == 'administrador' or $user_data['permissao'] == 'desenvolvedor')) {

        $saldoInicial = $_POST['saldoInicial'];
        $status = 'A';

        $empresa = $user_data['empresa'];

        // Seta fuso horário de Brasília e pega data e hora atuais
        date_default_timezone_set('America/Sao_Paulo');
        $dataAtual = DATE("Y-m-d");
        $horaAtual = DATE("H:i:s");

        // Verifica se já existe um caixa aberto para a empresa
        $sqlStatus = "SELECT * FROM $tabelaCaixa WHERE empresa ='$empresa' and statusCaixa = 'A'";
        $resultStatus = $db->query($sqlStatus) or die($db->error);
        $status_caixa = mysqli_fetch_assoc($resultStatus);

        if (!isset($status_caixa['statusCaixa'])){
            // Insere novo registro de caixa no banco de dados
            $result = mysqli_query($db, "INSERT INTO $tabelaCaixa(usuario, empresa, saldoInicial, saldo, dataAtual, horaAtual, statusCaixa) VALUES ('$email', '$empresa', '$saldoInicial', '$saldoInicial', '$dataAtual', '$horaAtual', '$status')");
            header('Location: ../templates/caixa.php?alert=caixa_alert&mensagem=Caixa aberto com sucesso!');
        } else {
            header('Location: ../templates/caixa.php?alert=caixa_alert&mensagem=O caixa já se encontra aberto!');
        }

    } elseif ((password_verify($senha, $user_data['senha']) and $_SESSION['email'] != $email) or ($user_data['permissao'] != 'administrador' and $user_data['permissao'] != 'desenvolvedor')) {
        // Caso o usuário não tenha permissão ou as credenciais estejam incorretas
        header('Location: ../templates/caixa.php?alert=caixa_alert&mensagem=Usuário não tem permissão para alterar o caixa ou não existe!');
    }
} else {
    // Caso o formulário não tenha sido submetido corretamente
    header('Location: ../templates/caixa.php?alert=caixa_alert&mensagem=Não existe $_POST[submit]!');
}
?>