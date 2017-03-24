<?php

session_start();

include_once "../config.php";
include_once "../model/bancodedados.class.php";
include_once "../model/data.class.php";
include_once "../model/marca.class.php";

$objBd = new BancodeDados();


if (isset($_POST['action']))
{
    if ($_POST['action'] == 'inserirMarca')
    {
        $dados = array(
            'descricao' => $_POST['descricao']
        );
		
        if( !$objBd->insert( 'marca', $dados ) )
        {
            $objBd->rollback();
            $msg = 'OPERACAO_ERRO';
            echo "<script>window.location='../view/index.php?p=marca-form&st=" . $msg . "'</script>";
            exit();
        }
        
        $objBd->commit();
        $msg = 'OPERACAO_SUCESSO';
        echo "<script>window.location='../view/index.php?p=marca-lista&st=" . $msg . "'</script>";
        exit();
    }
    else if ( $_POST['action'] == 'editarMarca' )
    {
        $objmarca = new Marca();
        $objmarca->obterMarca( $_POST['idMarca'] );
        
        $dados = array(
            'descricao' => $_POST['descricao']
        );

        if( !$objBd->edit( 'marca', $dados, $objmarca->getMarcaId() ) )
        {
            $objBd->rollback();
            $msg = 'OPERACAO_ERRO';
            echo "<script>window.location='../view/index.php?p=marca-forma&idMarca=".$objmarca->getMarcaID()."&st=" . $msg . "'</script>";
            exit();
        }
        
        $objBd->commit();
        $msg = 'OPERACAO_SUCESSO';
        
        echo "<script>window.location='../view/index.php?p=marca-lista&idMarca=".$objmarca->getMarcaId()."&st=" . $msg . "'</script>";
        exit();
    }
}
else if ( isset( $_GET['action'] ) )
{
    if ( $_GET['action'] == 'statusMarca' )
    {
        $idMarca = $_GET['idMarca'];
        
        $objMarca = new Marca();
        $objMarca->obterMarca( $_GET['idMarca'] );
        
        $dados = array(
            'status' => $_GET['status']
        );

        if( !$objBd->edit( 'marca', $dados, $objMarca->getMarcaId() ) )
        {
            $objBd->rollback();
            $msg = 'OPERACAO_ERRO';
            echo "<script>window.location='../view/index.php?p=marca-lista&idMarca=".$objMarca->getMarcaId()."&st=" . $msg . "'</script>";
            exit();
        }
        
        $objBd->commit();
        $msg = 'OPERACAO_SUCESSO';
        
        echo "<script>window.location='../view/index.php?p=marca-lista&idMarca=".$objMarca->getMarcaId()."&st=" . $msg . "'</script>";
        exit();
    }
}
?>