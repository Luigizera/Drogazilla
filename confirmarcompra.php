<?php
    include('conectaBD.php');
    include('seguranca0.php');
    $id = $_SESSION['id'];
    $carrinho = $_SESSION['carrinho'];

    $sql = "SELECT COUNT(S_CAR_CARRINHO) FROM tb_carrinho WHERE S_CAR_CARRINHO = '$carrinho'";
    $result = mysqli_query($link,$sql);
    while($tbl = mysqli_fetch_array($result))
    {
        $resultado = $tbl[0];
    }
    if($resultado != 0)
    {
        $sql = "SELECT COUNT(I_COD_PESSOA) FROM tb_endereco WHERE I_COD_PESSOA = $id";
        $result = mysqli_query($link,$sql);
        while($tbl = mysqli_fetch_array($result))
        {
            $resultado = $tbl[0];
        }
        if($resultado != 0)
        {
            $sql = "SELECT * FROM tb_endereco WHERE I_COD_PESSOA = $id";
            $result = mysqli_query($link,$sql);
            while($tbl = mysqli_fetch_array($result))
            {
                $endereco = $tbl[2];
                $bairro = $tbl[3];
                $cidade = $tbl[4];
                $uf = $tbl[5];
                $cep = $tbl[6];
            }
        }
        else
        {
            header("Location: usuario.php?msg_erro=Insira um endereço.");
            exit();
        }
    }
    else
    {
        header("Location: carrinho.php?msg_erro=Insira itens no carrinho.");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="estilo.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <title>Drogazilla - Confirmar compra</title>
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
        <section class="dados_pessoais">
            <h2>Este é o seu endereço?</h2>
            <p>
                <label for="endereco">Endereço:</label>
                <input type="text" name="endereco" id="endereco" maxlength="50" value="<?=$endereco?>" disabled>
            </p>
            <p>
                <label for="bairro">Bairro:</label>
                <input type="text" name="bairro" id="bairro" maxlength="25" value="<?=$bairro?>" disabled>
            </p>
            <p>
                <label for="UF">Estado:</label>
                <input type="text" name="UF" id="UF" maxlength="25" value="<?=$uf?>" disabled>
            </p>
            <p>
                <label for="cidade">Cidade:</label>
                <input type="text" name="cidade" id="cidade" maxlength="25" value="<?=$cidade?>" disabled>
            </p>
            <p>
                <label for="CEP">CEP:</label>
                <input type="text" name="CEP" id="CEP" maxlength="9" value="<?=$cep?>" disabled>
            </p>
            
            <a href="finalizarcompra.php"><button id="btnSim">Sim</button></a>
            <a href="alterarendereco.php?cliente=<?=$id?>"><button id="btnNao">Não</button></a>
        </section>
    </main>
    <footer>

    </footer>
</body>
</html>

<script src="script.js"></script>