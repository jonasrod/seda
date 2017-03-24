<?php

include_once '../model/endereco.class.php';
include_once '../model/clienteid.class.php';
include_once '../model/tipoenderecoid.class.php';

$objClienteId = new ClienteId();
$objTipoEnderecoId = new TipoEnderecoId();
$objEndereco = new Endereco();

$action = "inserirEndereco";

if( isset( $_GET["idEndereco"] ) )
{
	$action = "editarEndereco";
	$objEndereco->obterEndereco( $_GET["idEndereco"] );
}

?>

<script src="../js/jquery.validate.min.js"></script>

<div class="span6">
<div class="row-fluid">
<form id="form1" name="form1" method="post" action="../controller/endereco-controle.php"  class="form-inline">

<p><a href="index.php?cmd=endereco-lista" class="btn btn-info">&lt;&lt; Voltar</a>
<input type="submit" name="salvar" id="salvar" value="Salvar" class="btn btn-success" /></p>

<input type="hidden" name="action" value="<?=$action?>" />
<input type="hidden" name="idEndereco" value="<?=$objEndereco->getEnderecoID()?>" />

<div class="control-group">
	<label class="control-label span3" for="enderecoId">EnderecoId</label> 
	<input type="text" name="enderecoId" id="enderecoId"  class="span9" required="true" value="<?=$objEndereco->getEnderecoId()?>" />
</div>

<div class="control-group">
	<label for="clienteid" class="control-label span3">ClienteId</label>
	<select name="clienteid" id="clienteid" class="span9" required="true">
	<option value="" disabled="disabled" selected="selected">Selecione a clienteid</option>
	<?php foreach( $objClienteId->listarClienteId() as $clienteid ) { ?>
		<option value="<?=$clienteid->getClienteIdID()?>" <?php if( $clienteid->getClienteIdID() == $objEndereco->getClienteId()->getClienteIdID() ){ ?>selected="selected"<?php } ?>>
		<?=$clienteid->getDescricao()?></option>
	<?php } ?>
	</select>
</div>

<div class="control-group">
	<label for="tipoenderecoid" class="control-label span3">TipoEnderecoId</label>
	<select name="tipoenderecoid" id="tipoenderecoid" class="span9" required="true">
	<option value="" disabled="disabled" selected="selected">Selecione a tipoenderecoid</option>
	<?php foreach( $objTipoEnderecoId->listarTipoEnderecoId() as $tipoenderecoid ) { ?>
		<option value="<?=$tipoenderecoid->getTipoEnderecoIdID()?>" <?php if( $tipoenderecoid->getTipoEnderecoIdID() == $objEndereco->getTipoEnderecoId()->getTipoEnderecoIdID() ){ ?>selected="selected"<?php } ?>>
		<?=$tipoenderecoid->getDescricao()?></option>
	<?php } ?>
	</select>
</div>

<div class="control-group">
	<label class="control-label span3" for="cep">Cep</label> 
	<input type="text" name="cep" id="cep"  class="span9" required="true" value="<?=$objEndereco->getCep()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="endereco">Endereco</label> 
	<input type="text" name="endereco" id="endereco"  class="span9" required="true" value="<?=$objEndereco->getEndereco()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="numero">Numero</label> 
	<input type="text" name="numero" id="numero"  class="span9" required="true" value="<?=$objEndereco->getNumero()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="complemento">Complemento</label> 
	<input type="text" name="complemento" id="complemento"  class="span9" required="true" value="<?=$objEndereco->getComplemento()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="bairro">Bairro</label> 
	<input type="text" name="bairro" id="bairro"  class="span9" required="true" value="<?=$objEndereco->getBairro()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="cidade">Cidade</label> 
	<input type="text" name="cidade" id="cidade"  class="span9" required="true" value="<?=$objEndereco->getCidade()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="estado">Estado</label> 
	<input type="text" name="estado" id="estado"  class="span9" required="true" value="<?=$objEndereco->getEstado()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="observacoes">Observacoes</label> 
	<input type="text" name="observacoes" id="observacoes"  class="span9" required="true" value="<?=$objEndereco->getObservacoes()?>" />
</div>

</form>
</div>
</div>