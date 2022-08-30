<?php
    include('conectaBD.php');
    include('seguranca10.php');
    if ($_SERVER['REQUEST_METHOD'] == "POST") 
    {
        $termo = $_POST['termo'];
        $coluna = $_POST['coluna'];
        $sql = "SELECT * FROM tb_pessoa WHERE $coluna LIKE '%$termo%'";
    } 
    else 
    {
        $sql = "SELECT * FROM tb_pessoa";
    }


    $result = mysqli_query($link, $sql);



?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="estilo.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <title>DrogaZilla - Lista de Clientes</title>
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
            <a href="registrar.php"><button>Novo Cliente</button></a>
            <form action="listapessoa.php" method="post">
                <select name="coluna" id="tbusca" onchange="muda()">
                    <option value="S_NM_PESSOA">Nome</option>
                    <option value="S_SNM_PESSOA">Sobrenome</option>
                    <option value="S_CPF_PESSOA">CPF</option>
                    <option value="S_CEL_PESSOA">Celular</option>
                    <option value="S_EMA_PESSOA">E-mail</option>
                </select>
                <input type="text" name="termo" id="txtb" placeholder="Digite o Nome">
                <input type="submit" value="Pesquisar">
            </form>
        </div>


        <div class="lista">
            <table>
                <tr>
                    <th>Nome</th>
                    <th>CPF</th>
                    <th>Data de nascimento</th>
                    <th>Gênero</th>
                    <th>Celular</th>
                    <th>Email</th>
                    <th>Nível</th>
                    <th></th>
                    <th></th>
                </tr>
                <?php
                while ($tbl = mysqli_fetch_array($result)) 
                {
                    echo ("<tr>");
                    echo ("<td>" . $tbl[1] . " " . $tbl[2] . "</td>");
                    echo ("<td>" . $tbl[3] . "</td>");
                    echo ("<td>" . date("d/m/Y", strtotime($tbl[4])) . "</td>");
                    echo ("<td>" . $tbl[5] . "</td>");
                    echo ("<td>" . $tbl[6] . "</td>");
                    echo ("<td>" . $tbl[7] . "</td>");
                    echo ($tbl[9]==10?"<td>Administrador</td>":"<td>Usuário</td>");
                    echo ("<td><a href='alterarpessoa.php?cliente=" . $tbl[0] . "'><button id='btnalterar'>Alterar</button></a></td>");
                    echo ("<td><a href='deletarpessoa.php?cliente=" . $tbl[0] . "'><button id='btnexcluir'>Excluir</button></a></td>");
                    echo ("</tr>");
                }
                ?>
            </table>
        </div>
    </main>
</body>

<script src="script.js"></script>