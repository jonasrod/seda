<?php
error_reporting(E_ALL);
session_start();
include_once "../config.php";
include_once "funcoes.inc.php";


$mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') '
            . $mysqli->connect_error);
}

$mysqli->autocommit(FALSE);

function print_rr($texto)
{
	echo '<pre>'; print_r($texto); echo '</pre>';
}

include_once("valida_login.inc.php");
?>