<?php

    session_start();

    if(isset($_POST['submit'])){
        include_once('db.php');

        $email = $_POST['email'];
        $senha = $_POST['senha'];

        $sql = "SELECT * FROM usuarios WHERE email = '$email' LIMIT 1";
        $result = $db->query($sql) or die($db->error);
        $user_data = mysqli_fetch_assoc($result);

        if ((password_verify($senha, $user_data['senha']) and $_SESSION['email'] == $email) and ($user_data['permissao'] == 'administrador' or $user_data['permissao'] == 'desenvolvedor')) {
            $status = 'F';

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
            
            $dbName = "db_" . strtolower(str_replace(' ', '_', $empresa));
            $db = new mysqli($dbhost, $dbUsername, $dbPassword, $dbName);

            $tabelaCaixa = "caixa";
            $tabelaMov = "movimentacoes";
            
            $sqlStatus = "SELECT * FROM $tabelaCaixa WHERE empresa ='$empresa' and statusCaixa = 'A'";
            $resultStatus = $db->query($sqlStatus) or die($db->error);
            $status_caixa = mysqli_fetch_assoc($resultStatus);

            if (!isset($status_caixa['statusCaixa'])){
                header('Location: ../templates/caixa.php?alert=caixa_alert&mensagem=Não existe nenhum caixa em aberto!');
            }else{
                if (mysqli_num_rows($email_exists_query) > 0 && $status_caixa['statusCaixa'] == 'A') {
                    $result = mysqli_query($db, "UPDATE $tabelaCaixa SET statusCaixa='$status'");

                    $result2 = mysqli_query($db, "UPDATE $tabelaMov SET statusCaixa='$status'");

                    header('Location: ../templates/caixa.php?alert=caixa_alert&mensagem=Caixa Fechado com sucesso!');
                }else{
                    header('Location: ../templates/caixa.php?alert=caixa_alert&mensagem=Não existe nenhum caixa em aberto!');
                }
            }
       
        }elseif ((password_verify($senha, $user_data['senha']) and $_SESSION['email'] != $email) or ($user_data['permissao'] != 'administrador' and $user_data['permissao'] != 'desenvolvedor')) {
            header('Location: ../templates/caixa.php?alert=caixa_alert&mensagem=Usuário não tem permissão para alterar o caixa ou não existe!');
        }
    }else{
        header('Location: ../templates/caixa.php?alert=caixa_alert&mensagem=Não existe $_POST[submit]!');
    }
?>