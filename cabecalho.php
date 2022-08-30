<?php
        if(session_status() == 1) session_start();
        if(isset($_SESSION['nivel']) && $_SESSION['nivel'] == 0)
        {
            ?>
                <p id="login">Bem-vindo <a href="usuario.php" title="Perfil"><b><?=$_SESSION['nome']?></b></a></p>
                <p><a href="carrinho.php"><i class="material-icons color-menu" title="Carrinho de Compras">add_shopping_cart</i></a></p>
                <p><a href="logout.php"><i class="material-icons color-menu" title="Logout">input</i></a></p>
            <?php
        }
        else
        {
            if(isset($_SESSION['nivel']) && $_SESSION['nivel'] == 10)
            {
                ?>
                    <p id="login">Bem-vindo <a href="usuario.php" title="Perfil"><b><?=$_SESSION['nome']?></b></a></p>
                    <p><a href="listapessoa.php"><i class="material-icons color-menu" title="Lista de Clientes">format_list_numbered</i></a></p>
                    <p><a href="listaproduto.php"><i class="material-icons color-menu" title="Lista de Produtos">featured_play_list</i></a></p>
                    <p><a href="listapedido.php"><i class="material-icons color-menu" title="Lista de Pedidos">chrome_reader_mode</i></a></p>
                    <p><a href="carrinho.php"><i class="material-icons color-menu" title="Carrinho de Compras">add_shopping_cart</i></a></p>
                    <p><a href="logout.php"><i class="material-icons color-menu" title="Logout">input</i></a></p>
                <?php
            }
        
            else
            {
                ?>
                    <p id="login"><a href="login.php" title="Faça o Login">Login</a></p>
                    <a href="carrinho.php"><i class="material-icons color-menu" title="Carrinho de Compras">add_shopping_cart</i></a>
                <?php
            }
        }
?>