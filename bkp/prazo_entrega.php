<?php
require_once 'wcm/config.php';
require_once 'wcm/model/bancodedados.class.php';
require_once 'wcm/model/produto.class.php';
include_once 'wcm/model/files.class.php';
require_once 'wcm/model/data.class.php';
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
</head>
<body>
<!-- Header Start -->
<?php include("header.inc.php");?>
<!-- Header Ends -->
<!--Content starts-->
<div id="maincontainer">
	<div class="container">
		<div class="row">
        	<!--Sidebar Starts-->
			<div class="span3">
				<aside>
					<h1 class="headingfull"><span>Institucional</span></h1>
					<?php require_once 'menu_lateral.inc.php'; ?>
				</aside>
				<aside>
       			  <?php include_once 'mais_vendidos.inc.php'; ?>
                </aside>
				<aside>
					<h1 class="headingfull"><span>Informa&ccedil;&otilde;es &Uacute;teis</span> </h1>
					<?php require_once 'informacoes_uteis.inc.php'; ?>
						
					<!--<div class="sidewidt">
						<img alt="" src="images/adbanner2.jpg">
					</div>-->
				</aside>
			</div>
            <!--sidebar Ends-->
            <div class="span9">
  <!-- Featured Product-->
  <section id="featured">
    <h1 class="headingfull"><span>PRAZO DE ENTREGA</span></h1>
    <div class="sidewidt" style="padding: 20px; text-align: justify;"><br />
Após a confirmação de pagamento, que leva em média 1 a 3 dias úteis, o pedido será separado para envio. Portanto o prazo de entrega começa a contar a partir da confirmação de pagamento.<br /><br />
O envio dos pedidos será através de SEDEX (1 a 2 dias úteis) ou PAC ( 4 a 10 dias úteis).<br /><br /> 
O endereço de entrega fornecido pelo comprador deverá ser dentro do território nacional, em local atendido pelos serviços dos Correios e transportadoras.<br />
Caso a embalagem esteja danificada ou violada não aceite a entrega da sua mercadoria. Receberemos de volta a mercadoria danificada e neste caso, providenciaremos uma nova entrega.
<br /><br />
Clique no botão <a href="rastreamento.php">RASTREAR PEDIDO</a> para acompanhar status e o envio do seu pedido.

<br />&nbsp;
    </div>
  </section>
</div>
<div class="span12">
  <div class="brandwidt">
    <a class="margin-none span2"><img src="images/bandeira/pagseguro.jpg"></a>
    <a class="span2"><img src="images/bandeira/bradesco.jpg"></a>
    <a class="span2"><img src="images/bandeira/boleto.jpg"></a>
    <a class="span2"><img src="images/bandeira/pac.jpg"></a>
    <a  class="span2"><img src="images/bandeira/sedex.jpg"></a>
    <a class="span2"><img src="images/bandeira/certisign.jpg"></a>
  </div>
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