<?php

include_once '../../wcm/model/classesGeradas/model/tipoendereco.class.php';

$objTipoendereco = new Tipoendereco();

$action = "inserirTipoendereco";

if( isset( $_GET["idTipoendereco"] ) )
{
	$action = "editarTipoendereco";
	$objTipoendereco->obterTipoendereco( $_GET["idTipoendereco"] );
}

?>

<script src="../js/jquery.validate.min.js"></script>

<div class="span6">
<div class="row-fluid">
<form id="form1" name="form1" method="post" action="../controller/tipoendereco-controle.php"  class="form-inline">

<p><a href="index.php?cmd=tipoendereco-lista" class="btn btn-info">&lt;&lt; Voltar</a>
<input type="submit" name="salvar" id="salvar" value="Salvar" class="btn btn-success" /></p>

<input type="hidden" name="action" value="<?=$action?>" />
<input type="hidden" name="idTipoendereco" value="<?=$objTipoendereco->getTipoenderecoID()?>" />

<div class="control-group">
	<label class="control-label span3" for="tipoEnderecoId">TipoEnderecoId</label> 
	<input type="text" name="tipoEnderecoId" id="tipoEnderecoId"  class="span9" required="true" value="<?=$objTipoendereco->getTipoEnderecoId()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="descricao">Descricao</label> 
	<input type="text" name="descricao" id="descricao"  class="span9" required="true" value="<?=$objTipoendereco->getDescricao()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="status">Status</label> 
	<input type="text" name="status" id="status"  class="span9" required="true" value="<?=$objTipoendereco->getStatus()?>" />
</div>

</form>
</div>
</div>