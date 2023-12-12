<?php
    include '../includes/autenticacao.php';
    include '../includes/perm-vendedor.php';
    include '../includes/alert.php';
?>

<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>H18 Dev | Abertura de caixa</title>
        <link rel="stylesheet" href="../static/css/reset.css">
        <link rel="stylesheet" href="../static/css/abrir-caixa.css">
    </head>
    <body>
        <?php include '../includes/header.php';?>
        <button onclick="mostrarPopup()">Mostrar Popup</button>

        <!-- Div de sobreposição -->
        <div id="overlay"></div>

        <!-- Div do Popup -->
        <div id="popup">
            <h2>Este é um popup em PHP</h2>
            <p>Conteúdo do popup...</p>
            <button onclick="fecharPopup()">Fechar Popup</button>
        </div>
        <div class="content">
            
        </div>
        <?php include '../includes/footer.php'; ?>
    </body>  
    <script src="../static/js/popup.js"></script>
</html>