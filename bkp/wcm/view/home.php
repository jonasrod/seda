<?php

include_once '../model/produto.class.php';
include_once '../model/data.class.php';
include_once '../model/bancodedados.class.php';
include_once '../model/alerta.class.php';

$objData = new Data();

$objProduto = new Produto();
$objBd = new BancodeDados();

/***********************************************************
 * Query para montar lista dos produtos com estoque minimo *
 ***********************************************************/
$sql  = 'select * from produto where quantidade <= quantidadeMinima order by quantidade asc';
$result = $objBd->executarSQL($sql);

/***********************************************
 * Query para trazer os produtos mais vendidos *
 ***********************************************/
$sql_vendas = "select
					sum(cp.quantidade) as quantidade,
					p.descricao
				from 
					venda as v
				left join carrinho  as c on v.mCarrinhoId = c.carrinhoId
				left join carrinhoproduto as cp on c.carrinhoId = cp.mCarrinhoId
				left join produto as p on cp.mProdutoId = p.produtoId
				where
					v.status = 3
				group by cp.mProdutoId
				order by quantidade DESC
				limit 10";
$result_vendas = $objBd->executarSQL($sql_vendas);

?>
<div class="span12">
  <h4 class="header">Resumo</h4>
</div>

<div class="span6">
	<div class="widget">
		<h4 class="header">Controle de Estoque</h4>
		<div class="row-fluid">
			<div class="span12">
				<div class="table-panel">
					<table id="datatable" class="table table-striped sortable">
						<thead>
							<tr>
								<th class="header">Produto</th>
								<th class="header">Quantidade</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach( $objProduto->listarProdutoComFiltro( $result ) as $produto ) { ?>
							<tr <?php echo ($produto->getQuantidade() == 0) ? 'style="color: red;"' : '' ?>>
								<th><?php echo $produto->getDescricao(); ?></th>
								<th><?php echo $produto->getQuantidade(); ?></th>
							</tr>
							<?php
							}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="span6">
	<div class="widget">
		<h4 class="header">Produtos mais Vendidos</h4>
		<div class="row-fluid">
			<div class="span12">
				<div class="table-panel">
					<table id="datatable" class="table table-striped sortable">
						<thead>
							<tr>
								<th class="header">Produto</th>
								<th class="header">Total Vendas</th>
							</tr>
						</thead>
						<tbody>
							<?php while( $row = $result_vendas->fetch_array() ) { ?>
							<tr>
								<th><?php echo $row['descricao']; ?></th>
								<th><?php echo $row['quantidade']; ?></th>
							</tr>
							<?php
							}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>