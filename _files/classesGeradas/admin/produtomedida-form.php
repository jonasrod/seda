<?php

include_once '../../wcm/model/classesGeradas/model/produtomedida.class.php';
include_once '../model/produtoid.class.php';

$objProdutoId = new ProdutoId();
$objProdutomedida = new Produtomedida();

$action = "inserirProdutomedida";

if( isset( $_GET["idProdutomedida"] ) )
{
	$action = "editarProdutomedida";
	$objProdutomedida->obterProdutomedida( $_GET["idProdutomedida"] );
}

?>

<script src="../js/jquery.validate.min.js"></script>

<div class="span6">
<div class="row-fluid">
<form id="form1" name="form1" method="post" action="../controller/produtomedida-controle.php"  class="form-inline">

<p><a href="index.php?cmd=produtomedida-lista" class="btn btn-info">&lt;&lt; Voltar</a>
<input type="submit" name="salvar" id="salvar" value="Salvar" class="btn btn-success" /></p>

<input type="hidden" name="action" value="<?=$action?>" />
<input type="hidden" name="idProdutomedida" value="<?=$objProdutomedida->getProdutomedidaID()?>" />

<div class="control-group">
	<label class="control-label span3" for="medidaId">MedidaId</label> 
	<input type="text" name="medidaId" id="medidaId"  class="span9" required="true" value="<?=$objProdutomedida->getMedidaId()?>" />
</div>

<div class="control-group">
	<label for="produtoid" class="control-label span3">ProdutoId</label>
	<select name="produtoid" id="produtoid" class="span9" required="true">
	<option value="" disabled="disabled" selected="selected">Selecione a produtoid</option>
	<?php foreach( $objProdutoId->listarProdutoId() as $produtoid ) { ?>
		<option value="<?=$produtoid->getProdutoIdID()?>" <?php if( $produtoid->getProdutoIdID() == $objProdutomedida->getProdutoId()->getProdutoIdID() ){ ?>selected="selected"<?php } ?>>
		<?=$produtoid->getDescricao()?></option>
	<?php } ?>
	</select>
</div>

<div class="control-group">
	<label class="control-label span3" for="medida">Medida</label> 
	<input type="text" name="medida" id="medida"  class="span9" required="true" value="<?=$objProdutomedida->getMedida()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="quantidade">Quantidade</label> 
	<input type="text" name="quantidade" id="quantidade"  class="span9" required="true" value="<?=$objProdutomedida->getQuantidade()?>" />
</div>

</form>
</div>
</div>