<?php
    if($user_data['permissao'] == 'dev'){
        $permissao = true;
        $email = $_SESSION['email'];
    }else{
        $permissao = false;
        header("Location: ../templates/index.php?id=$user_data[id]");
    }
?>