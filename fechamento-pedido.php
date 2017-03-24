<?php
require_once 'wcm/config.php';
require_once 'wcm/model/bancodedados.class.php';
require_once 'wcm/model/produto.class.php';
include_once 'wcm/model/files.class.php';
require_once 'wcm/model/data.class.php';
require_once 'calculo_carrinho.ajax.php';
include_once 'wcm/model/endereco.class.php';
include_once 'wcm/model/descontofrete.class.php';

if (!isset($_SESSION['brw_idLogin'])) {
    $_SESSION['fechamento']['redirecionamento'] = 'fechamento-pedido.php';
    header('Location: login-conta.php');
    exit();
}
$objBd = new BancodeDados();
$total_peso = 0;

$objDescontoFrete = new DescontoFrete();
$objDescontoFrete->getDescontoFrete();


if (isset($_SESSION['carrinho']) && count($_SESSION['carrinho']) > 0) {
    $sql_in = "(";
    foreach ($_SESSION['carrinho'] as $produto_carrinho) {
        $sql_in .= $produto_carrinho['produto'] . ',';
    }
    $sql_in = substr($sql_in, 0, -1);
    $sql_in .= ")";

    $sql_produtos_carrinho = "select * from produto where produtoId in $sql_in";
    $result_produto_carrinho = $objBd->executarSQL($sql_produtos_carrinho);
    $sql_peso = "select sum(peso) as peso from produto where produtoId in $sql_in";
    $result_peso = $objBd->executarSQL($sql_produtos_carrinho);
    $row_peso = $result_peso->fetch_array();
    $total_peso = $row_peso['peso'];

}
$valor_frete = 0;
$objProduto = new Produto();
$objEndereco = new Endereco();
$objEndereco->obterEnderecoPorCliente($_SESSION['brw_idLogin']);
$client = new SoapClient('http://ws.correios.com.br/calculador/CalcPrecoPrazo.asmx?WSDL');
$function = 'CalcPrecoPrazo';
$arguments = array('CalcPrecoPrazo' => array(	
		'nCdEmpresa' => 9912351440, 
		'sDsSenha' => '19380699', 
		'nCdServico' => 41106, 
		'sCepOrigem' => '08653300', 
		'sCepDestino' => 0, 
		'nVlPeso' => $total_peso, 
		'nCdFormato' => 1, 
		'nVlComprimento' => 16, 
		'nVlAltura' => 2, 
		'nVlLargura' => 11, 
		'nVlDiametro' => 0, 
		'sCdMaoPropria' => 'N', 
		'nVlValorDeclarado' => 0, 
		'sCdAvisoRecebimento' => 'N'
	)
);

$options = array('location' => 'http://ws.correios.com.br/calculador/CalcPrecoPrazo.asmx');
$valor_frete_pac = '';
$valor_frete_sedex = '';

