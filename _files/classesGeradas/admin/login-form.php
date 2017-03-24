<?php

include_once '../../wcm/model/classesGeradas/model/login.class.php';

$objLogin = new Login();

$action = "inserirLogin";

if( isset( $_GET["idLogin"] ) )
{
	$action = "editarLogin";
	$objLogin->obterLogin( $_GET["idLogin"] );
}

?>

<script src="../js/jquery.validate.min.js"></script>

<div class="span6">
<div class="row-fluid">
<form id="form1" name="form1" method="post" action="../controller/login-controle.php"  class="form-inline">

<p><a href="index.php?cmd=login-lista" class="btn btn-info">&lt;&lt; Voltar</a>
<input type="submit" name="salvar" id="salvar" value="Salvar" class="btn btn-success" /></p>

<input type="hidden" name="action" value="<?=$action?>" />
<input type="hidden" name="idLogin" value="<?=$objLogin->getLoginID()?>" />

<div class="control-group">
	<label class="control-label span3" for="loginId">LoginId</label> 
	<input type="text" name="loginId" id="loginId"  class="span9" required="true" value="<?=$objLogin->getLoginId()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="login">Login</label> 
	<input type="text" name="login" id="login"  class="span9" required="true" value="<?=$objLogin->getLogin()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="senha">Senha</label> 
	<input type="text" name="senha" id="senha"  class="span9" required="true" value="<?=$objLogin->getSenha()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="status">Status</label> 
	<input type="text" name="status" id="status"  class="span9" required="true" value="<?=$objLogin->getStatus()?>" />
</div>

</form>
</div>
</div>