<?php
include_once "../../xajax_core/xajax.inc.php";
include_once "../model/subcategoria.class.php";
include_once "../model/bancodedados.class.php";

function getSubcategoria($categoriaId) {
	
	$objResponse=new xajaxResponse();
	$objSubCategoria = new Subcategoria();
	$objBd = new BancodeDados();
	
	$objResponse->assign("subcategoriaid", "options.length", 0);
	
	$script  = "var objOption = new Option('Selecione','0');";
	$script .= "document.getElementById('subcategoriaid').options.add(objOption);";
	$objResponse->script($script);
	
	$sql = "select * from subcategoria where mCategoriaId = $categoriaId";
	$result = $objBd->executarSQL($sql);
	
	foreach($objSubCategoria->listarSubcategoriaComFiltro($result) as $subcategoria) {
		$script  = "var objOption = new Option('".$subcategoria->getDescricao()."', '".$subcategoria->getSubcategoriaId()."');";
		$script .= "document.getElementById('subcategoriaid').options.add(objOption);";
		$objResponse->script($script);
	}
	
	
	return $objResponse;
}


/*** a new xajax object ***/
$xajax = new xajax();
/*** register the PHP functions ***/
$xajax->register(XAJAX_FUNCTION, 'getSubcategoria');
$xajax->processRequest();
?>
