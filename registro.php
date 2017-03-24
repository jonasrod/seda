<?php
require_once 'wcm/config.php';
require_once 'wcm/model/bancodedados.class.php';
require_once 'wcm/model/produto.class.php';
require_once 'wcm/model/files.class.php';
require_once 'wcm/model/estado.class.php';
require_once 'wcm/model/genero.class.php';
require_once 'wcm/model/tipo_cliente.class.php';
require_once 'wcm/model/data.class.php';
include_once 'wcm/model/alerta.class.php';
include_once 'wcm/model/cliente.class.php';
include_once 'wcm/model/endereco.class.php';
include_once 'wcm/model/tipo_endereco.class.php';
require_once 'calculo_carrinho.ajax.php';

$objEstado = new Estado();
$objGenero = new Genero();
$objTipoCliente = new TipoCliente();
$objBd = new BancodeDados();
$objCliente = new Cliente();
$objEndereco = new Endereco();
$objEnderecoF = new Endereco();

$action = "inserirCliente";

if (isset($_GET['clienteId'])) 
{
	$action = "editarCliente";
	
	$objCliente->obterCliente($_GET['clienteId']);
	$objEndereco->obterEnderecoPorCliente($_GET['clienteId']);
	$objEnderecoF->obterEnderecoFPorCliente($_GET['clienteId']);
}

$location = '';

