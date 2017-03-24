<?php

include_once '../model/cliente.class.php';
include_once '../model/genero.class.php';
include_once '../model/tipo_cliente.class.php';
include_once '../model/endereco.class.php';
include_once '../model/tipo_endereco.class.php';
include_once '../model/data.class.php';
include_once '../model/bancodedados.class.php';

$objGeneroId = new Genero();
$objTipoClienteId = new TipoCliente();
$objCliente = new Cliente();
$objEndereco = new Endereco();
$objTipoEnderecoId = new TipoEndereco();
$objBd = new BancodeDados();
$objEnderecoF = new Endereco();

$action = "inserirCliente";

$endereco = null;

if( isset( $_GET["idCliente"] ) )
{
	$action = "editarCliente";
	$objCliente->obterCliente( $_GET["idCliente"] );
	
	$objEndereco->obterEnderecoPorCliente($_GET["idCliente"]);
	$objEnderecoF->obterEnderecoFPorCliente($_GET["idCliente"]);
}


?>

<script src="../js/jquery.validate.min.js"></script>
<script type="text/javascript" src="../js/jquery.maskedinput-1.3.js"></script>
<script type="text/javascript">
	
	function getEndereco(sufixo) {
		if($.trim($("#cep" + sufixo).val()) != ""){
			$.getScript("http://cep.republicavirtual.com.br/web_cep.php?formato=javascript&cep="+$("#cep" + sufixo).val(), function(){
				if(resultadoCEP["tipo_logradouro"] != ''){
					if (resultadoCEP["resultado"]) {
						$("#endereco" + sufixo).val(unescape(resultadoCEP["tipo_logradouro"]) + " " + unescape(resultadoCEP["logradouro"]));
						$("#bairro" + sufixo).val(unescape(resultadoCEP["bairro"]));
						$("#cidade" + sufixo).val(unescape(resultadoCEP["cidade"]));
						$("#estado" + sufixo).val(unescape(resultadoCEP["uf"]));
						$("#numero" + sufixo).focus();
					}
				}
			});
		}
	}
	
	function alteraCampos() {
		if ($("#tipoclienteid").val() == '2') {
			$("#lblNome").html('Raz&atilde;o Social');
			$("#lblTipoDocumento").html('CNPJ');
			$("#divSobrenome").hide();
			$("#divRg").hide();
			$("#divDtNiver").hide();
			$("#divGenero").hide();
		} else {
			$("#lblNome").html('Nome');
			$("#lblTipoDocumento").html('CPF');
			$("#divSobrenome").show();
			$("#divRg").show();
			$("#divDtNiver").show();
			$("#divGenero").show();
		}
	}
	
	function escondeCampos() {
		if ($("#mesmoEndereco").attr('checked') == 'checked') {
			$("#enderecoFaturamento").hide();
		} else {
			$("#enderecoFaturamento").show();
		}
	}
	
	$(document).ready(function() {
		//$("#cpf").mask("999.999.999-99");
		//$("#rg").mask("99.999.999-9");
		//$("#telResidencial").mask("(99) 9999-9999");
		//$("#telComercial").mask("(99) 9999-9999");
		//$("#telCelular").mask("(99) 99999-9999");
		//$("#cep").mask("99999-999");
		
		alteraCampos();
		
		<?php
        if ($action == "inserirCliente" || ($action == "editarCliente" && trim($objEnderecoF->getCep()) != '')) {
        	?>
        	$("#enderecoFaturamento").show();
        	<?php
        } else {
        	?>
        	$("#enderecoFaturamento").hide();
        	<?php
        }
        ?>
	});
</script>

<form id="form1" name="form1" method="post" action="../controller/cliente-controle.php"  class="form-inline">
<div class="span6">
<div class="row-fluid">

<p><a href="index.php?p=cliente-lista" class="btn btn-info">&lt;&lt; Voltar</a>
<input type="submit" name="salvar" id="salvar" value="Salvar" class="btn btn-success" /></p>

<input type="hidden" name="action" value="<?=$action?>" />
<input type="hidden" name="idCliente" value="<?=$objCliente->getClienteId()?>" />
<input type="hidden" name="idEndereco" value="<?=$objEndereco->getEnderecoId()?>" />

<div class="control-group" id="divGenero">
	<label for="generoid" class="control-label span3">Genero</label>
	<select name="generoid" id="generoid" class="span9">
	<option value="" disabled="disabled" selected="selected">Selecione a genero</option>
	<?php foreach( $objGeneroId->listarGenero() as $generoid ) { ?>
		<option value="<?=$generoid->getGeneroId()?>" <?php if( $generoid->getGeneroId() == $objCliente->getGeneroId()->getGeneroId() ){ ?>selected="selected"<?php } ?>>
		<?=$generoid->getDescricao()?></option>
	<?php } ?>
	</select>
</div>

<div class="control-group">
	<label for="tipoclienteid" class="control-label span3">Tipo Cliente</label>
	<select name="tipoclienteid" id="tipoclienteid" class="span9" required="true" onChange="alteraCampos()">
	<option value="" disabled="disabled" selected="selected">Selecione a tipocliente</option>
	<?php foreach( $objTipoClienteId->listarTipoCliente() as $tipoclienteid ) { ?>
		<option value="<?=$tipoclienteid->getTipoClienteId()?>" <?php if( $tipoclienteid->getTipoClienteId() == $objCliente->getTipoClienteId()->getTipoClienteId() ){ ?>selected="selected"<?php } ?>>
		<?=$tipoclienteid->getDescricao()?></option>
	<?php } ?>
	</select>
