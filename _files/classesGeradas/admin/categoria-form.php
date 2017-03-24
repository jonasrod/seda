<?php

include_once '../../wcm/model/classesGeradas/model/categoria.class.php';

$objCategoria = new Categoria();

$action = "inserirCategoria";

if( isset( $_GET["idCategoria"] ) )
{
	$action = "editarCategoria";
	$objCategoria->obterCategoria( $_GET["idCategoria"] );
}

?>

<script src="../js/jquery.validate.min.js"></script>

<div class="span6">
<div class="row-fluid">
<form id="form1" name="form1" method="post" action="../controller/categoria-controle.php"  class="form-inline">

<p><a href="index.php?cmd=categoria-lista" class="btn btn-info">&lt;&lt; Voltar</a>
<input type="submit" name="salvar" id="salvar" value="Salvar" class="btn btn-success" /></p>

<input type="hidden" name="action" value="<?=$action?>" />
<input type="hidden" name="idCategoria" value="<?=$objCategoria->getCategoriaID()?>" />

<div class="control-group">
	<label class="control-label span3" for="categoriaId">CategoriaId</label> 
	<input type="text" name="categoriaId" id="categoriaId"  class="span9" required="true" value="<?=$objCategoria->getCategoriaId()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="descricao">Descricao</label> 
	<input type="text" name="descricao" id="descricao"  class="span9" required="true" value="<?=$objCategoria->getDescricao()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="dtCadastro">DtCadastro</label> 
	<input type="text" name="dtCadastro" id="dtCadastro"  class="span9" required="true" value="<?=$objCategoria->getDtCadastro()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="status">Status</label> 
	<input type="text" name="status" id="status"  class="span9" required="true" value="<?=$objCategoria->getStatus()?>" />
</div>

</form>
</div>
</div>