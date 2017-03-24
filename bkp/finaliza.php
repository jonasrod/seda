<?php
require_once 'wcm/config.php';
require_once 'wcm/model/bancodedados.class.php';
require_once 'wcm/model/produto.class.php';
include_once 'wcm/model/files.class.php';
require_once 'wcm/model/data.class.php';

$objBd = new BancodeDados();
$objProduto = new Produto();

if (isset($_GET['id_pagseguro'])) { // pagamento feito pelo pagseguro
	require_once 'wcm/model/venda.class.php';
	
	$objVenda = new Venda();
	
	$dados = array('pagseguroId' => $_GET['id_pagseguro']);
	
	if( !$objBd->edit( 'venda', $dados, $_SESSION['pedido']['id'] ) )
    {
        $objBd->rollback();
    }
    
    $objBd->commit();
}

Data::enviaEmail($_SESSION['pedido']['numeroPedido']);
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
<?php require_once 'headxajax.inc.php';?>
<script src="js/jquery.js"></script>
<script type="text/javascript">
	
	function geraBoleto() {
		window.open('boleto/boleto_bradesco.php?numPedido=<?=$_SESSION['pedido']['numeroPedido'];?>');
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
      
      <section id="featured">
  
  
     <h2> Pedido Finalizado com sucesso! </h2>
  
    <div class="control-group">
                <label class="control-label"></label>
                <div class="controls">
                 
                 N&uacute;mero do Pedido
                 
                 <h1><?php echo $_SESSION['pedido']['numeroPedido'];?></h1>
				  <?php
				  if ($_SESSION['pedido']['formaPagamento'] == 'boleto') {?>
				  	  <br><br>
				  	  <a class="btn btn-success" href="javascript:geraBoleto();">Gerar Boleto</a>&nbsp;&nbsp;
				  	  <?php
				  } else if ($_SESSION['pedido']['formaPagamento'] == 'transferencia') {
				  	  ?>
				  	  <p>
				  	  	<strong>Dados para Transfer&ecirc;ncia/Dep&oacute;sito</strong><br />
				  	  	<strong>Agência:</strong> 3188<br />
				  	  	<strong>Conta Corrente:</strong> 18955-3<br />
				  	  	<strong>DIRCE DA SILVA CARDOSO - ME</strong><br />
				  	  	<strong>CNPJ:</strong> 019.380.699/0001-90<br />
				  	  	<strong>Valor: </strong><?=Data::formataMoeda($_SESSION['pedido']['valor_total'])?>
				  	  </p>
				  	  <br /><br />
				  	  <?php
				  } else {
				  	  echo '<br><br>';
				  }
				  ?>
				  <a class="btn btn-success" href="limpacarrinho.php">Continuar Comprando</a>
				  
				 <!-- <label class="radio">
                    <input type="radio" name="optionsRadios" id="optionsRadios2" value="option2">
                   <img src="images/cartao.png" > </img><br><br><br> As melhores bandeiras de Cartões de crédito </label>-->
                </div>
              </div>
  
  
  
  
	
	
         
  </section>
   
   
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
<script src="js/jquery.js"></script>
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
<script defer src="js/custom.js"></script><script>  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');  ga('create', 'UA-56982537-1', 'auto');  ga('send', 'pageview');</script>
<script type="text/javascript">
$(window).load(function () {
  $('#slider').nivoSlider();
});
</script>
</body>
</html>