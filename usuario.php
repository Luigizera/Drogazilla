<?php
    include('conectaBD.php');
    include('seguranca0.php');
    $id = $_SESSION['id'];
    $sql = "SELECT COUNT(I_COD_PESSOA) FROM tb_pessoa WHERE I_COD_PESSOA = $id";
    $result = mysqli_query($link,$sql);
    while($tbl = mysqli_fetch_array($result))
    {
        $resultado = $tbl[0];
    }
    if($resultado != 0)
    {
        $sql = "SELECT * FROM tb_pessoa WHERE I_COD_PESSOA = $id";
        $result = mysqli_query($link,$sql);
        while($tbl = mysqli_fetch_array($result))
        {
            $nome = $tbl[1];
            $snm = $tbl[2];
            $cpf = $tbl[3];
            $nasc = $tbl[4];
            $nasc = date("d/m/Y", strtotime($nasc));
            $genero = $tbl[5];
            $cel = $tbl[6];
            $email = $tbl[7];
        }
    }

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
        $endereco = NULL;
        $bairro = NULL;
        $cidade = NULL;
        $uf = NULL;
        $cep = NULL;
    }

    
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="estilo.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <title>Drogazilla - Perfil</title>
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
        <section class="tema_pessoal">
            <h1>Tema</h1>
            <p>
                <label for="tema">Escolha um tema:</label>
                <select id="select">
                    <option value="Padrão" onclick="setTheme('Padrão')">Padrão</option>
                    <option value="Invertido" onclick="setTheme('Invertido')">Invertido</option>
                </select>
            </p>
        </section>
        <section class="dados_pessoais">
            <h1>Dados Pessoais</h1>
            <br>
            <h3 id="msg_erro">
                <?php
                if (isset($_GET['msg_erro'])) echo ($_GET['msg_erro']);
                ?>
            </h3>
            <p>
                <label for="nome">Nome:</label>
                <input type="text" name="nome" id="nome" maxlength="30" value="<?=$nome?>" disabled>
            </p>
            <p>
                <label for="sobrenome">Sobrenome:</label>
                <input type="text" name="sobrenome" id="sobrenome" maxlength="30" value="<?=$snm?>" disabled>
            </p>
            <p>
                <label for="cpf">CPF:</label>
                <input type="text" name="cpf" id="cpf" maxlength="14" value="<?=$cpf?>" disabled>
            </p>
            <p>
                <label for="nasc">Data de nascimento:</label>
                <input type="text" name="nasc" id="nasc" maxlength="10" value="<?=$nasc?>" disabled>
            </p>
            <p>
                <label for="genero">Gênero:</label>
                <input type="text" name="genero" id="genero" value="<?=$genero?>" disabled>
            </p>
            <p>
                <label for="celular">Celular:</label>
                <input type="text" name="celular" id="celular" maxlength="14" value="<?=$cel?>" disabled>
            </p>
            <p>
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" maxlength="40" value="<?=$email?>" disabled>
            </p>
                <a href="alterarpessoa.php?cliente=<?=$id?>"><button id="alterarinfo">Alterar Informações</button></a>
        </section>
        <section class="dados_pessoais">
            <h1>Endereço</h1>
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
            <a href="alterarendereco.php?cliente=<?=$id?>"><button id="alterarinfo">Alterar Endereço</button></a>
        </section>

        <section class="pedidos_pessoais">
        <h1>Pedidos</h1>
        <?php
            $sql = "SELECT COUNT(I_COD_PEDIDO) FROM tb_pedido WHERE I_COD_PESSOA = $id";
            $result = mysqli_query($link, $sql);
            while($tbl = mysqli_fetch_array($result))
            {
                $resultado = $tbl[0];
            }
            if($resultado == 0)
            {
                echo("<p>Você não tem nenhum pedido.</p>");
            }
            else
            {
        ?>
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
                    $sql = "SELECT * FROM tb_pedido WHERE I_COD_PESSOA = $id";
                    $result = mysqli_query($link, $sql);
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
                                    echo ("<td><a href='deletarpedido.php?pedido=" . $tbl[0] . "'><button id='btnexcluir'>Cancelar pedido</button></a></td>");
                                    echo ("</tr>");
                                }
                            }
                        }
                    }
                }
                ?>
            </table>
        </section>
    </main>
    </main>
</body>
</html>

<script src="script.js"></script>