<?php

include_once '../model/venda.class.php';
include_once '../model/alerta.class.php';

$objVenda = new Venda();

$action = "inserirRastreamento";

if( isset( $_GET["idVenda"] ) )
{
	$objVenda->obterVenda( $_GET["idVenda"] );
}

?>

<script src="../js/jquery.validate.min.js"></script>

<div class="span12">
<?php if (isset($_GET['st'])) { $objAlerta = new Alerta($_GET['st']); } ?> 
</div>

<div class="span6">
<div class="row-fluid">
<form id="form1" name="form1" method="post" action="../controller/venda-controle.php"  class="form-inline">

<p><a href="index.php?p=venda-lista" class="btn btn-info">&lt;&lt; Voltar</a>
<input type="submit" name="salvar" id="salvar" value="Salvar" class="btn btn-success" /></p>

<input type="hidden" name="action" value="<?php echo $action;?>" />
<input type="hidden" name="idVenda" value="<?php echo $objVenda->getVendaID();?>" />

<div class="control-group">
	<label class="control-label span3" for="descricao">C&oacute;d. Rastreamento</label> 
	<input type="text" name="descricao" id="descricao"  class="span9" required="true" value="<?php echo $objVenda->getRastreamento();?>" />
</div>

</form>
</div>
</div>