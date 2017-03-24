<?php

include_once '../model/cliente.class.php';
include_once '../model/genero.class.php';
include_once '../model/tipo_cliente.class.php';
include_once '../model/endereco.class.php';
include_once '../model/tipo_endereco.class.php';
include_once '../model/carrinho.class.php';
include_once '../model/carrinhoproduto.class.php';
include_once '../model/produto.class.php';
include_once '../model/venda.class.php';
include_once '../model/data.class.php';
include_once '../model/bancodedados.class.php';

$objGeneroId = new Genero();
$objTipoClienteId = new TipoCliente();
$objCliente = new Cliente();
$objEndereco = new Endereco();
$objTipoEnderecoId = new TipoEndereco();
$objVenda = new Venda();
$objCarrinhoProduto = new Carrinhoproduto();
$objBd = new BancodeDados();

if( isset( $_GET["idVenda"] ) )
{
	$objVenda->obterVenda($_GET["idVenda"]);
	$objCliente->obterCliente( $objVenda->getMClienteId() );
	$objEndereco->obterEnderecoPorCliente($objCliente->getClienteId());
	
	$sql = "select * from carrinhoproduto where mCarrinhoId = " . $objVenda->getCarrinhoId()->getCarrinhoId();
	$result = $objBd->executarSQL($sql);
}

?>
<style>
.btn{

}
</style>
<script type="text/javascript">
	function imprimir() {
		$(document).ready(function() {
			$("#divPage").removeClass("page")
			window.print();
			$("#divPage").addClass("page")
		});
	}
</script>
<div class="span12 noPrint">
<h4 class="header">Detalhes da Venda</h4>
<div class="row-fluid">
	<div class="span6 ">
  		<div class="row-fluid">
  			<p><a href="index.php?p=venda-lista" class="btn btn-info">&lt;&lt; Voltar</a>
  			<input type="button" name="imprimir" id="imprimir" value="Imprimir" class="btn btn-success" onClick="imprimir()" /></p>
  		</div>
  	</div>
</div>
</div>

<div class="span12 noPrint">
<div class="row-fluid ">&nbsp;</div>
</div>

<div class="span12">
<div class="row-fluid">
	<strong>N&uacute;mero do Pedido: </strong><?=$objVenda->getReferencia()?>
	<br /><br />
	<strong>Dados do Cliente</strong>
	<br /><br />
	<?php
	$complemento = $objEndereco->getComplemento();
	if (empty($complemento)) {
		$complemento = '';
	} else {
		$complemento = ' - ' . $objEndereco->getComplemento();
	}
	
	echo '<strong>Nome:</strong> ' . $objCliente->getNome() . ' ' . $objCliente->getSobrenome() . '<br>';
	echo '<strong>CPF:</strong> ' . $objCliente->getCpf() . '<br>';
	echo '<strong>E-mail:</strong> ' . $objCliente->getEmail() . '<br>';
	echo '<strong>Telefone:</strong> ' . $objCliente->getTelCelular() . '<br>';
	echo '<strong>Endere&ccedil;o:</strong> ' . $objEndereco->getEndereco() . ', ' . $objEndereco->getNumero() . $complemento . '<br>';
	echo '<strong>Bairro:</strong> ' . $objEndereco->getBairro() . ' - <strong>CEP</strong> ' . Data::formataCep($objEndereco->getCep()) . '<br>';
	echo '<strong>Cidade:</strong> ' . $objEndereco->getCidade() . ' - ' . $objEndereco->getEstado() . '<br>';
	echo '<strong>Como ficou Sabendo:</strong> ' . $objCliente->getComoFicouSabendo();
	?>
	<br /><br />
	<strong>Dados da Compra</strong>
	<br /><br />
	<strong>Tipo Frete: </strong><?=$objVenda->getTipoEntrega()?>
	<br /><br />
	<table class="table table-striped sortable">
	    <thead>
	      <tr>
	      	<th>C&oacute;digo</th>
	        <th>Produto</th>
	        <th>Marca</th>
	        <th>Quantidade</th>
	        <th style="text-align: right">Valor R$</th>
	      </tr>
	    </thead>
	    <tbody>
		<?php
		$valor_total_carrinho = 0;
		foreach( $objCarrinhoProduto->listarComFiltro( $result ) as $carrinhoProduto ) {
			$valor_total_carrinho += ($carrinhoProduto->getValor() * $carrinhoProduto->getQuantidade());
			?>
		
			<tr>
				<td><?=$carrinhoProduto->getProdutoId()->getCodigoProduto()?></td>
				<td><?=$carrinhoProduto->getProdutoId()->getTitulo() . ' - ' . $carrinhoProduto->getProdutoId()->getDescricao()?></td>
				<td><?=$carrinhoProduto->getProdutoId()->getMarcaId()->getDescricao()?></td>
				<td><?=$carrinhoProduto->getQuantidade()?></td>
				<td style="text-align: right"><?=Data::formataMoeda($carrinhoProduto->getValor() * $carrinhoProduto->getQuantidade())?></td>
			</tr>
		
		<?php
		}
		?>
		</tbody>
			<?php
			if ($objVenda->getTipoPagamentoId()->getTipoPagamentoId() == 2 || $objVenda->getTipoPagamentoId()->getTipoPagamentoId() == 3) { 
			?>
				<tr>
				 	<td colspan="4" style="text-align: right"><strong>Deconto pagamento boleto ou transfer&ecirc;ncia 5%</strong></td>
					<td style="text-align: right"><strong><?=Data::formataMoeda($valor_total_carrinho * (5 / 100))?></strong></td>
				</tr>
			<?php
			} 
			?>
			<tr>
			 	<td colspan="4" style="text-align: right"><strong>Total</strong></td>
				<td style="text-align: right"><strong><?=Data::formataMoeda($objVenda->getValorTotalProduto())?></strong></td>
			</tr>
			<tr>
			 	<td colspan="4" style="text-align: right"><strong>Frete</strong></td>
				<td style="text-align: right"><strong><?=Data::formataMoeda($objVenda->getValorFrete())?></strong></td>
			</tr>
			<tr>
			 	<td colspan="4" style="text-align: right"><strong>Valor Total</strong></td>
				<td style="text-align: right"><strong><?=Data::formataMoeda($objVenda->getValorFrete() + $objVenda->getValorTotalProduto())?></strong></td>
			</tr>
	</table>
</div>
</div>