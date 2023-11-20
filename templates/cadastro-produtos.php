<?php
    include '../includes/autenticacao.php';
    include '../includes/permissao.php';
    include '../includes/alert.php'; 
?>

<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>H18 Dev | Cadastro de produtos</title>
        <link rel="stylesheet" href="../static/css/reset.css">
        <link rel="stylesheet" href="../static/css/header.css">
        <link rel="stylesheet" href="../static/css/footer.css">
        <link rel="stylesheet" href="../static/css/cadastro-produtos.css">
    </head>
    <body>
        <?php include '../includes/header.php'; ?>
        <div class="content">
            <div class="form">
                <form action="../backend/cadastrar-produtos.php?id=<?php echo $user_data['id']?>" method="POST">
                    <fieldset class="fildset">
                        <h1 class="h1" id="h1-cadastro-produtos">Cadastro de Produtos</h1>
                        <br>
                        <input type="number" name="referencia" id="referencia" class="inputUser" placeholder="Referência" required>
                        <br><br>
                        <input type="text" name="descricao" id="descricao" class="inputUser" placeholder="Descrição" required>
                        <br><br>
                        <input type="text" name="modelo" id="modelo" class="inputUser" placeholder="Modelo" required>
                        <br><br>
                        <input type="marca" name="marca" id="marca" class="inputUser" placeholder="Marca" required>
                        <br><br>
                        <input type="text" name="fornecedor" id="fornecedor" class="inputUser" placeholder="Fornecedor" required>
                        <br><br>
                        <input type="number" name="qtd" id="qtd" class="inputUser" placeholder="Quantidade" required>
                        <br><br>
                        <input type="number" step="0.01" name="custo" id="custo" class="inputUser" placeholder="Preço de Custo" required>
                        <br><br>
                        <input type="number" step="0.01" name="venda" id="venda" class="inputUser" placeholder="Preço de Venda" required>
                        <br><br>
                        <input type="hidden" name="id_user" value="<?php echo $user_data['id'] ?>">
                        <input type="submit" name="submit" id="submit" class="inputSubmit"><br>
                        <button class="btn-voltar" onclick="window.location.href='estoque.php?id=<?php echo $user_data['id']?>&tipo=todos'">Voltar</button>
                    </fieldset>
                </form>
            </div>
        </div>
        <?php include '../includes/footer.php'; ?>
    </body>
</html>