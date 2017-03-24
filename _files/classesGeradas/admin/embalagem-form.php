<?php

include_once '../../wcm/model/classesGeradas/model/embalagem.class.php';

$objEmbalagem = new Embalagem();

$action = "inserirEmbalagem";

if( isset( $_GET["idEmbalagem"] ) )
{
	$action = "editarEmbalagem";
	$objEmbalagem->obterEmbalagem( $_GET["idEmbalagem"] );
}

?>

<script src="../js/jquery.validate.min.js"></script>

<div class="span6">
<div class="row-fluid">
<form id="form1" name="form1" method="post" action="../controller/embalagem-controle.php"  class="form-inline">

<p><a href="index.php?cmd=embalagem-lista" class="btn btn-info">&lt;&lt; Voltar</a>
<input type="submit" name="salvar" id="salvar" value="Salvar" class="btn btn-success" /></p>

<input type="hidden" name="action" value="<?=$action?>" />
<input type="hidden" name="idEmbalagem" value="<?=$objEmbalagem->getEmbalagemID()?>" />

<div class="control-group">
	<label class="control-label span3" for="embalagemId">EmbalagemId</label> 
	<input type="text" name="embalagemId" id="embalagemId"  class="span9" required="true" value="<?=$objEmbalagem->getEmbalagemId()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="descricao">Descricao</label> 
	<input type="text" name="descricao" id="descricao"  class="span9" required="true" value="<?=$objEmbalagem->getDescricao()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="altura">Altura</label> 
	<input type="text" name="altura" id="altura"  class="span9" required="true" value="<?=$objEmbalagem->getAltura()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="largura">Largura</label> 
	<input type="text" name="largura" id="largura"  class="span9" required="true" value="<?=$objEmbalagem->getLargura()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="comprimento">Comprimento</label> 
	<input type="text" name="comprimento" id="comprimento"  class="span9" required="true" value="<?=$objEmbalagem->getComprimento()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="status">Status</label> 
	<input type="text" name="status" id="status"  class="span9" required="true" value="<?=$objEmbalagem->getStatus()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="dtCadastro">DtCadastro</label> 
	<input type="text" name="dtCadastro" id="dtCadastro"  class="span9" required="true" value="<?=$objEmbalagem->getDtCadastro()?>" />
</div>

</form>
</div>
</div>