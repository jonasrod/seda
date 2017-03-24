<?php
require_once 'wcm/config.php';
require_once 'wcm/model/bancodedados.class.php';
require_once 'wcm/model/produto.class.php';

$objBd = new BancodeDados();
$objProduto = new Produto();
$objProduto->obterProduto($_GET['produtoId']);

if (isset($_SESSION['carrinho'][$_GET['produtoId']])) {
	
	$_SESSION['carrinho'][$_GET['produtoId']]['quantidade'] += 1; // adiciona mais um item ao carrinho
	
} else {
	
	$quantidadeProduto = 1;
	
	if (isset($_GET['quantidadeProduto'])) {
		$quantidadeProduto = $_GET['quantidadeProduto'];
	}
	
	$_SESSION['carrinho'][$_GET['produtoId']] = array(
													'produto' => $_GET['produtoId'], 
													'quantidade' => $quantidadeProduto
												  );
}

if ($objProduto->getQuantidade() < $_SESSION['carrinho'][$_GET['produtoId']]['quantidade']) {
	$_SESSION['carrinho'][$_GET['produtoId']]['quantidade'] = $objProduto->getQuantidade();
	$_SESSION['mensagem_estoque'] = 'Quantidade do produto em estoque: ' . $objProduto->getQuantidade();
}


if (isset($_GET['acao']) && $_GET['acao'] == 'comprar') {
	header("Location: fechamento-pedido.php");
} else {
	header('Location: ' . $_SERVER['HTTP_REFERER']);
}
exit();
?>