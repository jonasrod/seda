<?php

include_once '../../wcm/model/classesGeradas/model/estado.class.php';

$objEstado = new Estado();

$action = "inserirEstado";

if( isset( $_GET["idEstado"] ) )
{
	$action = "editarEstado";
	$objEstado->obterEstado( $_GET["idEstado"] );
}

?>

<script src="../js/jquery.validate.min.js"></script>

<div class="span6">
<div class="row-fluid">
<form id="form1" name="form1" method="post" action="../controller/estado-controle.php"  class="form-inline">

<p><a href="index.php?cmd=estado-lista" class="btn btn-info">&lt;&lt; Voltar</a>
<input type="submit" name="salvar" id="salvar" value="Salvar" class="btn btn-success" /></p>

<input type="hidden" name="action" value="<?=$action?>" />
<input type="hidden" name="idEstado" value="<?=$objEstado->getEstadoID()?>" />

<div class="control-group">
	<label class="control-label span3" for="estadoID">EstadoID</label> 
	<input type="text" name="estadoID" id="estadoID"  class="span9" required="true" value="<?=$objEstado->getEstadoID()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="sigla">Sigla</label> 
	<input type="text" name="sigla" id="sigla"  class="span9" required="true" value="<?=$objEstado->getSigla()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="descricao">Descricao</label> 
	<input type="text" name="descricao" id="descricao"  class="span9" required="true" value="<?=$objEstado->getDescricao()?>" />
</div>

</form>
</div>
</div>