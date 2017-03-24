<?php
require_once 'wcm/config.php';
require_once 'wcm/model/bancodedados.class.php';
require_once 'wcm/model/produto.class.php';
include_once 'wcm/model/files.class.php';
require_once 'wcm/model/data.class.php';

$objBd = new BancodeDados();
$objProduto = new Produto();

$quantidadePorPagina = 10;
$orderBy = 'p.valor asc';

if (isset($_GET['pag'])) {
	$quantidadePorPagina = $_GET['pag'];
}

if (isset($_GET['order_by'])) {
	if ($_GET['order_by'] == 'preco_asc') {
		$orderBy = 'p.valor asc';
	} else if ($_GET['order_by'] == 'preco_desc') {
		$orderBy = 'p.valor desc';
	} else if ($_GET['order_by'] == 'nome_asc') {
		$orderBy = 'p.titulo asc';
	} else if ($_GET['order_by'] == 'nome_desc') {
		$orderBy = 'p.titulo desc';
	} else if ($_GET['order_by'] == 'marca_asc') {
		$orderBy = 'm.descricao asc';
	} else {
		$orderBy = 'p.titulo';
	}
}

$where = '';

if (isset($_GET['categoria'])) {
	$sql_produtos =
			"	select p.* " .
			"	from " .
			"		produto as p," .
			"		marca as m, " .
			"		categoria as c, " .
			"		produtocategoria as pc " .
			"where " .
			"	p.produtoId = pc.mProdutoId " .
			"and " .
			"	p.mMarcaId = m.marcaId " .
			"and " .
			"	pc.mCategoriaId = c.categoriaId " .
			"and " .
			"	c.descricao = '".$_GET['categoria']."' " .
			"and " .
			"	p.status = 1 " .
			"and " .
			"	p.quantidade > 0 ";
			
} else if (isset($_GET['subcategoriaId'])) {
	$sql_produtos =
			"	select p.* " .
			"	from " .
			"		produto as p, " .
			"		marca as m, " .
			"		subcategoria as s, " .
			"		produtocategoria as pc " .
			"where " .
			"	p.produtoId = pc.mProdutoId " .
			"and " .
			"	p.mMarcaId = m.marcaId " .
			"and " .
			"	pc.mSubcategoriaId = s.subcategoriaId " .
			"and " .
			"	s.descricao = '".$_GET['subcategoriaId']."' " .
			"and " .
			"	p.status = 1 " .
			"and " .
			"	p.quantidade > 0 ";
	//$sql_produtos = "select * from produto as p where p.status = 1 and p.quantidade > 0 and mSubcategoriaId = " . $_GET['subcategoriaId'];
	
} else {
	header("Location: index.php");
	exit();
}

if (isset($_POST['busca']) && $_POST['busca'] != 'Faça sua busca...') {
	$sql_produtos .= " and p.titulo like '%".$_POST['busca']."%' or p.descricao like '%".$_POST['busca']."%' ";
}

$sql_produtos .= " group by p.produtoId order by $orderBy ";
$result_produto_destaque = $objBd->executarSQL($sql_produtos);

/***********************************************
 * Query para trazer os produtos mais vendidos *
 ***********************************************/
$sql_vendas = "select
					max(cp.quantidade) as quantidade,
					p.produtoId,
					p.descricao,
					p.valor,		
					ct.descricao as descricaoCategoria
				from 
					venda as v
				left join carrinho  as c on v.mCarrinhoId = c.carrinhoId
				left join carrinhoproduto as cp on c.carrinhoId = cp.mCarrinhoId
				left join produto as p on cp.mProdutoId = p.produtoId
				left join subcategoria as s on s.subcategoriaId = p.mSubcategoriaId
				left join categoria as ct on ct.categoriaId = s.mCategoriaId		
				where
					v.status = 3
				group by cp.mProdutoId
				order by quantidade DESC
				limit 3";
$result_vendas = $objBd->executarSQL($sql_vendas);
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
        <li class="active">Categoria<span class="divider">/</span></li>
      
      </ul>
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
					<h1 class="headingfull"><span></span> </h1>
					<div class="sidewidt">
						<img alt="" src="images/adbanner2.jpg">
					</div>
				</aside>
			</div>
            <!--sidebar Ends-->
            <div class="span9">
          <!--<h1 class="productname">Oferta de Verão Melhor Produto</h1>-->
          <section id="latest">
            <div class="row">
              <div class="span9">
                <div class="sorting well">
                  <form class="form-inline pull-left" action="<?php echo $_SERVER['PHP_SELF'];?>" method="GET" id="formRelevancia">
                  	<?php
                  	if (isset($_GET['categoria'])) {
						echo '<input type="hidden" name="categoria" value="'.$_GET['categoria'].'" />';
					} else if (isset($_GET['subcategoriaId'])) {
						echo '<input type="hidden" name="subcategoriaId" value="'.$_GET['subcategoriaId'].'" />';
					}
                  	?>
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
                      <option value="10">10</option>
                      <option value="15">15</option>
                      <option value="20">20</option>
                      <option value="25">25</option>
                      <option value="30">30</option>
                    </select>
                  </form>
                </div>
                <section id="thumbnails">
                  <ul class="thumbnails grid" style="display: block;">
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
                    <ul>
                      <li><a href="#">Anterior</a>
                      </li>
                      <li class="active">
                        <a href="#">1</a>
                      </li>
                      <li><a href="#">2</a>
                      </li>
                      <li><a href="#">3</a>
                      </li>
                      <li><a href="#">4</a>
                      </li>
                      <li><a href="#">Pr&oacute;xima</a>
                      </li>
                    </ul>
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