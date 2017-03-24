<?php
include_once '../model/login.class.php';

$objLogin = new Login();
$objLogin->obterLogin( $_SESSION['wcm']['brw_idLogin'] );

function compararPaginas( $pagina1, $pagina2 )
{
	$valor1 = explode("-", $pagina1);
	$valor2 = explode("-", $pagina2);
	
	if( $valor1[0] == $valor2[0] )
		return true;
	else
		return false;
}

?>
<div id="in-nav" class="noPrint">
  <div class="container">
  
    <div class="row">
      <div class="span12">
      	<a id="logo" href="index.php"><strong>SEDA ER&Oacute;TICA</strong></a>
        <ul class="pull-right">
          <li><a href="logout.php">Sair</a></li>
        </ul>
      </div>
    </div>
  </div>
</div>
<div id="in-sub-nav" class="noPrint">
  <div class="container">
    <div class="row">
      <div class="span12">
        <ul class="menu">
          <li><a href="index.php" <?php if( compararPaginas( $pagina, 'home' ) ) { echo 'class="active"'; } ?>>
          <i class="batch home"></i><br>Home</a></li>
          <li><a href="index.php?p=categoria-lista" <?php if( compararPaginas( $pagina, 'categoria' ) ) { echo 'class="active"'; } ?>>
          <i class="batch forms"></i><br>Categorias</a></li>
          <li><a href="index.php?p=subcategoria-lista" <?php if( compararPaginas( $pagina, 'subcategoria' ) ) { echo 'class="active"'; } ?>>
          <i class="batch forms"></i><br>Subcategorias</a></li>
          <li><a href="index.php?p=produto-lista" <?php if( compararPaginas( $pagina, 'produto' ) ) { echo 'class="active"'; } ?>>
          <i class="batch forms"></i><br>Produtos</a></li>
          <li><a href="index.php?p=marca-lista" <?php if( compararPaginas( $pagina, 'marca' ) ) { echo 'class="active"'; } ?>>
          <i class="batch forms"></i><br>Marcas</a></li>
          <li><a href="index.php?p=cliente-lista" <?php if( compararPaginas( $pagina, 'cliente' ) ) { echo 'class="active"'; } ?>>
          <i class="batch forms"></i><br>Clientes</a></li>
          <li><a href="index.php?p=venda-lista" <?php if( compararPaginas( $pagina, 'venda' ) ) { echo 'class="active"'; } ?>>
          <i class="batch forms"></i><br>Registro Vendas</a></li>
          <li><a href="index.php?p=historico-venda" <?php if( compararPaginas( $pagina, 'historico' ) ) { echo 'class="active"'; } ?>>
          <i class="batch forms"></i><br>Hist&oacute;rico de Vendas</a></li>
          <li><a href="index.php?p=email-lista" <?php if( compararPaginas( $pagina, 'email' ) ) { echo 'class="active"'; } ?>>
          <i class="batch forms"></i><br>E-mails</a></li>
<!--          
          <li><a href="index.php?p=turma-lista" <?php if( compararPaginas( $pagina, 'turma' ) ) { echo 'class="active"'; } ?>>
          <i class="batch plane"></i><br>Turmas</a></li>
          <li><a href="index.php?p=laboratorio-lista" <?php if( compararPaginas( $pagina, 'laboratorio' ) ) { echo 'class="active"'; } ?>><i class="batch quill"></i><br>Laborat&oacute;rios</a></li>
          <li><a href="#"><i class="batch forms"></i><br>Relat&oacute;rios</a></li>
          <li><a href="index.php?p=funcionario-lista" <?php if( compararPaginas( $pagina, 'funcionario' ) ) { echo 'class="active"'; } ?>><i class="batch users"></i><br>Funcion&aacute;rios</a></li>
          <li><a href="#"><i class="batch settings"></i><br>Configura&ccedil;&otilde;es</a></li>
          -->
        </ul>
      </div>
    </div>
  </div>
</div>