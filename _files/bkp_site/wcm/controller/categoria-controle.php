<?php

session_start();

include_once "../config.php";
include_once "../model/bancodedados.class.php";
include_once "../model/data.class.php";
include_once "../model/categoria.class.php";

$objBd = new BancodeDados();

if (isset($_POST['action']))
{
    if ($_POST['action'] == 'inserirCategoria')
    {
        $dados = array(
            'descricao' => $_POST['descricao']
        );
		
        if( !$objBd->insert( 'categoria', $dados ) )
        {
            $objBd->rollback();
            $msg = 'OPERACAO_ERRO';
            echo "<script>window.location='../view/index.php?p=categoria-form&st=" . $msg . "'</script>";
            exit();
        }
        
        $objBd->commit();
        $msg = 'OPERACAO_SUCESSO';
        echo "<script>window.location='../view/index.php?p=categoria-lista&st=" . $msg . "'</script>";
        exit();
    }
    else if ( $_POST['action'] == 'editarCategoria' )
    {
        $objCategoria = new Categoria();
        $objCategoria->obterCategoria( $_POST['idCategoria'] );
        
        $dados = array(
            'descricao' => $_POST['descricao']
        );

        if( !$objBd->edit( 'categoria', $dados, $objCategoria->getCategoriaID() ) )
        {
            $objBd->rollback();
            $msg = 'OPERACAO_ERRO';
            echo "<script>window.location='../view/index.php?p=categoria-forma&idCategoria=".$objCategoria->getCategoriaID()."&st=" . $msg . "'</script>";
            exit();
        }
        
        $objBd->commit();
        $msg = 'OPERACAO_SUCESSO';
        
        echo "<script>window.location='../view/index.php?p=categoria-lista&idCategoria=".$objCategoria->getCategoriaID()."&st=" . $msg . "'</script>";
        exit();
    }
}
else if ( isset( $_GET['action'] ) )
{
    if ( $_GET['action'] == 'statusCategoria' )
    {
        $idCategoria = $_GET['idCategoria'];
        
        $objCategoria = new Categoria();
        $objCategoria->obterCategoria( $_GET['idCategoria'] );
        
        $dados = array(
            'status' => $_GET['status']
        );

        if( !$objBd->edit( 'categoria', $dados, $objCategoria->getCategoriaID() ) )
        {
            $objBd->rollback();
            $msg = 'OPERACAO_ERRO';
            echo "<script>window.location='../view/index.php?p=categoria-lista&idCategoria=".$objCategoria->getCategoriaID()."&st=" . $msg . "'</script>";
            exit();
        }
        
        $objBd->commit();
        $msg = 'OPERACAO_SUCESSO';
        
        echo "<script>window.location='../view/index.php?p=categoria-lista&idCategoria=".$objCategoria->getCategoriaID()."&st=" . $msg . "'</script>";
        exit();
    }
}
?>