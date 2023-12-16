<?php
    include '../includes/autenticacao.php';
    include '../includes/perm-adm.php';
    include '../includes/alert.php';

    $consult = "SELECT * FROM usuarios WHERE email = '$email'";
    $consult_result = $db->query($consult);
    $user_data = mysqli_fetch_assoc($consult_result);

    $empresa = $user_data['empresa'];

    $dbName = "db_" . strtolower(str_replace(' ', '_', $empresa));
    $db = new mysqli($dbhost, $dbUsername, $dbPassword, $dbName);
    
    $tabelaCaixa = "caixa";
    
    $sqlCaixa = "SELECT * FROM $tabelaCaixa WHERE empresa = '$empresa' and statusCaixa = 'A'";
    $sqlCaixa_result = $db->query($sqlCaixa);
    $caixaData = mysqli_fetch_assoc($sqlCaixa_result);

    if (isset($caixaData['saldoInicial'])){
        $saldoInicial = number_format($caixaData['saldoInicial'], 2, ',', '.');
        $totalMov = number_format($caixaData['totalMov'], 2, ',', '.');
        $saldo = number_format($caixaData['saldoInicial']+$caixaData['totalMov'], 2, ',', '.');
        $idCaixa = $caixaData['id'];
    }else{
        $saldoInicial = number_format(0, 2);
        $totalMov = number_format(0, 2);
        $saldo = number_format(0, 2);
        $idCaixa = '0';
    }

    //seta fuso horário de brasília e pega data e hora separadas
    date_default_timezone_set('America/Sao_Paulo');
    $dataAtual = DATE("Y-m-d");
    $horaAtual = DATE("H:i:s");

    $tabelaMov = "movimentacoes";
    $sqlMov = "SELECT * FROM $tabelaMov WHERE empresa = '$empresa' AND dataMov = '$dataAtual' AND idCaixa = $idCaixa ORDER BY id ASC";
    $sqlMov_result = $db->query($sqlMov);

    $sqlStatus = "SELECT * FROM $tabelaCaixa WHERE empresa ='$empresa' AND statusCaixa = 'A'";
    $resultStatus = $db->query($sqlStatus) or die($db->error);
    $status_caixa = mysqli_fetch_assoc($resultStatus);

    if(!isset($status_caixa)){
        $status = 'Fechado';
    }else{
        $status = 'Aberto';
    }

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
        <link rel="stylesheet" href="../static/css/adicionar-mov.css">
        <script src="../static/js/popup.js"></script>
    </head>
    <body>
        <?php include '../includes/header.php';?>
        <div id="overlay"></div>
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
        <div id="popup-adicionar-mov">
            <h2>Adicionar Movimentação</h2><br><br>
            <form action="../backend/adicionar-mov.php" method="POST" class="form" id="form">
                <input type="email" name="email" id="email" placeholder="Email" class="inputUser" required><br><br>
                <input type="password" name="senha" id="senha" placeholder="Senha" class="inputUser" required><br><br>
                <input type="text" name="descMov" id="descMov" placeholder="Descrição" class="inputUser" required><br><br>
                <input type="number" step="0.01" name="valorMov" id="valorMov" placeholder="Valor" class="inputUser" required><br><br>
                <input type="submit" name="submit" id="submit" value="Confirmar" class="inputSubmit">
            </form>
            <input type="submit" value="Cancelar" class="inputSubmitCancelar" onclick="closePopupAdicionarMov()">
        </div>
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
                <button onclick="openPopupAdicionarMov()">Adicionar</button>
                <button>Retirar</button>
                <button onclick="openPopupFecharCaixa()">Fechar Caixa</button>
            </div>
            <div class="movimentacoes">
                <table class="table-mov">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Usuário</th>
                            <th scope="col">Descrição</th>
                            <th scope="col">Valor</th>
                            <th scope="col">Data</th>
                            <th scope="col">Hora</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            while($movData = mysqli_fetch_assoc($sqlMov_result)){
                                echo "<tr>";
                                    echo "<td>".$movData['id']."</td>";
                                    echo "<td>".$movData['usuario']."</td>";
                                    echo "<td>".$movData['descMov']."</td>";
                                    echo "<td>".'R$'.number_format($movData['valorMov'], 2, ',', '.')."</td>";
                                    echo "<td>".$movData['dataMov']."</td>";
                                    echo "<td>".$movData['horaMov']."</td>";
                                echo "</tr>";
                            }
                        ?>
                    </tbody>
                </table>
            </div>
            <?php 
                echo "<div class='barra-saldo'>";
                    echo "<p>Saldo inicial: R$$saldoInicial</p>";
                    echo "<p>Movimentações: R$$totalMov</p>";
                    echo "<p>Saldo: R$$saldo</p>";
                    echo "<p>Status: $status</p>";
                echo "</div>";
            ?>
        </div>
        <?php include '../includes/footer.php'; ?>
    </body>
</html>