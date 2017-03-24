<?php

include_once '../model/categoria.class.php';
include_once '../model/alerta.class.php';

$objCategoria = new Categoria();

$action = "inserirCategoria";

if( isset( $_GET["idCategoria"] ) )
{
	$action = "editarCategoria";
	$objCategoria->obterCategoria( $_GET["idCategoria"] );
}

?>

<script src="../js/jquery.validate.min.js"></script>

<div class="span12">
<?php if (isset($_GET['st'])) { $objAlerta = new Alerta($_GET['st']); } ?> 
</div>

<div class="span6">
<div class="row-fluid">
<form id="form1" name="form1" method="post" action="../controller/categoria-controle.php"  class="form-inline">

<p><a href="index.php?p=categoria-lista" class="btn btn-info">&lt;&lt; Voltar</a>
<input type="submit" name="salvar" id="salvar" value="Salvar" class="btn btn-success" /></p>

<input type="hidden" name="action" value="<?php echo $action;?>" />
<input type="hidden" name="idCategoria" value="<?php echo $objCategoria->getCategoriaID();?>" />

<div class="control-group">
	<label class="control-label span3" for="descricao">Descricao</label> 
	<input type="text" name="descricao" id="descricao"  class="span9" required="true" value="<?php echo $objCategoria->getDescricao();?>" />
</div>

</form>
</div>
</div>