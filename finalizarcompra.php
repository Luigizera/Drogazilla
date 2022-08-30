<?php
    include('conectaBD.php');
    include('seguranca0.php');
    $id = $_SESSION['id'];
    $carrinho = $_SESSION['carrinho'];
    $email = $_SESSION['email'];
    $vlrtotal = 0;

    $sql = "SELECT COUNT(S_CAR_CARRINHO) FROM tb_carrinho WHERE S_CAR_CARRINHO = '$carrinho'"; //Conta quantos carrinhos o usuário tem
    $result = mysqli_query($link,$sql);
    while($tbl = mysqli_fetch_array($result))
    {
        $resultado = $tbl[0];
    }
    if($resultado != 0) //Verifica se existe pelo menos 1 carrinho
    {
        $sql = "SELECT COUNT(I_COD_PESSOA) FROM tb_endereco WHERE I_COD_PESSOA = $id";
        $result = mysqli_query($link,$sql);
        while($tbl = mysqli_fetch_array($result))
        {
            $resultado = $tbl[0];
        }
        if($resultado != 0)
        {
            $sql = "SELECT I_COD_ENDERECO FROM tb_endereco WHERE I_COD_PESSOA = $id"; //Pega o endereço do usuário
            $result = mysqli_query($link,$sql);
            while($tbl = mysqli_fetch_array($result))
            {
                $endereco = $tbl[0];
            }
            $sql2 = "SELECT I_COD_PESSOA,D_VLRUNID_CARRINHO FROM tb_carrinho WHERE S_CAR_CARRINHO = '$carrinho'"; //Pega o valor total do carrinho do usuário e a pessoa
            $result2 = mysqli_query($link, $sql2);
            while($tbl2 = mysqli_fetch_array($result2))
            {
                $pessoa = $tbl2[0];
                $vlrtotal += $tbl2[1];
            }
            $data = date("Y-m-d H:i:s"); //Pega a data e hora atual

            $sql3 = "SELECT * FROM tb_carrinho WHERE S_CAR_CARRINHO = '$carrinho'"; //Seleciona todos os carrinhos do usuário
            $result3 = mysqli_query($link, $sql3);
            while($tbl3 = mysqli_fetch_array($result3)) //Insere todos os carrinhos do usuário e os deleta
            {
                $prod = $tbl3[2];
                $qnt = $tbl3[4];

                $sql4 = "INSERT INTO tb_pedido(I_COD_PESSOA,I_COD_ENDERECO, I_COD_PRODUTO, I_QNT_PEDIDO, D_VLRTOT_PEDIDO, DT_COMP_PEDIDO) VALUES ($pessoa,$endereco,$prod,$qnt,$vlrtotal,'$data')";
                mysqli_query($link, $sql4);

                $sql5 = "DELETE FROM tb_carrinho WHERE I_COD_PRODUTO = $prod AND S_CAR_CARRINHO = '$carrinho'";
                mysqli_query($link, $sql5);
            }
            $_SESSION['carrinho'] = md5($email. date("m.d.y H:i:s") . rand()); //Atualiza a variavel de sessão 'carrinho' do usuário
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
    <title>Drogazilla - Compra concluída</title>
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
            <p>Compra Concluida</p>
        </section>
    </main>
</body>
</html>

<script src="script.js"></script>