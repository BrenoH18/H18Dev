<?php
    session_start();

    if(isset($_POST['submit'])){
        include_once('db.php');

        $email = $_POST['email'];
        $senha = $_POST['senha'];


        $sql = "SELECT * FROM usuarios WHERE email = '$email' LIMIT 1";
        $result = $db->query($sql) or die($db->error);
        $user_data = mysqli_fetch_assoc($result);

        if($user_data){
    
            if(password_verify($senha, $user_data['senha'])){
                $_SESSION['logado'] = true;
                $_SESSION['email'] = $email;
                
                header("Location: ../templates/index.php?id=$user_data[id]?alert=login_alert&mensagem=Login efetuado!");
            }else{
                $_SESSION['logado'] = false;
                header('Location: ../templates/login.php?alert=login_alert&mensagem=Senha incorreta, tente novamente!');
            }
        }else{
            $_SESSION['logado'] = false;
                header('Location: ../templates/login.php?alert=login_alert&mensagem=E-mail não encontrado, tente novamente!');
        }
        
    }else{
        header('Location: ../templates/login.php');
    }
?>
