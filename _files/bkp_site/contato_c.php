<?php
session_start();
extract($_POST);

if (isset($_SESSION['contato']['sucesso'])) {
	unset($_SESSION['contato']['sucesso']);
}

//print_r($_POST);exit;

$mensagem  = "Nome: $nome <br />";
$mensagem .= "Email: $email<br />";
$mensagem .= "Assunto: Contato via site<br /><br />";
$mensagem .= "Mensagem: $texto";

$headers = "MIME-Version: 1.1\r\n";
$headers = "Content-Type: text/html; charset=iso-8859-1" . "\n"; 
$headers .= "Return-Path: Contato <$departamento>\n";
$headers .= "From: $departamento" ."\n";

$emailsender = "$departamento";

if(!mail($departamento, "Contato via site", $mensagem, $headers ,"-r".$emailsender)){ // Se for Postfix
    $headers .= "Return-Path: " . $emailsender . "\n"; // Se "não for Postfix"
    mail($departamento, "Contato via site", $mensagem, $headers );
}

$_SESSION['contato']['sucesso'] = "<font color='blue'>Mensagem enviada com sucesso!</font>";

header('Location: contato.php?' . $_SERVER['QUERY_STRING'] );

exit();
?>