<?php // Enviar dados dos produtos para o Banco de Dados
    session_start();
    if(isset($_POST['submit'])){

        include_once('db.php');

        $referencia = str_pad($_POST['referencia'], 4, '0', STR_PAD_LEFT);
        $descricao = strtoupper($_POST['descricao']); 
        $modelo = strtoupper($_POST['modelo']);
        $marca = strtoupper($_POST['marca']);
        $fornecedor = strtoupper($_POST['fornecedor']);
        $qtd = $_POST['qtd'];
        $custo = $_POST['custo'];
        $venda = $_POST['venda'];
        $lucro = $venda-$custo;
        $custoEstoque = $qtd*$custo;
        $empresa = $_POST['empresa'];
        
        //seta fuso horário de brasília e pega data e hora separadas
        date_default_timezone_set('America/Sao_Paulo');
        $data = DATE("Y-m-d");
        $hora = DATE("H:i:s");

        $tabela = "produtos_" . strtolower(str_replace(' ', '_', $empresa));
        $referencia_exists_query = mysqli_query($db, "SELECT * FROM $tabela WHERE referencia='$referencia'");
        if (mysqli_num_rows($referencia_exists_query) > 0) {
            header('Location: ../templates/cadastro-produtos.php?alert=referencia_alert&mensagem=Esta referência já está cadastrada em outro produto. Por favor, escolha outra referência!');
        }else{
            $result = mysqli_query($db, "INSERT INTO $tabela ( referencia, descricao, modelo, marca, fornecedor, qtd, custo, venda, lucro, custoEstoque, empresa, data, hora) VALUES ( '$referencia', '$descricao', '$modelo', '$marca', '$fornecedor', '$qtd', '$custo', '$venda', '$lucro', '$custoEstoque', '$empresa', '$data', '$hora')");
    
            $email = $_SESSION['email'];
    
            $consult = "SELECT * FROM usuarios WHERE email = '$email'";
            $consult_result = $db->query($consult);
            $user_data = mysqli_fetch_assoc($consult_result);
            header("Location: ../templates/estoque.php?empresa=$user_data[empresa]&tipo=todos");
        }
    }
?>