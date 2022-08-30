<?php
    include('conectaBD.php');
    $sql = "SELECT * FROM tb_produto";
    $result = mysqli_query($link, $sql);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="estilo.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <title>DrogaZilla</title>
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
        <section class="index_banner">
            <h1>Bem-vindo à DrogaZilla</h1>
            <a href="sobre.php"><img src="img/banner1.png"></a>
        </section>
        <section class="produtos">
            <h1>Destaques</h1>
            <?php
                while ($tbl = mysqli_fetch_array($result)) 
                {
                    $valor = str_replace('.', ',', $tbl[3]);
                    ?>
                        <table>
                            <tr>
                                <td colspan="4" rowspan="4"><img src='img_produto/<?=$tbl[4]?>'></td>
                                <td colspan="4"><?=$tbl[2]?></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td colspan="2">R$ <?=$valor?></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td colspan="2"><a href='carrinho.php?adicionar=<?=$tbl[0]?>'><button>+ Carrinho</button></a></td>
                            </tr>
                        </table>
                    <?php
                }
            ?>
        </section>
    </main>
</body>
</html>

<script src="script.js"></script>