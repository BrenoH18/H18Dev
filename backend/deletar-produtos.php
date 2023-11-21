<?php
    session_start();

    if(!empty($_GET['id'])){

        include_once('db.php');

        $empresa = $user_data['empresa'];
        $tabela = "produtos_" . strtolower(str_replace(' ', '_', $empresa));
        
        $id = $_GET['id'];

        $sqlSelect = "SELECT * FROM $tabela WHERE id=$id";

        $result = $db->query($sqlSelect);

        if($result->num_rows > 0){
            $sqlDelete = "DELETE FROM $tabela WHERE id=$id";
            $resultDelete = $db->query($sqlDelete);
        }
    }
    $email = $_SESSION['email'];

    $consult = "SELECT * FROM usuarios WHERE email = '$email'";
    $consult_result = $db->query($consult);
    $user_data = mysqli_fetch_assoc($consult_result);
    header("Location: ../templates/estoque.php?empresa=$user_data[empresa]&tipo=todos");
?>