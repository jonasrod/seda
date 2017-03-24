<?php

include_once '../../wcm/model/classesGeradas/model/bannerlateral.class.php';

$objBannerlateral = new Bannerlateral();

$action = "inserirBannerlateral";

if( isset( $_GET["idBannerlateral"] ) )
{
	$action = "editarBannerlateral";
	$objBannerlateral->obterBannerlateral( $_GET["idBannerlateral"] );
}

?>

<script src="../js/jquery.validate.min.js"></script>

<div class="span6">
<div class="row-fluid">
<form id="form1" name="form1" method="post" action="../controller/bannerlateral-controle.php"  class="form-inline">

<p><a href="index.php?cmd=bannerlateral-lista" class="btn btn-info">&lt;&lt; Voltar</a>
<input type="submit" name="salvar" id="salvar" value="Salvar" class="btn btn-success" /></p>

<input type="hidden" name="action" value="<?=$action?>" />
<input type="hidden" name="idBannerlateral" value="<?=$objBannerlateral->getBannerlateralID()?>" />

<div class="control-group">
	<label class="control-label span3" for="id">Id</label> 
	<input type="text" name="id" id="id"  class="span9" required="true" value="<?=$objBannerlateral->getId()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="name">Name</label> 
	<input type="text" name="name" id="name"  class="span9" required="true" value="<?=$objBannerlateral->getName()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="size">Size</label> 
	<input type="text" name="size" id="size"  class="span9" required="true" value="<?=$objBannerlateral->getSize()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="type">Type</label> 
	<input type="text" name="type" id="type"  class="span9" required="true" value="<?=$objBannerlateral->getType()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="url">Url</label> 
	<input type="text" name="url" id="url"  class="span9" required="true" value="<?=$objBannerlateral->getUrl()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="title">Title</label> 
	<input type="text" name="title" id="title"  class="span9" required="true" value="<?=$objBannerlateral->getTitle()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="description">Description</label> 
	<input type="text" name="description" id="description"  class="span9" required="true" value="<?=$objBannerlateral->getDescription()?>" />
</div>

</form>
</div>
</div>