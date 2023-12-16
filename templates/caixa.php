<?php
    include '../includes/autenticacao.php';
    include '../includes/perm-adm.php';
    include '../includes/alert.php';

    $consult = "SELECT * FROM usuarios WHERE email = '$email'";
    $consult_result = $db->query($consult);
    $user_data = mysqli_fetch_assoc($consult_result);

    $empresa = $user_data['empresa'];
    
    $tabelaCaixa = "caixa_" . strtolower(str_replace(' ', '_', $user_data['empresa']));
    $sqlCaixa = "SELECT * FROM $tabelaCaixa WHERE empresa = '$empresa' and statusCaixa = 'A'";
    $sqlCaixa_result = $db->query($sqlCaixa);
    $caixaData = mysqli_fetch_assoc($sqlCaixa_result);

    if (isset($caixaData['saldoInicial'])){
        $saldoInicial = number_format($caixaData['saldoInicial'], 2);
        $saldo = number_format($caixaData['saldo'], 2);
    }else{
        $saldoInicial = number_format(0, 2);
        $saldo = number_format(0, 2);
    }

    $dataAtual = DATE('Y-m-d');

    $tabelaMov = "movimentacoes_" . strtolower(str_replace(' ', '_', $user_data['empresa']));
    $sqlMov = "SELECT * FROM $tabelaMov WHERE empresa = '$empresa' and dataMov = $dataAtual";
    $sqlMov_result = $db->query($sqlMov);
    $movData = mysqli_fetch_assoc($sqlMov_result);

    $consulta = "SELECT SUM(valorMov) as total FROM $tabelaMov WHERE dataMov = $dataAtual";
    $resultado = $db->query($consulta);
    if ($resultado) {
        $linha = $resultado->fetch_assoc();
        $movTotal = $linha['total'];
    } else {
        $movTotal = $linha['total'];
    }

    if(isset($movData['valorMov']) and isset($caixaData['saldoInicial'])){
        $movTotal = $linha['total'];
    }else{
        $movTotal = number_format(0, 2);
    }

    $sqlStatus = "SELECT * FROM $tabelaCaixa WHERE empresa ='$empresa' and statusCaixa = 'A'";
    $resultStatus = $db->query($sqlStatus) or die($db->error);
    $status_caixa = mysqli_fetch_assoc($resultStatus);

?>

<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>H18 Dev | Caixa</title>
        <link rel="stylesheet" href="../static/css/reset.css">
        <link rel="stylesheet" href="../static/css/caixa.css">
        <link rel="stylesheet" href="../static/css/abrir-caixa.css">
        <link rel="stylesheet" href="../static/css/fechar-caixa.css">
        <script src="../static/js/popup.js"></script>
    </head>
    <body>
        <?php include '../includes/header.php';?>
        <div id="overlay-abrir-caixa"></div>
        <div id="popup-abrir-caixa">
            <h2>Abertura de Caixa</h2>
            <form action="../backend/abertura-caixa.php" method="POST" class="form" id="form">
                <input type="email" name="email" id="email" placeholder="Email" class="inputUser" required><br>
                <input type="password" name="senha" id="senha" placeholder="Senha" class="inputUser" required><br>
                <input type="number" step="0.01" name="saldoInicial" id="saldoInicial" placeholder="Saldo Inicial" class="inputUser" required><br>
                <input type="submit" name="submit" id="submit" value="Confirmar" class="inputSubmit">
            </form>
            <input type="submit" value="Cancelar" class="inputSubmitCancelar" onclick="closePopupAbrirCaixa()">
        </div>
        <div id="overlay-fechar-caixa"></div>
        <div id="popup-fechar-caixa">
            <h2>Fechamento de Caixa</h2>
            <form action="../backend/fechamento-caixa.php" method="POST" class="form" id="form">
                <input type="email" name="email" id="email" placeholder="Email" class="inputUser" required><br>
                <input type="password" name="senha" id="senha" placeholder="Senha" class="inputUser" required><br>
                <?php 
                    echo "<input type='text'  name='saldo' id='saldo' class='inputUser' value='R$$saldo' readonly>";
                ?>
                <input type="submit" name="submit" id="submit" value="Confirmar" class="inputSubmit">
                <input type="submit" value="Cancelar" class="inputSubmitCancelar" onclick="closePopupFecharCaixa()">
            </form>
        </div>
        <div class="content">
            <div class="tool-bar">
                <button onclick="openPopupAbrirCaixa()">Abrir Caixa</button>
                <button>Entrada</button>
                <button>Retirada</button>
                <button onclick="openPopupFecharCaixa()">Fechar Caixa</button>
            </div>
            <div>
                <?php 
                    if (isset($status_caixa['statusCaixa'])){
                        if ($status_caixa['statusCaixa'] == 'A'){
                            echo "<div class='barra-saldo'>";
                                echo "<p>Saldo inicial: R$$saldoInicial</p>";
                                echo "<p>Total movimentações: R$$movTotal</p>";
                                echo "<p>Saldo: R$$saldo</p>";
                            echo "</div>";
                        }else{
                        }
                    }else{
                    }
                ?>
            </div>
        </div>
       
        <?php include '../includes/footer.php'; ?>
    </body>
</html>