<?php
    // Importa as classes do PHPMailer para o namespace global
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;

    if(isset($_POST['submit'])){

        include_once('db.php');

        //recebe email enviado pelo usuário
        $email = $_POST['email'];

        // Verificar se o email já está registrado no banco de dados
        $email_exists_query = mysqli_query($db, "SELECT * FROM usuarios WHERE email='$email'");
        if (mysqli_num_rows($email_exists_query) > 0) {

            //seta fuso horário de brasília e pega data e hora separadas
            date_default_timezone_set('America/Sao_Paulo');
            $dataAtual = DATE("Y-m-d");
            $horaAtual = DATE("H:i:s");
    
            $token = uniqid();
    
            //coletar dados do usuário
            $sql = "SELECT * FROM usuarios WHERE email = '$email'";
            $sql_result = $db->query($sql);
            $user_data = mysqli_fetch_assoc($sql_result);
    
            $nome = $user_data['nome'];
            $sobrenome = $user_data['sobrenome'];
            
            //inserir dados na tabela
            $insertData = mysqli_query($db, "INSERT INTO solicita_redefinir_senha (email, dataAtual, horaAtual, token) VALUES ('$email', '$dataAtual', '$horaAtual', '$token')");
    
            //Enviar email
            /**
             * Este exemplo mostra configurações para usar ao enviar e-mails pelos servidores do Gmail.
             * Isso utiliza autenticação tradicional com id e senha - veja o exemplo gmail_xoauth.phps
             * para ver como usar o XOAUTH2.
             * A seção IMAP mostra como salvar essa mensagem na pasta 'Sent Mail' usando comandos IMAP.
             */
    
            require 'vendor/autoload.php';
    
            // Cria uma nova instância do PHPMailer
            $mail = new PHPMailer();
    
            // Informa ao PHPMailer para usar SMTP
            $mail->isSMTP();
    
            // Habilita a depuração SMTP
            // SMTP::DEBUG_OFF = desativado (para uso em produção)
            // SMTP::DEBUG_CLIENT = mensagens do cliente
            // SMTP::DEBUG_SERVER = mensagens do cliente e servidor
            // $mail->SMTPDebug = SMTP::DEBUG_SERVER;
    
            // Define o nome do host do servidor de e-mail
            $mail->Host = 'smtp.gmail.com';
            // Use `$mail->Host = gethostbyname('smtp.gmail.com');`
            // se sua rede não suportar SMTP sobre IPv6,
            // embora isso possa causar problemas com o TLS
    
            // Define o número da porta SMTP:
            // - 465 para SMTP com TLS implícito, também conhecido como RFC8314 SMTPS ou
            // - 587 para SMTP+STARTTLS
            $mail->Port = 465;
    
            // Define o mecanismo de criptografia a ser usado:
            // - SMTPS (TLS implícito na porta 465) ou
            // - STARTTLS (TLS explícito na porta 587)
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    
            // Define se deve usar autenticação SMTP
            $mail->SMTPAuth = true;
    
            // Nome de usuário para autenticação SMTP - use o endereço de e-mail completo para o Gmail
            $mail->Username = 'h18desenvolvimentos@gmail.com';
    
            // Senha para autenticação SMTP
            $mail->Password = 'klro xaqw ghze ztpc';
    
            // Define quem enviará a mensagem
            // Note que com o Gmail, você só pode usar seu endereço de conta (igual a `Username`)
            // ou aliases predefinidos que você configurou em sua conta.
            // Não use endereços enviados pelo usuário aqui
            $mail->setFrom('h18desenvolvimentos@gmail.com', 'H18 Desenvolvimentos');
    
            // Define um endereço alternativo para respostas
            // Este é um bom lugar para colocar endereços enviados pelo usuário
            $mail->addReplyTo('h18desenvolvimentos@gmail.com', 'H18 Desenvolvimentos');
    
            // Define quem receberá a mensagem
            $mail->addAddress($email, $nome);
    
            // Configuração para enviar mensagens HTML
            $mail->isHTML(true);
            
            // Configuração de codificação UTF-8
            $mail->CharSet = 'UTF-8';

            // Define a linha de assunto
            $mail->Subject = 'Redefinir senha';
    
            // Lê um corpo de mensagem HTML de um arquivo externo, converte imagens referenciadas para incorporadas,
            // converte HTML em um corpo de texto alternativo básico
            $mail->Body = "
                        <h1>H18 Desenvolvimentos</h1>
                        <p>Olá, $nome $sobrenome.</p>
                        <p>Recebemos uma mensagem informando que você esqueceu sua senha. Se foi você, pode redefinir a senha agora.</p>        
                        <a href='http://localhost/GitHub/H18-Dev-Site/templates/rec-senha.php?token=$token'><button>Redefinir senha</button></a>";
    
            // Substitui o corpo de texto simples por um criado manualmente
            $mail->AltBody = 'Olá, $nome $sobrenome.
            Recebemos uma mensagem informando que você esqueceu sua senha. Se foi você, pode redefinir a senha agora.';
    
            // Anexa um arquivo de imagem
            // $mail->addAttachment('imagens/phpmailer_mini.png');
    
            // Envia a mensagem e verifica erros
            if (!$mail->send()) {
                // echo 'Erro ao enviar mensagem: ' . $mail->ErrorInfo;
            } else {
                header('Location: ../templates/solic-sucess.php');
                // Seção 2: IMAP
                // Descomente estas linhas para salvar sua mensagem na pasta 'Sent Mail'.
                // if (save_mail($mail)) {
                //     echo "Mensagem salva!";
                // }
            }
    
            // Seção 2: IMAP
            // Os comandos IMAP requerem a Extensão IMAP do PHP, encontrada em: https://php.net/manual/en/imap.setup.php
            // Função a ser chamada que utiliza as funções PHP imap_*() para salvar mensagens: https://php.net/manual/en/book.imap.php
            // Você pode usar imap_getmailboxes($imapStream, '/imap/ssl', '*' ) para obter uma lista de pastas ou rótulos disponíveis,
            // o que pode ser útil se você estiver tentando fazer isso funcionar em um servidor IMAP que não seja do Gmail.
            // function save_mail($mail)
            // {
            //     // Você pode alterar 'Sent Mail' para qualquer outra pasta ou etiqueta desejada
            //     $caminho = '{imap.gmail.com:993/imap/ssl}[Gmail]/Sent Mail';
    
            //     // Informa ao seu servidor para abrir uma conexão IMAP usando o mesmo nome de usuário e senha que você usou para o SMTP
            //     $imapStream = imap_open($caminho, $mail->Username, $mail->Password);
    
            //     $resultado = imap_append($imapStream, $caminho, $mail->getSentMIMEMessage());
            //     imap_close($imapStream);
    
            //     return $resultado;
            // }
        }else{
            header('Location: ../templates/solic-rec.php?alert=email-env&mensagem=Não há usuário com o email informado, tente novamente!');
        }
    }
?>