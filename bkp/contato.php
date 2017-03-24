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
<?php require_once 'headxajax.inc.php';?>
<script src="js/jquery.js"></script>
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
          <a href="index.php">Home</a>
          <span class="divider">/</span>
        </li>
        <li class="active">Contato</li>
      </ul>
		<div class="row">
        	<!--Sidebar Starts-->
            
			<div class="span3">
				<aside>
					<?php require_once 'menu_lateral.inc.php'; ?>
				</aside>
				<aside>
       			    <?php include_once 'mais_vendidos.inc.php'; ?>
                </aside>
				<aside>
					<h1 class="headingfull"><span></span> </h1>
					<div class="sidewidt">
						<img alt="" src="images/adbanner2.jpg">
					</div>
				</aside>
			</div>
            <!--sidebar Ends-->
            <div class="span9">
  <!-- Featured Product-->
  
  <section id="featured">
  
  <h1> FORMULÁRIO DE CONTATO   </h1>
  
  
<?php echo isset($_SESSION['contato']['sucesso']) ? $_SESSION['contato']['sucesso'] : "";?>
<form name="formulario" method="post" action="contato_c.php">
<div align="left"></div>
<table width="401" border="0" cellspacing="0" cellpadding="0" align="left"><!--DWLayoutTable-->
<tr >
<td valign="middle" width="100" nowrap>
<p><font class="texto" color="#999999">Nome:</font></p>
</td>
<td width="301">
<input class="form_campos" type="text" name="nome" size="34">
</td>
</tr>

<tr >
<td valign="middle" nowrap><p><font class="texto">Email:</font></p></td>
<td>
<input class="form_campos" type="text" name="email" size="34">
</td>
</tr>
<tr >
<td valign="middle" nowrap><p><font class="texto">Departamento:</font></p></td>
<td>
	<select name="departamento" class="form_campos">
		<option value="contato@sedaerotica.com.br">Compras</option>
		<option value="contato@sedaerotica.com.br">Marketing</option>
		<option value="contato@sedaerotica.com.br">Sac</option>
		<option value="contato@sedaerotica.com.br">Vendas</option>
	</select>
</td>
</tr>
<!--<tr bgcolor="#fff">
<td valign="middle" nowrap><font class="texto">Assunto:</font></td>
<td>
<select class="form_campos" name="assunto_mensagem">
<option value="Opini&atilde;o" selected>Opini&atilde;o</option>
<option value="Sugestão">Sugestão</option>
<option value="Parceria">Parceria</option>
<option value="Reclama&ccedil;&atilde;o">Reclama&ccedil;&atilde;o</option>
<option value="Sem assunto">Outros</option>
</select>
</td>
</tr>--><br>
<tr >
<td valign="middle" nowrap ><p><font class="texto">Mensagem:</font></p></td>
<td>
<textarea class="form_campos" name="texto" cols="27" rows="4"></textarea>
</td>
</tr>
<tr >
<td colspan="2" valign="middle">
<!-- <font class="texto">* campos obrigat�rios</font> -->
<br>
<div align="center">
<input class="form_botao" type="submit" name="Enviar" value="Enviar ">
<input class="form_botao" type="reset" name="Limpar" value="Limpar">
</div>
</td>
</tr>
<tr>
<td></td>
<td></td>
</tr>
</table>
</form>
  
   
    
	 
	
	
    
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