<?php
require_once 'wcm/config.php';


if (array_key_exists($_GET['produtoId'], $_SESSION['carrinho'])) {
	
	deleteFromArray($_SESSION['carrinho'], $_GET['produtoId'], TRUE);
	
}

header('Location: ' . $_SERVER['HTTP_REFERER']);
exit();
?>
