<?php

include_once '../model/marca.class.php';
include_once '../model/data.class.php';
include_once '../model/bancodedados.class.php';
include_once '../model/alerta.class.php';

$objData = new Data();

$objLista = new Marca();
$objBd = new BancodeDados();

$sql  = 'select * ';
$sql .= 'from marca ';

if( isset( $_POST['busca'] ) )
{
	
	if( $_POST['busca'] == 'marca' )
	{
		if( !empty( $_POST['marca'] ) )
		{
			$sql  = 'select * ';
			$sql .= 'from marca ';
			$sql .= 'where descricao like "%'. $_POST['marca'] .'%" ';
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
<h4 class="header">Marcas <a href="index.php?p=marca-form" class="btn btn-small btn-success btn-form">Cadastrar marca</a></h4>
<div class="row-fluid ">
  
  <div class="span6 ">
  	<div class="row-fluid">
    
    	<div class="span6">
        <form id="form1" name="form1" method="post" action="index.php?p=marca-lista">
        <input type="hidden" name="busca" value="marca" />
        <fieldset>
        
            <label for="matricula">Marca</label>
            <input type="text" name="marca" id="marca" value=""  />
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
      <?php foreach( $objLista->listarMarcaComFiltro( $result ) as $obj ) { ?>
      <tr>
        <td><?php echo $obj->getDescricao(); ?></td>
        <td><?php echo $objData->formataTimestamp($obj->getDtCadastro()); ?></td>
        <td>
        	<?php
        	if ($obj->getStatus() == 1) {
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
              <a href="index.php?p=marca-form&idMarca=<?php echo $obj->getMarcaId()?>">Editar</a>
              <a href="../controller/marca-controle.php?action=statusMarca&idMarca=<?php echo $obj->getMarcaId()?>&status=<?php echo ($obj->getStatus() == 1) ? '0' : '1';?>">
				<?php
              	if ($obj->getStatus() == 1) {
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
