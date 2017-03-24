<?php

include_once '../../wcm/model/classesGeradas/model/genero.class.php';

$objGenero = new Genero();

$action = "inserirGenero";

if( isset( $_GET["idGenero"] ) )
{
	$action = "editarGenero";
	$objGenero->obterGenero( $_GET["idGenero"] );
}

?>

<script src="../js/jquery.validate.min.js"></script>

<div class="span6">
<div class="row-fluid">
<form id="form1" name="form1" method="post" action="../controller/genero-controle.php"  class="form-inline">

<p><a href="index.php?cmd=genero-lista" class="btn btn-info">&lt;&lt; Voltar</a>
<input type="submit" name="salvar" id="salvar" value="Salvar" class="btn btn-success" /></p>

<input type="hidden" name="action" value="<?=$action?>" />
<input type="hidden" name="idGenero" value="<?=$objGenero->getGeneroID()?>" />

<div class="control-group">
	<label class="control-label span3" for="generoId">GeneroId</label> 
	<input type="text" name="generoId" id="generoId"  class="span9" required="true" value="<?=$objGenero->getGeneroId()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="descricao">Descricao</label> 
	<input type="text" name="descricao" id="descricao"  class="span9" required="true" value="<?=$objGenero->getDescricao()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="status">Status</label> 
	<input type="text" name="status" id="status"  class="span9" required="true" value="<?=$objGenero->getStatus()?>" />
</div>

</form>
</div>
</div>