<?php
include('conectaBD.php');
include('seguranca10.php');
if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
    $erro = false;
    $nmgenerico = $_POST['nmgenerico'];
    if(!$nmgenerico)
    {
        $erro = true;
        header("Location: registrarproduto.php?msg_erro=Coloque o nome genérico do produto.");
    }
    $sql = "SELECT COUNT(I_COD_PRODUTO) FROM tb_produto WHERE S_NM_PRODUTO = '$nmgenerico'";
    $result = mysqli_query($link, $sql);
    while($tbl = mysqli_fetch_array($result))
    {
        $nmG = $tbl[0];
    }
    if($nmG != 0)
    {
        $erro = true;
        header("Location: registrarproduto.php?msg_erro=Nome de produto genérico já existente.");
    }
    $nmcomercial = $_POST['nmcomercial'];
    if(!$nmcomercial)
    {
        $erro = true;
        header("Location: registrarproduto.php?msg_erro=Coloque o nome comercial do produto.");
    }
    $sql = "SELECT COUNT(I_COD_PRODUTO) FROM tb_produto WHERE S_NMCO_PRODUTO = '$nmcomercial'";
    $result = mysqli_query($link, $sql);
    while($tbl = mysqli_fetch_array($result))
    {
        $nmC = $tbl[0];
    }
    if($nmC != 0)
    {
        $erro = true;
        header("Location: registrarproduto.php?msg_erro=Nome de produto comercial já existente.");
    }
    $valor = $_POST['valor'];
    if(!$valor)
    {
        $erro = true;
        header("Location: registrarproduto.php?msg_erro=Coloque o valor do produto.");
    }
    $valor = str_replace(",", ".", $valor);
    $img = $_POST['img'];
    if(!$img)
    {
        $erro = true;
        header("Location: registrarproduto.php?msg_erro=Coloque a imagem do produto.");
    }

    $sql = "INSERT INTO tb_produto (S_NM_PRODUTO, S_NMCO_PRODUTO, D_VLRUNID_PRODUTO, S_IMG_PRODUTO) VALUES ('$nmgenerico', '$nmcomercial', '$valor', '$img')";
    if (!$erro)
    {
        mysqli_query($link, $sql);
        header("Location: registrarproduto.php?msg_erro=Sucesso!");
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <link href="estilo.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <title>DrogaZilla - Cadastro de Produto</title>
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
        <div class="tela_registro-produto">
            <form action="registrarproduto.php" method="post">
                <h2>Registrar Produto</h2>
                <h3 id="msg_erro">
                    <?php
                    if (isset($_GET['msg_erro'])) echo ($_GET['msg_erro']);
                    ?>
                </h3>
                <p>
                    <label for="nmgenerico">Nome Genérico:</label>
                    <input type="text" name="nmgenerico" id="nmgenerico" maxlength="30" placeholder="Digite o nome genérico" required>
                </p>
                <p>
                    <label for="nmcomercial">Nome Comercial:</label>
                    <input type="text" name="nmcomercial" id="nmcomercial" maxlength="30" placeholder="Digite o nome comercial" required>
                </p>
                <p>
                    <label for="valor">Valor por Unidade:</label>
                    <input type="number" min="1" step="any" name="valor" id="valor" placeholder="Digite o valor" required>
                </p>
                <p>
                    <label for="img">Imagem do Produto:</label>
                    <input type="file" name="img" id="img" accept="image/png, image/jpeg, image/jpg">
                </p>
                <p>
                    <input type="submit" value="Salvar">
                </p>
            </form>
        </div>
    </main>
</body>
</html>

<script src="script.js"></script>