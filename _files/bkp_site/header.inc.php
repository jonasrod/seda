<?php
require_once 'wcm/model/categoria.class.php';
require_once 'wcm/model/subcategoria.class.php';

$objCategoria = new Categoria();
$objBd = new BancodeDados();

$sql_categoria = "select * from categoria where status = 1"; // limita a 10 para nao estourar o menu
$result_categoria = $objBd->executarSQL($sql_categoria);

$menu = array();

foreach( $objCategoria->listarCategoriaComFiltro( $result_categoria ) as $categoria ) {
	$objSubcategoria = new Subcategoria();
	$sql_subcategoria = "select * from subcategoria where status = 1 and mCategoriaId = " . $categoria->getCategoriaId();
	$result_subcategoria = $objBd->executarSQL($sql_subcategoria);
	
	$menus[$categoria->getDescricao()] = array();
	
	foreach( $objSubcategoria->listarSubcategoriaComFiltro( $result_subcategoria ) as $subcategoria ) {
		$menus[$categoria->getDescricao()][] = array(
													 'subcategoriaId' => $subcategoria->getSubcategoriaId(),
													 'descricao' 	  => $subcategoria->getDescricao()
													 );
	}
}
?>
<header>
  <!-- Sticky Navbar Start -->
  <div id="main-nav" class="navbar navbar-fixed-top">
    <div class="container">
      <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      </button>
      <ul class="nav">
          <li><a href="#"><i class="icon-envelope"></i> contato@sedaerotica.com.br</a></li>
          <li><a href="#"><i class="icon-phone-sign"></i>  11 4751 5800</a></li>          
      </ul>
      <nav style="height:0px" class="nav-collapse collapse">
        <ul class="nav pull-right">
          <?php
          if (isset($_SESSION['brw_nome'])) {?>
	          <li><a>OL&Aacute;&nbsp;&nbsp;<?php echo strtoupper($_SESSION['brw_nome'])?></a></li>
	          <?php
          }?> 
          <li><a href="index.php">HOME</a></li>
          <li><a href="meus-pedidos.php">MEUS PEDIDOS</a></li>
		  <li><a href="fechamento-pedido.php">VER CARRINHO</a></li>
		  <?php
          if (!isset($_SESSION['brw_logado'])) {
          	  ?>      
              <li><a href="login-conta.php">LOGIN</a></li>
          	  <?php
          } else {
          	  ?>      
              <li><a href="login-controle.php?action=logout">SAIR</a></li>
          	  <?php
          }
          ?>
       </ul>
      </nav>
    </div>
  </div>
  <!--Sticky Navbar End -->
  
  <div class="header-white">
    <div class="container">
      <div class="row">
        <div class="span4"><img src="images/logo-prov.png" width="300" height="120"></div>
        <div class="span8">
		<br>
          <div class="row">
            <div class="pull-right logintext"><img src="images/logo2.png" ></a>  </div>
          </div>
		  <br>
         <form class="form-search marginnull topsearch pull-right" method="post" action="index.php">
          <div class="span6 pull-left">
          <button value="Search" class="btn btn-success pull-right search" type="submit">Busca</button>
			<input type="text" name="busca" class="span5 search-query search-icon-top pull-right" value="Fa&ccedil;a sua busca..." onFocus="if (this.value=='Fa&ccedil;a sua busca...') this.value='';" onBlur="if (this.value=='') this.value='Fa&ccedil;a sua busca...';">
		  </div>
          <div class="pull-right ml5"><a data-toggle="modal" href="#myModal" class="btn btn-info pull-right"><i class="icon-shopping-cart"></i> Carrinho (<?php echo (isset($_SESSION['carrinho'])) ? count($_SESSION['carrinho']) : '0' ;?>)</a></div>
          </form>
		  <br><br><br>
        </div>
      </div>
    </div>
    <!-- Navigation Start -->
    <div  id="categorymenu">
      <div class="container">
        <nav class="subnav">
          <ul class="nav-pills categorymenu">
          	<?php
          	foreach($menus as $menu => $submenus) {
	          	?>
	            <li><a href="categoria.php?categoria=<?=$menu?>"><?=$menu;?></a>
	            <?php
	            if (count($submenus) > 0) {
		            ?>
					<div>
		                <ul class="arrow">
		                  <?php
		                  foreach($submenus as $submenu) {
			                  ?>
			                  <li><a href="categoria.php?subcategoriaId=<?=$submenu['descricao'];?>"><?=$submenu['descricao'];?></a></li>
							  <?php
		                  }
						  ?>
		                </ul>
		            </div>
		            <?php
	            }
	            ?>
				</li>
				<?php
          	}
			?>
          </ul>
        </nav>
      </div>
    </div>
    <!-- Navigation Ends -->
  </div>
</header>