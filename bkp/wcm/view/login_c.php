<?php
require_once "gerador.inc.php";

extract($_POST);

if (isset($_SESSION['login']['erros'])) {
	unset($_SESSION['login']['erros']);
}

foreach($_POST as $key => $value) {
    $_SESSION['login'][$key] = $value;
}

if ($_POST['user'] == '' || $_POST['pass'] == '') {
	$_SESSION['login']['erros'] = '<p>Preencha o campo usu&aacute;rio e senha!</p>';
}

if (isset($_SESSION['login']['erros'])) {
	header('Location: index.php?PHPSESSID='.session_id());
	exit();
} else {

	$sql = "SELECT " .
			"	id_login, " .
			"	usuario," .
			"	id_tipo_login " .
			"FROM " .
			"	login " .
			"WHERE " .
			"	 usuario = '".addslashes($_POST['user'])."' " .
			"AND senha = '".addslashes($_POST['pass'])."'" .
			"AND status = 1 ";
	if (!$res = $mysqli->query($sql)) {
		echo $mysqli->error;
	    $res->close();
	    exit();
	} else {
	/*	
	if (!$res = mysql_query($sql, $conn)) {
		echo mysql_error();
		exit();
	} else {*/

		if ($res->num_rows != 1) {
			$_SESSION['login']['erros'] = "<font color='red'>Usu&aacute;rio ou senha incorretos.</font>";
		}

		if (isset($_SESSION['login']['erros'])) {
			header('Location: index.php?PHPSESSID='.session_id());
			exit();
		}

		list($id_login, $user, $tipo_login) = $res->fetch_array();
		
		$_SESSION['login']['id_login'] 	 = $id_login;
		$_SESSION['login']['user'] 		 = $user;
		$_SESSION['login']['tipo_login'] = $tipo_login;
		
		$pagina = "index.php";
		
		if ($tipo_login == USUARIO_MASTER) {
			$pagina = "gerenciamento/home.php";
		} else if ($tipo_login == USUARIO_BUFFET) {
			
			$sql = "SELECT " .
					"	id_buffet," .
					"	subdominio " .
					"FROM " .
					"	buffets " .
					"WHERE " .
					"	 id_login = $id_login ";
			if (!$res = $mysqli->query($sql)) {
				echo $mysqli->error;
			    $res->close();
			    exit();
			}
			list($id_buffet, $subdominio) = $res->fetch_array();
			$_SESSION['login']['id_buffet']  = $id_buffet;
			$_SESSION['login']['subdominio'] = $subdominio; 
			$pagina = "buffet/home.php";
		} else if ($tipo_login == USUARIO_CLIENTE) {
			$pagina = "cliente/home.php";
		}

		header("Location: $pagina?PHPSESSID=". session_id());
		exit();
	}
}
?>
