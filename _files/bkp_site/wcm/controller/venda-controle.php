<?php

session_start();

include_once "../config.php";
include_once "../model/bancodedados.class.php";
include_once "../model/data.class.php";
include_once "../model/venda.class.php";
include_once "../model/produto.class.php";
include_once "../model/carrinhoproduto.class.php";

$objBd = new BancodeDados();

if ( isset( $_GET['action'] ) )
{
    if ( $_GET['action'] == 'statusVenda' )
    {
        $idVenda = $_GET['idVenda'];
        
        $objVenda = new Venda();
        $objVenda->obterVenda( $_GET['idVenda'] );
        
        $dados = array(
            'status' => $_GET['status']
        );

        if( !$objBd->edit( 'venda', $dados, $objVenda->getVendaId() ) )
        {
            $objBd->rollback();
            $msg = 'OPERACAO_ERRO';
            echo "<script>window.location='../view/index.php?p=venda-lista&idVenda=".$objVenda->getVendaId()."&st=" . $msg . "'</script>";
            exit();
        }
        
        if ($_GET['status'] == '4' || $_GET['status'] == 4) { // cancelamento
        	$objCarrinhoProduto = new Carrinhoproduto();
        	
        	$sql = "select * from carrinhoproduto where mCarrinhoId = " . $objVenda->getCarrinhoId()->getCarrinhoId();
        	$result = $objBd->executarSQL($sql);
        	
        	foreach( $objCarrinhoProduto->listarComFiltro( $result ) as $carrinhoProduto ) 
        	{
        		$sql_update  = "update produto set quantidade = quantidade + " . $carrinhoProduto->getQuantidade();
        		$sql_update .= " where produtoId = " . $carrinhoProduto->getProdutoId()->getProdutoId();
        		
        		if( !$objBd->executarSQL($sql_update) )
        		{
        			$objBd->rollback();
		            $msg = 'OPERACAO_ERRO';
		            echo "<script>window.location='../view/index.php?p=venda-lista&idVenda=".$objVenda->getVendaId()."&st=" . $msg . "'</script>";
		            exit();
        		}
        	}
        	
        }
        
        $objBd->commit();
        $msg = 'OPERACAO_SUCESSO';
        
        echo "<script>window.location='../view/index.php?p=venda-lista&idVenda=".$objVenda->getVendaId()."&st=" . $msg . "'</script>";
        exit();
        
    }
} 
else if (isset($_POST['action'])) 
{
	if ($_POST['action'] == 'inserirRastreamento')
	{
        
        $objVenda = new Venda();
        $objVenda->obterVenda( $_POST['idVenda'] );
        
        $dados = array(
            'rastreamento' => $_POST['descricao']
        );

        if( !$objBd->edit( 'venda', $dados, $_POST['idVenda'] ) )
        {
            $objBd->rollback();
            $msg = 'OPERACAO_ERRO';
            echo "<script>window.location='../view/index.php?p=venda-lista&idVenda=".$objVenda->getVendaId()."&st=" . $msg . "'</script>";
            exit();
        }
        
        $objBd->commit();
        $msg = 'OPERACAO_SUCESSO';
        
        echo "<script>window.location='../view/index.php?p=venda-lista&idVenda=".$objVenda->getVendaId()."&st=" . $msg . "'</script>";
        exit();
	}
}
?>