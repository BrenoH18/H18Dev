<?php
    session_start();
    if(!empty($_GET['id'])){

        include_once('db.php');

        $id = $_GET['id'];

        $sqlSelect = "SELECT * FROM produtos WHERE id=$id";

        $result = $db->query($sqlSelect);

        if($result->num_rows > 0){
            $sqlDelete = "DELETE FROM produtos WHERE id=$id";
            $resultDelete = $db->query($sqlDelete);
        }
    }
    $email = $_SESSION['email'];

    $consult = "SELECT * FROM usuarios WHERE email = '$email'";
    $consult_result = $db->query($consult);
    $user_data = mysqli_fetch_assoc($consult_result);
    header("Location: ../templates/estoque.php?id=$user_data[id]&tipo=todos");
?>