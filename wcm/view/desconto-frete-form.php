<?php

include_once '../model/descontofrete.class.php';
include_once '../model/alerta.class.php';

$objDescontoFrete = new DescontoFrete();

$action = "editarCategoria";

$objDescontoFrete->getDescontoFrete();
?>

<script src="../js/jquery.validate.min.js"></script>
<script src="../js/jquery.maskedinput-1.3.js"></script>
<script src="../js/jquery.maskMoney.min.js"></script>

<script>
	$(document).ready(function() {
		$("#valor").maskMoney({prefix:'R$ ', allowNegative: true, thousands:'', decimal:'.', affixesStay: false});
	});
</script>

<div class="span12">
<?php if (isset($_GET['st'])) { $objAlerta = new Alerta($_GET['st']); } ?> 
</div>

<div class="span6">
<div class="row-fluid">
<form id="form1" name="form1" method="post" action="../controller/desconto-frete-controle.php"  class="form-inline">

<p><a href="index.php?p=home" class="btn btn-info">&lt;&lt; Voltar</a>
<input type="submit" name="salvar" id="salvar" value="Salvar" class="btn btn-success" /></p>

<input type="hidden" name="action" value="<?php echo $action;?>" />
<input type="hidden" name="idDescontoFrete" value="<?php echo $objDescontoFrete->getDescontoFreteId();?>" />

<div class="control-group">
	<label class="control-label span3" for="valor">Valor para Descontar o Frete tipo PAC</label>
	<input type="text" name="valor" id="valor"  class="span9" required="true" value="<?php echo $objDescontoFrete->getValorDesconto();?>" />
</div>

</form>
</div>
</div>