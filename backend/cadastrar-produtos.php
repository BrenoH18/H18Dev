<?php
    session_start(); // Inicia a sessão para acessar variáveis globais de sessão

    if (isset($_POST['submit'])) { // Verifica se o formulário foi enviado

        include_once('db.php'); // Inclui o arquivo de conexão com o banco de dados

        // Formata e prepara os dados enviados pelo formulário
        $referencia = str_pad($_POST['referencia'], 4, '0', STR_PAD_LEFT); // Adiciona zeros à esquerda da referência para garantir 4 dígitos
        $descricao = strtoupper($_POST['descricao']); // Converte a descrição para maiúsculas
        $modelo = strtoupper($_POST['modelo']); // Converte o modelo para maiúsculas
        $marca = strtoupper($_POST['marca']); // Converte a marca para maiúsculas
        $fornecedor = strtoupper($_POST['fornecedor']); // Converte o fornecedor para maiúsculas
        $qtd = $_POST['qtd']; // Quantidade do produto
        $custo = $_POST['custo']; // Custo do produto
        $venda = $_POST['venda']; // Preço de venda do produto
        $lucro = $venda - $custo; // Calcula o lucro do produto
        $custoEstoque = $qtd * $custo; // Calcula o custo total do estoque para a quantidade especificada
        $empresa = $_POST['empresa']; // Nome da empresa

        // Define o fuso horário e obtém a data e a hora atuais
        date_default_timezone_set('America/Sao_Paulo');
        $data = DATE("Y-m-d"); // Data atual
        $hora = DATE("H:i:s"); // Hora atual

        // Cria o nome da tabela baseado no nome da empresa
        $tabela = "produtos_" . strtolower(str_replace(' ', '_', $empresa));

        // Verifica se a referência já existe na tabela
        $referencia_exists_query = mysqli_query($db, "SELECT * FROM $tabela WHERE referencia='$referencia'");
        if (mysqli_num_rows($referencia_exists_query) > 0) {
            // Se a referência já existe, redireciona o usuário com uma mensagem de alerta
            header('Location: ../templates/cadastro-produtos.php?alert=referencia_alert&mensagem=Esta referência já está cadastrada em outro produto. Por favor, escolha outra referência!');
        } else {
            // Se a referência não existe, insere os dados do produto na tabela correspondente
            $result = mysqli_query($db, "INSERT INTO $tabela (referencia, descricao, modelo, marca, fornecedor, qtd, custo, venda, lucro, custoEstoque, empresa, data, hora) VALUES ('$referencia', '$descricao', '$modelo', '$marca', '$fornecedor', '$qtd', '$custo', '$venda', '$lucro', '$custoEstoque', '$empresa', '$data', '$hora')");

            // Obtém o email do usuário logado na sessão
            $email = $_SESSION['email'];

            // Consulta os dados do usuário logado
            $consult = "SELECT * FROM usuarios WHERE email = '$email'";
            $consult_result = $db->query($consult);
            $user_data = mysqli_fetch_assoc($consult_result);

            // Redireciona o usuário para a página de estoque com os dados da empresa
            header("Location: ../templates/estoque.php?empresa=$user_data[empresa]&tipo=todos");
        }
    }
?>