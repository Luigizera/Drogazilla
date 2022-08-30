<?php
if(!session_start()) session_start();
if(!isset($_SESSION['nivel']))
{
    header('Location:login.php?msg_erro=Faça seu login.');
    exit();
}