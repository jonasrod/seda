<?php
include_once "wcm/config.php";
include_once "wcm/model/bancodedados.class.php";
include_once "wcm/model/data.class.php";
include_once "wcm/model/venda.class.php";

$objBd = new BancodeDados();
$objVenda = new Venda();

$objVenda->obterVendaPorNumPedido($_POST['order_number']);

if ($_POST['payment_status'] == 2 || $_POST['payment_status'] == '2') {
	$dados = array(
			'status'  => 2,
			'cieloId' => $_POST['checkout_cielo_order_number']
	);
} else {
	$dados = array(
			'cieloId' => $_POST['checkout_cielo_order_number']
	);
}

if( !$objBd->edit( 'venda', $dados, $objVenda->getVendaId() ) )
{
	$objBd->rollback();
	echo '<status>OK</status>';
	exit();
}

$objBd->commit();

?>
<status>OK</status>