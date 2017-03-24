<?php

include_once '../model/subcategoria.class.php';
include_once '../model/categoria.class.php';
include_once '../model/alerta.class.php';

$objCategoria = new Categoria();
$objSubcategoria = new Subcategoria();

$action = "inserirSubcategoria";

if( isset( $_GET["idSubcategoria"] ) )
{
	$action = "editarSubcategoria";
	$objSubcategoria->obterSubcategoria( $_GET["idSubcategoria"] );
}

?>

<script src="../js/jquery.validate.min.js"></script>

<div class="span12">
<?php if (isset($_GET['st'])) { $objAlerta = new Alerta($_GET['st']); } ?> 
</div>

<div class="span6">
<div class="row-fluid">
<form id="form1" name="form1" method="post" action="../controller/subcategoria-controle.php"  class="form-inline">

<p><a href="index.php?p=subcategoria-lista" class="btn btn-info">&lt;&lt; Voltar</a>
<input type="submit" name="salvar" id="salvar" value="Salvar" class="btn btn-success" /></p>

<input type="hidden" name="action" value="<?php echo $action;?>" />
<input type="hidden" name="idSubcategoria" value="<?php echo $objSubcategoria->getSubcategoriaID();?>" />

<div class="control-group">
	<label class="control-label span3" for="descricao">Descricao</label> 
	<input type="text" name="descricao" id="descricao"  class="span9" required="true" value="<?php echo $objSubcategoria->getDescricao()?>" />
</div>

<div class="control-group">
	<label for="categoriaid" class="control-label span3">Categoria</label>
	<select name="categoriaid" id="categoriaid" class="span9" required="true">
	<option value="" disabled="disabled" selected="selected">Selecione a Categoria</option>
	<?php foreach( $objCategoria->listarCategoria() as $categoriaid ) { ?>
		<option value="<?php echo $categoriaid->getCategoriaID()?>" <?php if( $categoriaid->getCategoriaID() == $objSubcategoria->getCategoriaid()->getCategoriaID() ){ ?>selected="selected"<?php } ?>>
		<?php echo $categoriaid->getDescricao()?></option>
	<?php } ?>
	</select>
</div>

</form>
</div>
</div>