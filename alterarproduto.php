<?php
    include('conectaBD.php');
    include('seguranca10.php');
    if ($_SERVER['REQUEST_METHOD'] == 'POST') 
    {
        $id = $_POST['id'];
        $erro = false;
        $nmgenerico = $_POST['nmgenerico'];
        if(!$nmgenerico)
        {
            $erro = true;
            header("Location: alterarproduto.php?msg_erro=Coloque o nome genérico do produto.");
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
            header("Location: alterarproduto.php?msg_erro=Nome de produto genérico já existente.");
        }

        $nmcomercial = $_POST['nmcomercial'];
        if(!$nmcomercial)
        {
            $erro = true;
            header("Location: alterarproduto.php?msg_erro=Coloque o nome comercial do produto.");
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
            header("Location: alterarproduto.php?msg_erro=Nome de produto comercial já existente.");
        }
        $valor = $_POST['valor'];
        if(!$valor)
        {
            $erro = true;
            header("Location: alterarproduto.php?msg_erro=Coloque o valor do produto.");
        }
        $valor = str_replace(",", ".", $valor);
        $img = $_POST['img'];
        if(!$img)
        {
            $sql = "SELECT S_IMG_PRODUTO FROM tb_produto WHERE I_COD_PRODUTO = $id";
            $result = mysqli_query($link, $sql);
            while($tbl = mysqli_fetch_array($result))
            {
                $img = $tbl[0];
            }
        }
        

        if(!$erro)
        {
            $sql = "UPDATE tb_produto SET S_NM_PRODUTO = '$nmgenerico', S_NMCO_PRODUTO = '$nmcomercial', D_VLRUNID_PRODUTO = $valor, S_IMG_PRODUTO = '$img' WHERE I_COD_PRODUTO = $id";
            mysqli_query($link, $sql);
            header("Location: alterarproduto.php?msg_erro=Sucesso!");
        }
    }
    
    $id = $_GET['produto'];
    if(!isset($_GET['produto']))
    {
        header('Location: listaproduto.php');
        exit();
    }
    $sql = "SELECT * FROM tb_produto WHERE I_COD_PRODUTO = $id";
    $result = mysqli_query($link, $sql);
    while ($tbl = mysqli_fetch_array($result)) 
    {
        $nmgenerico = $tbl[1];
        $nmcomercial = $tbl[2];
        $valor = $tbl[3];
        $img = $tbl[4];
    }
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <link href="estilo.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <title>DrogaZilla - Alterar informações do produto</title>
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
        <div class="tela_registro-pessoa">
            <form action="alterarproduto.php" method="post">
                <h2>Alterar informações do produto</h2>
                <h3 id="msg_erro">
                    <?php
                    if (isset($_GET['msg_erro'])) echo ($_GET['msg_erro']);
                    ?>
                </h3>
                <input type="hidden" name="id" value=<?=$id?>>
                <p>
                    <label for="nmgenerico">Nome Genérico:</label>
                    <input type="text" name="nmgenerico" id="nmgenerico" maxlength="30" placeholder="Digite o nome genérico" value="<?=$nmgenerico?>" required>
                </p>
                <p>
                    <label for="nmcomercial">Nome Comercial:</label>
                    <input type="text" name="nmcomercial" id="nmcomercial" maxlength="30" placeholder="Digite o nome comercial" value="<?=$nmcomercial?>" required>
                </p>
                <p>
                    <label for="valor">Valor por Unidade:</label>
                    <input type="number" min="1" step="any" name="valor" id="valor" placeholder="Digite o valor" value="<?=$valor?>" required>
                </p>
                <p>
                    <label for="img">Imagem do Produto:</label>
                    <input type="file" name="img" id="img" value="<?=$img?>" accept="image/png, image/jpeg, image/jpg">
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