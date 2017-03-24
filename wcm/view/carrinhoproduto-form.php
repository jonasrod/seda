<?php

include_once '../model/carrinhoproduto.class.php';
include_once '../model/produtoid.class.php';

$objProdutoId = new ProdutoId();
$objCarrinhoproduto = new Carrinhoproduto();

$action = "inserirCarrinhoproduto";

if( isset( $_GET["idCarrinhoproduto"] ) )
{
	$action = "editarCarrinhoproduto";
	$objCarrinhoproduto->obterCarrinhoproduto( $_GET["idCarrinhoproduto"] );
}

?>

<script src="../js/jquery.validate.min.js"></script>

<div class="span6">
<div class="row-fluid">
<form id="form1" name="form1" method="post" action="../controller/carrinhoproduto-controle.php"  class="form-inline">

<p><a href="index.php?cmd=carrinhoproduto-lista" class="btn btn-info">&lt;&lt; Voltar</a>
<input type="submit" name="salvar" id="salvar" value="Salvar" class="btn btn-success" /></p>

<input type="hidden" name="action" value="<?=$action?>" />
<input type="hidden" name="idCarrinhoproduto" value="<?=$objCarrinhoproduto->getCarrinhoprodutoID()?>" />

<div class="control-group">
	<label class="control-label span3" for="mCarrinhoId">MCarrinhoId</label> 
	<input type="text" name="mCarrinhoId" id="mCarrinhoId"  class="span9" required="true" value="<?=$objCarrinhoproduto->getMCarrinhoId()?>" />
</div>

<div class="control-group">
	<label for="produtoid" class="control-label span3">ProdutoId</label>
	<select name="produtoid" id="produtoid" class="span9" required="true">
	<option value="" disabled="disabled" selected="selected">Selecione a produtoid</option>
	<?php foreach( $objProdutoId->listarProdutoId() as $produtoid ) { ?>
		<option value="<?=$produtoid->getProdutoIdID()?>" <?php if( $produtoid->getProdutoIdID() == $objCarrinhoproduto->getProdutoId()->getProdutoIdID() ){ ?>selected="selected"<?php } ?>>
		<?=$produtoid->getDescricao()?></option>
	<?php } ?>
	</select>
</div>

<div class="control-group">
	<label class="control-label span3" for="quantidade">Quantidade</label> 
	<input type="text" name="quantidade" id="quantidade"  class="span9" required="true" value="<?=$objCarrinhoproduto->getQuantidade()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="dtCadastro">DtCadastro</label> 
	<input type="text" name="dtCadastro" id="dtCadastro"  class="span9" required="true" value="<?=$objCarrinhoproduto->getDtCadastro()?>" />
</div>

</form>
</div>
</div>