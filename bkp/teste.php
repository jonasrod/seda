<?php
try {
	
	$opts = array(
        'http'=>array(
            'user_agent' => 'PHPSoapClient'
            )
        );

    $context = stream_context_create($opts);
	
	$client = new SoapClient('http://ws.correios.com.br/calculador/CalcPrecoPrazo.asmx?WSDL', array('stream_context' => $context,
                                   'cache_wsdl' => WSDL_CACHE_NONE));
	$function = 'CalcPrecoPrazo';
	
	$arguments= array('CalcPrecoPrazo' => array(
	                        'nCdEmpresa'    	  => 9912351440,
	                        'sDsSenha'      	  => '19380699',
	                        'nCdServico'    	  => 41106,
	                        'sCepOrigem'    	  => '08653300',
	                        'sCepDestino'   	  => '09112000',
	                        'nVlPeso'       	  => 0.05,
	         				'nCdFormato'    	  => 1,
	         				'nVlComprimento'	  => 16,
	         				'nVlAltura'	    	  => 2, 
	         				'nVlLargura'		  => 11,
	         				'nVlDiametro'		  => 0,
	         				'sCdMaoPropria' 	  => 'N',
	         				'nVlValorDeclarado'   => 0,
	         				'sCdAvisoRecebimento' => 'N'
	                ));
	
	$options = array('location' => 'http://ws.correios.com.br/calculador/CalcPrecoPrazo.asmx');
	$result = $client->__soapCall($function, $arguments, $options);
	$valor_frete = $_SESSION['fechamento']['valorFrete'] = $result->CalcPrecoPrazoResult->Servicos->cServico->Valor;
	echo $valor_frete;
	
} catch(Exception $e) {
	echo '<pre>';
	print_r($e);
}
?>