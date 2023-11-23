<?php
    if($user_data['permissao'] == 'desenvolvedor'){
        $email = $_SESSION['email'];
    }elseif($user_data['permissao'] == 'administrador'){
        $email = $_SESSION['email'];
    }elseif($user_data['permissao'] == 'vendedor'){
        $email = $_SESSION['email'];
    }else{
        $permissao = false;
        header("Location: ../templates/index.php?id=$user_data[id]");
    }
?>