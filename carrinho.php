<?php
    include('conectaBD.php');
    include('seguranca0.php');
    $id = $_SESSION['id'];
    $carrinho = $_SESSION['carrinho'];
    $tabela = false;

    if(isset($_GET['deletar'])) //Deleta um item do carrinho
    {
        $deletar = $_GET['deletar'];
        $sql = "DELETE FROM tb_carrinho WHERE I_COD_CARRINHO = $deletar";
        mysqli_query($link,$sql);
        header('Location: carrinho.php');
        exit();
    }
    if(isset($_GET["adicionar"])) //Adiciona um item do carrinho
    {
        $adicionar = $_GET['adicionar'];
        $qnt = 1;

        $sql2 = "SELECT D_VLRUNID_PRODUTO FROM tb_produto WHERE I_COD_PRODUTO = $adicionar";
        $result2 = mysqli_query($link,$sql2);    
        while($tbl2 = mysqli_fetch_array($result2)) //Pega o valor do produto
        {
            $prod_vlr = $tbl2[0];
        }

        $sql = "SELECT COUNT(S_CAR_CARRINHO) FROM tb_carrinho WHERE S_CAR_CARRINHO = '$carrinho'";
        $result = mysqli_query($link, $sql);
        while($tbl = mysqli_fetch_array($result)) //Verifica se já existe um carrinho
        {
            $resultado = $tbl[0];
        }

        if($resultado != 0)
        {
            $sql = "SELECT * FROM tb_carrinho WHERE S_CAR_CARRINHO = '$carrinho'";
            $result = mysqli_query($link, $sql);
            while($tbl = mysqli_fetch_array($result)) //Parte de verificação se o produto já existe na tabela
            {
                $prod = $tbl[2];
                $qntatual = $tbl[4];

                if($adicionar == $prod) //Se o código do adicionar já existir no carrinho do usuário atualiza a quantidade
                {
                    $qnt = $qntatual + 1;
                    $prod_vlr *= $qnt;
                    $sql = "UPDATE tb_carrinho SET I_QNT_CARRINHO = $qnt, D_VLRUNID_CARRINHO = $prod_vlr WHERE I_COD_PRODUTO = '$adicionar' AND S_CAR_CARRINHO = '$carrinho'";
                    mysqli_query($link, $sql);
                    header('Location: carrinho.php');
                    exit();
                }
            }
            $sql = "INSERT INTO tb_carrinho(I_COD_PESSOA, I_COD_PRODUTO, S_CAR_CARRINHO,I_QNT_CARRINHO, D_VLRUNID_CARRINHO) VALUES ($id,$adicionar,'$carrinho', $qnt, $prod_vlr)";
            mysqli_query($link, $sql);
            header('Location: carrinho.php');
            exit();
        }
        else
        {
            $sql = "INSERT INTO tb_carrinho(I_COD_PESSOA, I_COD_PRODUTO, S_CAR_CARRINHO,I_QNT_CARRINHO, D_VLRUNID_CARRINHO) VALUES ($id,$adicionar,'$carrinho', $qnt, $prod_vlr)";
            mysqli_query($link, $sql);
            header('Location: carrinho.php');
            exit();
        }

    }
    else
    {
        $sql = "SELECT COUNT(S_CAR_CARRINHO) FROM tb_carrinho WHERE S_CAR_CARRINHO = '$carrinho'";
        $result = mysqli_query($link,$sql);
        while($tbl = mysqli_fetch_array($result))
        {
            $resultado = $tbl[0];
        }
        
        if($resultado != 0)
        {
            $sql = "SELECT * FROM tb_carrinho WHERE S_CAR_CARRINHO = '$carrinho'";
            $result = mysqli_query($link, $sql);
            $tabela = true;
        }
    }
    
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="estilo.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <title>DrogaZilla - Carrinho</title>
    <style>
        #msg_erro
        {
            text-align: center;
        }    
    </style>
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
        <section class="produtos">
            <h1>Seu carrinho:</h1>
            <h3 id="msg_erro">
                <?php
                if (isset($_GET['msg_erro'])) echo ($_GET['msg_erro']);
                ?>
            </h3>
            <?php
            if($tabela == true)
            {
                while ($tbl = mysqli_fetch_array($result)) 
                {
                    $valor = str_replace('.', ',', $tbl[5]);
                    $produto = $tbl[2];
                    $sql3 = "SELECT S_IMG_PRODUTO, S_NMCO_PRODUTO FROM tb_produto WHERE I_COD_PRODUTO = $produto";
                    $result3 = mysqli_query($link, $sql3);
                    while($tbl3 = mysqli_fetch_array($result3))
                    {
                        ?>
                 
                            <table>
                                <tr>
                                    <td colspan="4" rowspan="4"><img src='img_produto/<?=$tbl3[0]?>'></td>
                                    <td colspan="4"><?=$tbl3[1]?></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td colspan="2">Quantidade: <?=$tbl[4]?></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td colspan="2">R$ <?=$valor?></td>
                                </tr>
                                <tr>
                                    <td colspan="2"><a href='carrinho.php?deletar=<?=$tbl[0]?>'><button>Remover do Carrinho</button></a></td>
                                    <td colspan="2"><a href='carrinho.php?adicionar=<?=$tbl[2]?>'><button>Adicionar Mais</button></a></td>
                                </tr>
                            </table>
                        <?php
                    }
                }
            }
            else
            {
                ?>
                <p><img src="img/carrinho_vazio.png"></p>
                <?php
            }
            ?>
        </section>
        <?php
            $vlrtotal = 0;
            $sql4 = "SELECT D_VLRUNID_CARRINHO FROM tb_carrinho WHERE S_CAR_CARRINHO = '$carrinho'";
            $result4 = mysqli_query($link, $sql4);
            while($tbl4 = mysqli_fetch_array($result4))
            {
                $vlrtotal += $tbl4[0];
            }
        ?>
        <section class="carrinho-enviar">
            <p>Valor total da compra: <b>R$ <?=$vlrtotal?></b></p>
            <a href="confirmarcompra.php"><button id="finalizarcompra">Finalizar Compra</button></a>
        </section>
    </main>
</body>
</html>

<script src="script.js"></script>