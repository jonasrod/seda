<?php

session_start();

include_once "../config.php";
include_once "../model/bancodedados.class.php";
include_once "../model/data.class.php";
include_once "../model/categoria.class.php";

$objBd = new BancodeDados();

if (isset($_GET['action']))
{
    if ($_GET['action'] == 'excluir')
    {
        $sql = "delete from email where emailId = " . $_GET['idEmail'];
		
        if( !$objBd->executarSQL($sql) )
        {
            $objBd->rollback();
            $msg = 'OPERACAO_ERRO';
            echo "<script>window.location='../view/index.php?p=email-lista&st=" . $msg . "'</script>";
            exit();
        }
        
        $objBd->commit();
        $msg = 'OPERACAO_SUCESSO';
        echo "<script>window.location='../view/index.php?p=email-lista&st=" . $msg . "'</script>";
        exit();
    }
}
?>