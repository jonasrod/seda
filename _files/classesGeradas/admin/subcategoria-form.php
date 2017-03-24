<?php

include_once '../../wcm/model/classesGeradas/model/subcategoria.class.php';
include_once '../model/categoriaid.class.php';

$objCategoriaId = new CategoriaId();
$objSubcategoria = new Subcategoria();

$action = "inserirSubcategoria";

if( isset( $_GET["idSubcategoria"] ) )
{
	$action = "editarSubcategoria";
	$objSubcategoria->obterSubcategoria( $_GET["idSubcategoria"] );
}

?>

<script src="../js/jquery.validate.min.js"></script>

<div class="span6">
<div class="row-fluid">
<form id="form1" name="form1" method="post" action="../controller/subcategoria-controle.php"  class="form-inline">

<p><a href="index.php?cmd=subcategoria-lista" class="btn btn-info">&lt;&lt; Voltar</a>
<input type="submit" name="salvar" id="salvar" value="Salvar" class="btn btn-success" /></p>

<input type="hidden" name="action" value="<?=$action?>" />
<input type="hidden" name="idSubcategoria" value="<?=$objSubcategoria->getSubcategoriaID()?>" />

<div class="control-group">
	<label class="control-label span3" for="subcategoriaId">SubcategoriaId</label> 
	<input type="text" name="subcategoriaId" id="subcategoriaId"  class="span9" required="true" value="<?=$objSubcategoria->getSubcategoriaId()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="descricao">Descricao</label> 
	<input type="text" name="descricao" id="descricao"  class="span9" required="true" value="<?=$objSubcategoria->getDescricao()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="dtCadastro">DtCadastro</label> 
	<input type="text" name="dtCadastro" id="dtCadastro"  class="span9" required="true" value="<?=$objSubcategoria->getDtCadastro()?>" />
</div>

<div class="control-group">
	<label for="categoriaid" class="control-label span3">CategoriaId</label>
	<select name="categoriaid" id="categoriaid" class="span9" required="true">
	<option value="" disabled="disabled" selected="selected">Selecione a categoriaid</option>
	<?php foreach( $objCategoriaId->listarCategoriaId() as $categoriaid ) { ?>
		<option value="<?=$categoriaid->getCategoriaIdID()?>" <?php if( $categoriaid->getCategoriaIdID() == $objSubcategoria->getCategoriaId()->getCategoriaIdID() ){ ?>selected="selected"<?php } ?>>
		<?=$categoriaid->getDescricao()?></option>
	<?php } ?>
	</select>
</div>

<div class="control-group">
	<label class="control-label span3" for="status">Status</label> 
	<input type="text" name="status" id="status"  class="span9" required="true" value="<?=$objSubcategoria->getStatus()?>" />
</div>

</form>
</div>
</div>