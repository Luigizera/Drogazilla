<?php
    include('conectaBD.php');
    include('seguranca10.php');
    
    $sql = "SELECT * FROM tb_pedido";
    $result = mysqli_query($link, $sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="estilo.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <title>DrogaZilla - Lista de Pedidos</title>
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
        <div class="lista">
        <h1>Pedidos</h1>
            <table>
                <tr>
                    <th>CPF do Comprador</th>
                    <th>Endereço</th>
                    <th>Bairro</th>
                    <th>Cidade</th>
                    <th>UF</th>
                    <th>CEP</th>
                    <th>Produto</th>
                    <th>Quantidade do Produto</th>
                    <th>Valor total do Pedido</th>
                    <th>Data da compra</th>
                    <th></th>
                </tr>
                <?php
                while ($tbl = mysqli_fetch_array($result)) //Traz tudo da tabela pedido
                {
                    $valor = str_replace('.', ',', $tbl[5]);
                    $endereco = $tbl[2];
                    $sql2 = "SELECT * FROM tb_endereco WHERE I_COD_ENDERECO = $endereco";
                    $result2 = mysqli_query($link, $sql2);
                    while($tbl2 = mysqli_fetch_array($result2)) //Traz tudo da tabela endereço
                    {
                        $produto = $tbl[3];
                        $sql3 = "SELECT * FROM tb_produto WHERE I_COD_PRODUTO = $produto";
                        $result3 = mysqli_query($link, $sql3);
                        while($tbl3 = mysqli_fetch_array($result3)) //Traz tudo da tabela produto
                        {
                            $pessoa = $tbl[1];
                            $sql4 = "SELECT S_CPF_PESSOA FROM tb_pessoa WHERE I_COD_PESSOA = $pessoa";
                            $result4 = mysqli_query($link, $sql4);
                            while($tbl4 = mysqli_fetch_array($result4)) //Traz o CPF da tabela pessoa
                            {
                                echo ("<tr>");
                                echo ("<td>" . $tbl4[0] . "</td>");
                                echo ("<td>" . $tbl2[2] . "</td>");
                                echo ("<td>" . $tbl2[3] . "</td>");
                                echo ("<td>" . $tbl2[4] . "</td>");
                                echo ("<td>" . $tbl2[5] . "</td>");
                                echo ("<td>" . $tbl2[6] . "</td>");
                                echo ("<td>" . $tbl3[1] . "</td>");
                                echo ("<td>" . $tbl[4] . "</td>");
                                echo ("<td>" . $valor . "</td>");
                                echo ("<td>" . date("d/m/Y - H:i:s", strtotime($tbl[6])) . "</td>");
                                echo ("<td><a href='deletarpedido.php?pedido=" . $tbl[0] . "'><button id='btnexcluir'>Excluir</button></a></td>");
                                echo ("</tr>");
                            }
                        }
                    }
                }
                ?>
            </table>
        </div>
    </main>
</body>
</html>

<script src="script.js"></script>