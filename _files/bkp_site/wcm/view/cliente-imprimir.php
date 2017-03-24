<?php

include_once '../model/cliente.class.php';
include_once '../model/genero.class.php';
include_once '../model/tipo_cliente.class.php';
include_once '../model/endereco.class.php';
include_once '../model/tipo_endereco.class.php';
include_once '../model/data.class.php';
include_once '../model/bancodedados.class.php';

$objGeneroId = new Genero();
$objTipoClienteId = new TipoCliente();
$objCliente = new Cliente();
$objEndereco = new Endereco();
$objTipoEnderecoId = new TipoEndereco();
$objBd = new BancodeDados();

if( isset( $_GET["idCliente"] ) )
{
	$objCliente->obterCliente( $_GET["idCliente"] );
	
	$objEndereco->obterEnderecoPorCliente($_GET["idCliente"]);
}

?>
<style>
.btn{

}
</style>
<script type="text/javascript">
	function imprimir() {
		$(document).ready(function() {
			$("#divPage").removeClass("page")
			window.print();
			$("#divPage").addClass("page")
		});
	}
</script>
<div class="span12 noPrint">
<h4 class="header">Cliente</h4>
<div class="row-fluid">
	<div class="span6 ">
  		<div class="row-fluid">
  			<p><a href="index.php?p=cliente-lista" class="btn btn-info">&lt;&lt; Voltar</a>
			<input type="button" name="imprimir" id="imprimir" value="Imprimir" class="btn btn-success" onClick="imprimir()" /></p>
  		</div>
  	</div>
</div>
</div>

<div class="span12 noPrint">
<div class="row-fluid ">&nbsp;</div>
</div>

<div class="span12">
<div class="row-fluid">
	<?php
	$complemento = $objEndereco->getComplemento();
	if (empty($complemento)) {
		$complemento = '';
	} else {
		$complemento = ' - ' . $objEndereco->getComplemento();
	}
	
	echo $objCliente->getNome() . ' ' . $objCliente->getSobrenome() . '<br>';
	echo $objEndereco->getEndereco() . $complemento . '<br>';
	echo $objEndereco->getBairro() . ' - CEP ' . Data::formataCep($objEndereco->getCep()) . '<br>';
	echo $objEndereco->getCidade() . ' - ' . $objEndereco->getEstado();
	
	?>
</div>
</div>