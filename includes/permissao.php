<?php
    if($user_data['permissao'] == 1){
        $permissao = true;
        $email = $_SESSION['email'];
    }else{
        $permissao = false;
        header("Location: ../index.php?id=$user_data[id]");
    }
?>