<?php
require_once 'wcm/config.php';
include_once 'wcm/model/cliente.class.php';
require_once 'wcm/model/bancodedados.class.php';
require_once 'wcm/model/produto.class.php';
include_once 'wcm/model/files.class.php';
require_once 'wcm/model/data.class.php';
require_once 'wcm/model/venda.class.php';

$objBd = new BancodeDados();
$objProduto = new Produto();
$objVenda = new Venda();
$objCliente = new Cliente();


$_SESSION['pedido']['id'] = 335;
$_SESSION['pedido']['numeroPedido'] = '20140000290';

$objVenda->obterVenda($_SESSION['pedido']['id']);
$objCliente->obterCliente( $objVenda->getMClienteId() );

Data::enviaEmailCliente($_SESSION['pedido']['numeroPedido'], $objCliente, $objVenda);
?>