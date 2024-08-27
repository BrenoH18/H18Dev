<?php
    if($user_data['permissao'] == 'dev'){
        $permissao = true;
        $email = $_SESSION['email'];
    }elseif($user_data['permissao'] == 'admin'){
        
    }else{
        $permissao = false;
        header("Location: ../templates/index.php?id=$user_data[id]");
    }
?>