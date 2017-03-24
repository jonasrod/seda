<?php

include_once '../../wcm/model/classesGeradas/model/marca.class.php';

$objMarca = new Marca();

$action = "inserirMarca";

if( isset( $_GET["idMarca"] ) )
{
	$action = "editarMarca";
	$objMarca->obterMarca( $_GET["idMarca"] );
}

?>

<script src="../js/jquery.validate.min.js"></script>

<div class="span6">
<div class="row-fluid">
<form id="form1" name="form1" method="post" action="../controller/marca-controle.php"  class="form-inline">

<p><a href="index.php?cmd=marca-lista" class="btn btn-info">&lt;&lt; Voltar</a>
<input type="submit" name="salvar" id="salvar" value="Salvar" class="btn btn-success" /></p>

<input type="hidden" name="action" value="<?=$action?>" />
<input type="hidden" name="idMarca" value="<?=$objMarca->getMarcaID()?>" />

<div class="control-group">
	<label class="control-label span3" for="marcaId">MarcaId</label> 
	<input type="text" name="marcaId" id="marcaId"  class="span9" required="true" value="<?=$objMarca->getMarcaId()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="descricao">Descricao</label> 
	<input type="text" name="descricao" id="descricao"  class="span9" required="true" value="<?=$objMarca->getDescricao()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="dtCadastro">DtCadastro</label> 
	<input type="text" name="dtCadastro" id="dtCadastro"  class="span9" required="true" value="<?=$objMarca->getDtCadastro()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="status">Status</label> 
	<input type="text" name="status" id="status"  class="span9" required="true" value="<?=$objMarca->getStatus()?>" />
</div>

</form>
</div>
</div>