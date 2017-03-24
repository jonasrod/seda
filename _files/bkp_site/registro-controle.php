<?php

session_start();

include_once "wcm/config.php";
include_once "wcm/model/bancodedados.class.php";
include_once "wcm/model/data.class.php";
include_once "wcm/model/cliente.class.php";
include_once "wcm/model/endereco.class.php";

$objBd = new BancodeDados();

if (isset($_POST['action']))
{
    if ( $_POST['action'] == 'inserirCliente' )
    {
        $objCliente = new Cliente();
        $objEndereco = new Endereco();
        
        $dados = array(
        	'mTipoClienteId'   => $_POST['tipoCliente'],
            'nome'	   	 	   => $_POST['nome'],
            'sobrenome'        => $_POST['sobrenome'],
            'mGeneroId'        => $_POST['genero'],
            'email'	           => $_POST['email'],
            'telCelular'	   => Data::limpaFormatacao($_POST['telefone']),
            'cpf'	   		   => $_POST['cpf'],
            'rg'	   		   => $_POST['rg'],
            'senha'	   		   => $_POST['senha'],
            'comoFicouSabendo' => $_POST['comoConheceu'],
            'dtAniversario'    => Data::formataDataBD($_POST['dtAniversario']),
            'telResidencial'   => Data::limpaFormatacao($_POST['telResidencial']),
            'telComercial'     => Data::limpaFormatacao($_POST['telComercial'])
        );

        if( !$objBd->insert( 'cliente', $dados ) )
        {
            $objBd->rollback();
            $msg = 'OPERACAO_ERRO';
            echo "<script>window.location='registro.php?p=categoria-form&st=" . $msg . "'</script>";
            exit();
        }
        
        $clienteId = $objBd->insert_id;
        
        $dados = array(
        	'mClienteId'   => $clienteId,
            'cep'	   	   => str_replace('-', '', $_POST['cep']),
            'endereco'     => $_POST['endereco'],
            'numero'	   => $_POST['numero'],
            'complemento'  => $_POST['complemento'],
            'bairro'	   => $_POST['bairro'],
            'cidade'	   => $_POST['cidade'],
            'estado'	   => $_POST['estado'],
            'mTipoEnderecoId' => 2,
            'observacoes'  => $_POST['referencia']
        );
        
        if( !$objBd->insert( 'endereco', $dados ) )
        {
            $objBd->rollback();
            $msg = 'OPERACAO_ERRO';
            echo "<script>window.location='registro.php?st=" . $msg . "'</script>";
            exit();
        }
        
        if (!isset($_POST['mesmoEndereco'])) {
        	$dados = array(
	        	'mClienteId'   => $clienteId,
	            'cep'	   	   => str_replace('-', '', $_POST['cepF']),
	            'endereco'     => $_POST['enderecoF'],
	            'numero'	   => $_POST['numeroF'],
	            'complemento'  => $_POST['complementoF'],
	            'bairro'	   => $_POST['bairroF'],
	            'cidade'	   => $_POST['cidadeF'],
	            'estado'	   => $_POST['estadoF'],
	            'mTipoEnderecoId' => 1,
	            'observacoes'  => $_POST['referenciaF']
	        );
	        
	        if( !$objBd->insert( 'endereco', $dados ) )
	        {
	            $objBd->rollback();
	            $msg = 'OPERACAO_ERRO';
	            echo "<script>window.location='registro.php?st=" . $msg . "'</script>";
	            exit();
	        }
        }
        
        if (isset($_POST['novidades'])) {
        	$dados = array(
		        'email' => $_POST['email']
		    );
			
		    if( !$objBd->insert( 'email', $dados ) )
		    {
		        $objBd->rollback();
		        $msg = 'OPERACAO_ERRO';
		        echo "<script>window.location='registro.php?st=" . $msg . "'</script>";
		        exit();
		    }
        }
        
        $_SESSION['brw_logado'] = true;
        $_SESSION['brw_idLogin'] = $clienteId;
        
        $objBd->commit();
        $msg = 'OPERACAO_SUCESSO';
        
        echo "<script>window.location='minha-conta.php?idCliente=".$clienteId."&st=" . $msg . "'</script>";
        exit();
    }
    else if ($_POST['action'] == 'editarCliente') {
    	$idCliente = $_POST['idCliente'];
        
        $objCliente = new Cliente();
        $objCliente->obterCliente( $_POST['idCliente'] );
        
        $objEndereco = new Endereco();
        $objEndereco->obterEnderecoPorCliente( $_POST['idCliente'] );
        
        $dados = array(
        	'mTipoClienteId'   => $_POST['tipoCliente'],
            'nome'	   	 	   => $_POST['nome'],
            'sobrenome'        => $_POST['sobrenome'],
            'mGeneroId'        => $_POST['genero'],
            'email'	           => $_POST['email'],
            'telCelular'	   => Data::limpaFormatacao($_POST['telefone']),
            'cpf'	   		   => $_POST['cpf'],
            'rg'	   		   => $_POST['rg'],
            'senha'	   		   => $_POST['senha'],
            'comoFicouSabendo' => $_POST['comoConheceu'],
            'dtAniversario'    => Data::formataDataBD($_POST['dtAniversario']),
            'telResidencial'   => Data::limpaFormatacao($_POST['telResidencial']),
            'telComercial'     => Data::limpaFormatacao($_POST['telComercial'])
        );

        if( !$objBd->edit( 'cliente', $dados, $objCliente->getClienteId() ) )
        {
            $objBd->rollback();
            $msg = 'OPERACAO_ERRO';
            echo "<script>window.location='registro.php?clienteId=".$objCliente->getClienteId()."&st=" . $msg . "'</script>";
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
            'observacoes'  => $_POST['referencia']
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
	            'observacoes'  => $_POST['referenciaF']
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
        
        if (isset($_GET['location']))
        {
        	echo "<script>window.location='".$_GET['location'].".php?session=".session_id()."&idCliente=".$objCliente->getClienteId()."&st=" . $msg . "'</script>";
        } 
        else
        {
        	echo "<script>window.location='minha-conta.php?idCliente=".$objCliente->getClienteId()."&st=" . $msg . "'</script>";
        } 
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