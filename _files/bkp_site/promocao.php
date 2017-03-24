<?php
require_once 'wcm/config.php';
require_once 'wcm/model/bancodedados.class.php';
require_once 'wcm/model/produto.class.php';
include_once 'wcm/model/files.class.php';
require_once 'wcm/model/data.class.php';
require_once 'wcm/model/paginacao.class.php';

$objBd = new BancodeDados();
$objProduto = new Produto();

$quantidadePorPagina = 10;
$orderBy = 'p.dtCadastro desc';

if (isset($_GET['pag'])) {
	$quantidadePorPagina = $_GET['pag'];
}

if (isset($_GET['order_by'])) {
	
	if ($_GET['order_by'] == 'preco_asc') {
		$orderBy = 'p.valor, p.dtCadastro asc';
	} else if ($_GET['order_by'] == 'preco_desc') {
		$orderBy = 'p.valor, p.dtCadastro desc';
	} else if ($_GET['order_by'] == 'nome_asc') {
		$orderBy = 'p.titulo, p.dtCadastro asc';
	} else if ($_GET['order_by'] == 'nome_desc') {
		$orderBy = 'p.titulo, p.dtCadastro desc';
	} else if ($_GET['order_by'] == 'nome_desc') {
		$orderBy = 'm.descricao, p.dtCadastro asc';
	} else {
		$orderBy = 'p.dtCadastro desc';
	}
}

$objPaginacao = new Paginacao($objProduto->listarProdutoPromocao(), $quantidadePorPagina);
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
<script type="text/javascript">
	function submit() {
		document.getElementById('formRelevancia').submit();
	}
</script>
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
    <ul class="breadcrumb">
        <li><a href="index.php">Home</a><span class="divider">/</span></li>
        <li><a href="promocao.php">Promo&ccedil;&atilde;o</a><span class="divider">/</span></li>
      
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
          <h1 class="productname">Promo&ccedil;&otilde;es</h1>
          <section id="latest">
            <div class="row">
              <div class="span9">
                <div class="sorting well">
                  <form class="form-inline pull-left" action="<?php echo $_SERVER['PHP_SELF'];?>" method="GET" id="formRelevancia">
                    Classificar por :
                    <select class="span2" name="order_by" id="relevancia" onChange="submit()">
                      <option value="preco_asc">Menor Preço</option>
                      <option value="preco_desc">Maior Preço</option>
                      <option value="nome_asc">Nome Crescente</option>
                      <option value="nome_desc">Nome Decrescente</option>
                      <option value="marca_asc">Marca</option>
                    </select>
                    &nbsp;&nbsp;
                    Visualizar:
                    <select class="span1" name="pag" id="pag" onChange="submit()">
                      <option value="10" <?php echo (isset($_GET['pag']) && $_GET['pag'] == '10') ? 'selected' : '';?>>10</option>
                      <option value="15" <?php echo (isset($_GET['pag']) && $_GET['pag'] == '15') ? 'selected' : '';?>>15</option>
                      <option value="20" <?php echo (isset($_GET['pag']) && $_GET['pag'] == '20') ? 'selected' : '';?>>20</option>
                      <option value="25" <?php echo (isset($_GET['pag']) && $_GET['pag'] == '25') ? 'selected' : '';?>>25</option>
                      <option value="30" <?php echo (isset($_GET['pag']) && $_GET['pag'] == '30') ? 'selected' : '';?>>30</option>
                    </select>
                  </form>
                 <!-- <div class="btn-group pull-right">
                    <button id="list" class="btn"><i class="icon-th-list"></i>
                    </button>
                    <button id="grid" class="btn btn-success"><i class="icon-th icon-white"></i></button>
                  </div>-->
                </div>
                <section id="thumbnails">
                  <ul class="thumbnails grid" style="display: block;">
                  
					<?php
			        foreach( $objProduto->listarProdutoPromocao($objPaginacao, $orderBy) as $produto ) {
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
				                        <a href="produto.php?produtoId=<?php echo $produto->getProdutoId();?>" class="info">Saiba mais</a>
				                        <a href="addcarrinho.php?produtoId=<?php echo $produto->getProdutoId();?>" class="wishlist">Add Carrinho</a>
				                        <a href="compare.html" class="compare">Compare</a>
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
                
                  <div class="pagination pull-right">
                  <?php echo $objPaginacao->drawPaginacao();?>
                  </div>
                </section>
              </div>
            </div>
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
<script defer src="js/custom.js"></script>
<script type="text/javascript">
$(window).load(function () {
  $('#slider').nivoSlider();
});
</script>
</body>
</html>