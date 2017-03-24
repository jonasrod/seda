<?php

include_once '../../wcm/model/classesGeradas/model/venda.class.php';
include_once '../model/carrinhoid.class.php';
include_once '../model/tipopagamentoid.class.php';
include_once '../model/embalagemid.class.php';

$objCarrinhoId = new CarrinhoId();
$objTipoPagamentoId = new TipoPagamentoId();
$objEmbalagemId = new EmbalagemId();
$objVenda = new Venda();

$action = "inserirVenda";

if( isset( $_GET["idVenda"] ) )
{
	$action = "editarVenda";
	$objVenda->obterVenda( $_GET["idVenda"] );
}

?>

<script src="../js/jquery.validate.min.js"></script>

<div class="span6">
<div class="row-fluid">
<form id="form1" name="form1" method="post" action="../controller/venda-controle.php"  class="form-inline">

<p><a href="index.php?cmd=venda-lista" class="btn btn-info">&lt;&lt; Voltar</a>
<input type="submit" name="salvar" id="salvar" value="Salvar" class="btn btn-success" /></p>

<input type="hidden" name="action" value="<?=$action?>" />
<input type="hidden" name="idVenda" value="<?=$objVenda->getVendaID()?>" />

<div class="control-group">
	<label class="control-label span3" for="vendaId">VendaId</label> 
	<input type="text" name="vendaId" id="vendaId"  class="span9" required="true" value="<?=$objVenda->getVendaId()?>" />
</div>

<div class="control-group">
	<label for="carrinhoid" class="control-label span3">CarrinhoId</label>
	<select name="carrinhoid" id="carrinhoid" class="span9" required="true">
	<option value="" disabled="disabled" selected="selected">Selecione a carrinhoid</option>
	<?php foreach( $objCarrinhoId->listarCarrinhoId() as $carrinhoid ) { ?>
		<option value="<?=$carrinhoid->getCarrinhoIdID()?>" <?php if( $carrinhoid->getCarrinhoIdID() == $objVenda->getCarrinhoId()->getCarrinhoIdID() ){ ?>selected="selected"<?php } ?>>
		<?=$carrinhoid->getDescricao()?></option>
	<?php } ?>
	</select>
</div>

<div class="control-group">
	<label class="control-label span3" for="mClienteId">MClienteId</label> 
	<input type="text" name="mClienteId" id="mClienteId"  class="span9" required="true" value="<?=$objVenda->getMClienteId()?>" />
</div>

<div class="control-group">
	<label for="tipopagamentoid" class="control-label span3">TipoPagamentoId</label>
	<select name="tipopagamentoid" id="tipopagamentoid" class="span9" required="true">
	<option value="" disabled="disabled" selected="selected">Selecione a tipopagamentoid</option>
	<?php foreach( $objTipoPagamentoId->listarTipoPagamentoId() as $tipopagamentoid ) { ?>
		<option value="<?=$tipopagamentoid->getTipoPagamentoIdID()?>" <?php if( $tipopagamentoid->getTipoPagamentoIdID() == $objVenda->getTipoPagamentoId()->getTipoPagamentoIdID() ){ ?>selected="selected"<?php } ?>>
		<?=$tipopagamentoid->getDescricao()?></option>
	<?php } ?>
	</select>
</div>

<div class="control-group">
	<label for="embalagemid" class="control-label span3">EmbalagemId</label>
	<select name="embalagemid" id="embalagemid" class="span9" required="true">
	<option value="" disabled="disabled" selected="selected">Selecione a embalagemid</option>
	<?php foreach( $objEmbalagemId->listarEmbalagemId() as $embalagemid ) { ?>
		<option value="<?=$embalagemid->getEmbalagemIdID()?>" <?php if( $embalagemid->getEmbalagemIdID() == $objVenda->getEmbalagemId()->getEmbalagemIdID() ){ ?>selected="selected"<?php } ?>>
		<?=$embalagemid->getDescricao()?></option>
	<?php } ?>
	</select>
</div>

<div class="control-group">
	<label class="control-label span3" for="referencia">Referencia</label> 
	<input type="text" name="referencia" id="referencia"  class="span9" required="true" value="<?=$objVenda->getReferencia()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="status">Status</label> 
	<input type="text" name="status" id="status"  class="span9" required="true" value="<?=$objVenda->getStatus()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="valorTotalProduto">ValorTotalProduto</label> 
	<input type="text" name="valorTotalProduto" id="valorTotalProduto"  class="span9" required="true" value="<?=$objVenda->getValorTotalProduto()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="valorFrete">ValorFrete</label> 
	<input type="text" name="valorFrete" id="valorFrete"  class="span9" required="true" value="<?=$objVenda->getValorFrete()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="valorDesconto">ValorDesconto</label> 
	<input type="text" name="valorDesconto" id="valorDesconto"  class="span9" required="true" value="<?=$objVenda->getValorDesconto()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="dtCadastro">DtCadastro</label> 
	<input type="text" name="dtCadastro" id="dtCadastro"  class="span9" required="true" value="<?=$objVenda->getDtCadastro()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="pagseguroId">PagseguroId</label> 
	<input type="text" name="pagseguroId" id="pagseguroId"  class="span9" required="true" value="<?=$objVenda->getPagseguroId()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="cieloId">CieloId</label> 
	<input type="text" name="cieloId" id="cieloId"  class="span9" required="true" value="<?=$objVenda->getCieloId()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="rastreamento">Rastreamento</label> 
	<input type="text" name="rastreamento" id="rastreamento"  class="span9" required="true" value="<?=$objVenda->getRastreamento()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="notaFiscal">NotaFiscal</label> 
	<input type="text" name="notaFiscal" id="notaFiscal"  class="span9" required="true" value="<?=$objVenda->getNotaFiscal()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="tipoEntrega">TipoEntrega</label> 
	<input type="text" name="tipoEntrega" id="tipoEntrega"  class="span9" required="true" value="<?=$objVenda->getTipoEntrega()?>" />
</div>

</form>
</div>
</div>