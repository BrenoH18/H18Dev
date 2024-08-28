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
    
    $id = $user_data['id'];
    
    // Verifica a senha e permissões do usuário
    if ((password_verify($senha, $user_data['senha']) and $_SESSION['email'] == $email) and ($user_data['permissao'] == 'admin' or $user_data['permissao'] == 'dev')) {

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
            $sqlDataCaixa = "SELECT * FROM $tabelaCaixa WHERE empresa ='$empresa' and dataAtual = '$dataAtual'";
            $resultDataCaixa = $db->query($sqlDataCaixa) or die($db->error);
            $dataCaixa = mysqli_fetch_assoc($resultDataCaixa);

            if(isset($dataCaixa)){
                $descMov = 'Reabertura de Caixa';
                $valorMov = $_POST['saldoInicial'];
                $idCaixa = $dataCaixa['id'];

                // Inserção de movimentação
                $stmt = mysqli_prepare($db, "INSERT INTO $tabelaMov (usuario, empresa, descMov, valorMov, dataMov, horaMov, idCaixa, statusCaixa) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                mysqli_stmt_bind_param($stmt, 'ssssssss', $email, $empresa, $descMov, $valorMov, $dataAtual, $horaAtual, $idCaixa, $status);
                mysqli_stmt_execute($stmt);

                // Reabertura de Movimentações
                $stmt2 = mysqli_prepare($db, "UPDATE $tabelaMov SET statusCaixa=? WHERE idCaixa=$idCaixa");
                mysqli_stmt_bind_param($stmt2, 's', $status);
                mysqli_stmt_execute($stmt2);

                // Atualização do caixa
                $totalMov = $dataCaixa['totalMov'] + $valorMov;
                $saldo = $dataCaixa['saldo'] + $valorMov;
                
                $stmt2 = mysqli_prepare($db, "UPDATE $tabelaCaixa SET totalMov=?, saldo=?, statusCaixa=? WHERE id=$idCaixa");
                mysqli_stmt_bind_param($stmt2, 'sss', $totalMov, $saldo, $status);
                mysqli_stmt_execute($stmt2);


                header("Location: ../templates/caixa.php?id=$id&alert=caixa_alert&mensagem=Caixa reaberto com sucesso!");
            }else{
                // Insere novo registro de caixa no banco de dados
                $result = mysqli_query($db, "INSERT INTO $tabelaCaixa(usuario, empresa, saldoInicial, saldo, dataAtual, horaAtual, statusCaixa) VALUES ('$email', '$empresa', '$saldoInicial', '$saldoInicial', '$dataAtual', '$horaAtual', '$status')");
                header("Location: ../templates/caixa.php?id=$id&alert=caixa_alert&mensagem=Caixa aberto com sucesso!");
            }
        } else {
            header("Location: ../templates/caixa.php?id=$id&alert=caixa_alert&mensagem=O caixa já se encontra aberto!");
        }

    } elseif ((password_verify($senha, $user_data['senha']) and $_SESSION['email'] != $email) or ($user_data['permissao'] != 'administrador' and $user_data['permissao'] != 'desenvolvedor')) {
        // Caso o usuário não tenha permissão ou as credenciais estejam incorretas
        header("Location: ../templates/caixa.php?id=$id&alert=caixa_alert&mensagem=Usuário não tem permissão para alterar o caixa ou não existe!");
    }
} else {
    // Caso o formulário não tenha sido submetido corretamente
    header("Location: ../templates/caixa.php?id=$id&alert=caixa_alert&mensagem=Não existe $_POST[submit]!");
}
?>