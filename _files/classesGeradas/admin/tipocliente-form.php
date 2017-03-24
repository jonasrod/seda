<?php

include_once '../../wcm/model/classesGeradas/model/tipocliente.class.php';

$objTipocliente = new Tipocliente();

$action = "inserirTipocliente";

if( isset( $_GET["idTipocliente"] ) )
{
	$action = "editarTipocliente";
	$objTipocliente->obterTipocliente( $_GET["idTipocliente"] );
}

?>

<script src="../js/jquery.validate.min.js"></script>

<div class="span6">
<div class="row-fluid">
<form id="form1" name="form1" method="post" action="../controller/tipocliente-controle.php"  class="form-inline">

<p><a href="index.php?cmd=tipocliente-lista" class="btn btn-info">&lt;&lt; Voltar</a>
<input type="submit" name="salvar" id="salvar" value="Salvar" class="btn btn-success" /></p>

<input type="hidden" name="action" value="<?=$action?>" />
<input type="hidden" name="idTipocliente" value="<?=$objTipocliente->getTipoclienteID()?>" />

<div class="control-group">
	<label class="control-label span3" for="tipoClienteId">TipoClienteId</label> 
	<input type="text" name="tipoClienteId" id="tipoClienteId"  class="span9" required="true" value="<?=$objTipocliente->getTipoClienteId()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="descricao">Descricao</label> 
	<input type="text" name="descricao" id="descricao"  class="span9" required="true" value="<?=$objTipocliente->getDescricao()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="status">Status</label> 
	<input type="text" name="status" id="status"  class="span9" required="true" value="<?=$objTipocliente->getStatus()?>" />
</div>

</form>
</div>
</div>