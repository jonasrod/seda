<?php

include_once '../../wcm/model/classesGeradas/model/servicoect.class.php';

$objServicoect = new Servicoect();

$action = "inserirServicoect";

if( isset( $_GET["idServicoect"] ) )
{
	$action = "editarServicoect";
	$objServicoect->obterServicoect( $_GET["idServicoect"] );
}

?>

<script src="../js/jquery.validate.min.js"></script>

<div class="span6">
<div class="row-fluid">
<form id="form1" name="form1" method="post" action="../controller/servicoect-controle.php"  class="form-inline">

<p><a href="index.php?cmd=servicoect-lista" class="btn btn-info">&lt;&lt; Voltar</a>
<input type="submit" name="salvar" id="salvar" value="Salvar" class="btn btn-success" /></p>

<input type="hidden" name="action" value="<?=$action?>" />
<input type="hidden" name="idServicoect" value="<?=$objServicoect->getServicoectID()?>" />

<div class="control-group">
	<label class="control-label span3" for="servidoECTID">ServidoECTID</label> 
	<input type="text" name="servidoECTID" id="servidoECTID"  class="span9" required="true" value="<?=$objServicoect->getServidoECTID()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="idServico">IdServico</label> 
	<input type="text" name="idServico" id="idServico"  class="span9" required="true" value="<?=$objServicoect->getIdServico()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="codigoServicoECT">CodigoServicoECT</label> 
	<input type="text" name="codigoServicoECT" id="codigoServicoECT"  class="span9" required="true" value="<?=$objServicoect->getCodigoServicoECT()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="descricaoServicoECT">DescricaoServicoECT</label> 
	<input type="text" name="descricaoServicoECT" id="descricaoServicoECT"  class="span9" required="true" value="<?=$objServicoect->getDescricaoServicoECT()?>" />
</div>

</form>
</div>
</div>