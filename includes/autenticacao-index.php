<?php
    session_start();

    if($_SESSION['logado'] == true){

        $email = $_SESSION['email'];
        
        include_once('backend/db.php');
        
        $consult = "SELECT * FROM usuarios WHERE email = '$email'";
        $consult_result = $db->query($consult);
        $user_data = mysqli_fetch_assoc($consult_result);
        
    }else{
        session_destroy();
        header('Location: templates/login.php');
    }
?>