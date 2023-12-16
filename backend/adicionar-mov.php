<?php

    session_start();

    if(isset($_POST['submit'])){
        include_once('db.php');

        $email = $_POST['email'];
        $senha = $_POST['senha'];

        $sql = "SELECT * FROM usuarios WHERE email = '$email' LIMIT 1";
        $result = $db->query($sql) or die($db->error);
        $user_data = mysqli_fetch_assoc($result);
        
        $empresa = $user_data['empresa'];

        $dbName = "db_" . strtolower(str_replace(' ', '_', $empresa));
        $db = new mysqli($dbhost, $dbUsername, $dbPassword, $dbName);

        $tabelaCaixa = "caixa";
        $tabelaMov = "movimentacoes";
        
        $sqlCaixa = "SELECT * FROM $tabelaCaixa WHERE empresa = '$empresa' and statusCaixa = 'A'";
        $sqlCaixa_result = $db->query($sqlCaixa);
        $caixaData = mysqli_fetch_assoc($sqlCaixa_result);

        $totalMovAntigo = $caixaData['totalMov'];
        $idCaixa = $caixaData['id'];
        $statusCaixa = $caixaData['statusCaixa'];

        $descMov = $_POST['descMov'];
        $valorMov = $_POST['valorMov'];
        $totalMov = $totalMovAntigo+$valorMov;

        //seta fuso horário de brasília e pega data e hora separadas
        date_default_timezone_set('America/Sao_Paulo');
        $dataAtual = DATE("Y-m-d");
        $horaAtual = DATE("H:i:s");

        if ((password_verify($senha, $user_data['senha']) and $_SESSION['email'] == $email) and ($user_data['permissao'] == 'administrador' or $user_data['permissao'] == 'desenvolvedor')) {
            $result = mysqli_query($db, "INSERT INTO $tabelaMov (usuario, empresa, descMov, valorMov, dataMov, horaMov, idCaixa, statusCaixa) VALUES ('$email', '$empresa', '$descMov', '$valorMov', '$dataAtual', '$horaAtual', '$idCaixa', '$statusCaixa')");

            $result2 = mysqli_query($db, "UPDATE $tabelaCaixa SET totalMov='$totalMov' WHERE statusCaixa='A'");

            header('Location: ../templates/caixa.php?alert=caixa_alert&mensagem=Movimentação adicionada com sucesso!');
        }elseif ((password_verify($senha, $user_data['senha']) and $_SESSION['email'] != $email) or ($user_data['permissao'] != 'administrador' and $user_data['permissao'] != 'desenvolvedor')) {
            header('Location: ../templates/caixa.php?alert=caixa_alert&mensagem=Usuário não tem permissão para alterar o caixa ou não existe!');
        }
    }else{
        header('Location: ../templates/caixa.php?alert=caixa_alert&mensagem=Não existe $_POST[submit]!');
    }
?>