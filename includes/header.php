<?php
    $id = $user_data['id'];
    $empresa = $user_data['empresa'];

    function ul($user_data, $id, $empresa){
        if($user_data['permissao'] == 'desenvolvedor'){
            echo"<ul>";
                echo 
                    "<li class='nav-item'>
                        <a href='../templates/usuarios.php?id=$id' class='nav-link'>Usuários</a>
                    </li>";
                echo 
                    "<li class='nav-item'>
                        <a href='../templates/caixa.php?id=$id' class='nav-link'>Caixa</a>
                    </li>";
                echo 
                    "<li class='nav-item'>
                        <a href='../templates/reposicao.php?id=$id'  class='nav-link'>Reposição</a>
                    </li>";
                echo 
                    "<li class='nav-item'>
                        <a href='../templates/estoque.php?empresa=<?php echo $empresa?>&tipo=todos' class='nav-link'>Estoque</a>
                    </li>";
                echo 
                    "<li class='nav-item'>
                        <a href='../templates/vendas.php?id=$id' class='nav-link'>Vendas</a>
                    </li>";
                echo 
                    "<li class='nav-item'>
                        <a href='../templates/index.php?id=$id' class='nav-link'>Ínicio</a>
                    </li>";
            echo"</ul>";
        }elseif($user_data['permissao'] == 'administrador'){
            echo"<ul>";
                // echo 
                //     "<li class='nav-item'>
                //         <a href='../templates/compras.php?id=$id'  class='nav-link'>Reposição</a>
                //     </li>";
                // echo 
                //     "<li class='nav-item'>
                //         <a href='../templates/caixa.php?id=$id' class='nav-link'>Caixa</a>
                //     </li>";
                echo 
                    "<li class='nav-item'>
                        <a href='../templates/estoque.php?empresa=<?php echo $empresa?>&tipo=todos' class='nav-link'>Estoque</a>
                    </li>";
                // echo 
                //     "<li class='nav-item'>
                //         <a href='../templates/vendas.php?id=$id' class='nav-link'>Vendas</a>
                //     </li>";
                echo 
                    "<li class='nav-item'>
                        <a href='../templates/index.php?id=$id' class='nav-link'>Ínicio</a>
                    </li>";
            echo"</ul>";
        }elseif($user_data['permissao'] == 'vendedor'){
            echo"<ul>";
                // echo 
                //     "<li class='nav-item'>
                //         <a href='../templates/vendas.php?id=$id' class='nav-link'>Vendas</a>
                //     </li>";
                echo 
                    "<li class='nav-item'>
                        <a href='../templates/index.php?id=$id' class='nav-link'>ínicio</a>
                    </li>";
            echo"</ul>";
        }elseif($user_data['permissao'] == 'user'){   
        
        }else{
            header('Location: login.php');
        }
    }
?>

<html lang="pt-br">
    <head>
        <link rel="stylesheet" href="../static/css/header.css">
    </head>
    <body>
        <header>
            <nav class="nav-bar">
                <div class="logo">
                    <h1>H18 Dev</h1>
                </div>
                <div class="nav-list">
                    <?php ul($user_data, $id, $empresa); ?>
                </div>

                <div class="sair-button">
                    <button>
                        <a href="../backend/sair.php">
                            Sair
                        </a>
                    </button>
                </div>

                <div class="mobile-menu-icon">
                    <button onclick="menuShow()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5"/>
                        </svg>
                    </button>
                </div>
                <div class="mobile-menu-icon-close">
                    <button onclick="menuShow()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                            <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z"/>
                        </svg>
                    </button>
                </div>
            </nav>

            <div class="mobile-menu">
                <?php ul($user_data, $id, $empresa); ?>
                <div class="sair-button">
                    <button>
                        <a href="../backend/sair.php">
                            Sair
                        </a>
                    </button>
                </div>
            </div>
        </header>
        <script src="../static/js/menuShow.js"></script>
    </body>
</html>