<?php

include_once '../model/cliente.class.php';
include_once '../model/data.class.php';
include_once '../model/bancodedados.class.php';
include_once '../model/alerta.class.php';

$objCliente = new Cliente();
$objBd = new BancodeDados();

$sql  = 'select * ';
$sql .= 'from cliente ';

if( isset( $_POST['busca'] ) )
{
	
	if( $_POST['busca'] == 'pesq' )
	{
		if( !empty( $_POST['pesq'] ) )
		{
			$sql  = 'select * ';
			$sql .= 'from cliente ';
			$sql .= 'where nome like "%'. $_POST['pesq'] .'%" ';
			$sql .= 'OR sobrenome like "%'. $_POST['pesq'] .'%"';
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
<h4 class="header">Clientes</h4>
<div class="row-fluid ">
  
  <div class="span6 ">
  	<div class="row-fluid">
    
    	<div class="span6">
        <form id="form1" name="form1" method="post" action="index.php?p=cliente-lista">
        <input type="hidden" name="busca" value="pesq" />
        <fieldset>
        
            <label for="cliente">Cliente</label>
            <input type="text" name="pesq" id="cliente" value=""  />
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
        <th>Nome</th>
        <th>E-mail</th>
        <th style="text-align">Celular</th>
        <th>Data Cadastro</th>
        
        <th>Status</th>
        <th></th> 
      </tr>
    </thead>
    <tbody>
      <?php foreach( $objCliente->listarClienteComFiltro( $result ) as $cliente ) { ?>
      <tr>
        <td><?php echo $cliente->getNome() . " " . $cliente->getSobrenome(); ?></td>
        <td><?php echo $cliente->getEmail();?></td>
        <td><?php echo Data::formataTel($cliente->getTelCelular());?></td>
        <td><?php echo Data::formataTimestamp($cliente->getDtCadastro()); ?></td>
        <td>
        	<?php
        	if ($cliente->getStatus() == 1) {
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
              <a href="index.php?p=cliente-form&idCliente=<?php echo $cliente->getClienteId()?>">Editar</a>
              <a href="../controller/cliente-controle.php?action=statusCLiente&idCliente=<?php echo $cliente->getClienteId()?>&status=<?php echo ($cliente->getStatus() == 1) ? '0' : '1';?>">
				<?php
              	if ($cliente->getStatus() == 1) {
              		echo 'Inativar';
              	} else {
              		echo 'Ativar';
              	}
              	?>
			  </a>
			  <a href="index.php?p=cliente-imprimir&idCliente=<?php echo $cliente->getClienteId()?>">Imprimir</a>
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
