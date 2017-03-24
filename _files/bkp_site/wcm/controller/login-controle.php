<?php

session_start();

include_once "../config.php";
include_once "../model/bancodedados.class.php";
include_once '../model/login.class.php';

$objBd = new BancodeDados();

if (isset($_POST['action']))
{
    if ($_POST['action'] == 'autenticarUsuario')
    {
        $objLogin = new Login();
		
        if ($objLogin->autenticarUsuario($_POST['login'], $_POST['senha']))
        {
            echo "<script>window.location='../view/index.php'</script>";
        }
        else
        {
        	echo "<script>window.location='../view/login.php?st=LOGIN_INCORRETO'</script>";
        }
    }
}
else if (isset($_GET['action']))
{
    if ($_GET['action'] == 'logout')
    {
        if (isset($_SESSION['wcm']['brw_logado']))
        {
            unset($_SESSION['wcm']['brw_logado']);
            unset($_SESSION['wcm']['brw_idUsuario']);

            echo "<script>window.location='../view'</script>";
            exit();
        } else
        {
            echo "<script>window.location='../view'</script>";
            exit();
        }
    }
}
?>