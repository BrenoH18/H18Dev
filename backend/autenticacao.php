<?php
    session_start();

    if(isset($_POST['submit'])){
        include_once('db.php');

        $email = $_POST['email'];
        $senha = $_POST['senha'];

        $sql = "SELECT * FROM usuarios WHERE email = '$email' LIMIT 1";
        $result = $db->query($sql) or die($db->error);
        $user_data = mysqli_fetch_assoc($result);

        if(password_verify($senha, $user_data['senha'])){
            $_SESSION['logado'] = true;
            $_SESSION['email'] = $email;

            header("Location: ../index.php?id=$user_data[id]");
        }else{
            $_SESSION['logado'] = false;
            header('Location: ../templates/login.php?alert=login_alert&mensagem=Email ou senha incorretos, tente novamente!');
        }
    }else{
        header('Location: ../templates/login.php');
    }
?>
