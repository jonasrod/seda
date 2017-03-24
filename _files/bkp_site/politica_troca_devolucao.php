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
    <h1 class="headingfull"><span>TROCAS E DEVOLU&Ccedil;&Otilde;ES</span></h1>
    <div class="sidewidt" style="padding: 20px; text-align: justify;"><br />
<strong>Na Seda Erótica, a satisfação do cliente está acima de tudo.</strong>
<br /><br />
Em qualquer um dos casos abaixo, entre em contato conosco logo após o recebimento do seu pedido através do e-mail contato@sedaerotica.com.br, nos informando se deseja efetuar a troca ou a devolução, com nome do comprador, nome do produto, número da Nota Fiscal e nos esclareça o motivo. Após você deverá enviar o produto por encomenda normal ou sedex convencional diretamente para o endereço:
<br />
<strong>Estrada do Baruel, 2.840, Baruel – Suzano – SP – CEP 08653-300</strong>  
<br /><br />
<strong>• Troca por Defeito de Fabricação.</strong><br />
Em caso de produtos com defeito, o prazo máximo é de 30 dias, contados a partir da data do recebimento do mesmo.
<br /><br />
O produto passará por nosso controle de qualidade e sendo constatado o defeito de fabricação, providenciaremos o envio de um novo produto sem custos adicionais.
<br /><br />
Não haverá troca se, por exemplo, houver indício de mau uso, lavagem inadequada, desgaste devido ao uso ou dano acidental.
<br /><br />
Quando for nos reenviar o produto, embale-o corretamente para que o mesmo não sofra nenhum dano causado pela falta de proteção. Se o produto sofrer algum dano no reenvio, não trocaremos.
<br /><br />
Coloque dentro da caixa o número do seu pedido e se possível uma forma de contato (telefone ou e-mail) para entrarmos em contato assim que recebermos sua encomenda.
<br /><br />
No caso de vestuário é necessário que a embalagem seja a original e possua a etiqueta do fabricante. Se houver vestígios de que o produto foi utilizado não efetuaremos a troca.
<br /><br />
<strong>• Troca por Desistência ou Devolução</strong><br />
Você terá até 7 dias, a partir do recebimento do produto, para devolvê-lo. Para isso, ele deve ser devolvido em sua embalagem original, sem uso e acompanhado de seus acessórios, etiquetas e nota fiscal. Se preferir trocar o produto por outro, a troca poderá ser feita por um produto de valor igual ou superior ao adquirido, caso haja diferença no preço, o cliente deverá providenciar a diferença no pagamento.
<br /><br />
Neste caso o cliente é responsável pelas despesas de envio de retorno e pode optar pela forma que mais lhe convier.

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
<script defer src="js/custom.js"></script>
<script type="text/javascript">
$(window).load(function () {
  $('#slider').nivoSlider();
});
</script>
</body>
</html>