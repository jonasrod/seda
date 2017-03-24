<?php

include_once '../../wcm/model/classesGeradas/model/referenciasequence.class.php';

$objReferenciasequence = new Referenciasequence();

$action = "inserirReferenciasequence";

if( isset( $_GET["idReferenciasequence"] ) )
{
	$action = "editarReferenciasequence";
	$objReferenciasequence->obterReferenciasequence( $_GET["idReferenciasequence"] );
}

?>

<script src="../js/jquery.validate.min.js"></script>

<div class="span6">
<div class="row-fluid">
<form id="form1" name="form1" method="post" action="../controller/referenciasequence-controle.php"  class="form-inline">

<p><a href="index.php?cmd=referenciasequence-lista" class="btn btn-info">&lt;&lt; Voltar</a>
<input type="submit" name="salvar" id="salvar" value="Salvar" class="btn btn-success" /></p>

<input type="hidden" name="action" value="<?=$action?>" />
<input type="hidden" name="idReferenciasequence" value="<?=$objReferenciasequence->getReferenciasequenceID()?>" />

<div class="control-group">
	<label class="control-label span3" for="sequence">Sequence</label> 
	<input type="text" name="sequence" id="sequence"  class="span9" required="true" value="<?=$objReferenciasequence->getSequence()?>" />
</div>

</form>
</div>
</div>