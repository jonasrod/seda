<?php
require_once 'wcm/config.php';
require_once 'wcm/model/bancodedados.class.php';
require_once 'wcm/model/endereco.class.php';
require_once 'wcm/model/data.class.php';
include_once 'wcm/model/alerta.class.php';

$objBd = new BancodeDados();
$objEndereco = new Endereco();

$objEndereco->obterEnderecoPorCliente($_SESSION['brw_idLogin']);

if (isset($_GET['tipoFrete'])) 
{
	$tipoFrete = array('41106' => 'PAC', '40010' => 'SEDEX');
	$_SESSION['tipoFrete'] = $tipoFrete[$_GET['tipoFrete']];
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
<?php require_once 'headxajax.inc.php';?>
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
      
      <section id="featured">
  
  
     <h2> Confirme o edere&ccedil;o de Entrega </h2>
     <p>
	   <?php if (isset($_GET['st'])) { $objAlerta = new Alerta($_GET['st']); } ?> 
	 </p>
  <form action="forma-pagamento-controle.php?session=<?php echo session_id();?>" method="post">
    <div class="control-group">
	
                <label class="control-label"></label>
                <div class="controls">
				  <?php
				  	if (Data::formataCep($objEndereco->getCep()) != $_GET['cep']) {
				  		echo "<font color='red'>Aten&ccedil;&atilde;o! o CEP <strong>".$_GET['cep']."</strong>, " .
				  				"utilizado para c&aacute;lculo do frete &eacute; diferente do cadastrado.<br />" .
				  				"Caso deseje alterar o endereço, utilize a opção \"Alterar Endereço\" abaixo.</font><br /><br /><br />";
				  	}
				    
				  	$complemento = $objEndereco->getComplemento();
					if (empty($complemento)) {
						$complemento = '';
					} else {
						$complemento = ' - ' . $objEndereco->getComplemento();
					}
					
					echo $objEndereco->getEndereco() . $complemento . '<br>';
					echo $objEndereco->getBairro() . ' - CEP ' . Data::formataCep($objEndereco->getCep()) . '<br>';
					echo $objEndereco->getCidade() . ' - ' . $objEndereco->getEstado();
				  ?>
                  
				  <br><br><br><br><br><br>
				  
				  <a href="<?php echo URL_SEGURA;?>registro.php?session=<?php echo session_id();?>&location=forma-pagamento&clienteId=<?=$_SESSION['brw_idLogin']?>" class="btn btn-default pull-left" />Alterar Endere&ccedil;o</a>&nbsp;&nbsp;
				  <a href="<?php echo URL_SEGURA;?>forma-pagamento.php?session=<?php echo session_id();?>" class="btn btn-success pull-left" />Continuar</a>
				  
                </div>
                
              </div>
              
  
  
  </form>
  
	
	
         
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