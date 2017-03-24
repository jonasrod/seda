<?php

include_once '../model/email.class.php';
include_once '../model/data.class.php';
include_once '../model/bancodedados.class.php';
include_once '../model/alerta.class.php';

$objData = new Data();

$objEmail = new Email();
$objBd = new BancodeDados();

$sql  = 'select * ';
$sql .= 'from email ';

if( isset( $_POST['busca'] ) )
{
	
	if( $_POST['busca'] == 'email' )
	{
		if( !empty( $_POST['email'] ) )
		{
			$sql  = 'select * ';
			$sql .= 'from email ';
			$sql .= 'where email like "%'. $_POST['email'] .'%" ';
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
<h4 class="header">E-mails</h4>
<div class="row-fluid ">
  
  <div class="span6 ">
  	<div class="row-fluid">
    
    	<div class="span6">
        <form id="form1" name="form1" method="post" action="index.php?p=email-lista">
        <input type="hidden" name="busca" value="email" />
        <fieldset>
        
            <label for="matricula">E-mail</label>
            <input type="text" name="email" id="email" value=""  />
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
        <th>E-mail</th>
        <th>Data Cadastro</th>
        <th></th> 
      </tr>
    </thead>
    <tbody>
      <?php foreach( $objEmail->listarEmailComFiltro( $result ) as $email ) { ?>
      <tr>
        <td><?php echo $email->getEmail(); ?></td>
        <td><?php echo $objData->formataTimestamp($email->getDtCadastro()); ?></td>
        <td>
          <div class="btn-group">
            <button class="btn btn-small">A&ccedil;&atilde;o</button>
            <button data-toggle="dropdown" class="btn dropdown-toggle btn-small"><span class="caret"></span></button>
            <ul class="dropdown-menu">
              <li>
              <a href="../controller/email-controle.php?action=excluir&idEmail=<?php echo $email->getEmailId()?>">
              Excluir
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