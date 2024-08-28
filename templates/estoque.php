<?php
    include '../includes/autenticacao.php';
    include '../includes/perm-adm.php';
    include '../includes/alert.php';
    
    $id = $user_data['id'];

    if(!empty($_GET['empresa'])){
        $empresa = $user_data['empresa'];
        $tabela = "produtos_" . strtolower(str_replace(' ', '_', $empresa));
        $tipo = $_GET['tipo'];

        if($tabela === "produtos_"){
            header("Location: ../templates/index.php?id=$user_data[id]?alert=index_alert&mensagem=Nenhuma Empresa informada, por favor informe uma empresa antes de continuar para esta tela!");
        }

        if(!empty($_GET['search'])){
            $value_pesquisa = $_GET['search'];

            if($tipo == 'todos'){
                $sql = "SELECT * FROM $tabela WHERE (referencia = '$value_pesquisa' OR fornecedor LIKE '%$value_pesquisa%'OR descricao LIKE '%$value_pesquisa%' OR modelo LIKE '%$value_pesquisa%' OR marca LIKE '%$value_pesquisa%') ORDER BY id ASC";
                $result = $db->query($sql);
            }elseif($tipo == "id"){
                $sql = "SELECT * FROM $tabela WHERE (id = '$value_pesquisa') ORDER BY id ASC";
                $result = $db->query($sql);
            }elseif($tipo == "referencia"){
                $value_pesquisa = str_pad($_GET['search'], 4, '0', STR_PAD_LEFT);
                $sql = "SELECT * FROM $tabela WHERE (referencia = '$value_pesquisa') ORDER BY id ASC";
                $result = $db->query($sql);
            }elseif($tipo == "descricao"){
                $sql = "SELECT * FROM $tabela WHERE (descricao LIKE '%$value_pesquisa%') ORDER BY id ASC";
                $result = $db->query($sql);
            }elseif($tipo == "modelo"){
                $sql = "SELECT * FROM $tabela WHERE (modelo LIKE '%$value_pesquisa%') ORDER BY id ASC";
                $result = $db->query($sql);
            }elseif($tipo == "marca"){
                $sql = "SELECT * FROM $tabela WHERE (marca LIKE '%$value_pesquisa%') ORDER BY id ASC";
                $result = $db->query($sql);
            }elseif($tipo == "fornecedor"){
                $sql = "SELECT * FROM $tabela WHERE (fornecedor LIKE '%$value_pesquisa%') ORDER BY id ASC";
                $result = $db->query($sql);
            }
        }else{
            $value_pesquisa = '';
            
            $sql = "SELECT * FROM $tabela ORDER BY id ASC";
            $result = $db->query($sql);
        }

    }
    else{
        header("Location: estoque.php?empresa=$user_data[empresa]&tipo=todos");
    }

 
?>

<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>H18 Dev | Estoque</title>
        <link rel="stylesheet" href="../assets/css/reset.css">
        <link rel="stylesheet" href="../assets/css/estoque.css">
    </head>
    <body>
        <?php include '../includes/header.php'; ?>
        <div class="content">
            <div class="box-search">
                <select name="select-tipo" id="select-tipo" class="select-tipo">
                    <option value="todos" <?php echo ($_GET['tipo'] == 'todos') ? 'selected' : ''; ?>>Todos</option>
                    <option value="id" <?php echo ($_GET['tipo'] == 'id') ? 'selected' : ''; ?>>ID</option>
                    <option value="referencia" <?php echo ($_GET['tipo'] == 'referencia') ? 'selected' : ''; ?>>Referência</option>
                    <option value="descricao" <?php echo ($_GET['tipo'] == 'descricao') ? 'selected' : ''; ?>>Descrição</option>
                    <option value="modelo" <?php echo ($_GET['tipo'] == 'modelo') ? 'selected' : ''; ?>>Modelo</option>
                    <option value="marca" <?php echo ($_GET['tipo'] == 'marca') ? 'selected' : ''; ?>>Marca</option>
                    <option value="fornecedor" <?php echo ($_GET['tipo'] == 'fornecedor') ? 'selected' : ''; ?>>Fornecedor</option>
                </select>
                <input type="search" class="inputPesquisa" value="<?php echo $value_pesquisa ?>" placeholder="Pesquisar" id="pesquisar">
                <input type="hidden" name="empresa" value="<?php echo $user_data['empresa'] ?>" id="empresa">
                <button onclick="searchData()" class="btn-pesquisa">
                    <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                    </svg>
                </button>
            </div>
            <div class="box">
                <table class="table-bg">
                    <thead>
                        <tr id="tr-td">
                            <th class ="th" id="th-1" scope="col">ID</th>
                            <th scope="col">Referência</th>
                            <th scope="col">Descrição</th>
                            <th scope="col">Modelo</th>
                            <th scope="col">Marca</th>
                            <th scope="col">Fornecedor</th>
                            <th scope="col">Qtd</th>
                            <th scope="col">Custo</th>
                            <th scope="col">Venda</th>
                            <th scope="col">Lucro</th>
                            <th scope="col">Custo Estoque</th>
                            <th scope="col">Editar</th>
                            <th scope="col" class="th" id="th-2">Remover</th>
                            <?php
                                echo "<th scope='col' class='btn-add' id='btn-add'><a class='btn' id='add' href='cadastro-produtos.php?id=$id' class='btn-adicionar-produto'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-plus-circle' viewBox='0 0 16 16'><path d='M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z'/> <path d='M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 18 4z'/></svg></a></th>";
                            ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php //Passando dados do banco de dados para a tabela de produtos!
                            while($product_data = mysqli_fetch_assoc($result)){
                                echo "<tr>";
                                echo "<td>".$product_data['id']."</td>";
                                echo "<td>".$product_data['referencia']."</td>";
                                echo "<td>".$product_data['descricao']."</td>";
                                echo "<td>".$product_data['modelo']."</td>";
                                echo "<td>".$product_data['marca']."</td>";
                                echo "<td>".$product_data['fornecedor']."</td>";
                                echo "<td>".$product_data['qtd']."</td>";
                                echo "<td>".'R$'.$product_data['custo']."</td>";
                                echo "<td>".'R$'.$product_data['venda']."</td>";
                                echo "<td>".'R$'.$product_data['lucro']."</td>";
                                echo "<td>".'R$'.$product_data['custoEstoque']."</td>";
                                echo "<td>
                                        <a class='btn' id='pencil' href='editar-produtos.php?id=$product_data[id]'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-pencil' viewBox='0 0 16 16'>
                                        <path d='M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z'/></svg></a>
                                        </td>";
                                echo "<td>
                                        <a class='btn' id='trash' href='../backend/deletar-produtos.php?id=$product_data[id]'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-trash3' viewBox='0 0 16 16'>
                                        <path d='M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z'/></svg></a>
                                        </td>";
                                echo "</tr>";
                            }
                        ?>
                    </tbody>
                </table>
            </div>
            <script src="../assets/js/search.js"></script>
        </div>
        <?php include '../includes/footer.php'; ?>
    </body>
</html>

