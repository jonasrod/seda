<?php

session_start();

include_once "../config.php";
include_once "../model/bancodedados.class.php";
include_once "../model/data.class.php";
include_once "../model/subcategoria.class.php";
include_once "../model/categoria.class.php";

$objBd = new BancodeDados();

if (isset($_POST['action']))
{
    if ($_POST['action'] == 'inserirSubcategoria')
    {
    	$objCategoria = new Categoria();
        $objCategoria->obterCategoria( $_POST['categoriaid'] );
        
        $dados = array(
            'descricao' => $_POST['descricao'],
            'mCategoriaId' => $objCategoria->getCategoriaId()
        );
		
        if( !$objBd->insert( 'subcategoria', $dados ) )
        {
            $objBd->rollback();
            $msg = 'OPERACAO_ERRO';
            echo "<script>window.location='../view/index.php?p=subcategoria-form&st=" . $msg . "'</script>";
            exit();
        }
        
        $objBd->commit();
        $msg = 'OPERACAO_SUCESSO';
        echo "<script>window.location='../view/index.php?p=subcategoria-lista&st=" . $msg . "'</script>";
        exit();
    }
    else if ( $_POST['action'] == 'editarSubcategoria' )
    {
        $objSubcategoria = new Subcategoria();
        $objSubcategoria->obterSubcategoria( $_POST['idSubcategoria'] );
        
        $objCategoria = new Categoria();
        $objCategoria->obterCategoria( $_POST['categoriaid'] );
        
        $dados = array(
            'descricao'	   => $_POST['descricao'],
            'mCategoriaId' => $objCategoria->getCategoriaId()
        );

        if( !$objBd->edit( 'subcategoria', $dados, $objSubcategoria->getSubcategoriaId() ) )
        {
            $objBd->rollback();
            $msg = 'OPERACAO_ERRO';
            echo "<script>window.location='../view/index.php?p=subcategoria-forma&idSubcategoria=".$objSubcategoria->getSubcategoriaId()."&st=" . $msg . "'</script>";
            exit();
        }
        
        $objBd->commit();
        $msg = 'OPERACAO_SUCESSO';
        
        echo "<script>window.location='../view/index.php?p=subcategoria-lista&idSubcategoria=".$objSubcategoria->getSubcategoriaId()."&st=" . $msg . "'</script>";
        exit();
    }
}
else if ( isset( $_GET['action'] ) )
{
    if ( $_GET['action'] == 'statusSubcategoria' )
    {
        $idSubcategoria = $_GET['idSubcategoria'];
        
        $objSubcategoria = new Subcategoria();
        $objSubcategoria->obterSubcategoria( $_GET['idSubcategoria'] );
        
        $dados = array(
            'status' => $_GET['status']
        );

        if( !$objBd->edit( 'subcategoria', $dados, $objSubcategoria->getSubcategoriaId() ) )
        {
            $objBd->rollback();
            $msg = 'OPERACAO_ERRO';
            echo "<script>window.location='../view/index.php?p=subcategoria-lista&idSubcategoria=".$objSubcategoria->getSubcategoriaId()."&st=" . $msg . "'</script>";
            exit();
        }
        
        $objBd->commit();
        $msg = 'OPERACAO_SUCESSO';
        
        echo "<script>window.location='../view/index.php?p=subcategoria-lista&idSubcategoria=".$objSubcategoria->getSubcategoriaId()."&st=" . $msg . "'</script>";
        exit();
    }
}
?>