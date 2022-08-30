<?php
    include('conectaBD.php');
    include('seguranca0.php');

    if ($_SERVER['REQUEST_METHOD'] == 'POST') 
    {
        $pedido = $_POST['pedido'];
        if($_SESSION['nivel'] != 10)
        {
            $id = $_SESSION['id'];
            $sql = "SELECT I_COD_PESSOA FROM tb_pedido WHERE I_COD_PEDIDO = $pedido";
            $result = mysqli_query($link, $sql);
            while($tbl = mysqli_fetch_array($result))
            {
                $cod = $tbl[0];
            }
            if($cod != $id)
            {
                header('Location: usuario.php?msg_erro=Você não tem permissão.');
                exit();
            }
            else
            {
                $sql = "DELETE FROM tb_pedido WHERE I_COD_PEDIDO = $pedido";
                mysqli_query($link, $sql);
                header('Location: usuario.php');
                exit();
            }
        }

        $sql = "DELETE FROM tb_pedido WHERE I_COD_PEDIDO = $pedido";
        mysqli_query($link, $sql);
        header('Location: usuario.php');
        exit();
    }

    if (!isset($_GET['pedido'])) header("Location: listapedido.php");
    
    $pedido = $_GET['pedido'];
    $sql = "SELECT I_COD_PESSOA FROM tb_pedido WHERE I_COD_PEDIDO = $pedido";
    $result = mysqli_query($link, $sql);
    while($tbl=mysqli_fetch_array($result))
    {
        $cod_pessoa = $tbl[0];
        $sql2 = "SELECT S_CPF_PESSOA FROM tb_pessoa WHERE I_COD_PESSOA = $cod_pessoa";
        $result2 = mysqli_query($link, $sql2);
        while($tbl2 = mysqli_fetch_array($result2))
        {
            $pessoa = $tbl2[0];
        }
    }
    
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="estilo.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <title>DrogaZilla - Cancelar pedido</title>
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
            <h2>Cancelar pedido</h2>
            <form action="deletarpedido.php" method="post">
                <p>Deseja cencelar o pedido do CPF: <b><?=$pessoa?></b>?</p>
                <h3 id="msg_erro">
                    <?php
                    if (isset($_GET['msg_erro'])) echo ($_GET['msg_erro']);
                    ?>
                </h3>
                <input type="hidden" name="pedido" value=<?=$pedido?>>
                <input type="submit" id="btnSim" value="Sim">
            </form>
            <a href="listapedido.php"><button id="btnNao">Não</button></a>
        </div>
    </main>
</body>
</html>

<script src="script.js"></script>