<?php

/*
 ************************************************************************
 PagSeguro Config File
 ************************************************************************
 */

$PagSeguroConfig = array();

//$PagSeguroConfig['environment'] = array();
$PagSeguroConfig['environment'] = "production"; // production, sandbox

$PagSeguroConfig['credentials'] = array();
$PagSeguroConfig['credentials']['email'] = "casagil@ig.com.br";
$PagSeguroConfig['credentials']['token']['production'] = "5DF836B06D76467187E12AD17E2D4EB1";
$PagSeguroConfig['credentials']['token']['sandbox'] = "8E417FC4CC0943C0A5D96D08F113D45D";

$PagSeguroConfig['application'] = array();
$PagSeguroConfig['application']['charset'] = "UTF-8"; // UTF-8, ISO-8859-1

$PagSeguroConfig['log'] = array();
$PagSeguroConfig['log']['active'] = false;
$PagSeguroConfig['log']['fileLocation'] = "";
