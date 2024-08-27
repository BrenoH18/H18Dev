<?php
    // Importa as classes do PHPMailer para o namespace global
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;

    if (isset($_POST['submit'])) { // Verifica se o formulário foi enviado

        include_once('db.php'); // Inclui o arquivo de conexão com o banco de dados

        $email = $_POST['email']; // Recebe o email enviado pelo usuário

        // Verifica se o email está registrado no banco de dados
        $email_exists_query = mysqli_query($db, "SELECT * FROM usuarios WHERE email='$email'");
        if (mysqli_num_rows($email_exists_query) > 0) {

            date_default_timezone_set('America/Sao_Paulo'); // Define o fuso horário
            $dataAtual = DATE("Y-m-d"); // Obtém a data atual
            $horaAtual = DATE("H:i:s"); // Obtém a hora atual

            $token = uniqid(); // Gera um token único para a redefinição de senha

            // Coleta os dados do usuário com base no email
            $sql = "SELECT * FROM usuarios WHERE email = '$email'";
            $sql_result = $db->query($sql);
            $user_data = mysqli_fetch_assoc($sql_result);

            $nome = $user_data['nome']; // Obtém o nome do usuário
            $sobrenome = $user_data['sobrenome']; // Obtém o sobrenome do usuário
            
            // Insere os dados da solicitação de redefinição de senha na tabela
            $insertData = mysqli_query($db, "INSERT INTO solicita_redefinir_senha (email, dataAtual, horaAtual, token) VALUES ('$email', '$dataAtual', '$horaAtual', '$token')");

            require 'vendor/autoload.php'; // Carrega o autoload do PHPMailer

            // Cria uma nova instância do PHPMailer
            $mail = new PHPMailer();

            $mail->isSMTP(); // Configura o PHPMailer para usar SMTP
            $mail->Host = 'smtp.gmail.com'; // Define o servidor SMTP
            $mail->Port = 465; // Define a porta do SMTP
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Define o método de criptografia
            $mail->SMTPAuth = true; // Habilita autenticação SMTP
            $mail->Username = 'h18desenvolvimentos@gmail.com'; // Nome de usuário do SMTP
            $mail->Password = 'klro xaqw ghze ztpc'; // Senha do SMTP

            $mail->setFrom('h18desenvolvimentos@gmail.com', 'H18 Desenvolvimentos'); // Define o remetente
            $mail->addReplyTo('h18desenvolvimentos@gmail.com', 'H18 Desenvolvimentos'); // Define o endereço para respostas
            $mail->addAddress($email, $nome); // Define o destinatário

            $mail->isHTML(true); // Configura o e-mail para enviar HTML
            $mail->CharSet = 'UTF-8'; // Define a codificação de caracteres
            $mail->Subject = 'Redefinir senha'; // Define o assunto do e-mail

            // Define o corpo da mensagem em HTML
            $mail->Body = "
                        <h1>H18 Desenvolvimentos</h1>
                        <p>Olá, $nome $sobrenome.</p>
                        <p>Recebemos uma mensagem informando que você esqueceu sua senha. Se foi você, pode redefinir a senha agora.</p>        
                        <a href='http://localhost/h18dev/templates/rec-senha.php?token=$token'><button>Redefinir senha</button></a>";

            // Define o corpo alternativo da mensagem em texto
            $mail->AltBody = 'Olá, $nome $sobrenome. Recebemos uma mensagem informando que você esqueceu sua senha. Se foi você, pode redefinir a senha agora.';
            
            // Envia o e-mail e verifica se houve erro
            if (!$mail->send()) {
                // Caso haja erro, ele pode ser exibido ou registrado
                // echo 'Erro ao enviar mensagem: ' . $mail->ErrorInfo;
            } else {
                header('Location: ../templates/login.php?alert=login_alert&mensagem=E-mail enviado com sucesso!');
            }
        } else {
            header('Location: ../templates/solic-rec.php?alert=solic-rec_alert&mensagem=E-mail inválido, tente novamente!'); // Redireciona em caso de email não encontrado
        }
    }
?>