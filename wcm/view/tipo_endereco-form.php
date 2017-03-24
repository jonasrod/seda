<?php

include_once '../model/tipo_endereco.class.php';

$objTipo_endereco = new Tipo_endereco();

$action = "inserirTipo_endereco";

if( isset( $_GET["idTipo_endereco"] ) )
{
	$action = "editarTipo_endereco";
	$objTipo_endereco->obterTipo_endereco( $_GET["idTipo_endereco"] );
}

?>

<script src="../js/jquery.validate.min.js"></script>

<div class="span6">
<div class="row-fluid">
<form id="form1" name="form1" method="post" action="../controller/tipo_endereco-controle.php"  class="form-inline">

<p><a href="index.php?cmd=tipo_endereco-lista" class="btn btn-info">&lt;&lt; Voltar</a>
<input type="submit" name="salvar" id="salvar" value="Salvar" class="btn btn-success" /></p>

<input type="hidden" name="action" value="<?=$action?>" />
<input type="hidden" name="idTipo_endereco" value="<?=$objTipo_endereco->getTipo_enderecoID()?>" />

<div class="control-group">
	<label class="control-label span3" for="tipoEnderecoId">TipoEnderecoId</label> 
	<input type="text" name="tipoEnderecoId" id="tipoEnderecoId"  class="span9" required="true" value="<?=$objTipo_endereco->getTipoEnderecoId()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="descricao">Descricao</label> 
	<input type="text" name="descricao" id="descricao"  class="span9" required="true" value="<?=$objTipo_endereco->getDescricao()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="status">Status</label> 
	<input type="text" name="status" id="status"  class="span9" required="true" value="<?=$objTipo_endereco->getStatus()?>" />
</div>

</form>
</div>
</div>