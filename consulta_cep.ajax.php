<?php
$client = new SoapClient('https://apps.correios.com.br/SigepMasterJPA/AtendeClienteService/AtendeCliente?wsdl');

$arguments = array('consultaCEP' => array('cep' => $_GET['cep']));
$options = array('location' => 'https://apps.correios.com.br/SigepMasterJPA/AtendeClienteService/AtendeCliente');
$function = 'consultaCEP';
try {
	$result = $client->__soapCall($function, $arguments, $options);
	echo json_encode($result->return);
} catch (Exception $e) {
	echo json_encode(array('erro' => true));
}

?>