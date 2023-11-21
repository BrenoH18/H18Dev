<?php
    session_start();

    include_once('db.php');

    if($_POST['update']){

        $id= $_POST['id'];
        $descricao = strtoupper($_POST['descricao']); 
        $modelo = strtoupper($_POST['modelo']);
        $marca = strtoupper($_POST['marca']);
        $fornecedor = strtoupper($_POST['fornecedor']);
        $qtd = $_POST['qtd'];
        $custo = $_POST['custo'];
        $venda = $_POST['venda'];
        $custoEstoque = $qtd*$custo;
        $lucro = $venda-$custo;

        $empresa = $user_data['empresa'];
        $tabela = "produtos_" . strtolower(str_replace(' ', '_', $empresa));

        $sqlUpdate = "UPDATE $tabela SET descricao='$descricao', modelo='$modelo', marca='$marca', fornecedor='$fornecedor', qtd='$qtd', custo='$custo', venda='$venda', lucro='$lucro', custoEstoque='$custoEstoque' WHERE id='$id'";

        $result = $db->query($sqlUpdate);
    }
    $email = $_SESSION['email'];

    $consult = "SELECT * FROM usuarios WHERE email = '$email'";
    $consult_result = $db->query($consult);
    $user_data = mysqli_fetch_assoc($consult_result);
    header("Location: ../templates/estoque.php?empresa=$user_data[empresa]&tipo=todos");
?>