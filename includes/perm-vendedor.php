<?php
    if($user_data['permissao'] == 'dev'){
        $email = $_SESSION['email'];
    }elseif($user_data['permissao'] == 'admin'){
        $email = $_SESSION['email'];
    }elseif($user_data['permissao'] == 'vendedor'){
        $email = $_SESSION['email'];
    }else{
        $permissao = false;
        header("Location: ../templates/index.php?id=$user_data[id]");
    }
?>