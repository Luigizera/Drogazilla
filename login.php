<?php
if(session_start()) session_destroy();
include('conectaBD.php');
if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
    $login = $_POST['username'];
    $senha = $_POST['senha'];
    $senha = $senha."LUIGIZERA";
    $senha = md5($senha);
    $sql = "SELECT COUNT(I_COD_PESSOA) FROM tb_pessoa WHERE S_EMA_PESSOA = '$login' AND S_PASS_PESSOA = '$senha'";
    $result = mysqli_query($link, $sql);
    while ($tbl = mysqli_fetch_array($result)) 
    {
        $total = $tbl[0];
    }
    if ($total == 0) //Passa para o CPF
    {
        $login =  preg_replace("/[^0-9]/", "", $login); // deixa apenas numeros
        if (strlen($login) != 11)
        {
            header('Location: login.php?msg_erro=Login inválido');
            exit();
        }
        $login = substr_replace($login, '-', 9, 0);
        $login = substr_replace($login, '.', 6, 0);
        $login = substr_replace($login, '.', 3, 0);
        $sql = "SELECT COUNT(I_COD_PESSOA) FROM tb_pessoa WHERE S_CPF_PESSOA = '$login' AND S_PASS_PESSOA = '$senha'";
        $result = mysqli_query($link, $sql);
        while ($tbl = mysqli_fetch_array($result)) 
        {
            $total = $tbl[0];
        }
        if ($total == 0) 
        {
            header('Location: login.php?msg_erro=Login inválido');
            exit();
        }
        else
        {
            $sql = "SELECT * FROM tb_pessoa WHERE S_CPF_PESSOA = '$login' AND S_PASS_PESSOA = '$senha'";
            $result = mysqli_query($link, $sql);
            while ($tbl = mysqli_fetch_array($result)) 
            {
                $id = $tbl[0];
                $nome = $tbl[1];
                $snome = $tbl[2];
                $CPF = $tbl[3];
                $cel = $tbl[6];
                $email = $tbl[7];
                $nivel = $tbl[9];
            }
            session_start();
            $_SESSION['id'] = $id;
            $_SESSION['nome'] = $nome;
            $_SESSION['sobrenome'] = $snome;
            $_SESSION['email'] = $email;
            $_SESSION['nivel'] = $nivel;
            $_SESSION['carrinho'] = md5($email. date("m.d.y H:i:s") . rand());
            header('Location: index.php');
            exit();
        }
    }
    else //Faz o login com o Email
    {
        $sql = "SELECT * FROM tb_pessoa WHERE S_EMA_PESSOA = '$login' AND S_PASS_PESSOA = '$senha'";
        $result = mysqli_query($link, $sql);
        while ($tbl = mysqli_fetch_array($result)) 
        {
            $id = $tbl[0];
            $nome = $tbl[1];
            $snome = $tbl[2];
            $CPF = $tbl[3];
            $cel = $tbl[6];
            $email = $tbl[7];
            $nivel = $tbl[9];
        }
        session_start();
        $_SESSION['id'] = $id;
        $_SESSION['nome'] = $nome;
        $_SESSION['sobrenome'] = $snome;
        $_SESSION['email'] = $email;
        $_SESSION['nivel'] = $nivel;
        $_SESSION['carrinho'] = md5($email . date("m.d.y H:i:s") . rand());
        echo($email . date("m.d.y H:i:s") . "LUIGIZERA");
        header('Location: index.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link href="estilo.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <title>DrogaZilla - Login</title>
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
        <div class="tela_login">
            <div id="login">
                <h2>Já sou cliente DrogaZilla.</h2>
                <p>Faça o login para acelerar sua compra</p>
                <form action="login.php" method="post">
                    <h3 id="msg_erro">
                        <?php
                        if (isset($_GET['msg_erro'])) echo ($_GET['msg_erro']);
                        ?>
                    </h3>
                    <p>
                        <label for="username">Email ou CPF:</label>
                        <input type="text" name="username" id="username" placeholder="Digite seu login" required>
                    </p>
                    <p>
                        <label for="senha">Senha:</label>
                        <input type="password" name="senha" id="senha" placeholder="Digite sua senha" required>
                    </p>

                    <p>
                        <input type="submit" value="Fazer Login">
                    </p>
                </form>
                <?php 
                    if(isset($_GET['msg_erro']) && $_GET['msg_erro'] == "Login inválido")
                    {
                        ?>
                            <p><a href="recuperasenha.php">Esqueceu sua senha?</a></p>
                        <?php
                    }
                ?>
            </div>
            <div id="registre">
                <h2>Ainda não sou um cliente DrogaZilla.</h2>
                <p>Cadastre-se para receber novidades e finalizar sua compra</p>
                <br>
                <p>A seguir você informará seus dados para continuar o processo de compra.</p>
                <a href="registrar.php"><button>Cadastre-se</button></a>
            </div>
        </div>
    </main>
</body>
</html>

<script src="script.js"></script>