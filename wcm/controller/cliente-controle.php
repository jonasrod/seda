<?php

session_start();

include_once "../config.php";
include_once "../model/bancodedados.class.php";
include_once "../model/data.class.php";
include_once "../model/cliente.class.php";
include_once "../model/endereco.class.php";

$objBd = new BancodeDados();

if (isset($_POST['action']))
{
    if ( $_POST['action'] == 'editarCliente' )
    {
        $objCliente = new Cliente();
        $objCliente->obterCliente( $_POST['idCliente'] );
        
        $objEndereco = new Endereco();
        $objEndereco->obterEnderecoPorCliente( $_POST['idCliente'] );
        
        $dados = array(
        	'mTipoClienteId'   => $_POST['tipoclienteid'],
            'nome'	   	 	   => $_POST['nome'],
            'sobrenome'        => $_POST['sobrenome'],
            'mGeneroId'        => $_POST['generoid'],
            'email'	           => $_POST['email'],
            'telCelular'	   => $_POST['telCelular'],
            'cpf'	   		   => $_POST['cpf'],
            'rg'	   		   => $_POST['rg'],
            'dtAniversario'    => Data::formataDataBD($_POST['dtAniversario']),
            'telResidencial'   => $_POST['telResidencial'],
            'telComercial'     => $_POST['telComercial']
        );

        if( !$objBd->edit( 'cliente', $dados, $objCliente->getClienteId() ) )
        {
            $objBd->rollback();
            $msg = 'OPERACAO_ERRO';
            echo "<script>window.location='../view/index.php?p=cliente-forma&idCliente=".$objCliente->getClienteId()."&st=" . $msg . "'</script>";
            exit();
        }
        
        $dados = array(
        	'mClienteId'   => $objCliente->getClienteId(),
            'cep'	   	   => str_replace('-', '', $_POST['cep']),
            'endereco'     => $_POST['endereco'],
            'numero'	   => $_POST['numero'],
            'complemento'  => $_POST['complemento'],
            'bairro'	   => $_POST['bairro'],
            'cidade'	   => $_POST['cidade'],
            'estado'	   => $_POST['estado'],
            'mTipoEnderecoId' => 2,
            'observacoes'  => $_POST['observacoes']
        );
        
        if( !$objBd->edit( 'endereco', $dados, $objEndereco->getEnderecoId() ) )
        {
            $objBd->rollback();
            $msg = 'OPERACAO_ERRO';
            echo "<script>window.location='registro.php?clienteId=".$objCliente->getClienteId()."&st=" . $msg . "'</script>";
            exit();
        }
        
        if (!isset($_POST['mesmoEndereco'])) {
        	$objEnderecoF = new Endereco();
        	$objEnderecoF->obterEnderecoFPorCliente( $_POST['idCliente'] );
        	$dados = array(
	        	'mClienteId'   => $objCliente->getClienteId(),
	            'cep'	   	   => str_replace('-', '', $_POST['cepF']),
	            'endereco'     => $_POST['enderecoF'],
	            'numero'	   => $_POST['numeroF'],
	            'complemento'  => $_POST['complementoF'],
	            'bairro'	   => $_POST['bairroF'],
	            'cidade'	   => $_POST['cidadeF'],
	            'estado'	   => $_POST['estadoF'],
	            'mTipoEnderecoId' => 1,
	            'observacoes'  => $_POST['observacoesF']
	        );
	        
	        if( !$objBd->edit( 'endereco', $dados, $objEnderecoF->getEnderecoId() ) )
	        {
	            $objBd->rollback();
	            $msg = 'OPERACAO_ERRO';
	            echo "<script>window.location='registro.php?st=" . $msg . "'</script>";
	            exit();
	        }
        } else {
        	$objEnderecoF = new Endereco();
        	$objEnderecoF->obterEnderecoFPorCliente( $_POST['idCliente'] );
        	
        	if ($objEnderecoF->getCep() != '') 
        	{
        		if( !$objBd->delete( 'endereco', $objEnderecoF->getEnderecoId() ) )
		        {
		            $objBd->rollback();
		            $msg = 'OPERACAO_ERRO';
		            echo "<script>window.location='registro.php?st=" . $msg . "'</script>";
		            exit();
		        }
        	}
        }
        
        $objBd->commit();
        $msg = 'OPERACAO_SUCESSO';
        
        echo "<script>window.location='../view/index.php?p=cliente-lista&idCliente=".$objCliente->getClienteId()."&st=" . $msg . "'</script>";
        exit();
    }
}
else if ( isset( $_GET['action'] ) )
{
    if ( $_GET['action'] == 'statusCliente' )
    {
        $idCliente = $_GET['idCliente'];
        
        $objCliente = new Cliente();
        $objCliente->obterCliente( $_GET['idCliente'] );
        
        $dados = array(
            'status' => $_GET['status']
        );

        if( !$objBd->edit( 'cliente', $dados, $objCliente->getClienteId() ) )
        {
            $objBd->rollback();
            $msg = 'OPERACAO_ERRO';
            echo "<script>window.location='../view/index.php?p=cliente-lista&idCliente=".$objCliente->getClienteId()."&st=" . $msg . "'</script>";
            exit();
        }
        
        $objBd->commit();
        $msg = 'OPERACAO_SUCESSO';
        
        echo "<script>window.location='../view/index.php?p=cliente-lista&idCliente=".$objCliente->getClienteId()."&st=" . $msg . "'</script>";
        exit();
    }
}
?>