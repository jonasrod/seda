<?php

include_once '../../wcm/model/classesGeradas/model/tipopagamento.class.php';

$objTipopagamento = new Tipopagamento();

$action = "inserirTipopagamento";

if( isset( $_GET["idTipopagamento"] ) )
{
	$action = "editarTipopagamento";
	$objTipopagamento->obterTipopagamento( $_GET["idTipopagamento"] );
}

?>

<script src="../js/jquery.validate.min.js"></script>

<div class="span6">
<div class="row-fluid">
<form id="form1" name="form1" method="post" action="../controller/tipopagamento-controle.php"  class="form-inline">

<p><a href="index.php?cmd=tipopagamento-lista" class="btn btn-info">&lt;&lt; Voltar</a>
<input type="submit" name="salvar" id="salvar" value="Salvar" class="btn btn-success" /></p>

<input type="hidden" name="action" value="<?=$action?>" />
<input type="hidden" name="idTipopagamento" value="<?=$objTipopagamento->getTipopagamentoID()?>" />

<div class="control-group">
	<label class="control-label span3" for="tipoPagamentoId">TipoPagamentoId</label> 
	<input type="text" name="tipoPagamentoId" id="tipoPagamentoId"  class="span9" required="true" value="<?=$objTipopagamento->getTipoPagamentoId()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="descricao">Descricao</label> 
	<input type="text" name="descricao" id="descricao"  class="span9" required="true" value="<?=$objTipopagamento->getDescricao()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="status">Status</label> 
	<input type="text" name="status" id="status"  class="span9" required="true" value="<?=$objTipopagamento->getStatus()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="dtCadastro">DtCadastro</label> 
	<input type="text" name="dtCadastro" id="dtCadastro"  class="span9" required="true" value="<?=$objTipopagamento->getDtCadastro()?>" />
</div>

</form>
</div>
</div>