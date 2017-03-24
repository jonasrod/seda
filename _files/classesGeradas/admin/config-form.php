<?php

include_once '../../wcm/model/classesGeradas/model/config.class.php';

$objConfig = new Config();

$action = "inserirConfig";

if( isset( $_GET["idConfig"] ) )
{
	$action = "editarConfig";
	$objConfig->obterConfig( $_GET["idConfig"] );
}

?>

<script src="../js/jquery.validate.min.js"></script>

<div class="span6">
<div class="row-fluid">
<form id="form1" name="form1" method="post" action="../controller/config-controle.php"  class="form-inline">

<p><a href="index.php?cmd=config-lista" class="btn btn-info">&lt;&lt; Voltar</a>
<input type="submit" name="salvar" id="salvar" value="Salvar" class="btn btn-success" /></p>

<input type="hidden" name="action" value="<?=$action?>" />
<input type="hidden" name="idConfig" value="<?=$objConfig->getConfigID()?>" />

<div class="control-group">
	<label class="control-label span3" for="configID">ConfigID</label> 
	<input type="text" name="configID" id="configID"  class="span9" required="true" value="<?=$objConfig->getConfigID()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="chave">Chave</label> 
	<input type="text" name="chave" id="chave"  class="span9" required="true" value="<?=$objConfig->getChave()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="valor">Valor</label> 
	<input type="text" name="valor" id="valor"  class="span9" required="true" value="<?=$objConfig->getValor()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="descricao">Descricao</label> 
	<input type="text" name="descricao" id="descricao"  class="span9" required="true" value="<?=$objConfig->getDescricao()?>" />
</div>

</form>
</div>
</div>