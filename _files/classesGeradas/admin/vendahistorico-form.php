<?php

include_once '../../wcm/model/classesGeradas/model/vendahistorico.class.php';
include_once '../model/vendaid.class.php';

$objVendaId = new VendaId();
$objVendahistorico = new Vendahistorico();

$action = "inserirVendahistorico";

if( isset( $_GET["idVendahistorico"] ) )
{
	$action = "editarVendahistorico";
	$objVendahistorico->obterVendahistorico( $_GET["idVendahistorico"] );
}

?>

<script src="../js/jquery.validate.min.js"></script>

<div class="span6">
<div class="row-fluid">
<form id="form1" name="form1" method="post" action="../controller/vendahistorico-controle.php"  class="form-inline">

<p><a href="index.php?cmd=vendahistorico-lista" class="btn btn-info">&lt;&lt; Voltar</a>
<input type="submit" name="salvar" id="salvar" value="Salvar" class="btn btn-success" /></p>

<input type="hidden" name="action" value="<?=$action?>" />
<input type="hidden" name="idVendahistorico" value="<?=$objVendahistorico->getVendahistoricoID()?>" />

<div class="control-group">
	<label class="control-label span3" for="vendaHistoricoId">VendaHistoricoId</label> 
	<input type="text" name="vendaHistoricoId" id="vendaHistoricoId"  class="span9" required="true" value="<?=$objVendahistorico->getVendaHistoricoId()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="dtCadastro">DtCadastro</label> 
	<input type="text" name="dtCadastro" id="dtCadastro"  class="span9" required="true" value="<?=$objVendahistorico->getDtCadastro()?>" />
</div>

<div class="control-group">
	<label for="vendaid" class="control-label span3">VendaId</label>
	<select name="vendaid" id="vendaid" class="span9" required="true">
	<option value="" disabled="disabled" selected="selected">Selecione a vendaid</option>
	<?php foreach( $objVendaId->listarVendaId() as $vendaid ) { ?>
		<option value="<?=$vendaid->getVendaIdID()?>" <?php if( $vendaid->getVendaIdID() == $objVendahistorico->getVendaId()->getVendaIdID() ){ ?>selected="selected"<?php } ?>>
		<?=$vendaid->getDescricao()?></option>
	<?php } ?>
	</select>
</div>

</form>
</div>
</div>