<?php

include_once '../../wcm/model/classesGeradas/model/produtocategoria.class.php';
include_once '../model/categoriaid.class.php';
include_once '../model/subcategoriaid.class.php';
include_once '../model/produtoid.class.php';

$objCategoriaId = new CategoriaId();
$objSubcategoriaId = new SubcategoriaId();
$objProdutoId = new ProdutoId();
$objProdutocategoria = new Produtocategoria();

$action = "inserirProdutocategoria";

if( isset( $_GET["idProdutocategoria"] ) )
{
	$action = "editarProdutocategoria";
	$objProdutocategoria->obterProdutocategoria( $_GET["idProdutocategoria"] );
}

?>

<script src="../js/jquery.validate.min.js"></script>

<div class="span6">
<div class="row-fluid">
<form id="form1" name="form1" method="post" action="../controller/produtocategoria-controle.php"  class="form-inline">

<p><a href="index.php?cmd=produtocategoria-lista" class="btn btn-info">&lt;&lt; Voltar</a>
<input type="submit" name="salvar" id="salvar" value="Salvar" class="btn btn-success" /></p>

<input type="hidden" name="action" value="<?=$action?>" />
<input type="hidden" name="idProdutocategoria" value="<?=$objProdutocategoria->getProdutocategoriaID()?>" />

<div class="control-group">
	<label class="control-label span3" for="produtocategoriaID">ProdutocategoriaID</label> 
	<input type="text" name="produtocategoriaID" id="produtocategoriaID"  class="span9" required="true" value="<?=$objProdutocategoria->getProdutocategoriaID()?>" />
</div>

<div class="control-group">
	<label for="categoriaid" class="control-label span3">CategoriaId</label>
	<select name="categoriaid" id="categoriaid" class="span9" required="true">
	<option value="" disabled="disabled" selected="selected">Selecione a categoriaid</option>
	<?php foreach( $objCategoriaId->listarCategoriaId() as $categoriaid ) { ?>
		<option value="<?=$categoriaid->getCategoriaIdID()?>" <?php if( $categoriaid->getCategoriaIdID() == $objProdutocategoria->getCategoriaId()->getCategoriaIdID() ){ ?>selected="selected"<?php } ?>>
		<?=$categoriaid->getDescricao()?></option>
	<?php } ?>
	</select>
</div>

<div class="control-group">
	<label for="subcategoriaid" class="control-label span3">SubcategoriaId</label>
	<select name="subcategoriaid" id="subcategoriaid" class="span9" required="true">
	<option value="" disabled="disabled" selected="selected">Selecione a subcategoriaid</option>
	<?php foreach( $objSubcategoriaId->listarSubcategoriaId() as $subcategoriaid ) { ?>
		<option value="<?=$subcategoriaid->getSubcategoriaIdID()?>" <?php if( $subcategoriaid->getSubcategoriaIdID() == $objProdutocategoria->getSubcategoriaId()->getSubcategoriaIdID() ){ ?>selected="selected"<?php } ?>>
		<?=$subcategoriaid->getDescricao()?></option>
	<?php } ?>
	</select>
</div>

<div class="control-group">
	<label for="produtoid" class="control-label span3">ProdutoId</label>
	<select name="produtoid" id="produtoid" class="span9" required="true">
	<option value="" disabled="disabled" selected="selected">Selecione a produtoid</option>
	<?php foreach( $objProdutoId->listarProdutoId() as $produtoid ) { ?>
		<option value="<?=$produtoid->getProdutoIdID()?>" <?php if( $produtoid->getProdutoIdID() == $objProdutocategoria->getProdutoId()->getProdutoIdID() ){ ?>selected="selected"<?php } ?>>
		<?=$produtoid->getDescricao()?></option>
	<?php } ?>
	</select>
</div>

</form>
</div>
</div>