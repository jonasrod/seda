<?php
require_once 'wcm/config.php';
require_once 'wcm/model/bancodedados.class.php';
require_once 'wcm/model/produto.class.php';
include_once 'wcm/model/files.class.php';
require_once 'wcm/model/data.class.php';
require_once 'wcm/model/banner.class.php';

$objBd = new BancodeDados();
$objProduto = new Produto();
$objBanner = new Banner();

$sql_produtos_destaque = "select * from produto where destaque = 1 and status = 1 and quantidade > 0 ";

if (isset($_POST['busca']) && $_POST['busca'] != 'Faça sua busca...') {
	$sql_produtos_destaque .= " and (titulo like '%".$_POST['busca']."%' or descricao like '%".$_POST['busca']."%')";
}
$sql_produtos_destaque .= " order by titulo asc ";

$result_produto_destaque = $objBd->executarSQL($sql_produtos_destaque);
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
	<!--Slider Starts-->
	<section class="slider">
		<div class="container">
			<div class="slider-wrapper theme-default">
				<div id="slider" class="nivoSlider">
					<?php
					foreach ($objBanner->listarBanners() as $banner) {
						echo '<img src="banner/'.$banner->getName().'" data-thumb="banner/'.$banner->getName().'" alt="" />';
					} 
					?>
					<!--  
					<img src="images/banner1.jpg" data-thumb="images/banner1.jpg" alt="" />
					<img src="images/banner2.jpg" data-thumb="images/banner2.jpg" alt="" />
					<img src="images/banner3.jpg" data-thumb="images/banner3.jpg" alt="" data-transition="slideInLeft" />
					-->
				</div>
				<div id="htmlcaption" class="nivo-html-caption"> <strong>This</strong> is an example of a <em>HTML</em> caption with
					<a href="#">a link</a>
                </div>
			</div>
		</div>
	</section>
    <!--Slider Ends-->
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
    <h1 class="headingfull"><span>Linha de Produtos</span></h1>
    <div class="sidewidt">
      <ul class="thumbnails">
        <?php
        foreach( $objProduto->listarCategoriaComFiltro( $result_produto_destaque ) as $produto ) {
        	$objFile = new Files();
        	$objFile->obtemImagemPrincipal($produto->getProdutoId());
        ?>
        <li class="span3">	
          <a class="prdocutname" href="produto.php?produtoId=<?php echo $produto->getProdutoId();?>"><?php echo $produto->getTitulo();?></a>
          <div class="thumbnail">	
            <!--<span class="sale tooltip-test" data-original-title=""></span>-->
            <a href="produto.php?produtoId=<?php echo $produto->getProdutoId();?>"><span><span><img alt="" src="produtos/fotos/<?php echo $produto->getProdutoId();?>/<?php echo $objFile->getName();?>" width="240"></span></span> </a>
            <div class="caption">
			<p> <?php echo $produto->getDescricao() . ' - ' . $produto->getCodigoProduto();?></p>
			<?php
          	if ($produto->getQuantidade() == 0) {?>
          		Indispon&iacute;vel
          	<?php
          	} else {?>
              <div class="price pull-left">	
                <span class="oldprice"><?php echo ($produto->getDesconto() != '' && $produto->getDesconto() != 0) ? 'R$ ' . Data::formataMoeda($produto->getValorOriginal()) : '&nbsp;';?></span>
                <span class="newprice">R$ <?php echo Data::formataMoeda($produto->getValor());?></span>
              </div>	
              <a class="btn pull-right" href="produto.php?produtoId=<?php echo $produto->getProdutoId();?>">Comprar</a>
              <div class="clearfix"></div>
              <table class="table table-striped">
                <tbody>
                  <tr>
                    <td>
                      <span class="links pull-left">
                      	<?php
                      	if ($produto->getQuantidade() == 0) {?>
          					Indispon&iacute;vel
          					<?php
                      	} else {?>
                        <a href="produto.php?produtoId=<?php echo $produto->getProdutoId();?>" class="info">Saiba mais</a>
                        <a href="addcarrinho.php?produtoId=<?php echo $produto->getProdutoId();?>" class="wishlist">Add Carrinho</a>
                        <a href="compare.html" class="compare">Compare</a>
                        <?php
                      	}
                      	?>
                      </span>
                    </td>
                  </tr>
                </tbody>
              </table>
              <?php 
            }?>
            </div>
          </div>
        </li>
        <?php
        }
        ?>
      </ul>
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