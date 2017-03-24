<?php
error_reporting(E_ALL);

if (isset($_GET['session'])) {
	session_id($_GET['session']);
}

@session_start();

if ($_SERVER['HTTP_HOST'] == "localhost")
{
    // BANCO DE DADOS LOCAL
    define("DB_SERVER", "localhost");
    define("DB_USERNAME", "root");
    define("DB_PASSWORD", "");
    define("DB_NAME", "sedaerotica");
    define("URL_SEGURA", "");
    
    define("PLANILHA_PATH", "h:/workspace/sedaerotica/planilha/");
}
else
{
    // BANCO DE DADOS NO SERVIDOR
    define("DB_SERVER", "localhost");
    define("DB_USERNAME", "sedaerot_seda");
    define("DB_PASSWORD", "3r0t1c4");
    define("DB_NAME", "sedaerot_loja");
    define("URL_SEGURA", "https://sedaerotica.com.br/");
    
    define("PLANILHA_PATH", $_SERVER['DOCUMENT_ROOT'] . '/planilha/');
}

// CONFIGURACOES DO SITE
define("NOME_DO_SITE", "Seda Er&oacute;tica");

function print_rr($texto)
{
	echo '<pre>'; print_r($texto); echo '</pre>';
}

function deleteFromArray(&$array, $deleteIt, $useOldKeys = FALSE)
{
    $tmpArray = array();
    $found = FALSE;
    foreach($array as $key => $value)
    {
        if($key != $deleteIt)
        {
            if(FALSE === $useOldKeys)
            {
                $tmpArray[] = $value;
            }
            else
            {
                $tmpArray[$key] = $value;
            }
        }
        else
        {
            $found = TRUE;
        }
    }
   	
    $array = $tmpArray;
    
    return $found;
}

if (strpos($_SERVER['PHP_SELF'], '/wcm/') !== false 
	|| strpos($_SERVER['PHP_SELF'], '/boleto/') !== false 
	|| strpos($_SERVER['PHP_SELF'], '/classes/') !== false) {
	
} else {
	require_once 'calculo_carrinho.ajax.php';
}
?>