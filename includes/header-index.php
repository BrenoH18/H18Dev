<?php
    $id = $user_data['id'];
    $empresa = $user_data['empresa'];

    function navbar($user_data, $empresa, $id){
        if($user_data['permissao'] == 'desenvolvedor'){
            echo"<nav class='navbar'>";
                echo "<a href='templates/compras.php?id=$id' class='icon' id='icon-compras'>Compra de Produtos</a>";
                echo "<a href='templates/vendas.php?id=$id' class='icon 'id='icon-vendas'>Venda de Produtos</a>";
                echo "<a href='templates/estoque.php?empresa=<?php echo $empresa?>&tipo=todos' class='icon' id='icon-estoque'>Estoque de Produtos</a>";
                echo "<a href='templates/cadastro-empresas.php?id=$id&tipo=todos' class='icon' id='icon-cad-empresas'>Cadastro de Empresas</a>";
            echo"</nav>";
        }elseif($user_data['permissao'] == 'administrador'){
            echo"<nav class='navbar'>";
                echo "<a href='templates/compras.php?id=$id' class='icon' id='icon-compras'>Compra de Produtos</a>";
                echo "<a href='templates/vendas.php?id=$id' class='icon 'id='icon-vendas'>Venda de Produtos</a>";
                echo "<a href='templates/estoque.php?empresa=<?php echo $empresa?>&tipo=todos' class='icon' id='icon-estoque'>Estoque de Produtos</a>";
            echo"</nav>";
        }elseif($user_data['permissao'] == 'vendedor'){
            echo"<nav class='navbar'>";
                echo "<a href='templates/vendas.php?id=$id' class='icon 'id='icon-vendas'>Venda de Produtos</a>";
            echo"</nav>";
        }elseif($user_data['permissao'] == 'user'){
            header("Location: ../index.php?id=$user_data[id]");
        }
    };
?>

<html lang="pt-br">
    <head>
        <link rel="stylesheet" href="static/css/header.css">
    </head>
    <body>
        <header>
            <div class="header">
                <a href="index.php?id=$id" class="logo">Olá <strong><?php echo $user_data['nome'].' '.$user_data['sobrenome'];?></strong>, seja bem vindo!</a>
                <a href="backend/sair.php" class="icon-sair">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-box-arrow-right" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0v2z"/>
                        <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/>
                    </svg>
                </a>
            </div>
            <?php navbar($user_data, $empresa, $empresa);?>
            <!-- <nav class="navbar">
                <a href="templates/compras.php?id=$id" class="icon-compras">Compra de Produtos</a>
                <a href="templates/vendas.php?id=$id" class="icon-vendas">Venda de Produtos</a>
                <a href="templates/estoque.php?empresa=<?php echo $empresa?>&tipo=todos" class="icon-estoque">Estoque de Produtos</a>
                <a href="templates/cadastro-empresas.php?id=$id&tipo=todos" class="icon-estoque">Cadastro de Empresas</a>
            </nav> -->
        </header>
    </body>
</html>