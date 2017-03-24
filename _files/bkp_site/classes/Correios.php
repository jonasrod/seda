<?php
//header('Content-Type: text/html; charset=UTF-8');

require_once '../wcm/config.php';
require_once '../wcm/model/bancodedados.class.php';
require_once '../wcm/model/config.class.php';
require_once '../wcm/model/venda.class.php';
require_once '../wcm/model/servicoect.class.php';
require_once '../wcm/model/vendaservicoect.class.php';
require_once 'correios_config.php';
require_once 'correioslog.php';
require_once 'XMLSerializer.php';

/**
 * Classe para tratar todos os acessos aos correios.
 */
class Correrios {
	
	private $soapClient;
	private $ambiente = 'prod'; // homo = homolocacao, prod = producao
	private $config;
	
	public function __construct()
	{
		global $correiosconfig;
		$this->config = $correiosconfig;
	}
	
	/**
	 * Verifica se o cartão de postagem esta válido
	 */
	public function validaStatusCartaoPostagem() 
	{
		$this->soapClient = new SoapClient($this->config[$this->ambiente]['endpoint'] . "?wsdl");
		$function = "getStatusCartaoPostagem";
		
		$arguments= array('getStatusCartaoPostagem' => array(
		                        'numeroCartaoPostagem' => $this->config[$this->ambiente]['cartao'],
		                        'usuario'			   => $this->config[$this->ambiente]['user'],
		                        'senha' 			   => $this->config[$this->ambiente]['pass'],
		                ));
	
		$options = array('location' => $this->config[$this->ambiente]['endpoint']);
		$result = $this->soapClient->__soapCall($function, $arguments, $options);
		
		$retorno = false;
		
		if ($result->return == 'Normal')
		{
			$retorno = true;
		}
		
		return $retorno;
	}
	
	public function buscaCliente() 
	{
		
		$this->soapClient = new SoapClient($this->config[$this->ambiente]['endpoint'] . "?wsdl");
		$function = "buscaCliente";
		
		$arguments= array('buscaCliente' => array(
		                        'idContrato' 	   => $this->config[$this->ambiente]['contrato'],
		                        'idCartaoPostagem' => $this->config[$this->ambiente]['cartao'],
		                        'usuario'		   => $this->config[$this->ambiente]['user'],
		                        'senha' 		   => $this->config[$this->ambiente]['pass'],
		                ));
	
		$options = array('location' => $this->config[$this->ambiente]['endpoint']);
		$result = $this->soapClient->__soapCall($function, $arguments, $options);
		return $result;
	}
	
	public function solicitarEtiquetas($quantidade, $idServico)
	{
		$this->soapClient = new SoapClient($this->config[$this->ambiente]['endpoint'] . "?wsdl");
		$function = "solicitaEtiquetas";
		
		$arguments= array('solicitaEtiquetas' => array(
		                        'tipoDestinatario' => 'C',
		                        'identificador'    => $this->config[$this->ambiente]['cnpj'],
		                        'idServico'        => $idServico,
		                        'qtdEtiquetas'     => $quantidade,
		                        'usuario'		   => $this->config[$this->ambiente]['user'],
		                        'senha' 		   => $this->config[$this->ambiente]['pass'],
		                ));
	
		$options = array('location' => $this->config[$this->ambiente]['endpoint']);
		$result = $this->soapClient->__soapCall($function, $arguments, $options);
		return $result;
	}
	
	public function geraDigitoVerificadorEtiquetas($etiqueta) 
	{
		$this->soapClient = new SoapClient($this->config[$this->ambiente]['endpoint'] . "?wsdl");
		$function = "geraDigitoVerificadorEtiquetas";
		
		$arguments= array('geraDigitoVerificadorEtiquetas' => array(
		                        'etiquetas' => $etiqueta,
		                        'usuario'	=> $this->config[$this->ambiente]['user'],
		                        'senha' 	=> $this->config[$this->ambiente]['pass'],
		                ));
		
		$options = array('location' => $this->config[$this->ambiente]['endpoint']);
		$result = $this->soapClient->__soapCall($function, $arguments, $options);
		return $result->return;
	}
	
