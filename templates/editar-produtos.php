<?php
    include '../includes/autenticacao.php';
    include '../includes/perm-adm.php';
    include '../includes/alert.php';

    if(!empty($_GET['id'])){

        $id = $_GET['id'];

        $sqlSelect = "SELECT * FROM produtos WHERE id=$id";
        $result = $db->query($sqlSelect);

        if($result->num_rows > 0){
            while($product_data = mysqli_fetch_assoc($result)){
                $descricao = $product_data['descricao'];
                $modelo = $product_data['modelo'];
                $marca = $product_data['marca'];
                $fornecedor = $product_data['fornecedor'];
                $qtd = $product_data['qtd'];
                $custo = $product_data['custo'];
                $venda = $product_data['venda'];
            }
        }
        else{
            header("Location: estoque.php?id=$user_data[id]");
        }
    }
    else{
        header("Location: estoque.php?id=$user_data[id]");
    }
?>

<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>H18 Dev | Edição de produtos</title>
        <link rel="stylesheet" href="../static/css/reset.css">
        <link rel="stylesheet" href="../static/css/header.css">
        <link rel="stylesheet" href="../static/css/footer.css">
        <link rel="stylesheet" href="../static/css/editar-produtos.css">
    </head>
    <body>
        <?php include '../includes/header.php'; ?>
        <div class="content">
                <div class="form">
                    <form action="../backend/salvarEdicao-produtos.php" method="POST">
                        <fieldset class="fildset">
                            <h1 class="h1" id="h1-cadastro-produtos">Edição de Produtos</h1>
                            <br>
                            <input type="text" name="descricao" id="descricao" value="<?php echo $descricao ?>" class="inputUser" placeholder="Descrição" required>
                            <br><br>
                            <input type="text" name="modelo" id="modelo" value="<?php echo $modelo ?>" class="inputUser" placeholder="Modelo" required>
                            <br><br>
                            <input type="marca" name="marca" id="marca" value="<?php echo $marca ?>" class="inputUser" placeholder="Marca" required>
                            <br><br>
                            <input type="text" name="fornecedor" id="fornecedor" value="<?php echo $fornecedor ?>" class="inputUser" placeholder="Fornecedor" required>
                            <br><br>
                            <input type="number" name="qtd" id="qtd" value="<?php echo $qtd ?>" class="inputUser" placeholder="Preço de Custo" required>
                            <br><br>
                            <input type="number" step="0.01" name="custo" id="custo" value="<?php echo $custo ?>" class="inputUser" placeholder="Preço de Custo" required>
                            <br><br>
                            <input type="number" step="0.01" name="venda" id="venda" value="<?php echo $venda ?>" class="inputUser" placeholder="Preço de Venda" required>
                            <br><br>
                            <input type="hidden" name="id" value="<?php echo $id ?>">
                            <input type="submit" name="update" id="update" class="inputSubmit"><br>
                            <button class="btn-voltar" onclick="window.location.href='estoque.php?id=<?php echo $user_data['id']?>&tipo=todos'">Voltar</button>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
        <?php include '../includes/footer.php'; ?>
    </body>
</html>