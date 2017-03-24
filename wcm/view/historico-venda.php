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
$sql .= 'where status = 3 ';
$sql .= 'order by dtCadastro desc';

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
<h4 class="header">Hist&oacute;rico de Vendas</h4>
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
        <th>Valor</th>
        <th>Tipo Pagamento</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach( $objVenda->listarComFiltro( $result ) as $venda ) { ?>
      <tr>
        <td><?php echo Data::formataDataHora($venda->getDtCadastro()); ?></td>
        <td><?php echo $venda->getCarrinhoId()->getClienteId()->getNome() . ' ' . $venda->getCarrinhoId()->getClienteId()->getSobrenome();?></td>
        <td><?php echo Data::formataMoeda($venda->getValorTotalProduto());?></td>
        <td><?php echo $venda->getTipoPagamentoId()->getDescricao(); ?></td>
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
