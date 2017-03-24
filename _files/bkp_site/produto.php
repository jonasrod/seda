<?php
require_once 'wcm/config.php';
require_once 'wcm/model/bancodedados.class.php';
require_once 'wcm/model/produto.class.php';
include_once 'wcm/model/files.class.php';
require_once 'wcm/model/data.class.php';

if (!isset($_GET['produtoId'])) {
	header('Location: index.php');
	exit();
}

$objBd = new BancodeDados();
$objProduto = new Produto();
$objProduto->obterProduto($_GET['produtoId']);

$sql_files = "select * from files where mProdutoId = " . $_GET['produtoId'];
$result_files = $objBd->executarSQL($sql_files); 

$objFiles = new Files();
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
<script type="text/javascript" src="js/jquery.validate.min.js"></script>
<script type="text/javascript" src="js/jquery.maskedinput-1.3.js"></script>
<script type="text/javascript">

	$(document).ready(function() {
		$("#quantidadeProduto").mask("9?99", {placeholder:" "});
	});

	function validaQuantidade(produtoId) {
		
		var quantidadeProduto = $("#quantidadeProduto").val();
		
		if(quantidadeProduto == '') {
			alert("Informe a quantidade do produto!");
			return false;
		} else {
			location.href="addcarrinho.php?acao=comprar&quantidadeProduto="+quantidadeProduto+"&produtoId=" + produtoId;
		}
	}
</script>
</head>
<body>
<!-- Header Start -->
<?php include("header.inc.php");?>
<!-- Header Ends -->
<!--Content starts-->
<div id="maincontainer">
  <section id="product">
    <div class="container">
      <ul class="breadcrumb">
        <li><a href="index.php">Home</a><span class="divider">/</span></li>
        <li class="active">Produto</li>
      </ul>
      <!-- Product Details-->
      <div class="row">
        <div class="span5">
          <ul class="thumbnails mainimage">
            <?php
            foreach( $objFiles->listarFileComFiltro( $result_files ) as $file ) {?>
	            <li class="span5">
	              <a  rel="position: 'inside' , showTitle: false, adjustX:-4, adjustY:-4" class="thumbnail cloud-zoom" href="produtos/fotos/<?php echo $objProduto->getProdutoId();?>/<?php echo $file->getName();?>">
	                <img alt="" src="produtos/fotos/<?php echo $objProduto->getProdutoId();?>/<?php echo $file->getName();?>">
	              </a>
	            </li>
	            <?php
            }
            ?>
          </ul>
          
          <ul class="thumbnails mainimage">
           <?php
           $result_files->data_seek(0);
           foreach( $objFiles->listarFileComFiltro( $result_files ) as $file ) {?>
	            <li class="producthtumb">
	              <a href="#"><span><span><img width="240" src="produtos/fotos/<?php echo $objProduto->getProdutoId();?>/<?php echo $file->getName();?>" alt=""></span></span> </a>
	            </li>
	           <?php
           }
           ?>
          </ul>
          
        </div>
        <div class="span7">
          <div class="row">
            <div class="span7">
              <h1 class="productname"><?php echo $objProduto->getTitulo();?></h1>
			   <p class="productname"><?php echo $objProduto->getDescricao();?></p><br><br>
              <div class="productprice">
              	<?php
              	if ($objProduto->getQuantidade() > 0) {
	              	if ($objProduto->getDesconto() != '' && $objProduto->getDesconto() != 0) {
		              	?>
		                <div class="proldprice">R$ <?php echo Data::formataMoeda($objProduto->getValorOriginal());?></div>
		                <?php
	              	}
	                ?>
	                <div class="prnewprice span2 margin-none">R$ <?php echo Data::formataMoeda($objProduto->getValor());?></div>
	                <!--<div class="pull-right"><span class="label label-success">Availability:</span> 30 items in stock</div>-->
	            	<?php
              	}
              	?>
              </div>
              <div class="quantitybox">
              <?php
	          	if ($objProduto->getQuantidade() == 0) {?>
	          		Indispon&iacute;vel
	          		<?php
	          	} else {?>
	              	<input type="text" id="quantidadeProduto" name="quantidadeProduto" class="span1 selectqty" placeholder="QTD." style="float:left">
	              	
	                <a class="btn btn-success pull-left" href="#" onClick="return validaQuantidade(<?php echo $objProduto->getProdutoId();?>)">Comprar</a>
	                <div class="links  productlinks">
	                  <a class="wishlist" href="addcarrinho.php?produtoId=<?php echo $objProduto->getProdutoId();?>">Add Carrinho</a>
	                  <a class="compare" href="compare.html">Compare</a>
	                </div>
                <?php 
            	}?>
              </div>
              <div class="productdesc">
                <ul class="nav nav-tabs" id="myTab">
                  <li class="active"><a href="#description">Informa&ccedil;&otilde;es do Produto</a></li>
                  <li><a href="#specification">Informa&ccedil;&otilde;es T&eacute;cnicas</a></li>
                </ul>
                <div class="tab-content">
                  <div class="tab-pane active" id="description">
                    <?php
                    if ($objProduto->getTamanho() != '') {
                    	echo "TAMANHO: " . $objProduto->getTamanho() . '<br /><br />';
                    }
                     
                    echo stripcslashes($objProduto->getInformacao());
                    ?>
                  </div>
                  <div class="tab-pane " id="specification">
                  	<?=stripcslashes($objProduto->getInfotecnica())?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Product Description tab & comments-->
      
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