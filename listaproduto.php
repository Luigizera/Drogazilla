<?php
    include('conectaBD.php');
    include('seguranca10.php');
    if ($_SERVER['REQUEST_METHOD'] == "POST") 
    {
        $termo = $_POST['termo'];
        $coluna = $_POST['coluna'];
        $sql = "SELECT * FROM tb_produto WHERE $coluna LIKE '%$termo%'";
    } 
    else 
    {
        $sql = "SELECT * FROM tb_produto";
    }


    $result = mysqli_query($link, $sql);



?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="estilo.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <title>DrogaZilla - Lista de Produtos</title>
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
        <div id="busca">
            <a href="registrarproduto.php"><button>Novo Produto</button></a>
            <form action="listaproduto.php" method="post">
                <input type="submit" value="Pesquisar">
                <input type="text" name="termo" id="txtb" placeholder="Digite o Nome">
                <select name="coluna" id="tbusca" onchange="muda()">
                    <option value="S_NM_PRODUTO">Nome</option>
                    <option value="S_NMCO_PRODUTO">Nome Comercial</option>
                    <option value="D_VLRUNID_PRODUTO">Valor por Unidade</option>
                </select>

            </form>
        </div>


        <div class="lista">
            <table>
                <tr>
                    <th>Imagem</th>
                    <th>Nome</th>
                    <th>Nome Comercial</th>
                    <th>Valor por Unidade</th>
                    <th></th>
                    <th></th>
                </tr>
                <?php
                while ($tbl = mysqli_fetch_array($result)) 
                {
                    $valor = str_replace('.', ',', $tbl[3]);
                    echo ("<tr>");
                    echo ("<td><img src='img_produto/" . $tbl[4] . "'></td>");
                    echo ("<td>" . $tbl[1] . "</td>");
                    echo ("<td>" . $tbl[2] . "</td>");
                    echo ("<td>" . $valor . "</td>");
                    echo ("<td><a href='alterarproduto.php?produto=" . $tbl[0] . "'><button id='btnalterar'>Alterar</button></a></td>");
                    echo ("<td><a href='deletarproduto.php?produto=" . $tbl[0] . "'><button id='btnexcluir'>Excluir</button></a></td>");
                    echo ("</tr>");
                }
                ?>
            </table>
        </div>
    </main>
</body>
</html>

<script src="script.js"></script>