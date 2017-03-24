<?php
require_once 'PagSeguroLibrary/PagSeguroLibrary.php';
include_once "wcm/config.php";
include_once "wcm/model/bancodedados.class.php";
include_once "wcm/model/data.class.php";
include_once "wcm/model/venda.class.php";

/* Obtendo credenciais definidas no arquivo de configuração */
$credentials = PagSeguroConfig::getAccountCredentials();
  
/* Tipo de notificação recebida */  
$type = $_POST['notificationType'];  
  
/* Código da notificação recebida */  
$code = $_POST['notificationCode'];  

  
/* Verificando tipo de notificação recebida */  
if ($type === 'transaction') {  
      
    /* Obtendo o objeto PagSeguroTransaction a partir do código de notificação */  
    $transaction = PagSeguroNotificationService::checkTransaction(  
        $credentials,  
        $code // código de notificação  
    );
    
    /* objeto PagSeguroTransactionStatus */    
	$status = $transaction->getStatus();
	
	if ($status->getValue() == 3) {
		
		$objBd = new BancodeDados();
		$objVenda = new Venda();
		
		$objVenda->obterVendaPagseguroId($transaction->getCode());
		
		$dados = array(
            'status' => 2
        );

        if( !$objBd->edit( 'venda', $dados, $objVenda->getVendaId() ) )
        {
            $objBd->rollback();
            exit();
        }
        
        $objBd->commit();
	}
}

?>
