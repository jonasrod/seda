<?php

include_once '../model/produto.class.php';
include_once '../model/subcategoria.class.php';
include_once '../model/data.class.php';
include_once '../model/bancodedados.class.php';
include_once '../model/alerta.class.php';

$objData = new Data();

$objProduto = new Produto();
$objBd = new BancodeDados();

$sql  = 'select * ';
$sql .= 'from produto ';
$sql .= 'order by titulo';

if( isset( $_POST['busca'] ) )
{
	
	if( $_POST['busca'] == 'produto' )
	{
		if( !empty( $_POST['produto'] ) )
		{
			$sql  = 'select * ';
			$sql .= 'from produto ';
			$sql .= 'where descricao like "%'. $_POST['produto'] .'%" ';
		}
	}
}

$result = $objBd->executarSQL($sql);

?>
<style>
.btn{

}
</style>
<div class="span12">
<?php if (isset($_GET['st'])) { $objAlerta = new Alerta($_GET['st']); } ?> 
</div>
<div class="span12">
<h4 class="header">
	Produtos 
	<a href="index.php?p=produto-form" class="btn btn-small btn-success btn-form">Cadastrar produto</a>
	<a href="index.php?p=planilha-form" class="btn btn-small btn-success btn-form">Incluir Planilha</a>
</h4>
<div class="row-fluid ">
  
  <div class="span6 ">
  	<div class="row-fluid">
    
    	<div class="span6">
        <form id="form1" name="form1" method="post" action="index.php?p=produto-lista">
        <input type="hidden" name="busca" value="produto" />
        <fieldset>
        
            <label for="matricula">Produto</label>
            <input type="text" name="produto" id="produto" value=""  />
            <input type="submit" name="buscar" id="buscar" value="Buscar" class="btn btn-info" />
            
        </fieldset>
        </form>
    	</div>
        
    </div>
  </div>
</div>
</div>

<div class="span12">
<div class="row-fluid ">&nbsp;</div>
</div>

<div class="span12">

<?php if ( $result->num_rows > 0 ) { ?>
            
  <table class="table table-striped sortable">
    <thead>
      <tr>
        <th>Descri&ccedil;&atilde;o</th>
        <th>C&oacute;digo</th>
        <th>Categoria</th>
        <th>Subcategoria</th>
        <th style="text-align">Valor R$</th>
        <th style="text-align">Estoque</th>
        <th>Data Cadastro</th>        
        
        <th>Status</th>
        <th></th> 
      </tr>
    </thead>
    <tbody>
      <?php
      foreach( $objProduto->listarProdutoComFiltro( $result ) as $produto ) {
      ?>
      <tr>
        <td><?php echo $produto->getDescricao(); ?></td>
        <td><?php echo $produto->getCodigoProduto(); ?></td>
        <td>
        	<?php 
        	foreach($produto->getListaCategorias() as $produtoCategoria) {
        		echo $produtoCategoria->getCategoriaid()->getDescricao() . '<br />';
        	}
        	?>
        </td>
        <td>
        	<?php 
        	foreach($produto->getListaCategorias() as $produtoCategoria) {
        		echo $produtoCategoria->getSubcategoriaid()->getDescricao() . '<br />';
        	}
        	?>
        </td>
        <td><?php echo Data::formataMoeda($produto->getValor());?></td>
        <td><?php echo $produto->getQuantidade();?></td>
        <td><?php echo $objData->formataTimestamp($produto->getDtCadastro()); ?></td>
        <td>
        	<?php
        	if ($produto->getStatus() == 1) {
        		echo '<span class="label label-success">Ativo</span>';
        	} else {
        		echo '<span class="label label-default">Inativo</span>';
        	}
        	?>
		</td>
        <td>
          <div class="btn-group">
            <button class="btn btn-small">A&ccedil;&atilde;o</button>
            <button data-toggle="dropdown" class="btn dropdown-toggle btn-small"><span class="caret"></span></button>
            <ul class="dropdown-menu">
              <li>
              <a href="../controller/produto-controle.php?action=editar&idProduto=<?php echo $produto->getProdutoId()?>">Editar</a>
              <a href="../controller/produto-controle.php?action=statusProduto&idProduto=<?php echo $produto->getProdutoId()?>&status=<?php echo ($produto->getStatus() == 1) ? '0' : '1';?>">
				<?php
              	if ($produto->getStatus() == 1) {
              		echo 'Inativar';
              	} else {
              		echo 'Ativar';
              	}
              	?>
			  </a>
              </li>
            </ul>
          </div>
        </td>
      </tr>
      <?php } ?>
    </tbody>
  </table>
  <div class="pagination pagination-centered">
    <ul>
      <li class="disabled"><a href="#">&laquo;</a></li>
      <li class="active"><a href="#">1</a></li>
      <li><a href="#">2</a></li>
      <li><a href="#">3</a></li>
      <li><a href="#">4</a></li>
      <li><a href="#">5</a></li>
      <li><a href="#">&raquo;</a></li>
    </ul>
  </div>
  
<?php } ?>
  
</div>
