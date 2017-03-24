<?php

include_once '../../wcm/model/classesGeradas/model/carrinhoproduto.class.php';
include_once '../model/carrinhoid.class.php';
include_once '../model/produtoid.class.php';

$objCarrinhoId = new CarrinhoId();
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
	<label class="control-label span3" for="carrinhoprodutoID">CarrinhoprodutoID</label> 
	<input type="text" name="carrinhoprodutoID" id="carrinhoprodutoID"  class="span9" required="true" value="<?=$objCarrinhoproduto->getCarrinhoprodutoID()?>" />
</div>

<div class="control-group">
	<label for="carrinhoid" class="control-label span3">CarrinhoId</label>
	<select name="carrinhoid" id="carrinhoid" class="span9" required="true">
	<option value="" disabled="disabled" selected="selected">Selecione a carrinhoid</option>
	<?php foreach( $objCarrinhoId->listarCarrinhoId() as $carrinhoid ) { ?>
		<option value="<?=$carrinhoid->getCarrinhoIdID()?>" <?php if( $carrinhoid->getCarrinhoIdID() == $objCarrinhoproduto->getCarrinhoId()->getCarrinhoIdID() ){ ?>selected="selected"<?php } ?>>
		<?=$carrinhoid->getDescricao()?></option>
	<?php } ?>
	</select>
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
	<label class="control-label span3" for="valor">Valor</label> 
	<input type="text" name="valor" id="valor"  class="span9" required="true" value="<?=$objCarrinhoproduto->getValor()?>" />
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