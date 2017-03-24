<?php

include_once '../model/venda.class.php';
include_once '../model/tipopagamento.class.php';
include_once '../model/data.class.php';
include_once '../model/bancodedados.class.php';
include_once '../model/alerta.class.php';

$objVenda = new Venda();
$objBd = new BancodeDados();

$sql  = 'select * ';
$sql .= 'from venda ';
$sql .= 'where (status = 1 or status = 2) ';
$sql .= 'order by status, dtCadastro asc';

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
<h4 class="header">Vendas</h4>
</div>

<div class="span12">
<div class="row-fluid ">&nbsp;</div>
</div>

<div class="span12">

<?php if ( $result->num_rows > 0 ) { ?>
            
  <table class="table table-striped sortable">
    <thead>
      <tr>
        <th>Data</th>
        <th>Cliente</th>
        <th>Num. Pedido</th>
        <th>Valor</th>
        <th>Tipo Pagamento</th>
        <th>Frete</th>
        
        <th>Status</th>
        <th></th> 
      </tr>
    </thead>
    <tbody>
      <?php foreach( $objVenda->listarComFiltro( $result ) as $venda ) { ?>
      <tr>
        <td><?php echo Data::formataDataHora($venda->getDtCadastro()); ?></td>
        <td><?php echo $venda->getCarrinhoId()->getClienteId()->getNome() . ' ' . $venda->getCarrinhoId()->getClienteId()->getSobrenome();?></td>
        <td><?php echo $venda->getReferencia(); ?></td>
        <td><?php echo Data::formataMoeda($venda->getValorTotalProduto());?></td>
        <td><?php echo $venda->getTipoPagamentoId()->getDescricao(); ?></td>
        <td><?php echo $venda->getTipoEntrega(); ?></td>
        <td>
        	<?php
        	if ($venda->getStatus() == 1) {
        		echo '<span class="label label-success">Novo</span>';
        	} else if ($venda->getStatus() == 2) {
        		echo '<span class="label label-info">Pagamento Confirmado</span>';
        	}
        	?>
		</td>
        <td>
          <div class="btn-group">
            <button class="btn btn-small">A&ccedil;&atilde;o</button>
            <button data-toggle="dropdown" class="btn dropdown-toggle btn-small"><span class="caret"></span></button>
            <ul class="dropdown-menu">
              <li>
              <a href="../controller/venda-controle.php?action=statusVenda&idVenda=<?php echo $venda->getVendaId()?>&status=<?php echo ($venda->getStatus() == 1) ? '2' : '3';?>">
				<?php
              	if ($venda->getStatus() == 1) {
              		echo 'Confirmar Pagamento';
              	} else {
              		echo 'Finalizar';
              	}
              	?>
			  </a>
			  <a href="../controller/venda-controle.php?action=statusVenda&idVenda=<?php echo $venda->getVendaId()?>&status=4">Cancelar</a>
			  <a href="index.php?p=cliente-imprimir&idCliente=<?php echo $venda->getCarrinhoId()->getClienteId()->getClienteId()?>">Imprimir Etiqueta</a>
			  <a href="index.php?p=venda-detalhe&idVenda=<?php echo $venda->getVendaId();?>">Detalhe da Venda</a>
			  <a href="index.php?p=rastreamento-form&idVenda=<?php echo $venda->getVendaId();?>">Rastreamento</a>
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
