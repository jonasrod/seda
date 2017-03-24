<?php

include_once '../../wcm/model/classesGeradas/model/files.class.php';

$objFiles = new Files();

$action = "inserirFiles";

if( isset( $_GET["idFiles"] ) )
{
	$action = "editarFiles";
	$objFiles->obterFiles( $_GET["idFiles"] );
}

?>

<script src="../js/jquery.validate.min.js"></script>

<div class="span6">
<div class="row-fluid">
<form id="form1" name="form1" method="post" action="../controller/files-controle.php"  class="form-inline">

<p><a href="index.php?cmd=files-lista" class="btn btn-info">&lt;&lt; Voltar</a>
<input type="submit" name="salvar" id="salvar" value="Salvar" class="btn btn-success" /></p>

<input type="hidden" name="action" value="<?=$action?>" />
<input type="hidden" name="idFiles" value="<?=$objFiles->getFilesID()?>" />

<div class="control-group">
	<label class="control-label span3" for="id">Id</label> 
	<input type="text" name="id" id="id"  class="span9" required="true" value="<?=$objFiles->getId()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="name">Name</label> 
	<input type="text" name="name" id="name"  class="span9" required="true" value="<?=$objFiles->getName()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="size">Size</label> 
	<input type="text" name="size" id="size"  class="span9" required="true" value="<?=$objFiles->getSize()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="type">Type</label> 
	<input type="text" name="type" id="type"  class="span9" required="true" value="<?=$objFiles->getType()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="url">Url</label> 
	<input type="text" name="url" id="url"  class="span9" required="true" value="<?=$objFiles->getUrl()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="title">Title</label> 
	<input type="text" name="title" id="title"  class="span9" required="true" value="<?=$objFiles->getTitle()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="description">Description</label> 
	<input type="text" name="description" id="description"  class="span9" required="true" value="<?=$objFiles->getDescription()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="mProdutoId">MProdutoId</label> 
	<input type="text" name="mProdutoId" id="mProdutoId"  class="span9" required="true" value="<?=$objFiles->getMProdutoId()?>" />
</div>

</form>
</div>
</div>