<?php

include_once '../../wcm/model/classesGeradas/model/produtosequence.class.php';

$objProdutosequence = new Produtosequence();

$action = "inserirProdutosequence";

if( isset( $_GET["idProdutosequence"] ) )
{
	$action = "editarProdutosequence";
	$objProdutosequence->obterProdutosequence( $_GET["idProdutosequence"] );
}

?>

<script src="../js/jquery.validate.min.js"></script>

<div class="span6">
<div class="row-fluid">
<form id="form1" name="form1" method="post" action="../controller/produtosequence-controle.php"  class="form-inline">

<p><a href="index.php?cmd=produtosequence-lista" class="btn btn-info">&lt;&lt; Voltar</a>
<input type="submit" name="salvar" id="salvar" value="Salvar" class="btn btn-success" /></p>

<input type="hidden" name="action" value="<?=$action?>" />
<input type="hidden" name="idProdutosequence" value="<?=$objProdutosequence->getProdutosequenceID()?>" />

<div class="control-group">
	<label class="control-label span3" for="sequence">Sequence</label> 
	<input type="text" name="sequence" id="sequence"  class="span9" required="true" value="<?=$objProdutosequence->getSequence()?>" />
</div>

</form>
</div>
</div>