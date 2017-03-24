<?php
if (strpos($_SERVER['PHP_SELF'], '/buffet/') !== false
	|| strpos($_SERVER['PHP_SELF'], '/gerenciamento/') !== false) {
	if (!isset($_SESSION['login']['user'])) {
		header("Location: ../index.php");
		exit();
	}
}
?>
