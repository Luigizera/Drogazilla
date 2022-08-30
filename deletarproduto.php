<?php
    include('conectaBD.php');
    include('seguranca10.php');

    if ($_SERVER['REQUEST_METHOD'] == 'POST') 
    {
        $id = $_POST['id'];
        $sql = "DELETE FROM tb_produto WHERE I_COD_PRODUTO = $id";
        mysqli_query($link, $sql);
        header('Location: listaproduto.php');
    }

    if (!isset($_GET['produto'])) header("Location: listaproduto.php");
    $id = $_GET['produto'];
    $sql = "SELECT S_NM_PRODUTO FROM tb_produto WHERE I_COD_PRODUTO = $id";
    $result = mysqli_query($link, $sql);
    while($tbl=mysqli_fetch_array($result))
    {
        $nome = $tbl[0];
    }
    
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="estilo.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <title>DrogaZilla - Deletar produto</title>
</head>
<body onload="loadTheme()">
    <header>
        <a href="index.php"><img src="img/logo.png" alt="logo" width="120px"></a>
        <nav>
            <ul class="navbar_links">
                <li><a href="index.php">Home</a></li>
                <li><a href="sobre.php">Sobre</a></li>
                <li><a href="produtos.php">Produtos</a></li>
            </ul>
        </nav>
        <form action="produtos.php" method="get">
            <input type="search" name="search" placeholder="Pesquisar..." id="pesquisar">
            <input type="submit" value="&#128269" id="procurar">
        </form>
        <?php
            include('cabecalho.php')
        ?>
    </header>
    <main>
        <div id="deleta">
            <h2>Excluir conta</h2>
            <form action="deletarproduto.php" method="post">
                <p>Deseja excluir o produto <b><?=$nome?></b>?</p>
                <h3 id="msg_erro">
                    <?php
                    if (isset($_GET['msg_erro'])) echo ($_GET['msg_erro']);
                    ?>
                </h3>
                <input type="hidden" name="id" value=<?=$id?>>
                <input type="submit" id="btnSim" value="Sim">
            </form>
            <a href="listaproduto.php"><button id="btnNao">Não</button></a>
        </div>
    </main>
</body>
</html>

<script src="script.js"></script>