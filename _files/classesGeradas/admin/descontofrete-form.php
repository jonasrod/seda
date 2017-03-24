<?php

include_once '../../wcm/model/classesGeradas/model/descontofrete.class.php';

$objDescontofrete = new Descontofrete();

$action = "inserirDescontofrete";

if( isset( $_GET["idDescontofrete"] ) )
{
	$action = "editarDescontofrete";
	$objDescontofrete->obterDescontofrete( $_GET["idDescontofrete"] );
}

?>

<script src="../js/jquery.validate.min.js"></script>

<div class="span6">
<div class="row-fluid">
<form id="form1" name="form1" method="post" action="../controller/descontofrete-controle.php"  class="form-inline">

<p><a href="index.php?cmd=descontofrete-lista" class="btn btn-info">&lt;&lt; Voltar</a>
<input type="submit" name="salvar" id="salvar" value="Salvar" class="btn btn-success" /></p>

<input type="hidden" name="action" value="<?=$action?>" />
<input type="hidden" name="idDescontofrete" value="<?=$objDescontofrete->getDescontofreteID()?>" />

<div class="control-group">
	<label class="control-label span3" for="descontofreteId">DescontofreteId</label> 
	<input type="text" name="descontofreteId" id="descontofreteId"  class="span9" required="true" value="<?=$objDescontofrete->getDescontofreteId()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="valor_desconto">Valor_desconto</label> 
	<input type="text" name="valor_desconto" id="valor_desconto"  class="span9" required="true" value="<?=$objDescontofrete->getValor_desconto()?>" />
</div>

</form>
</div>
</div>