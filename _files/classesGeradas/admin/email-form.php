<?php

include_once '../../wcm/model/classesGeradas/model/email.class.php';

$objEmail = new Email();

$action = "inserirEmail";

if( isset( $_GET["idEmail"] ) )
{
	$action = "editarEmail";
	$objEmail->obterEmail( $_GET["idEmail"] );
}

?>

<script src="../js/jquery.validate.min.js"></script>

<div class="span6">
<div class="row-fluid">
<form id="form1" name="form1" method="post" action="../controller/email-controle.php"  class="form-inline">

<p><a href="index.php?cmd=email-lista" class="btn btn-info">&lt;&lt; Voltar</a>
<input type="submit" name="salvar" id="salvar" value="Salvar" class="btn btn-success" /></p>

<input type="hidden" name="action" value="<?=$action?>" />
<input type="hidden" name="idEmail" value="<?=$objEmail->getEmailID()?>" />

<div class="control-group">
	<label class="control-label span3" for="emailId">EmailId</label> 
	<input type="text" name="emailId" id="emailId"  class="span9" required="true" value="<?=$objEmail->getEmailId()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="email">Email</label> 
	<input type="text" name="email" id="email"  class="span9" required="true" value="<?=$objEmail->getEmail()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="dtCadastro">DtCadastro</label> 
	<input type="text" name="dtCadastro" id="dtCadastro"  class="span9" required="true" value="<?=$objEmail->getDtCadastro()?>" />
</div>

</form>
</div>
</div>