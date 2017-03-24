<?php
include_once '../model/alerta.class.php';

$action = "inserirPlanilha";
?>

<script src="../js/jquery.validate.min.js"></script>

<div class="span12">
<?php if (isset($_GET['st'])) { $objAlerta = new Alerta($_GET['st']); } ?> 
</div>

<div class="span6">
<div class="row-fluid">
<form id="form1" name="form1" method="post" action="../controller/planilha-controle.php"  class="form-inline" enctype="multipart/form-data">

<p><a href="index.php?p=produto-lista" class="btn btn-info">&lt;&lt; Voltar</a>
<input type="submit" name="salvar" id="salvar" value="Salvar" class="btn btn-success" /></p>

<input type="hidden" name="action" value="<?php echo $action;?>" />

<div class="control-group">
	<label class="control-label span3" for="descricao">Planilha</label> 
	<input type="file" id="planilha" name="planilha" size="50" placeholder="Planilha">
</div>

</form>
</div>
</div>