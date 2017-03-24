<?php
require_once 'wcm/config.php';
require_once 'wcm/model/bancodedados.class.php';
require_once 'wcm/model/produto.class.php';
include_once 'wcm/model/venda.class.php';
require_once 'wcm/model/data.class.php';
require_once 'calculo_carrinho.ajax.php';

if(!isset($_SESSION['brw_idLogin'])) {
	header('Location: login-conta.php');
	exit();
}

$objBd = new BancodeDados();
$objProduto = new Produto();
$objVenda = new Venda();

$sql = "select * from venda where mClienteId = " . $_SESSION['brw_idLogin'] . " order by dtCadastro desc";
$result = $objBd->executarSQL($sql);

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
<script type="text/javascript" src="js/jquery.maskedinput-1.3.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
	        
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
</script>
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
        <li><a href="index.php">Home</a><span class="divider">/</span></li>
        <li class="active">Meus Pedido</li>
      </ul>
      <h1 class="productname">Meus Pedidos</h1>
      <div class="cart-info">
        <table class="table table-striped table-bordered">
          <tbody><tr>
            <th width="14%" class="image">Data da Compra</th>
            <th width="21%" class="name">N&uacute;mero do Pedido</th>
            <th width="14%" class="model">Valor Total</th>
            <th width="12%" class="quantity">Valor Frete</th>
          </tr>
          <?php 
          foreach( $objVenda->listarComFiltro( $result ) as $venda ) { ?>
          
	          <tr>
	            <td class="image"><?php echo Data::formataDataHora($venda->getDtCadastro());?></td>
	            <td class="name"><a href="detalhe-pedido.php?vendaId=<?php echo $venda->getVendaId();?>"><?php echo $venda->getReferencia();?></a></td>
	            <td class="model">R$ <?php echo Data::formataMoeda($venda->getValorTotalProduto());?></td>
	            <td class="quantity">R$ <?php echo Data::formataMoeda($venda->getValorFrete());?></td>
	          </tr>
		      <?php
          }
		  ?>
		      
		        </tbody></table>
		      </div>
		  	  
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
<script type="text/javascript" src="js/jquery.maskedinput-1.3.js"></script><script>  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');  ga('create', 'UA-56982537-1', 'auto');  ga('send', 'pageview');</script>
<script type="text/javascript">
	$(window).load(function () {
	  $('#slider').nivoSlider();
	});
</script>
</body>
</html>