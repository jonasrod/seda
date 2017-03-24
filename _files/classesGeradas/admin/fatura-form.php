<?php

include_once '../../wcm/model/classesGeradas/model/fatura.class.php';

$objFatura = new Fatura();

$action = "inserirFatura";

if( isset( $_GET["idFatura"] ) )
{
	$action = "editarFatura";
	$objFatura->obterFatura( $_GET["idFatura"] );
}

?>

<script src="../js/jquery.validate.min.js"></script>

<div class="span6">
<div class="row-fluid">
<form id="form1" name="form1" method="post" action="../controller/fatura-controle.php"  class="form-inline">

<p><a href="index.php?cmd=fatura-lista" class="btn btn-info">&lt;&lt; Voltar</a>
<input type="submit" name="salvar" id="salvar" value="Salvar" class="btn btn-success" /></p>

<input type="hidden" name="action" value="<?=$action?>" />
<input type="hidden" name="idFatura" value="<?=$objFatura->getFaturaID()?>" />

<div class="control-group">
	<label class="control-label span3" for="faturaID">FaturaID</label> 
	<input type="text" name="faturaID" id="faturaID"  class="span9" required="true" value="<?=$objFatura->getFaturaID()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="mVendaID">MVendaID</label> 
	<input type="text" name="mVendaID" id="mVendaID"  class="span9" required="true" value="<?=$objFatura->getMVendaID()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="nossoNumero">NossoNumero</label> 
	<input type="text" name="nossoNumero" id="nossoNumero"  class="span9" required="true" value="<?=$objFatura->getNossoNumero()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="numeroDocumento">NumeroDocumento</label> 
	<input type="text" name="numeroDocumento" id="numeroDocumento"  class="span9" required="true" value="<?=$objFatura->getNumeroDocumento()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="dataVencimento">DataVencimento</label> 
	<input type="text" name="dataVencimento" id="dataVencimento"  class="span9" required="true" value="<?=$objFatura->getDataVencimento()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="dataDocumento">DataDocumento</label> 
	<input type="text" name="dataDocumento" id="dataDocumento"  class="span9" required="true" value="<?=$objFatura->getDataDocumento()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="dataProcessamento">DataProcessamento</label> 
	<input type="text" name="dataProcessamento" id="dataProcessamento"  class="span9" required="true" value="<?=$objFatura->getDataProcessamento()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="valorBoleto">ValorBoleto</label> 
	<input type="text" name="valorBoleto" id="valorBoleto"  class="span9" required="true" value="<?=$objFatura->getValorBoleto()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="status">Status</label> 
	<input type="text" name="status" id="status"  class="span9" required="true" value="<?=$objFatura->getStatus()?>" />
</div>

</form>
</div>
</div>