</div>

<div class="control-group">
	<label class="control-label span3" for="nome" id="lblNome">Nome</label> 
	<input type="text" name="nome" id="nome"  class="span9" required="true" value="<?=$objCliente->getNome()?>" />
</div>

<div class="control-group" id="divSobrenome">
	<label class="control-label span3" for="sobrenome">Sobrenome</label> 
	<input type="text" name="sobrenome" id="sobrenome"  class="span9" required="true" value="<?=$objCliente->getSobrenome()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="email">E-mail</label> 
	<input type="text" name="email" id="email"  class="span9" required="true" value="<?=$objCliente->getEmail()?>" />
</div>

<div class="control-group" id="divDtNiver">
	<label class="control-label span3" for="dtAniversario">Data Anivers&aacute;rio</label> 
	<input type="text" name="dtAniversario" id="dtAniversario"  class="span9" value="<?=Data::formataData($objCliente->getDtAniversario())?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="cpf" id="lblTipoDocumento">CPF</label> 
	<input type="text" name="cpf" id="cpf"  class="span9" required="true" value="<?=$objCliente->getCpf()?>" />
</div>

<div class="control-group" id="divRg">
	<label class="control-label span3" for="rg">RG</label> 
	<input type="text" name="rg" id="rg"  class="span9" value="<?=$objCliente->getRg()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="telResidencial">Tel Residencial</label> 
	<input type="text" name="telResidencial" id="telResidencial"  class="span9" required="true" value="<?=$objCliente->getTelResidencial()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="telComercial">Tel Comercial</label> 
	<input type="text" name="telComercial" id="telComercial"  class="span9" required="true" value="<?=$objCliente->getTelComercial()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="telCelular">Tel Celular</label> 
	<input type="text" name="telCelular" id="telCelular"  class="span9" required="true" value="<?=$objCliente->getTelCelular()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="receberNovidades">ReceberNovidades</label>
	<input type="checkbox" class="checkbox" name="receberNovidades" value="receberNovidades" <?php echo ($objCliente->getReceberNovidades() == 1) ? 'checked':'';?> />
</div>


</div>
</div>

<div class="span6">
<div class="row-fluid">

<div class="control-group">&nbsp;</div>

<div class="control-group">
	<h4 class="heading3">Endere&ccedil;o Entrega</h4>
</div>

<div class="control-group">
	<label class="control-label span3" for="cep">CEP</label> 
	<input type="text" name="cep" id="cep"  class="span9" required="true" value="<?=$objEndereco->getCep()?>" onBlur="getEndereco('')" />
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
<div class="control-group">
  Endere&ccedil;o de Faturamento &eacute; mesmo de Entrega?
  <input type="checkbox" name="mesmoEndereco" id="mesmoEndereco" value="1" <?php if ($action == "editarCliente" && $objEnderecoF->getCep() == '') echo 'checked' ?> onClick="escondeCampos()">
</div>

<!-- Endereco FATURAMENTO -->
<div id="enderecoFaturamento">
	<div class="control-group">
	  <h4>Endere&ccedil;o de Faturamento</h4>
	</div>
	<div class="control-group">
		<label class="control-label span3" for="cepF">CEP</label> 
		<input type="text" name="cepF" id="cepF"  class="span9" value="<?=$objEnderecoF->getCep()?>" onBlur="getEndereco('F')" />
	</div>
	
	<div class="control-group">
		<label class="control-label span3" for="enderecoF">Endereco</label> 
		<input type="text" name="enderecoF" id="enderecoF"  class="span9" value="<?=$objEnderecoF->getEndereco()?>" />
	</div>
	
	<div class="control-group">
		<label class="control-label span3" for="numeroF">Numero</label> 
		<input type="text" name="numeroF" id="numeroF"  class="span9" value="<?=$objEnderecoF->getNumero()?>" />
	</div>
	
	<div class="control-group">
		<label class="control-label span3" for="complementoF">Complemento</label> 
		<input type="text" name="complementoF" id="complementoF"  class="span9" value="<?=$objEnderecoF->getComplemento()?>" />
	</div>
	
	<div class="control-group">
		<label class="control-label span3" for="bairroF">Bairro</label> 
		<input type="text" name="bairroF" id="bairroF"  class="span9" value="<?=$objEnderecoF->getBairro()?>" />
	</div>
	
	<div class="control-group">
		<label class="control-label span3" for="cidadeF">Cidade</label> 
		<input type="text" name="cidadeF" id="cidadeF"  class="span9" value="<?=$objEnderecoF->getCidade()?>" />
	</div>
	
	<div class="control-group">
		<label class="control-label span3" for="estadoF">Estado</label> 
		<input type="text" name="estadoF" id="estadoF"  class="span9" value="<?=$objEnderecoF->getEstado()?>" />
	</div>
	
	<div class="control-group">
		<label class="control-label span3" for="observacoesF">Observacoes</label> 
		<input type="text" name="observacoesF" id="observacoesF"  class="span9" value="<?=$objEnderecoF->getObservacoes()?>" />
	</div>
</div>

</div>
</div>

</form>