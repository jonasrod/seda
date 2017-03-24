<?php
include_once 'xajax_core/xajax.inc.php';
require_once 'wcm/config.php';
require_once 'wcm/model/bancodedados.class.php';
require_once 'wcm/model/produto.class.php';
require_once 'wcm/model/data.class.php';

function calculaValorQuantidade($idProduto, $quantidade, $modal = true) {
	
	$objResponse=new xajaxResponse();
	
	$objBd = new BancodeDados();
	$objProduto = new Produto();
	
	$_SESSION['carrinho'][$idProduto]['quantidade'] = $quantidade;
	
	
	$objProduto->obterProduto($idProduto);
	
	if ($objProduto->getQuantidade() < $quantidade) {
		$_SESSION['carrinho'][$idProduto]['quantidade'] = $quantidade =  $objProduto->getQuantidade();
		$_SESSION['mensagem_estoque'] = 'Quantidade do produto em estoque: ' . $objProduto->getQuantidade();
	}
	
	$valorTotalProduto = $valorTotalCarrinho = ($quantidade * $objProduto->getValor());
	$valorTotalProduto = 'R$ ' . Data::formataMoeda($valorTotalProduto);
	
	foreach($_SESSION['carrinho'] as $key => $value) {
		if ($value['produto'] == $idProduto) {
			continue;
		}
		
		$objProduto = new Produto();
		$objProduto->obterProduto($value['produto']);
		
		$valorTotalCarrinho += ($objProduto->getValor() * $value['quantidade']);
	}
	
	$valorSubTotalCarrinho = 'R$ ' . Data::formataMoeda($valorTotalCarrinho);
	
	if (isset($_SESSION['fechamento']['valorFrete'])) {
		$valorTotalCarrinho += Data::formataMoedaBD($_SESSION['fechamento']['valorFrete']);
	}
	
	$_SESSION['fechamento']['valorTotal'] = $valorTotalCarrinho;
	
	$valorTotalCarrinho = 'R$ ' . Data::formataMoeda($valorTotalCarrinho);
	
	$script  = "document.getElementById('valorTotalProdutoModal$idProduto').innerHTML='$valorTotalProduto';";
	$script .= "document.getElementById('valorTotalCarrinhoModal').innerHTML='Total: $valorTotalCarrinho';";
	
	if (!$modal) {
		$script .= "document.getElementById('quantidadeModal$idProduto').value='$quantidade';";
		$script .= "document.getElementById('valorTotalProduto$idProduto').innerHTML='$valorTotalProduto';";
		$script .= "document.getElementById('valorSubtotalCarrinho').innerHTML='$valorSubTotalCarrinho';";
		$script .= "document.getElementById('valorTotalCarrinho').innerHTML='$valorTotalCarrinho';";
	}
	
	$objResponse->script($script);
	
	return $objResponse;
}

/*** a new xajax object ***/
$xajax = new xajax();
/*** register the PHP functions ***/
$xajax->register(XAJAX_FUNCTION, 'calculaValorQuantidade');
$xajax->processRequest();
?>
