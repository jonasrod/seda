<?php

include_once '../model/tipo_cliente.class.php';

$objTipo_cliente = new Tipo_cliente();

$action = "inserirTipo_cliente";

if( isset( $_GET["idTipo_cliente"] ) )
{
	$action = "editarTipo_cliente";
	$objTipo_cliente->obterTipo_cliente( $_GET["idTipo_cliente"] );
}

?>

<script src="../js/jquery.validate.min.js"></script>

<div class="span6">
<div class="row-fluid">
<form id="form1" name="form1" method="post" action="../controller/tipo_cliente-controle.php"  class="form-inline">

<p><a href="index.php?cmd=tipo_cliente-lista" class="btn btn-info">&lt;&lt; Voltar</a>
<input type="submit" name="salvar" id="salvar" value="Salvar" class="btn btn-success" /></p>

<input type="hidden" name="action" value="<?=$action?>" />
<input type="hidden" name="idTipo_cliente" value="<?=$objTipo_cliente->getTipo_clienteID()?>" />

<div class="control-group">
	<label class="control-label span3" for="tipoClienteId">TipoClienteId</label> 
	<input type="text" name="tipoClienteId" id="tipoClienteId"  class="span9" required="true" value="<?=$objTipo_cliente->getTipoClienteId()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="descricao">Descricao</label> 
	<input type="text" name="descricao" id="descricao"  class="span9" required="true" value="<?=$objTipo_cliente->getDescricao()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="status">Status</label> 
	<input type="text" name="status" id="status"  class="span9" required="true" value="<?=$objTipo_cliente->getStatus()?>" />
</div>

</form>
</div>
</div>