	public function fechaPlpVariosServicos($xml, $listaEtiquetas) 
	{
		$this->soapClient = new SoapClient($this->config[$this->ambiente]['endpoint'] . "?wsdl");
		$function = "fechaPlpVariosServicos";
		
		$arguments= array('fechaPlpVariosServicos' => array(
		                        'xml' 	   		 => $xml,
		                        'idPlpCliente'   => 1234567,
		                        'cartaoPostagem' => $this->config[$this->ambiente]['cartao'],
		                        'listaEtiquetas' => $listaEtiquetas,
		                        'usuario'		 => $this->config[$this->ambiente]['user'],
		                        'senha' 		 => $this->config[$this->ambiente]['pass'],
		                ));
	
		$options = array('location' => $this->config[$this->ambiente]['endpoint']);
		$result = $this->soapClient->__soapCall($function, $arguments, $options);
		return $result;
	}
	
	/**
	 * Recupera endereço por CEP
	 * @param string CEP que deseja consultar
	 */
	public function recuperarEndereco($cep) 
	{
		$this->soapClient = new SoapClient($this->config[$this->ambiente]['endpoint'] . "?wsdl");
		$function = "consultaCEP";
		
		$arguments= array('consultaCEP' => array(
		                        'cep' 	  => $cep
		                ));
		
		$options = array('location' => $this->config[$this->ambiente]['endpoint']);
		$result = $this->soapClient->__soapCall($function, $arguments, $options);
		return $result->return;
	}
}
header('Content-type: text/plain');
$correios = new Correrios();

if ($correios->validaStatusCartaoPostagem()) {
	echo 'Contrato Valido<br />';
	$cliente = $correios->buscaCliente();
	echo 'Nome servico: ' . $cliente->return->contratos->cartoesPostagem->servicos[4]->descricao . '<br />';
	echo 'Id Servico: ' . $cliente->return->contratos->cartoesPostagem->servicos[4]->id . '<br />';
	$objEtiquetas = $correios->solicitarEtiquetas(1, $cliente->return->contratos->cartoesPostagem->servicos[4]->id);
	$etiquetas = explode(',', $objEtiquetas->return);
	print_rr($etiquetas);
	//echo $correios->geraDigitoVerificadorEtiquetas($etiquetas[0]);
	
	$objetoPostal = array(
			'etiqueta' => $etiquetas[0],
			'cd_serv_post' => 40096,
			'peso' => 300,
			'cliente' => array(
					'nome' => 'Jonas Rodrigues de Oliveira',
					'telFixo' => '',
					'telCelular' => '11998384016',
					'email' => 'jonasrod@gmail.com',
					'endereco' => 'Rua Silla Nallon Gonzaga',
					'complemento' => 'AP 27 BL B',
					'numero' => 136,
					'bairro' => 'MARAJOARA',
					'cidade' => 'Santo André',
					'uf' => 'SP',
					'cep' => '09112000'
			),
			'nf' => ''
	);
	
	$correioslog = new correioslog($correiosconfig['prod'], $objetoPostal);
	$xml = XMLSerializer::generateValidXmlFromObj($correioslog, 'correioslog');
	
	libxml_use_internal_errors(true);
	$objDom = new DomDocument();
	
	$objDom->loadXML($xml);
	
	if (!$objDom->schemaValidate("correioslog.xsd")) {
		
	    /**
	     * Se não foi possível validar, você pode capturar
	     * todos os erros em um array
	     */
	    $arrayAllErrors = libxml_get_errors();
	   
	    /**
	     * Cada elemento do array $arrayAllErrors
	     * será um objeto do tipo LibXmlError
	     */
	    print_rr($arrayAllErrors);
	   	
	} else {
		echo "$xml";
	   	$plp = $correios->fechaPlpVariosServicos($xml, str_replace(' ', '', $etiquetas[0]));
	   	print_rr($plp);
	}
} else {
	echo 'Verificar contrato';
}
?>