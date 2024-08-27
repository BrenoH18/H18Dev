<?php
    session_start();
    
    if($_SESSION['logado'] == true){
        include_once('../backend/db.php');
       
        $email = $_SESSION['email'];
        
        $consult = "SELECT * FROM usuarios WHERE email = '$email'";
        $consult_result = $db->query($consult);
        $user_data = mysqli_fetch_assoc($consult_result);
        
    }else{
        session_destroy();
        header('Location: login.php');
    }
?>