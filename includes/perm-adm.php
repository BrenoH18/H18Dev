<?php
    if($user_data['permissao'] == 'desenvolvedor'){
        $permissao = true;
        $email = $_SESSION['email'];
    }elseif($user_data['permissao'] == 'administrador'){
        
    }else{
        $permissao = false;
        header("Location: ../templates/index.php?id=$user_data[id]");
    }
?>