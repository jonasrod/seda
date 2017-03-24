<?php
require_once 'wcm/config.php';
require_once 'wcm/model/bancodedados.class.php';
require_once 'wcm/model/produto.class.php';
require_once 'wcm/model/data.class.php';
include_once 'wcm/model/alerta.class.php';
include_once 'wcm/model/files.class.php';

if (isset($_SESSION['brw_logado'])) {
	header('Location: minha-conta.php?idCliente=' . $_SESSION['brw_idLogin']);
	exit();
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
						<img alt="" src="images/adbanner2.jpg">
					</div>
				</aside>
			</div>
            <!--sidebar Ends-->
            <div class="span9">
  <!-- Featured Product-->
  
  <section id="featured">
    <h1 class="productname">Login</h1>
    <p> Se você já possui uma conta conosco, por favor faça seu login na página de login.</p>
    
	  <section class="newcustomer">
            <h2 class="heading2">Novo Cliente </h2>
            <div class="loginbox">
              <h4 class="heading4"> Registrar Conta</h4>
              <p>Ao criar uma conta, você será capaz de comprar mais rápido, ser-se atualizado sobre o status de uma ordem, e acompanhar os pedidos que você já fez.</p>
              <br>
              <br>
              <a class="btn btn-success" href="registro.php">Continuar</a>
            </div>
          </section>
          <section class="returncustomer">
            <h2 class="heading2">Cliente </h2>
            <div class="loginbox">
              <h4 class="heading4">Eu sou um cliente antigo</h4>
              <p>
				<?php if (isset($_GET['st'])) { $objAlerta = new Alerta($_GET['st']); } ?> 
			  </p>
              <form class="form-vertical" action="<?php echo URL_SEGURA;?>login-controle.php?session=<?php echo session_id();?>" method="post">
                <fieldset>
                  <div class="control-group">
                    <label class="control-label">Email:</label>
                    <div class="controls">
                      <input type="text" class="span3" name="login">
                    </div>
                  </div>
                  <div class="control-group">
                    <label class="control-label">Senha:</label>
                    <div class="controls">
                      <input type="password" class="span3" name="senha">
                    </div>
                  </div>
                  <a href="recuperar-senha.php" class="">Esqueceu sua senha?</a>
                  <br>
                  <br>
                  <input type="hidden" name="action" value="autenticarUsuario" />
                  <input type="submit" class="btn btn-success" name="submit" value="Login" />
                </fieldset>
              </form>
            </div>
          </section>
	
	
    
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