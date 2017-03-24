<?php

include_once '../model/subcategoria.class.php';
include_once '../model/data.class.php';
include_once '../model/bancodedados.class.php';
include_once '../model/alerta.class.php';

$objData = new Data();

$objSubcategoria = new Subcategoria();
$objBd = new BancodeDados();

$sql  = 'select * ';
$sql .= 'from subcategoria ';

if( isset( $_POST['busca'] ) )
{
	
	if( $_POST['busca'] == 'subcategoria' )
	{
		if( !empty( $_POST['subcategoria'] ) )
		{
			$sql  = 'select * ';
			$sql .= 'from subcategoria ';
			$sql .= 'where descricao like "%'. $_POST['subcategoria'] .'%" ';
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
<h4 class="header">Subcategorias <a href="index.php?p=subcategoria-form" class="btn btn-small btn-success btn-form">Cadastrar subcategoria</a></h4>
<div class="row-fluid ">
  
  <div class="span6 ">
  	<div class="row-fluid">
    
    	<div class="span6">
        <form id="form1" name="form1" method="post" action="index.php?p=subcategoria-lista">
        <input type="hidden" name="busca" value="subcategoria" />
        <fieldset>
        
            <label for="matricula">Subcategoria</label>
            <input type="text" name="subcategoria" id="categoria" value=""  />
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
        <th>Categoria</th>
        <th>Data Cadastro</th>        
        
        <th>Status</th>
        <th></th> 
      </tr>
    </thead>
    <tbody>
      <?php foreach( $objSubcategoria->listarSubcategoriaComFiltro( $result ) as $subcategoria ) { ?>
      <tr>
        <td><?php echo $subcategoria->getDescricao(); ?></td>
        <td><?php $categoria = $subcategoria->getCategoriaId(); echo $categoria->getDescricao() ?></td>
        <td><?php echo $objData->formataTimestamp($subcategoria->getDtCadastro()); ?></td>
        <td>
        	<?php
        	if ($subcategoria->getStatus() == 1) {
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
              <a href="index.php?p=subcategoria-form&idSubcategoria=<?php echo $subcategoria->getSubcategoriaId()?>">Editar</a>
              <a href="../controller/subcategoria-controle.php?action=statusSubcategoria&idSubcategoria=<?php echo $subcategoria->getSubcategoriaId()?>&status=<?php echo ($subcategoria->getStatus() == 1) ? '0' : '1';?>">
				<?php
              	if ($subcategoria->getStatus() == 1) {
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
