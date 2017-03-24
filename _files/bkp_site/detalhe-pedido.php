<?php
require_once 'wcm/config.php';
require_once 'wcm/model/bancodedados.class.php';
require_once 'wcm/model/produto.class.php';
require_once 'wcm/model/venda.class.php';
require_once 'wcm/model/carrinhoproduto.class.php';
include_once 'wcm/model/files.class.php';
require_once 'wcm/model/data.class.php';
require_once 'calculo_carrinho.ajax.php';

if(!isset($_SESSION['brw_idLogin'])) {
	$_SESSION['fechamento']['redirecionamento'] = 'fechamento-pedido.php';
	header('Location: login-conta.php');
	exit();
}

$objBd = new BancodeDados();
$objProduto = new Produto();
$objVenda = new Venda();
$objCarrinhoProduto = new Carrinhoproduto();

if (isset($_GET['vendaId'])) {
	
	$objVenda->obterVenda($_GET['vendaId']);
	
	$sql_in = "select mProdutoId from carrinhoproduto where mCarrinhoId = " . $objVenda->getCarrinhoId()->getCarrinhoId();
	
	$sql_produtos_carrinho = "select * from produto where produtoId in ($sql_in)";
	$result_produto_carrinho = $objBd->executarSQL($sql_produtos_carrinho);
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
<!-- Inline CSS 
================================================== -->
<style>
.thumbnails{
	margin-left:6px;
}
.thumbnails > li {
    float: left;
    margin-bottom: 20px;
    margin-right: 4px;
	margin-left:4px;
}
</style>
<?php  
 /*** print the javasript ***/  
 $xajax->printJavascript();
?>
<script src="js/jquery.js"></script>
</head>
<body>
<!-- Header Start -->
<?php include("header.inc.php");?>
<!-- Header Ends -->
<!--Content starts-->
<div id="maincontainer">
	<section id="checkout">
    <div class="container">
      <ul class="breadcrumb">
        <li><a href="#">Home</a><span class="divider">/</span></li>
        <li class="active">Pedido</li>
      </ul>
      <h1 class="productname">Detalhe do Pedido <?=$objVenda->getReferencia()?></h1>
      <div class="cart-info">
        <table class="table table-striped table-bordered">
          <tbody><tr>
            <th width="14%" class="image">Imagem</th>
            <th width="21%" class="name">Produto</th>
            <th width="14%" class="model">C&oacute;digo</th>
            <th width="12%" class="quantity">Quantidade</th>
            <th width="15%" class="price">Pre&ccedil;o Unit&aacute;rio</th>
            <th width="13%" class="total">Total</th>
          </tr>
          <?php
          if (isset($result_produto_carrinho)) {
	          $valor_total_carrinho = 0;
			  $valor_total_itam     = 0;
	          foreach($objProduto->listarCategoriaComFiltro( $result_produto_carrinho ) as $produto) {
	          		
	          		$objFile = new Files();
        			$objFile->obtemImagemPrincipal($produto->getProdutoId());
	          		
	          		$sql_qtd = "select quantidade from carrinhoproduto where mCarrinhoId = ".$objVenda->getCarrinhoId()->getCarrinhoId().
	          					" and mProdutoId = " . $produto->getProdutoId();
					$result_qtd = $objBd->executarSQL($sql_qtd);
					
					$row = $result_qtd->fetch_array();
	          		
		        	$valor_total_item = $produto->getValor() * $row['quantidade'];
		        	
		        	$valor_total_carrinho = $valor_total_carrinho + $valor_total_item;
		          ?>
		          <tr>
		            <td class="image"><a href="produto.php?produtoId=<?php echo $produto->getProdutoId();?>"><img width="50" height="50" src="produtos/fotos/<?php echo $produto->getProdutoId();?>/thumbnail/<?php echo $objFile->getName();?>"></a></td>
		            <td class="name"><a href="produto.php?produtoId=<?php echo $produto->getProdutoId();?>"><?php echo $produto->getTitulo();?></a></td>
		            <td class="model"><?php echo $produto->getCodigoProduto();?></td>
		            <td class="quantity"><?=$row['quantidade'];?></td>
		            <td class="price">R$<?php echo Data::formataMoeda($produto->getValor());?></td>
		            <td class="total" id="valorTotalProduto<?php echo $produto->getProdutoId();?>">R$<?php echo Data::formataMoeda($valor_total_item);?></td>
		          </tr>
		     	  <?php
		      }
		      
		      ?>
		      </tbody></table>
		      </div>
		      <div class="row">
		        <div class="pull-right">
		          <div class="span4 pull-right">
		            <table class="table table-striped table-bordered ">
		              <tbody>
		              <tr>
		                <td><span class="extra bold totalamout">Total :</span></td>
		                <td><span class="bold totalamout" id="valorTotalCarrinho">R$ <?php echo Data::formataMoeda($valor_total_carrinho);?></span></td>
		              </tr>
		            </tbody></table><br>
		          </div>
		        </div>
		      </div>
			  <br><br>
		  	  <?php
          }
          ?>
    </div>
  </section>
</div>
<!-- Footer Starts-->
<?php require_once 'footer.inc.php';?>
<!-- Footer Starts-->
<?php require_once 'carrinho_modal.php';?>
<!-- /maincontainer -->

<!-- javascript
    ================================================== -->
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