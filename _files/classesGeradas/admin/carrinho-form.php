<?php

include_once '../../wcm/model/classesGeradas/model/carrinho.class.php';
include_once '../model/clienteid.class.php';

$objClienteId = new ClienteId();
$objCarrinho = new Carrinho();

$action = "inserirCarrinho";

if( isset( $_GET["idCarrinho"] ) )
{
	$action = "editarCarrinho";
	$objCarrinho->obterCarrinho( $_GET["idCarrinho"] );
}

?>

<script src="../js/jquery.validate.min.js"></script>

<div class="span6">
<div class="row-fluid">
<form id="form1" name="form1" method="post" action="../controller/carrinho-controle.php"  class="form-inline">

<p><a href="index.php?cmd=carrinho-lista" class="btn btn-info">&lt;&lt; Voltar</a>
<input type="submit" name="salvar" id="salvar" value="Salvar" class="btn btn-success" /></p>

<input type="hidden" name="action" value="<?=$action?>" />
<input type="hidden" name="idCarrinho" value="<?=$objCarrinho->getCarrinhoID()?>" />

<div class="control-group">
	<label class="control-label span3" for="carrinhoId">CarrinhoId</label> 
	<input type="text" name="carrinhoId" id="carrinhoId"  class="span9" required="true" value="<?=$objCarrinho->getCarrinhoId()?>" />
</div>

<div class="control-group">
	<label for="clienteid" class="control-label span3">ClienteId</label>
	<select name="clienteid" id="clienteid" class="span9" required="true">
	<option value="" disabled="disabled" selected="selected">Selecione a clienteid</option>
	<?php foreach( $objClienteId->listarClienteId() as $clienteid ) { ?>
		<option value="<?=$clienteid->getClienteIdID()?>" <?php if( $clienteid->getClienteIdID() == $objCarrinho->getClienteId()->getClienteIdID() ){ ?>selected="selected"<?php } ?>>
		<?=$clienteid->getDescricao()?></option>
	<?php } ?>
	</select>
</div>

<div class="control-group">
	<label class="control-label span3" for="presente">Presente</label> 
	<input type="text" name="presente" id="presente"  class="span9" required="true" value="<?=$objCarrinho->getPresente()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="mensagemPresente">MensagemPresente</label> 
	<input type="text" name="mensagemPresente" id="mensagemPresente"  class="span9" required="true" value="<?=$objCarrinho->getMensagemPresente()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="chaveSeguranca">ChaveSeguranca</label> 
	<input type="text" name="chaveSeguranca" id="chaveSeguranca"  class="span9" required="true" value="<?=$objCarrinho->getChaveSeguranca()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="dtCadastro">DtCadastro</label> 
	<input type="text" name="dtCadastro" id="dtCadastro"  class="span9" required="true" value="<?=$objCarrinho->getDtCadastro()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="dtAtualizacao">DtAtualizacao</label> 
	<input type="text" name="dtAtualizacao" id="dtAtualizacao"  class="span9" required="true" value="<?=$objCarrinho->getDtAtualizacao()?>" />
</div>

</form>
</div>
</div>