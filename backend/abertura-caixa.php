<?php

    session_start();

    if(isset($_POST['submit'])){

        include_once('db.php');

        $email = $_POST['email'];
        $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
        $saldoInicial = $_POST['saldoInicial'];
        $status = 'A';

        $sql = "SELECT * FROM usuarios WHERE email = '$email' LIMIT 1";
        $result = $db->query($sql) or die($db->error);
        $user_data = mysqli_fetch_assoc($result);

        $empresa = $user_data['empresa'];

        //seta fuso horário de brasília e pega data e hora separadas
        date_default_timezone_set('America/Sao_Paulo');
        $dataAtual = DATE("Y-m-d");
        $horaAtual = DATE("H:i:s");

        // Verificar se o email já está registrado no banco de dados
        $email_exists_query = mysqli_query($db, "SELECT * FROM usuarios WHERE email='$email'");

        $sqlStatus = "SELECT * FROM $tabelaCaixa WHERE empresa ='$empresa' and statusCaixa = 'A'";
        $resultStatus = $db->query($sqlStatus) or die($db->error);
        $status_caixa = mysqli_fetch_assoc($resultStatus);

        if (!isset($status_caixa['statusCaixa'])){
            $result = mysqli_query($db, "INSERT INTO $tabelaCaixa(usuario, empresa, saldoInicial, saldo, dataAtual, horaAtual, statusCaixa) VALUES ('$email', '$empresa', '$saldoInicial', '$saldoInicial', '$dataAtual', '$horaAtual', '$status')");
            header('Location: ../templates/caixa.php?alert=caixa_alert&mensagem=Caixa aberto com sucesso!');
        }else{
            header('Location: ../templates/caixa.php?alert=caixa_alert&mensagem=O caixa já se encontra aberto!');
        }
    }
?>
