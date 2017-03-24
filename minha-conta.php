<?php
require_once 'wcm/config.php';
require_once 'wcm/model/bancodedados.class.php';
require_once 'wcm/model/cliente.class.php';


if(!isset($_SESSION['brw_idLogin']) || (isset($_SESSION['brw_idLogin']) && $_SESSION['brw_idLogin'] == 0)) {
	header('Location: login-conta.php');
	exit();
}

$objBd = new BancodeDados();
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
<?php
if (isset($_GET['action']) && $_GET['action'] == 'boleto') {
	
	echo "window.open('boleto/boleto_bradesco.php');";
	
}
?>
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
    <h2>Minha Conta </h2>
	 <div class="span3 aboutus">
          <a href="registro.php?clienteId=<?=$_SESSION['brw_idLogin']?>">
          <ul>       
          <li ><img src="images/gotop.png"> </img>Cadastro</li>
         <p>Cadastre sua conta </p>
          </ul>
          </a>
     </div>
	 
	  <div class="span3 aboutus">
          <a href="contato.php">
          <ul>       
          <li ><img src="images/gotop.png"> </img>Linha direta</li>
         <p>Canal de duvidas </p>
          </ul>
          </a>
     </div>
	 
     
     <div class="span3 aboutus">
          <a href="login-controle.php?action=logout">
          <ul>
          <li ><img src="images/gotop.png"> </img>Sair</li>
         <p>Encerrar sessão</p>
          </ul>
          </a>
     </div>
	 
	 <br><br><br><br> <br><br><br><br> 
	 
	 <div class="span3 aboutus">
          <a href="rastreamento.php">
          <ul>       
          <li ><img src="images/gotop.png"> </img>Rastreamento</li>
         <p>Rastrear o pedido </p>
          </ul>
          </a>
     </div>
	 
	 <div class="span3 aboutus">
          <a href="meus-pedidos.php">
          <ul>       
          <li ><img src="images/gotop.png"> </img>Todos os pedidos</li>
         <p>Lista pedidos </p>
          </ul>
          </a>
     </div>
	 
	 <div class="span3 aboutus">
          <a href="segunda-via-boleto.php">
          <ul>       
          <li ><img src="images/gotop.png"> </img>Solicitar Boleto</li>
         <p>Imprimir copias de boleto </p>
          </ul>
          </a>
     </div>
	 
 <br><br><br><br> <br><br><br><br> 
	
	
         
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