if ($objEndereco->getCep() != '') {
    $arguments['CalcPrecoPrazo']['sCepDestino'] = $objEndereco->getCep();
    $arguments['CalcPrecoPrazo']['nCdServico'] = 41106;
    $result = $client->__soapCall($function, $arguments, $options);
    $valor_frete_pac = $result->CalcPrecoPrazoResult->Servicos->cServico->Valor;
    $arguments['CalcPrecoPrazo']['nCdServico'] = 40010;
    $result = $client->__soapCall($function, $arguments, $options);
    $valor_frete_sedex = $result->CalcPrecoPrazoResult->Servicos->cServico->Valor;
}
if (isset($_POST['cep'])) {
    if ($_POST['cep'] != '') {
        $arguments['CalcPrecoPrazo']['sCepDestino'] = $_POST['cep'];
    }
    $arguments['CalcPrecoPrazo']['nCdServico'] = $_POST['tipoFrete'];
    $result = $client->__soapCall($function, $arguments, $options);
	$valor_frete = $_SESSION['fechamento']['valorFrete'] = $result->CalcPrecoPrazoResult->Servicos->cServico->Valor;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title><?php echo NOME_DO_SITE; ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">
<!-- Fonts -->
<link href='http://fonts.googleapis.com/css?family=Droid+Serif'
	rel='stylesheet' type='text/css' />
<link href='http://fonts.googleapis.com/css?family=Ubuntu'
	rel='stylesheet' type='text/css' />
<link
	href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,400,800,700,300'
	rel='stylesheet' type='text/css'>
<!-- styles -->
<link href="css/bootstrap.css" rel="stylesheet">
<link href="css/bootstrap-responsive.css" rel="stylesheet">
<link href="css/docs.css" rel="stylesheet">
<link href="js/google-code-prettify/prettify.css" rel="stylesheet">
<link href="css/style.css" rel="stylesheet">
<!-- Slider -->
<link rel="stylesheet" href="css/default.css" type="text/css"
	media="screen" />
<link rel="stylesheet" href="css/nivo-slider.css" type="text/css"
	media="screen" />
<!-- Icon -->
<link rel="stylesheet" type="text/css" href="css/font-awesome.min.css" />
<!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>    <![endif]-->
<!-- fav and touch icons -->
<link rel="shortcut icon" href="images/favicon.png">
<!-- Inline CSS================================================== -->
<style>
.thumbnails {
	margin-left: 6px;
}

.thumbnails>li {
	float: left;
	margin-bottom: 20px;
	margin-right: 4px;
	margin-left: 4px;
}
</style>
<?php /*** print the javasript ***/
    $xajax->printJavascript(); ?>
<script src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery.maskedinput-1.3.js"></script>
<script type="text/javascript">    $(document).ready(function () {
            $("#cep").mask("99999-999");
        });
        function calculaValorQuantidadeModal(produtoId) {
            var quantidade = $("#quantidadeModal" + produtoId).val();
            xajax_calculaValorQuantidade(produtoId, quantidade, false);
        }
        function calculaValorQuantidade(produtoId) {
            var quantidade = $("#quantidade" + produtoId).val();
            xajax_calculaValorQuantidade(produtoId, quantidade, false);
        }
        function concluir() {
            var tipoFrete;
            if ($("#pac").is(":checked")) {
                tipoFrete = $("#pac").val();
            } else if ($("#sedex").is(":checked")) {
                tipoFrete = $("#sedex").val();
            } else {
                alert("Por favor, selecione o Tipo do Frete");
                return false;
            }
            window.location = '<?php echo URL_SEGURA;?>confirma-endereco.php?session=<?php echo session_id();?>&tipoFrete=' + tipoFrete + '&cep=' + $("#cep").val();
        }
        function validaCep() {
            if (!$("#pac").is(":checked") && !$("#sedex").is(":checked")) {
                alert("Por favor, selecione o Tipo do Frete");
                return false;
            } else {
                var objER = /^[0-9]{5}-[0-9]{3}$/;
                if (!objER.test($("#cep").val())) {
                    alert('Preencha o campo CEP corretamente');
                    return false;
                }
            }
            return;
        }
        function submitForm() {
            $('#form-frete').submit();
        }    <?php if (isset($_SESSION['mensagem_estoque'])) {
            echo 'alert("' . $_SESSION['mensagem_estoque'] . '");';
            unset($_SESSION['mensagem_estoque']);
        } ?></script>
</head>
<body>
	<!-- Header Start -->
	<?php include("header.inc.php"); ?>
	<!-- Header Ends -->
	<!--Content starts-->
	<div id="maincontainer">
		<section id="checkout">
			<div class="container">
				<ul class="breadcrumb">
					<li><a href="index.php">Home</a><span class="divider">/</span></li>
					<li class="active">Pedido</li>
				</ul>
				<h1 class="productname">Fechamento de Pedido</h1>

				<div class="cart-info">
					<table class="table table-striped table-bordered">
						<tbody>
							<tr>
								<th width="14%" class="image">Imagem</th>
								<th width="21%" class="name">Produto</th>
								<th width="14%" class="model">C&oacute;digo</th>
								<th width="12%" class="quantity">Quantidade</th>
								<th width="15%" class="price">Pre&ccedil;o Unit&aacute;rio</th>
								<th width="13%" class="total">Total</th>
								<th width="11%" class="total">Editar</th>
							</tr>
							<?php if (isset($result_produto_carrinho)) {
                    $valor_total_carrinho = 0;
                    $valor_total_itam = 0;
                    foreach ($objProduto->listarCategoriaComFiltro($result_produto_carrinho) as $produto) {
                        $objFile = new Files();
                        $objFile->obtemImagemPrincipal($produto->getProdutoId());
                        $valor_total_item = $produto->getValor() * $_SESSION['carrinho'][$produto->getProdutoId()]['quantidade'];
                        $valor_total_carrinho = $valor_total_carrinho + $valor_total_item; ?>
							<tr>
								<td class="image"><a
									href="produto.php?produtoId=<?php echo $produto->getProdutoId(); ?>"><img
										width="50" height="50"
										src="produtos/fotos/<?php echo $produto->getProdutoId(); ?>/thumbnail/<?php echo $objFile->getName(); ?>"></a>
								</td>
								<td class="name"><a
									href="produto.php?produtoId=<?php echo $produto->getProdutoId(); ?>"><?php echo $produto->getTitulo(); ?></a>
								</td>
								<td class="model"><?php echo $produto->getCodigoProduto(); ?></td>
								<td class="quantity"><input type="text" class="span1"
									name="quantidade"
									id="quantidade<?php echo $produto->getProdutoId(); ?>"
									value="<?php echo $_SESSION['carrinho'][$produto->getProdutoId()]['quantidade']; ?>"
									size="1"
									onBlur="calculaValorQuantidade(<?php echo $produto->getProdutoId(); ?>)">
								</td>
								<td class="price">R$<?php echo Data::formataMoeda($produto->getValor()); ?></td>
								<td class="total"
									id="valorTotalProduto<?php echo $produto->getProdutoId(); ?>">
									R$<?php echo Data::formataMoeda($valor_total_item); ?>
								</td>
								<td class="total"><a
									href="delcarrinho.php?produtoId=<?php echo $produto->getProdutoId(); ?>"><img
										alt="" src="images/remove.png" data-original-title="Remove"
										class="tooltip-test"></a></td>
							</tr>
							<?php
					}
					if (isset($_POST['tipoFrete']) && $_POST['tipoFrete'] == 41106 && $valor_total_carrinho > $objDescontoFrete->getValorDesconto()) {
						$_SESSION['fechamento']['valorTotal'] = $valor_total_carrinho;
						$valor_frete = $_SESSION['fechamento']['valorFrete'] = 0;
					} else {
						$_SESSION['fechamento']['valorTotal'] = $valor_total_carrinho + Data::formataMoedaBD($valor_frete);
					}
					?>
						</tbody>
					</table>
				</div>
				<div class="row">
					<div class="pull-right">
						<div class="span4 pull-right">
							<table class="table table-striped table-bordered ">
								<tbody>
									<tr>
										<td><span class="extra bold">Sub-Total :</span></td>
										<td><span class="bold" id="valorSubtotalCarrinho">R$
												<?php echo Data::formataMoeda($valor_total_carrinho); ?>
										</span></td>
									</tr>
									<tr>
										<td><span class="extra bold">Valor Frete:</span></td>
										<td><span class="bold">R$ <?php echo $valor_frete; ?></span></td>
									</tr>
									<tr>
										<td><span class="extra bold totalamout">Total :</span></td>
										<td><span class="bold totalamout" id="valorTotalCarrinho">R$
												<?php echo Data::formataMoeda($valor_total_carrinho + Data::formataMoedaBD($valor_frete)); ?>
										</span></td>
									</tr>
								</tbody>
							</table>
							<br>
							<button class="btn btn-success pull-right"
								onClick="return concluir()">Finalizar</button>
							<!--<a class="btn btn-success pull-right" href="<?php echo URL_SEGURA; ?>confirma-endereco.php?session=<?php echo session_id(); ?>">Finalizar</a>-->
							<a class="btn pull-right mr10" href="index.php">Continuar
								Comprando</a>
						</div>
					</div>
				</div>
				<br>
				<br>

				<form class="form-vertical form-inline"
					action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post"
					id="form-frete">
					<div class="cartoptionbox">
						<h4 class="heading4">Tipo Frete</h4>

						<div class="control-group">
							<input type="radio" name="tipoFrete" id="pac" value="41106"
								onclick="submitForm()"
								<?php echo (isset($_POST['tipoFrete']) && $_POST['tipoFrete'] == '41106') ? 'checked' : ''; ?>>
							PAC
							<?php
							if ($valor_total_carrinho > $objDescontoFrete->getValorDesconto()) {
								echo ($valor_frete_pac != '') ? " - " . '0,00' : '';
							} else {
								echo ($valor_frete_pac != '') ? " - " . $valor_frete_pac : '';
							}
							?>
							<br /> <input type="radio" name="tipoFrete" id="sedex"
								value="40010" onclick="submitForm()"
								<?php echo (isset($_POST['tipoFrete']) && $_POST['tipoFrete'] == '40010') ? 'checked' : ''; ?>>
							SEDEX
							<?php echo ($valor_frete_sedex != '') ? " - " . $valor_frete_sedex : ''; ?>
						</div>
					</div>
					<div class="cartoptionbox">
						<h4 class="heading4">Calcular Frete</h4>
						<fieldset>
							<div class="control-group">
								<label class="control-label">Digita&ccedil;&atilde;o de
									CEP</label>

								<div class="controls">
									<input type="text" class="span3" name="cep" id="cep"
										value="<?php echo (isset($_POST['cep'])) ? $_POST['cep'] : ''; ?>"
										maxlength="9"> <input type="submit"
										class="btn btn-success" value="Calcular"
										onClick="return validaCep()">
								</div>
							</div>
						</fieldset>
					</div>
				</form>
				<?php } ?>
			</div>
		</section>
	</div>
	<!-- Footer Starts-->
	<?php require_once 'footer.inc.php'; ?>
	<!-- Footer Starts-->
	<?php require_once 'carrinho_modal.php'; ?>
	<!-- /maincontainer -->
	<!-- javascript    ================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
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
	<script type="text/javascript" src="js/jquery.maskedinput-1.3.js"></script>
	<script type="text/javascript">    
		$(window).load(function () {
	        $('#slider').nivoSlider();
	    });
    </script>
</body>
</html>