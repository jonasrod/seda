<?php
include_once "wcm/config.php";
include_once "wcm/model/bancodedados.class.php";
include_once 'wcm/model/login.class.php';
include_once 'wcm/model/cliente.class.php';

$objBd = new BancodeDados();

if (isset($_POST['action']))
{
    if ($_POST['action'] == 'autenticarUsuario')
    {
        $objLogin = new Cliente();
		
        if ($objLogin->autenticarUsuario($_POST['login'], $_POST['senha']))
        {
        	if (isset($_SESSION['fechamento']['redirecionamento']) && $_SESSION['fechamento']['redirecionamento'] != "") {
        		echo "<script>window.location='".$_SESSION['fechamento']['redirecionamento']."'</script>";
        	} else {
        		echo "<script>window.location='index.php'</script>";
        	}
        }
        else
        {
        	echo "<script>window.location='login-conta.php?st=LOGIN_INCORRETO'</script>";
        }
    }
}
else if (isset($_GET['action']))
{
    if ($_GET['action'] == 'logout')
    {
        if (isset($_SESSION['brw_logado']))
        {
            unset($_SESSION['brw_logado']);
            unset($_SESSION['brw_idUsuario']);
			
			session_destroy();
			
            echo "<script>window.location='index.php'</script>";
            exit();
        } else
        {
            echo "<script>window.location='index.php'</script>";
            exit();
        }
    }
}
?>