<?php

session_start();

include_once "wcm/config.php";
include_once "wcm/model/bancodedados.class.php";
include_once "wcm/model/data.class.php";
include_once "wcm/model/cliente.class.php";

$objBd = new BancodeDados();

if (isset($_POST['action']))
{
    if ( $_POST['action'] == 'recuperarSenha' )
    {
        $objCliente = new Cliente();
        
        $objCliente->obterClientePorEmail($_POST['email']);
        
        Data::recuperaSenha($objCliente->getSenha(), $_POST['email']);
        
        echo "<script>window.location='recuperar-senha.php?st=OPERACAO_SUCESSO'</script>";
        exit();
    }
}
?>