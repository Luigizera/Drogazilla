<?php
if(!session_start()) session_start();
if(!isset($_SESSION['nivel']) || $_SESSION['nivel']!= 10)
{
    header('Location:login.php?msg_erro=Você não tem permissão de acesso.');
    exit();
}