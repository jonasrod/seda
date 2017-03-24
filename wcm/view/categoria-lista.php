<?php

include_once '../model/categoria.class.php';
include_once '../model/data.class.php';
include_once '../model/bancodedados.class.php';
include_once '../model/alerta.class.php';

$objData = new Data();

$objCategoria = new Categoria();
$objBd = new BancodeDados();

$sql  = 'select * ';
$sql .= 'from categoria ';

if( isset( $_POST['busca'] ) )
{
	
	if( $_POST['busca'] == 'categoria' )
	{
		if( !empty( $_POST['categoria'] ) )
		{
			$sql  = 'select * ';
			$sql .= 'from categoria ';
			$sql .= 'where descricao like "%'. $_POST['categoria'] .'%" ';
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
<h4 class="header">Categorias <a href="index.php?p=categoria-form" class="btn btn-small btn-success btn-form">Cadastrar categoria</a></h4>
<div class="row-fluid ">
  
  <div class="span6 ">
  	<div class="row-fluid">
    
    	<div class="span6">
        <form id="form1" name="form1" method="post" action="index.php?p=categoria-lista">
        <input type="hidden" name="busca" value="categoria" />
        <fieldset>
        
            <label for="matricula">Categoria</label>
            <input type="text" name="categoria" id="categoria" value=""  />
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
        <th>Data Cadastro</th>        
        
        <th>Status</th>
        <th></th> 
      </tr>
    </thead>
    <tbody>
      <?php foreach( $objCategoria->listarCategoriaComFiltro( $result ) as $categoria ) { ?>
      <tr>
        <td><?php echo $categoria->getDescricao(); ?></td>
        <td><?php echo $objData->formataTimestamp($categoria->getDtCadastro()); ?></td>
        <td>
        	<?php
        	if ($categoria->getStatus() == 1) {
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
              <a href="index.php?p=categoria-form&idCategoria=<?php echo $categoria->getCategoriaId()?>">Editar</a>
              <a href="../controller/categoria-controle.php?action=statusCategoria&idCategoria=<?php echo $categoria->getCategoriaId()?>&status=<?php echo ($categoria->getStatus() == 1) ? '0' : '1';?>">
              	<?php
              	if ($categoria->getStatus() == 1) {
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