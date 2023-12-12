<?php
    include '../includes/autenticacao.php';
    include '../includes/perm-adm.php';
    include '../includes/alert.php';
?>

<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>H18 Dev | Gerenciamento de Caixa</title>
        <link rel="stylesheet" href="../static/css/reset.css">
        <link rel="stylesheet" href="../static/css/caixa.css">
        <link rel="stylesheet" href="../static/css/abrir-caixa.css">
    </head>
    <body>
        <?php include '../includes/header.php';?>
        <div class="tool-bar-caixa">
            <a onclick="mostrarPopup()">Abrir Caixa</a>
            <a href="../templates/abrir-caixa.php?id=<?php echo $id?>"></a>
            <a href="../templates/contas-a-receber.php?id=<?php echo $id?>">Contas á Receber</a>
            <a href="../templates/contas-a-pagar.php?id=<?php echo $id?>">Contas á Pagar</a>
            <a href="../templates/fechamento-caixa.php?id=<?php echo $id?>">Fechamento de Caixa</a>
        </div>
        <div class="content">
            
        </div>
        <!-- Div de sobreposição -->
        <div id="overlay"></div>

        <!-- Div do Popup -->
        <div id="popup">
            <h2 id="h2-popup">Abertura de Caixa</h2>
            <form action="">
                <input type="text" name="user" id="user" placeholder="Usuário" class="inputUser" required><br>
                <input type="password" name="senha" id="senha" placeholder="Senha" class="inputUser" required><br>
                <input type="number" step="0.01" name="valor" id="valor" placeholder="Valor" class="inputUser" required><br>
                <input type="submit" name="submit" id="submit" value="Confirmar" class="btn-confirmar">
                <input type="submit" onclick="fecharPopup()" value="Cancelar" class="btn-cancelar">
            </form>
        </div>
        <div class="content">
            
        </div>
        <?php include '../includes/footer.php'; ?>
    </body>
    <script src="../static/js/popup-abrir-caixa.js"></script>
</html>