<?php

include_once '../../wcm/model/classesGeradas/model/cliente.class.php';
include_once '../model/generoid.class.php';
include_once '../model/tipoclienteid.class.php';

$objGeneroId = new GeneroId();
$objTipoClienteId = new TipoClienteId();
$objCliente = new Cliente();

$action = "inserirCliente";

if( isset( $_GET["idCliente"] ) )
{
	$action = "editarCliente";
	$objCliente->obterCliente( $_GET["idCliente"] );
}

?>

<script src="../js/jquery.validate.min.js"></script>

<div class="span6">
<div class="row-fluid">
<form id="form1" name="form1" method="post" action="../controller/cliente-controle.php"  class="form-inline">

<p><a href="index.php?cmd=cliente-lista" class="btn btn-info">&lt;&lt; Voltar</a>
<input type="submit" name="salvar" id="salvar" value="Salvar" class="btn btn-success" /></p>

<input type="hidden" name="action" value="<?=$action?>" />
<input type="hidden" name="idCliente" value="<?=$objCliente->getClienteID()?>" />

<div class="control-group">
	<label class="control-label span3" for="clienteId">ClienteId</label> 
	<input type="text" name="clienteId" id="clienteId"  class="span9" required="true" value="<?=$objCliente->getClienteId()?>" />
</div>

<div class="control-group">
	<label for="generoid" class="control-label span3">GeneroId</label>
	<select name="generoid" id="generoid" class="span9" required="true">
	<option value="" disabled="disabled" selected="selected">Selecione a generoid</option>
	<?php foreach( $objGeneroId->listarGeneroId() as $generoid ) { ?>
		<option value="<?=$generoid->getGeneroIdID()?>" <?php if( $generoid->getGeneroIdID() == $objCliente->getGeneroId()->getGeneroIdID() ){ ?>selected="selected"<?php } ?>>
		<?=$generoid->getDescricao()?></option>
	<?php } ?>
	</select>
</div>

<div class="control-group">
	<label for="tipoclienteid" class="control-label span3">TipoClienteId</label>
	<select name="tipoclienteid" id="tipoclienteid" class="span9" required="true">
	<option value="" disabled="disabled" selected="selected">Selecione a tipoclienteid</option>
	<?php foreach( $objTipoClienteId->listarTipoClienteId() as $tipoclienteid ) { ?>
		<option value="<?=$tipoclienteid->getTipoClienteIdID()?>" <?php if( $tipoclienteid->getTipoClienteIdID() == $objCliente->getTipoClienteId()->getTipoClienteIdID() ){ ?>selected="selected"<?php } ?>>
		<?=$tipoclienteid->getDescricao()?></option>
	<?php } ?>
	</select>
</div>

<div class="control-group">
	<label class="control-label span3" for="nome">Nome</label> 
	<input type="text" name="nome" id="nome"  class="span9" required="true" value="<?=$objCliente->getNome()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="sobrenome">Sobrenome</label> 
	<input type="text" name="sobrenome" id="sobrenome"  class="span9" required="true" value="<?=$objCliente->getSobrenome()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="email">Email</label> 
	<input type="text" name="email" id="email"  class="span9" required="true" value="<?=$objCliente->getEmail()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="senha">Senha</label> 
	<input type="text" name="senha" id="senha"  class="span9" required="true" value="<?=$objCliente->getSenha()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="dtAniversario">DtAniversario</label> 
	<input type="text" name="dtAniversario" id="dtAniversario"  class="span9" required="true" value="<?=$objCliente->getDtAniversario()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="status">Status</label> 
	<input type="text" name="status" id="status"  class="span9" required="true" value="<?=$objCliente->getStatus()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="dtCadastro">DtCadastro</label> 
	<input type="text" name="dtCadastro" id="dtCadastro"  class="span9" required="true" value="<?=$objCliente->getDtCadastro()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="cpf">Cpf</label> 
	<input type="text" name="cpf" id="cpf"  class="span9" required="true" value="<?=$objCliente->getCpf()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="rg">Rg</label> 
	<input type="text" name="rg" id="rg"  class="span9" required="true" value="<?=$objCliente->getRg()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="telResidencial">TelResidencial</label> 
	<input type="text" name="telResidencial" id="telResidencial"  class="span9" required="true" value="<?=$objCliente->getTelResidencial()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="telComercial">TelComercial</label> 
	<input type="text" name="telComercial" id="telComercial"  class="span9" required="true" value="<?=$objCliente->getTelComercial()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="telCelular">TelCelular</label> 
	<input type="text" name="telCelular" id="telCelular"  class="span9" required="true" value="<?=$objCliente->getTelCelular()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="receberNovidades">ReceberNovidades</label> 
	<input type="text" name="receberNovidades" id="receberNovidades"  class="span9" required="true" value="<?=$objCliente->getReceberNovidades()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="comoFicouSabendo">ComoFicouSabendo</label> 
	<input type="text" name="comoFicouSabendo" id="comoFicouSabendo"  class="span9" required="true" value="<?=$objCliente->getComoFicouSabendo()?>" />
</div>

</form>
</div>
</div>