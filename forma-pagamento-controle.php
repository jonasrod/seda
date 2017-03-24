<?php
require_once 'wcm/config.php';
require_once 'wcm/model/bancodedados.class.php';
require_once 'wcm/model/produto.class.php';
require_once 'wcm/model/venda.class.php';
require_once 'wcm/model/vendahistorico.class.php';
require_once 'wcm/model/carrinho.class.php';
require_once 'wcm/model/carrinhoproduto.class.php';
require_once 'wcm/model/fatura.class.php';
require_once 'wcm/model/referenciasequence.class.php';
require_once 'wcm/model/tipopagamento.class.php';
require_once 'wcm/model/cliente.class.php';
require_once 'wcm/model/endereco.class.php';
require_once 'wcm/model/data.class.php';


	
if (isset($_SESSION['brw_logado']) && $_SESSION['brw_logado']) {
	
	$url = $_SERVER['HTTP_REFERER'] . '?session=' . session_id();
	
	if (isset($_SESSION['carrinho']) && count($_SESSION['carrinho']) > 0) {
		
		$objBd = new BancodeDados();
		$objCarrinho = new Carrinho();
		$objCarrinhoProduto = new CarrinhoProduto();
		$objReferenciaSeq = new Referenciasequence();
		$objTipoPagamento = new TipoPagamento();
		$objProduto = new Produto();
		$objCliente = new Cliente();
		$objEndereco = new Endereco();
		
		$objCliente->obterCliente($_SESSION['brw_idLogin']);
    	$objEndereco->obterEnderecoPorCliente($objCliente->getClienteId());
		
		$url = 'finaliza.php?session=' . session_id();
		
		// persiste o carrinho
		$dados = array(
        	'mClienteId'	   => $_SESSION['brw_idLogin'],
        	'presente'  	   => 0,
        	'mensagemPresente' => "",
        	'chaveSeguranca'   => "",
        	'dtCadastro' 	   => date('Y-m-d H:i:s')
        );
		
        if( !$objBd->insert( 'carrinho', $dados ) )
        {
            $objBd->rollback();
            $msg = 'OPERACAO_ERRO';
            echo "<script>window.location='forma-pagamento.php?session=".session_id()."&st=" . $msg . "'</script>";
            exit();
        }
		
		$carrinhoId = $objBd->insert_id;
		
		// seleciona os produtos que estao no carrinho
		$sql_in = "(";
		foreach($_SESSION['carrinho'] as $produto_carrinho) {
			$sql_in .= $produto_carrinho['produto'] . ',';
		}
		
		$sql_in = substr($sql_in,0, -1);
		
		$sql_in .= ")";
		
		$sql_produtos_carrinho = "select * from produto where produtoId in $sql_in";
		$result_produto_carrinho = $objBd->executarSQL($sql_produtos_carrinho);
		
		$total_peso = 0;
		$valor_total_carrinho = 0;
		$valor_total_itam     = 0;
	    foreach($objProduto->listarCategoriaComFiltro( $result_produto_carrinho ) as $produto) {
	      		
	       	$valor_total_item = $produto->getValor() * $_SESSION['carrinho'][$produto->getProdutoId()]['quantidade'];
	    	$valor_total_carrinho = $valor_total_carrinho + $valor_total_item;
	    	
	    	$total_peso = $total_peso + ($produto->getPeso() * $_SESSION['carrinho'][$produto->getProdutoId()]['quantidade']);
	    	
	    	// persiste produtos comprados no carrinho
	    	$dados = array(
	        	'mCarrinhoId' => $carrinhoId,
	        	'mProdutoId'  => $produto->getProdutoId(),
	        	'quantidade'  => $_SESSION['carrinho'][$produto->getProdutoId()]['quantidade'],
	        	'dtCadastro'  => date('Y-m-d H:i:s'),
	    		'valor'		  => $produto->getValor(),
	    		'tamanho'	  => $_SESSION['carrinho'][$produto->getProdutoId()]['medida']
	        );
			
	        if( !$objBd->insert( 'carrinhoproduto', $dados ) )
	        {
	            $objBd->rollback();
	            $msg = 'OPERACAO_ERRO';
	            echo "<script>window.location='forma-pagamento.php?session=".session_id()."&st=" . $msg . "'</script>";
	            exit();
	        }
	    }
	    
	    // calcula o valor do frete caso nao tenha sido realizado na tela de pelo usuario
	    if (!isset($_SESSION['fechamento']['valorFrete'])) {
	    	//$valor_frete = $_SESSION['fechamento']['valorFrete'] = "13,70";
	    	
	    	$result = null;
	    	try {
		    	$client = new SoapClient('http://ws.correios.com.br/calculador/CalcPrecoPrazo.asmx?WSDL');
				$function = 'CalcPrecoPrazo';
				
				$arguments= array('CalcPrecoPrazo' => array(
				                        'nCdEmpresa'    	  => 9912351440,
				                        'sDsSenha'      	  => '19380699',
				                        'nCdServico'    	  => 41106,
				                        'sCepOrigem'    	  => '08653300',
				                        'sCepDestino'   	  => $objEndereco->getCep(),
				                        'nVlPeso'       	  => $total_peso,
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
				
			} catch(Exception $e) {
				try {
					$url = "https://pagseguro.uol.com.br/desenvolvedor/simulador_de_frete_calcular.jhtml?postalCodeFrom={08653300}&weight={$total_peso}&value={0}&postalCodeTo={".$objEndereco->getCep()."}";
					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL, $url);
					curl_setopt($ch, CURLOPT_VERBOSE, 1);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
					curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:'));
					curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
					curl_setopt($ch, CURLOPT_POST, 0);
					$result = curl_exec($ch);
					$resultArray = curl_getinfo($ch);
					curl_close($ch);
					
					$tfrete = 41106;
					
					$xml = @simplexml_load_string($result);
					if($xml){
						foreach($xml->cServico as $tfrete){
							if($tfrete->Codigo==41106){
								$valor_frete = $_SESSION['fechamento']['valorFrete'] = $tfrete->Valor;
								
							}
							if($tfrete->Codigo==40010){
								$valordofreteSEDEX = $tfrete->Valor;
								$prazodofreteSEDEX = $tfrete->PrazoEntrega;
							}
							if($tfrete->Codigo==81019){
								$valordofreteESEDEX = $tfrete->Valor;
								$prazodofreteESEDEX = $tfrete->PrazoEntrega;
							}
							$erro = $tfrete->MsgErro;
						}
					}
				} catch(Exception $e) {
					print_rr($e);
					$valor_frete = $_SESSION['fechamento']['valorFrete'] = 13.7;
				}
			}
	    }
	    
	    // registra a venda
	    $formaPagamento = "";
	    if (isset($_SESSION['fechamento']['formaPagamento'])) {
	    	$formaPagamento = $_SESSION['pedido']['formaPagamento'] = $_SESSION['fechamento']['formaPagamento'];
	    } else {
	    	$formaPagamento = $_SESSION['pedido']['formaPagamento'] = $_POST['formaPagamento'];
	    }
	    
	    $objTipoPagamento->obterTipopagamentoPorNome($formaPagamento);
	    $numeroPedido = $objReferenciaSeq->getLastID();
	    
	    $total_com_desconto = $valor_total_carrinho;
	    
	    if ($objTipoPagamento->getDescricao() == 'boleto') {
	    	$total_com_desconto = $valor_total_carrinho - ($valor_total_carrinho * (5 / 100)); // 5% de desconto
	    } else if ($objTipoPagamento->getDescricao() == 'transferencia') {
	    	$total_com_desconto = $valor_total_carrinho - ($valor_total_carrinho * (5 / 100)); // 5% de desconto
	    	$_SESSION['pedido']['valor_total'] = $total_com_desconto + Data::formataMoedaBD($_SESSION['fechamento']['valorFrete']);
	    } 
	    
	    $dados = array(
        	'mCarrinhoId'      => $carrinhoId,
        	'mClienteId'       => $_SESSION['brw_idLogin'],
        	'mTipoPagamentoId' => $objTipoPagamento->getTipoPagamentoId(),
        	'mEmbalagemId' 	   => 1,
        	'referencia' 	   => $numeroPedido,
        	'status' 	   	   => 1,
        	'valorTotalProduto'=> $total_com_desconto,
        	'valorFrete'	   => Data::formataMoedaBD($_SESSION['fechamento']['valorFrete']),
        	'valorDesconto'	   => 0,
        	'tipoEntrega' 	   => $_SESSION['tipoFrete'] 
        );
		
        if( !$objBd->insert( 'venda', $dados ) )
        {
            $objBd->rollback();
            $msg = 'OPERACAO_ERRO';
            echo "<script>window.location='forma-pagamento.php?session=".session_id()."&st=" . $msg . "'</script>";
            exit();
        }
        
        $vendaId = $_SESSION['pedido']['id'] = $objBd->insert_id;
        
        if ($objTipoPagamento->getDescricao() == 'boleto') {
        	
        	$total_com_desconto = ($total_com_desconto + Data::formataMoedaBD($_SESSION['fechamento']['valorFrete']));
        	
        	$dados = array(
	        	'mVendaId'          => $vendaId,
	        	'nossoNumero'       => $numeroPedido,
	        	'numeroDocumento'   => $vendaId,
	        	'dataVencimento'    => date('Y-m-d'),
	        	'dataDocumento'     => date('Y-m-d'),
	        	'dataProcessamento' => date('Y-m-d'),
	        	'valorBoleto'		=> $total_com_desconto
	        );
			
	        if( !$objBd->insert( 'fatura', $dados ) )
	        {
	            $objBd->rollback();
	            $msg = 'OPERACAO_ERRO';
	            echo "<script>window.location='forma-pagamento.php?session=".session_id()."&st=" . $msg . "'</script>";
	            exit();
	        }
        } else if ($objTipoPagamento->getDescricao() == 'pagseguro') {
        	
        	require_once 'PagSeguroLibrary/PagSeguroLibrary.php';
        	
        	$paymentRequest = new PagSeguroPaymentRequest();
        
        	$result_produto_carrinho->data_seek ( 0 );
        	
        	$i = 1;
        	foreach($objProduto->listarCategoriaComFiltro( $result_produto_carrinho ) as $produto) {
        		// adiciona itens
        		$paymentRequest->addItem(str_pad($i, 4, '0', STR_PAD_LEFT), $produto->getTitulo(), 
        								 $_SESSION['carrinho'][$produto->getProdutoId()]['quantidade'], 
        								 number_format($produto->getValor(),2,'.', ''));
        	}
    		
    		$paymentRequest->setSender(  
			    $objCliente->getNome() . ' ' . $objCliente->getSobrenome(),   
			    $objCliente->getEmail(),   
			    substr($objCliente->getTelCelular(), 0, 2),
			    substr($objCliente->getTelCelular(), 2)
			);
			
			$paymentRequest->setShippingAddress(  
			    $objEndereco->getCep(),
			    $objEndereco->getEndereco(),
			    $objEndereco->getNumero(),
			    $objEndereco->getComplemento(),
			    $objEndereco->getBairro(),
			    $objEndereco->getCidade(),
			    $objEndereco->getEstado(),
			    'BRA'
			);
			
			$paymentRequest->setCurrency("BRL");
			$paymentRequest->setShippingType(1);//PAC
			//$paymentRequest->setShippingType(2);//SEDEX
			//$paymentRequest->setShippingType(3);//nao especificado
			$paymentRequest->setReference($numeroPedido);
			$paymentRequest->setRedirectURL(URL_SEGURA . 'finaliza.php?session='.session_id());
			$paymentRequest->setNotificationURL(URL_SEGURA . 'notificacoes.php');
			$paymentRequest->addParameter('senderCPF', str_replace('-','', str_replace('.', '', $objCliente->getCpf())));
			
			$valor_frete_pagseguro = 0.0;
			if ($_SESSION['fechamento']['valorFrete'] > 0) {
				$valor_frete_pagseguro = Data::formataMoedaBD($_SESSION['fechamento']['valorFrete']);
			}
			
			$paymentRequest->setExtraAmount($valor_frete_pagseguro);
			
			/* Obtendo credenciais definidas no arquivo de configuração */
			$credentials = PagSeguroConfig::getAccountCredentials();
			
			try {
				// fazendo a requisição a API do PagSeguro pra obter a URL de pagamento
				$url = $paymentRequest->register($credentials);
			} catch(PagSeguroServiceException $e) {
				echo $e->getHttpStatus()->getStatus(); // imprime o código HTTP
      			print_rr($e->getErrors());
			    foreach ($e->getErrors() as $key => $error) {
			        echo $error->getCode(); // imprime o código do erro
			        echo $error->getMessage(); // imprime a mensagem do erro
			    }
			    $objBd->rollback();
			    exit();
	            $msg = 'OPERACAO_ERRO';
	            echo "<script>window.location='forma-pagamento.php?session=".session_id()."&st=" . $msg . "'</script>";
	            exit();
			}
        } else if ($objTipoPagamento->getDescricao() == 'cielo') {
        	
        	$result_produto_carrinho->data_seek ( 0 );
        	 
        	$carrinho_de_compras = "";
        	$dados_de_frete = "";
        	$i = 1;
        	foreach($objProduto->listarCategoriaComFiltro( $result_produto_carrinho ) as $produto) {
        		
        		$carrinho_de_compras .= '<input type="hidden" name="cart_'.$i.'_name" value="'.$produto->getTitulo().'" />';
        		$carrinho_de_compras .= '<input type="hidden" name="cart_'.$i.'_unitprice" value="'.($produto->getValor() * 100).'" />';
        		$carrinho_de_compras .= '<input type="hidden" name="cart_'.$i.'_quantity" value="'.$_SESSION['carrinho'][$produto->getProdutoId()]['quantidade'].'" />';
        		$carrinho_de_compras .= '<input type="hidden" name="cart_'.$i.'_weight" value="'.($produto->getPeso() * 1000).'" />';
        		$carrinho_de_compras .= '<input type="hidden" name="cart_'.$i.'_zipcode" value="'.$objEndereco->getCep().'" />';
        		$carrinho_de_compras .= '<input type="hidden" name="cart_'.$i.'_type" value="1" />';
        		
        		$i++;
        	}
        	
        	$shipping_price = (Data::formataMoedaBD($_SESSION['fechamento']['valorFrete']) * 100);
        	$shipping_type = 2;
        	if ($shipping_price <= 0) {
        		$shipping_type = 3;
        	}
        	
        	$form = '<form action="https://cieloecommerce.cielo.com.br/Transactional/Order/Index" method="post" name="formCielo" id="formCielo">
        	
			        	<input type="hidden" name="merchant_id" value="0bccb523-809b-4804-a7ae-5f70df33ef98" />
			        	<input type="hidden" name="order_number" value="'.$numeroPedido.'" />
			        	<input type="hidden" name="shipping_type" value="'.$shipping_type.'" />
			        	<input type="hidden" name="Shipping_Zipcode" value="'.$objEndereco->getCep().'" />
			        	'.$carrinho_de_compras.'
			        	<input type="hidden" name="shipping_1_name" value="'.$_SESSION['tipoFrete'].'" />
			        	<input type="hidden" name="shipping_1_price" value="'.$shipping_price.'" />
			        	<input type="hidden" name="Shipping_Address_Name" value="'.$objEndereco->getEndereco().'" />
			        	<input type="hidden" name="Shipping_Address_Number" value="'.$objEndereco->getNumero().'" />
			        	<input type="hidden" name="Shipping_Address_Complement" value="'.$objEndereco->getComplemento().'" />
			        	<input type="hidden" name="Shipping_Address_District" value="'.$objEndereco->getBairro().'" />
			        	<input type="hidden" name="Shipping_Address_City" value="'.$objEndereco->getCidade().'" />
			        	<input type="hidden" name="Shipping_Address_State" value="'.$objEndereco->getEstado().'" />
			        	<input type="hidden" name="Customer_Name" value="'.$objCliente->getNome() . ' ' . $objCliente->getSobrenome().'" />
			        	<input type="hidden" name="Customer_Email" value="'.$objCliente->getEmail().'" />
			        	<input type="hidden" name="Customer_Identity" value="'.str_replace('-','', str_replace('.', '', $objCliente->getCpf())).'" />
			        	<input type="hidden" name="Customer_Phone" value="'.Data::limpaFormatacao($objCliente->getTelResidencial()).'" />
        	
        			</form>
			        <script>document.getElementById("formCielo").submit();</script>';
        	$objBd->commit();
        	
        	unset($_SESSION['carrinho']);
        	unset($_SESSION['fechamento']);
        	
        	$_SESSION['pedido']['numeroPedido'] = $numeroPedido;
        	echo $form;
        	exit();
        }
        
		$objBd->commit();
		
		unset($_SESSION['carrinho']);
		unset($_SESSION['fechamento']);
		
		$_SESSION['pedido']['numeroPedido'] = $numeroPedido;
	}
	
	header('Location: ' . $url);
	exit();
} else {
	
	$_SESSION['fechamento']['formaPagamento']   = $_POST['formaPagamento'];
	$_SESSION['fechamento']['redirecionamento'] = 'forma-pagamento-controle.php';
	
	header('Location: login-conta.php');
	exit();
	
}


?>
