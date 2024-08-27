<?php

    session_start(); // Inicia a sessão para acessar variáveis globais de sessão

    if (isset($_POST['submit'])) { // Verifica se o formulário foi enviado
        include_once('db.php'); // Inclui o arquivo de conexão com o banco de dados

        $email = $_POST['email']; // Armazena o email enviado pelo formulário
        $senha = $_POST['senha']; // Armazena a senha enviada pelo formulário

        // Prepara e executa a consulta para buscar o usuário pelo email
        $sql = "SELECT * FROM usuarios WHERE email = '$email' LIMIT 1";
        $result = $db->query($sql) or die($db->error);
        $user_data = mysqli_fetch_assoc($result); // Obtém os dados do usuário

        // Verifica se a senha está correta, se o email na sessão corresponde ao email fornecido,
        // e se o usuário tem permissão de administrador ou desenvolvedor
        if ((password_verify($senha, $user_data['senha']) && $_SESSION['email'] == $email) &&
            ($user_data['permissao'] == 'admin' || $user_data['permissao'] == 'dev')) {
            
            $status = 'F'; // Define o novo status do caixa como fechado

            // Executa novamente a consulta para obter os dados mais atualizados do usuário
            $sql = "SELECT * FROM usuarios WHERE email = '$email' LIMIT 1";
            $result = $db->query($sql) or die($db->error);
            $user_data = mysqli_fetch_assoc($result);

            $id = $user_data['id'];

            $empresa = $user_data['empresa']; // Obtém o nome da empresa do usuário

            // Define o fuso horário e captura a data e a hora atuais
            date_default_timezone_set('America/Sao_Paulo');
            $dataAtual = DATE("Y-m-d");
            $horaAtual = DATE("H:i:s");

            // Verifica se o email está registrado no banco de dados
            $email_exists_query = mysqli_query($db, "SELECT * FROM usuarios WHERE email='$email'");
            
            // Prepara a consulta para verificar se existe um caixa aberto para a empresa
            $sqlStatus = "SELECT * FROM $tabelaCaixa WHERE empresa ='$empresa' and statusCaixa = 'A'";
            $resultStatus = $db->query($sqlStatus) or die($db->error);
            $status_caixa = mysqli_fetch_assoc($resultStatus); // Obtém o status do caixa

            // Verifica se existe um caixa em aberto
            if (!isset($status_caixa['statusCaixa'])) {
                // Redireciona com mensagem de alerta se não houver caixa aberto
                header("Location: ../templates/caixa.php?id=$id&alert=caixa_alert&mensagem=Não existe nenhum caixa em aberto!");
            } else {
                // Verifica se o email existe e se o caixa está aberto
                if (mysqli_num_rows($email_exists_query) > 0 && $status_caixa['statusCaixa'] == 'A') {
                    // Atualiza o status do caixa para fechado
                    $result = mysqli_query($db, "UPDATE $tabelaCaixa SET statusCaixa='$status'");

                    // Atualiza o status das movimentações relacionadas ao caixa para fechado
                    $result2 = mysqli_query($db, "UPDATE $tabelaMov SET statusCaixa='$status'");

                    // Redireciona com mensagem de sucesso após fechar o caixa
                    header("Location: ../templates/caixa.php?id=$id&alert=caixa_alert&mensagem=Caixa Fechado com sucesso!");
                } else {
                    // Redireciona com mensagem de alerta se não houver caixa aberto
                    header("Location: ../templates/caixa.php?id=$id&alert=caixa_alert&mensagem=Não existe nenhum caixa em aberto!");
                }
            }
       
        } elseif ((password_verify($senha, $user_data['senha']) && $_SESSION['email'] != $email) ||
                  ($user_data['permissao'] != 'administrador' && $user_data['permissao'] != 'desenvolvedor')) {
            // Redireciona com mensagem de alerta se o usuário não tiver permissão ou se o email não corresponder
            header("Location: ../templates/caixa.php?id=$id&alert=caixa_alert&mensagem=Usuário não tem permissão para alterar o caixa ou não existe!");
        }
    } else {
        // Redireciona com mensagem de alerta se o formulário não foi enviado corretamente
        header("Location: ../templates/caixa.php?id=$id&alert=caixa_alert&mensagem=Não existe $_POST[submit]!");
    }
?>