<?php

session_start();

include_once "../config.php";
include_once "../model/bancodedados.class.php";
include_once "../model/data.class.php";
include_once "../model/descontofrete.class.php";

$objBd = new BancodeDados();

if (isset($_POST['action']))
{
    if ( $_POST['action'] == 'editarCategoria' )
    {
        $objDescontoFrete = new DescontoFrete();
        $objDescontoFrete->obterDescontoFrete( $_POST['idDescontoFrete'] );
        
        $dados = array(
            'valor_desconto' => $_POST['valor']
        );

        if( !$objBd->edit( 'descontofrete', $dados, $objDescontoFrete->getDescontoFreteId() ) )
        {
            $objBd->rollback();
            $msg = 'OPERACAO_ERRO';
            echo "<script>window.location='../view/index.php?p=desconto-frete-forma&idDescontoFrete=".$objDescontoFrete->getDescontoFreteId()."&st=" . $msg . "'</script>";
            exit();
        }
        
        $objBd->commit();
        $msg = 'OPERACAO_SUCESSO';
        
        echo "<script>window.location='../view/index.php?p=home&idDescontoFrete=".$objDescontoFrete->getDescontoFreteId()."&st=" . $msg . "'</script>";
        exit();
    }
}
?>