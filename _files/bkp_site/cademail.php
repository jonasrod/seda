<?php
require_once 'wcm/config.php';
require_once 'wcm/model/bancodedados.class.php';
require_once 'wcm/model/email.class.php';

if (isset($_POST['email']))
{
	
	if (trim($_POST['email']) == '' || empty($_POST['email'])) {
		
		echo "<script>alert('Preencha o campo E-mail!')</script>";
		
	} else {
		$objBd = new BancodeDados();
	
		$dados = array(
	        'email' => $_POST['email']
	    );
		
	    if( !$objBd->insert( 'email', $dados ) )
	    {
	        $objBd->rollback();
	        $msg = 'OPERACAO_ERRO';
	        echo "<script>window.location='" . $_SERVER['HTTP_REFERER'] . "'</script>";
	        exit();
	    }
	    
	    $objBd->commit();
	}
}

echo "<script>window.location='" . $_SERVER['HTTP_REFERER'] . "'</script>";
exit();
?>
