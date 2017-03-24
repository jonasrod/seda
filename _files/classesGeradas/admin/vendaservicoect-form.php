<?php

include_once '../../wcm/model/classesGeradas/model/vendaservicoect.class.php';
include_once '../model/vendaid.class.php';
include_once '../model/servicoetcid.class.php';

$objVendaId = new VendaId();
$objServicoETCID = new ServicoETCID();
$objVendaservicoect = new Vendaservicoect();

$action = "inserirVendaservicoect";

if( isset( $_GET["idVendaservicoect"] ) )
{
	$action = "editarVendaservicoect";
	$objVendaservicoect->obterVendaservicoect( $_GET["idVendaservicoect"] );
}

?>

<script src="../js/jquery.validate.min.js"></script>

<div class="span6">
<div class="row-fluid">
<form id="form1" name="form1" method="post" action="../controller/vendaservicoect-controle.php"  class="form-inline">

<p><a href="index.php?cmd=vendaservicoect-lista" class="btn btn-info">&lt;&lt; Voltar</a>
<input type="submit" name="salvar" id="salvar" value="Salvar" class="btn btn-success" /></p>

<input type="hidden" name="action" value="<?=$action?>" />
<input type="hidden" name="idVendaservicoect" value="<?=$objVendaservicoect->getVendaservicoectID()?>" />

<div class="control-group">
	<label class="control-label span3" for="vendaServicoECTID">VendaServicoECTID</label> 
	<input type="text" name="vendaServicoECTID" id="vendaServicoECTID"  class="span9" required="true" value="<?=$objVendaservicoect->getVendaServicoECTID()?>" />
</div>

<div class="control-group">
	<label for="vendaid" class="control-label span3">VendaId</label>
	<select name="vendaid" id="vendaid" class="span9" required="true">
	<option value="" disabled="disabled" selected="selected">Selecione a vendaid</option>
	<?php foreach( $objVendaId->listarVendaId() as $vendaid ) { ?>
		<option value="<?=$vendaid->getVendaIdID()?>" <?php if( $vendaid->getVendaIdID() == $objVendaservicoect->getVendaId()->getVendaIdID() ){ ?>selected="selected"<?php } ?>>
		<?=$vendaid->getDescricao()?></option>
	<?php } ?>
	</select>
</div>

<div class="control-group">
	<label for="servicoetcid" class="control-label span3">ServicoETCID</label>
	<select name="servicoetcid" id="servicoetcid" class="span9" required="true">
	<option value="" disabled="disabled" selected="selected">Selecione a servicoetcid</option>
	<?php foreach( $objServicoETCID->listarServicoETCID() as $servicoetcid ) { ?>
		<option value="<?=$servicoetcid->getServicoETCIDID()?>" <?php if( $servicoetcid->getServicoETCIDID() == $objVendaservicoect->getServicoETCID()->getServicoETCIDID() ){ ?>selected="selected"<?php } ?>>
		<?=$servicoetcid->getDescricao()?></option>
	<?php } ?>
	</select>
</div>

<div class="control-group">
	<label class="control-label span3" for="codigoObjetoECT">CodigoObjetoECT</label> 
	<input type="text" name="codigoObjetoECT" id="codigoObjetoECT"  class="span9" required="true" value="<?=$objVendaservicoect->getCodigoObjetoECT()?>" />
</div>

</form>
</div>
</div>