if (isset($_GET['location']))
{
	$location = 'location=' . $_GET['location'] . '&';
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8">
<title><?php echo NOME_DO_SITE;?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">

<!-- Fonts -->
<link href='http://fonts.googleapis.com/css?family=Droid+Serif' rel='stylesheet' type='text/css' />
<link href='http://fonts.googleapis.com/css?family=Ubuntu' rel='stylesheet' type='text/css' />
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,400,800,700,300' rel='stylesheet' type='text/css'>

<!-- styles -->
<link href="css/bootstrap.css" rel="stylesheet">
<link href="css/bootstrap-responsive.css" rel="stylesheet">
<link href="css/docs.css" rel="stylesheet">
<link href="js/google-code-prettify/prettify.css" rel="stylesheet">
<link href="css/style.css" rel="stylesheet">

<!-- Slider -->
<link rel="stylesheet" href="css/default.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/nivo-slider.css" type="text/css" media="screen" />

<!-- Icon -->
<link rel="stylesheet" type="text/css" href="css/font-awesome.min.css" />
<!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

<!-- fav and touch icons -->
<link rel="shortcut icon" href="images/favicon.png">
<?php require_once 'headxajax.inc.php';?>
<script src="js/jquery.js"></script>
<script src="js/jquery.validate.min.js"></script>
<script src="js/util.validate.js"></script>
<script src="js/jquery.maskedinput-1.3.js"></script>
<script type="text/javascript">
	function getEndereco(sufixo) {
		if($.trim($("#cep" + sufixo).val()) != ""){
			/*$.getScript("//cep.republicavirtual.com.br/web_cep.php?formato=javascript&cep="+$("#cep" + sufixo).val(), function(){
				if(resultadoCEP["tipo_logradouro"] != ''){
					if (resultadoCEP["resultado"]) {
						$("#endereco" + sufixo).val(unescape(resultadoCEP["tipo_logradouro"]) + " " + unescape(resultadoCEP["logradouro"]));
						$("#bairro" + sufixo).val(unescape(resultadoCEP["bairro"]));
						$("#cidade" + sufixo).val(unescape(resultadoCEP["cidade"]));
						$("#estado" + sufixo).val(unescape(resultadoCEP["uf"]));
						$("#numero" + sufixo).focus();
					}
				}
			});*/
			$.getJSON("consulta_cep.ajax.php?cep="+$("#cep" + sufixo).val(), function(result){
				if (result.erro) {
					$("#endereco" + sufixo).val("");
					$("#bairro" + sufixo).val("");
					$("#cidade" + sufixo).val("");
					$("#estado" + sufixo).val("");
					alert("CEP não encontrado");
				} else {
					$("#endereco" + sufixo).val(result.end);
					$("#bairro" + sufixo).val(result.bairro);
					$("#cidade" + sufixo).val(result.cidade);
					$("#estado" + sufixo).val(result.uf);
				}
				$("#numero" + sufixo).focus();
		    });
		}
	}
	
	function validaSenha() {
		if ($("#senha").val() != $("#confirmaSenha").val()) {
			alert('As senhas devem ser iguais');
			return false;
		}
	}
	
	function validaCPF() {
		if (!isCpf($("#cpf").val()) ) {
			alert('CPF Inválido');
			$("#cpf").focus();
		}
	}
	
	function alteraCampos() {
		if ($("#tipoCliente").val() == '2') {
			$("#lblNome").html('<span class="red">*</span> Raz&atilde;o Social:');
			$("#lblTipoDocumento").html('<span class="red">*</span> CNPJ:');
			$("#divSobrenome").hide();
			$("#divRg").hide();
			$("#divDtNiver").hide();
			$("#divGenero").hide();
			$("#cpf").mask("99.999.999/9999-99");
		} else {
			$("#lblNome").html('<span class="red">*</span> Nome:');
			$("#lblTipoDocumento").html('<span class="red">*</span> CPF:');
			$("#divSobrenome").show();
			$("#divRg").show();
			$("#divDtNiver").show();
			$("#divGenero").show();
			$("#cpf").mask("999.999.999-99");
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
		$("#formCadastro").validate();
		
		$("#cpf").mask("999.999.999-99");
		$("#cep").mask("99999-999");
		$("#cepF").mask("99999-999");
		$("#dtAniversario").mask("99/99/9999");
		$("#telResidencial").mask("(99) 9999-9999");
		$("#telComercial").mask("(99) 9999-9999");

		$("#telefone").focus(function(){
			$(this).mask("(99)9999-9999?9",{
				completed:function(){
					$(this).mask("(99)99999-9999");
					}
			})
		});
		
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
</head>
<body>
<!-- Header Start -->
<?php include("header.inc.php");?>
<!-- Header Ends -->
<!--Content starts-->

<div id="maincontainer">
	<!--Slider Starts-->
	
    <!--Slider Ends-->
	<div class="container">
    <ul class="breadcrumb">
        <li>
          <a href="#">Home</a>
          <span class="divider">/</span>
        </li>
        <li class="active">Login</li>
      </ul>
		<div class="row">
        	<!--Sidebar Starts-->
            
			<div class="span3">
				<aside>
					<h1 class="headingfull"><span>Institucional</span></h1>
					<?php require_once 'menu_lateral.inc.php'; ?>
				</aside>
				</aside>
				<aside>
       			   <?php include_once 'mais_vendidos.inc.php'; ?>
                </aside>
				<aside>
					<h1 class="headingfull"><span></span> </h1>
					<div class="sidewidt">
						<?php include_once 'banner_lateral.inc.php'; ?>
					</div>
				</aside>
			</div>
            <!--sidebar Ends-->
            <div class="span9">
  <!-- Featured Product-->
  
  <section id="featured">
    <h1 class="productname">Registro de Conta</h1>
    <p>
	  <?php if (isset($_GET['st'])) { $objAlerta = new Alerta($_GET['st']); } ?> 
    </p>
    <p> Se você já possui uma conta conosco, por favor faça seu login na página de login.</p>
    
     <form class="form-horizontal" id="formCadastro" action="<?php echo URL_SEGURA;?>registro-controle.php?<?=$location?>session=<?php echo session_id();?>" method="post">
     		<input type="hidden" name="idCliente" value="<?=$objCliente->getClienteId()?>" />
			<input type="hidden" name="idEndereco" value="<?=$objEndereco->getEnderecoId()?>" />
            <h3 class="heading3">Seus detalhes Pessoais</h3>
            <div class="registerbox">
              <fieldset>
              	<div class="control-group">
                  <label class="control-label" for="select01">
                    <span class="red">*</span>Tipo Cliente:</label>
                  <div class="controls">
                    <select class="span3" id="tipoCliente" name="tipoCliente" onChange="alteraCampos()" required>
                      <option value="0">Selecione</option>
                      <?php
                      foreach($objTipoCliente->listarTipoCliente() as $tipoCliente) {
                      	  ?>
                          <option value="<?=$tipoCliente->getTipoClienteId()?>" <?php if ( $tipoCliente->getTipoClienteId() == $objCliente->getTipoClienteId()->getTipoClienteId() ) {echo 'selected="selected"';}?>><?=$tipoCliente->getDescricao()?></option>
                          <?php
                      }
                      ?>
                    </select>
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label" id="lblNome"><span class="red">*</span> Nome:</label>
                  <div class="controls">
                    <input type="text" class="input-xlarge" name="nome" id="nome" value="<?=$objCliente->getNome()?>" required>
                  </div>
                </div>
                <div class="control-group" id="divSobrenome">
                  <label class="control-label"><span class="red">*</span> Sobrenome:</label>
                  <div class="controls">
                    <input type="text" class="input-xlarge" name="sobrenome" id="sobrenome" value="<?=$objCliente->getSobrenome()?>">
                  </div>
                </div>
                 <div class="control-group" id="divGenero">
                  <label class="control-label" for="select01">
                    <span class="red">*</span>Genero:</label>
                  <div class="controls">
                    <select class="span3" id="genero" name="genero">
                      <option value="0">Selecione</option>
                      <?php
                      foreach($objGenero->listarGenero() as $genero) {
                      	  ?>
                          <option value="<?=$genero->getGeneroId()?>" <?php if ( $genero->getGeneroId() == $objCliente->getGeneroId()->getGeneroId() ) {echo 'selected="selected"';}?>><?=$genero->getDescricao()?></option>
                          <?php
                      }
                      ?>
                    </select>
                  </div>
                </div>
                <div class="control-group" id="divDtNiver">
                  <label class="control-label"><span class="red">*</span> Data de Anivers&aacute;rio:</label>
                  <div class="controls">
                    <input type="text" class="input-xlarge" name="dtAniversario" id="dtAniversario" value="<?=Data::formataData($objCliente->getDtAniversario())?>">
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label"><span class="red">*</span> Email:</label>
                  <div class="controls">
                    <input type="text" class="input-xlarge" name="email" id="email" value="<?=$objCliente->getEmail()?>" required>
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label">Tel. Residêncial:</label>
                  <div class="controls">
                    <input type="text" class="input-xlarge" name="telResidencial" id="telResidencial" value="<?=$objCliente->getTelResidencial()?>">
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label">Tel. Comercial:</label>
                  <div class="controls">
                    <input type="text" class="input-xlarge" name="telComercial" id="telComercial" value="<?=$objCliente->getTelComercial()?>">
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label"><span class="red">*</span> Celular:</label>
                  <div class="controls">
                    <input type="text" class="input-xlarge" name="telefone" id="telefone" value="<?=$objCliente->getTelCelular()?>" required>
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label" id="lblTipoDocumento"><span class="red">*</span> CPF:</label>
                  <div class="controls">
                    <input type="text" class="input-xlarge" name="cpf" id="cpf" value="<?=$objCliente->getCpf()?>" onBlur="validaCPF()" required>
                  </div>
                </div>
                <div class="control-group" id="divRg">
                  <label class="control-label"><span class="red">*</span> RG:</label>
                  <div class="controls">
                    <input type="text" class="input-xlarge" name="rg" id="rg" value="<?=$objCliente->getRg()?>">
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label"><span class="red">*</span> Como conheceu o site:</label>
                  <div class="controls">
                    <input type="text" class="input-xlarge" name="comoConheceu" id="comoConheceu" value="<?=$objCliente->getComoFicouSabendo()?>" required>
                  </div>
                </div>
              </fieldset>
            </div>
            <hr>
            <h3 class="heading3">Endereço Entrega</h3>
            <div class="registerbox">
              <fieldset>
              	<div class="control-group">
                  <label class="control-label">
                    <span class="red">*</span>CEP:</label>
                  <div class="controls">
                    <input type="text" class="input-xlarge" name="cep" id="cep" onBlur="getEndereco('')" value="<?=$objEndereco->getCep()?>" required>
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label"><span class="red">*</span> Endere&ccedil;o:</label>
                  <div class="controls">
                    <input type="text" class="input-xlarge" name="endereco" id="endereco" value="<?=$objEndereco->getEndereco()?>" required>
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label"><span class="red">*</span> N&uacute;mero:</label>
                  <div class="controls">
                    <input type="text" class="input-xlarge" name="numero" id="numero" value="<?=$objEndereco->getNumero()?>" required>
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label">Complemento:</label>
                  <div class="controls">
                    <input type="text" class="input-xlarge" name="complemento" id="complemento" value="<?=$objEndereco->getComplemento()?>">
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label"><span class="red">*</span> Bairro:</label>
                  <div class="controls">
                    <input type="text" class="input-xlarge" name="bairro" id="bairro" value="<?=$objEndereco->getBairro()?>" required>
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label">
                    <span class="red">*</span>Cidade:</label>
                  <div class="controls">
                    <input type="text" class="input-xlarge" name="cidade" id="cidade" value="<?=$objEndereco->getCidade()?>" required>
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label" for="select01">
                    <span class="red">*</span>Estado:</label>
                  <div class="controls">
                    <select class="span3" id="estado" name="estado" required>
                      <option value="0">Selecione</option>
                      <?php
                      foreach($objEstado->listarEstado() as $estado) {
                      	  ?>
                          <option value="<?=$estado->getSigla()?>" <?php if ($estado->getSigla() == $objEndereco->getEstado()) {echo 'selected';}?>><?=$estado->getDescricao()?></option>
                          <?php
                      }
                      ?>
                    </select>
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label">
                    <span class="red">*</span>Refer&ecirc;ncia:</label>
                  <div class="controls">
                    <input type="text" class="input-xlarge" name="referencia" id="referencia" value="<?=$objEndereco->getObservacoes()?>" required>
                  </div>
                </div>
                <div class="control-group">
              	  Endere&ccedil;o de Faturamento &eacute; mesmo de Entrega?
              	  <input type="checkbox" name="mesmoEndereco" id="mesmoEndereco" value="1" <?php if ($action == "editarCliente" && $objEnderecoF->getCep() == '') echo 'checked' ?> onClick="escondeCampos()">
                </div>
              </fieldset>
            </div>
            <hr>
            <div id="enderecoFaturamento">
            <h3 class="heading3">Endereço Faturamento</h3>
            <div class="registerbox">
              <fieldset>
              	<div class="control-group">
                  <label class="control-label">
                    <span class="red">*</span>CEP:</label>
                  <div class="controls">
                    <input type="text" class="input-xlarge" name="cepF" id="cepF" onBlur="getEndereco('F')" value="<?=$objEnderecoF->getCep()?>">
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label"><span class="red">*</span> Endere&ccedil;o:</label>
                  <div class="controls">
                    <input type="text" class="input-xlarge" name="enderecoF" id="enderecoF" value="<?=$objEnderecoF->getEndereco()?>">
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label"><span class="red">*</span> N&uacute;mero:</label>
                  <div class="controls">
                    <input type="text" class="input-xlarge" name="numeroF" id="numeroF" value="<?=$objEnderecoF->getNumero()?>">
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label">Complemento:</label>
                  <div class="controls">
                    <input type="text" class="input-xlarge" name="complementoF" id="complementoF" value="<?=$objEnderecoF->getComplemento()?>">
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label"><span class="red">*</span> Bairro:</label>
                  <div class="controls">
                    <input type="text" class="input-xlarge" name="bairroF" id="bairroF" value="<?=$objEnderecoF->getBairro()?>">
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label">
                    <span class="red">*</span>Cidade:</label>
                  <div class="controls">
                    <input type="text" class="input-xlarge" name="cidadeF" id="cidadeF" value="<?=$objEnderecoF->getCidade()?>">
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label" for="select01">
                    <span class="red">*</span>Estado:</label>
                  <div class="controls">
                    <select class="span3" id="estadoF" name="estadoF">
                      <option value="0">Selecione</option>
                      <?php
                      foreach($objEstado->listarEstado() as $estado) {
                      	  ?>
                          <option value="<?=$estado->getSigla()?>" <?php if ($estado->getSigla() == $objEnderecoF->getEstado()) {echo 'selected';}?>><?=$estado->getDescricao()?></option>
                          <?php
                      }
                      ?>
                    </select>
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label">
                    <span class="red">*</span>Refer&ecirc;ncia:</label>
                  <div class="controls">
                    <input type="text" class="input-xlarge" name="referenciaF" id="referenciaF" value="<?=$objEnderecoF->getObservacoes()?>">
                  </div>
                </div>
              </fieldset>
            </div>
            <hr>
            </div>
            <h3 class="heading3">Sua Senha</h3>
            <div class="registerbox">
              <fieldset>
                <div class="control-group">
                  <label class="control-label"><span class="red">*</span>Senha:</label>
                  <div class="controls">
                    <input type="password" class="input-xlarge" name="senha" id="senha" value="<?=$objCliente->getSenha()?>" required>
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label"><span class="red">*</span>Confirmar senha:</label>
                  <div class="controls">
                    <input type="password" class="input-xlarge" name="confirmaSenha" id="confirmaSenha" value="<?=$objCliente->getSenha()?>" required>
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label"></label>
                  <div class="controls">
                    <input type="checkbox" value="option2" name="novidades">Deseja receber novidades?
                  </div>
                </div>
              </fieldset>
            </div>
            <hr>

            <div class="pull-right">
              <label class="checkbox inline">
                <input type="checkbox" value="option2" checked required>
              </label>
              Eu li e concordo com a<a href="#"> Política de Privacidade</a>
              &nbsp;
              <input type="hidden" value="<?=$action;?>" name="action">
              <input type="Submit" value="Cadastrar" class="btn btn-success" onClick="return validaSenha()">
            </div>
          </form>
          <div class="clearfix"></div>     
  </section>
</div>
</div>
</div>
</div>
<!-- Footer Starts-->
<?php require_once 'footer.inc.php';?>
<!-- Footer Starts-->
<?php require_once 'carrinho_modal.php';?>
<!-- /maincontainer -->

<!-- javascript
    ================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<!--<script src="js/jquery.js"></script>-->
<!--<script src="js/jquery.validate.js"></script>-->
<script src="js/jquery.maskedinput-1.3.js"></script>
<script src="js/google-code-prettify/prettify.js"></script>
<script src="js/bootstrap-transition.js"></script>
<script src="js/bootstrap-alert.js"></script>
<script src="js/bootstrap-modal.js"></script>
<script src="js/bootstrap-dropdown.js"></script>
<script src="js/bootstrap-scrollspy.js"></script>
<script src="js/bootstrap-tab.js"></script>
<script src="js/bootstrap-tooltip.js"></script>
<script src="js/bootstrap-popover.js"></script>
<script src="js/bootstrap-button.js"></script>
<script src="js/bootstrap-collapse.js"></script>
<script src="js/bootstrap-carousel.js"></script>
<script src="js/bootstrap-typeahead.js"></script>
<script src="js/bootstrap-affix.js"></script>
<script src="js/application.js"></script>
<script src="js/respond.min.js"></script>
<script src="js/cloud-zoom.1.0.2.js"></script>
<script type="text/javascript" src="js/jquery.nivo.slider.js"></script>
<script defer src="js/custom.js"></script>
<script type="text/javascript">
$(window).load(function () {
  $('#slider').nivoSlider();
});
</script>
</body>
</html>