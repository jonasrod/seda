<?php
include_once "xajax_core/xajax.inc.php";

function getFrete($idProduto) {
	
	$objResponse=new xajaxResponse();
	
	$sql = "SELECT v.id, v.descricao FROM veiculo as v, catalogo_veiculo as cv, catalogo as c " .
			"WHERE v.id_marca = $idMarca ";
	
	if(!$res = mysql_query($sql)) {
		echo $sql;
		echo mysql_error();
		exit();
	}
	
	$client = new SoapClient('http://ws.correios.com.br/calculador/CalcPrecoPrazo.asmx?WSDL');

	$function = 'CalcPrecoPrazo';
	
	$arguments= array('CalcPrecoPrazo' => array(
	                        'nCdEmpresa'    	  => 9912351440,
	                        'sDsSenha'      	  => '19380699',
	                        'nCdServico'    	  => 41106,
	                        'sCepOrigem'    	  => '08653300',
	                        'sCepDestino'   	  => '09112000',
	                        'sCepDestino'   	  => '09112000',
	                        'nVlPeso'       	  => 2,
	         				'nCdFormato'    	  => 1,
	         				'nVlComprimento'	  => 16,
	         				'nVlAltura'	    	  => 12, 
	         				'nVlLargura'		  => 12,
	         				'nVlDiametro'		  => 12,
	         				'sCdMaoPropria' 	  => 'N',
	         				'nVlValorDeclarado'   => 0,
	         				'sCdAvisoRecebimento' => 'N'
	                ));
	
	$options = array('location' => 'http://ws.correios.com.br/calculador/CalcPrecoPrazo.asmx');
	 
	$result = $client->__soapCall($function, $arguments, $options);
	$result->CalcPrecoPrazoResult->Servicos->cServico->Valor;
	
	$objResponse->assign("veiculo", "disabled", false);// habilita o combo
	$objResponse->assign("veiculo", "options.length", 0);
	
	$script  = "var objOption = new Option('Selecione','0');";
	$script .= "document.getElementById('veiculo').options.add(objOption);";
	$objResponse->script($script);
	
	while(list($id, $desc) = mysql_fetch_array($res)) {
		$desc = utf8_decode($desc);
		$script  = "var objOption = new Option('$desc','$id');";
		if (isset($_SESSION['catalogo']['veiculo'])) {
			foreach($_SESSION['catalogo']['veiculo'] as $key) {
				if ($key == $id) {
					$script .= "objOption.selected = true;";
				}
			}
		}
		$script .= "document.getElementById('veiculo').options.add(objOption);";
		$objResponse->script($script);
	}
	
	return $objResponse;
}

/*** a new xajax object ***/
$xajax = new xajax();
/*** register the PHP functions ***/
$xajax->register(XAJAX_FUNCTION, 'getFrete');
$xajax->processRequest();
?>
