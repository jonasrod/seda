<?php

class Data
{
    /**
     * Implementar
     * date( 'd/m/Y', strtotime( $this->dataRegistro ) )
     */
    
	static public function formataData($data)
	{
		if (!empty($data))
		{
			return implode('/', array_reverse(explode('-', $data)));
		}
	}
	
	static public function formataDataHora($data)
	{
		if (!empty($data))
		{
			$d = explode(' ', $data);
			return implode('/', array_reverse(explode('-', $d[0]))) . ' ' . $d[1];
		}
	}
	
	static public function formataDataBD($data)
	{
		if (!empty($data))
		{
			return implode('-', array_reverse(explode('/', $data)));
		}
	}
	
	static public function formataMoeda($valor)
	{
		if (!empty($valor))
			return number_format($valor, 2, ',', '.');
	}
	
	static public function formataMoedaBD($valor)
	{
		$valor = str_replace('R$', '', $valor);
		$valor = str_replace(' ', '', $valor);
		$valor = str_replace('.', '', $valor);
		$valor = str_replace(',', '.', $valor);
		return $valor;
	}
	
	static public function formataTel($tel)
	{
		$retorno = '';
		if ($tel != 0 && !empty($tel)) {
			if (strlen($tel) == 11) {
				$retorno = '('.substr($tel, 0, 2).') '.substr($tel, 2, 5).'-'.substr($tel, -4);
			} else {
				$retorno = '('.substr($tel, 0, 2).')'.substr($tel, 2, 4).'-'.substr($tel, -4);
			}
		}
		return $retorno;
	}
	
	static public function formataCep($cep)
	{
		if (!empty($cep))
		{
			return substr($cep, 0, 5) . '-' . substr($cep, -3);
		}
	}
	
	static public function formataCepBD($cep)
	{
		if( !empty($cep) )
		{
			return str_replace('-','', $cep);
		}
	}
	
	static public function gerarSenha($length = 6)
	{
		$array = array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U",1,2,3,4,5,6,7,8,9,0);
		shuffle( $array );
		$senha = array_slice( $array, 0, $length );
		$senha = implode( "", $senha );
	
		return $senha; 
	}
	
	static public function formataTimestamp($timestamp)
	{
		$data = new DateTime($timestamp);
		return $data->format('d/m/Y');
	}
	
	static public function enviaEmail ($numPedido) 
	{
		$email   = "seda@sedaerotica.com.br";
		$assunto = "Novo Pedido";
		
		$mensagem   = "Novo pedido realizado no site<br /><br />";
		$mensagem  .= "N&uacute;mero do Pedido: $numPedido";
		
		$headers = "MIME-Version: 1.1\r\n";
		$headers = "Content-Type: text/html; charset=iso-8859-1" . "\n"; 
		$headers .= "Return-Path: Contato <$email>\n";
		$headers .= "From: $email" ."\n";
		
		if(!mail($email, $assunto, $mensagem, $headers ,"-r".$email)){ // Se for Postfix
		    $headers .= "Return-Path: " . $email . "\n"; // Se "não for Postfix"
		    mail($email, $assunto, $mensagem, $headers );
		}
	}
	
	static public function recuperaSenha ($senha, $to)
	{
		$email   = "seda@sedaerotica.com.br";
		$assunto = "Recuperação de Senha";
		
		$mensagem   = "Segue a senha registrada no seu cadastro: $senha<br /><br />";
		
		$headers = "MIME-Version: 1.1\r\n";
		$headers = "Content-Type: text/html; charset=iso-8859-1" . "\n"; 
		$headers .= "Return-Path: Contato <$email>\n";
		$headers .= "From: $email" ."\n";
		
		if(!mail($to, $assunto, $mensagem, $headers ,"-r".$email)){ // Se for Postfix
		    $headers .= "Return-Path: " . $email . "\n"; // Se "não for Postfix"
		    mail($to, $assunto, $mensagem, $headers );
		}
	}
	
	static function br2nl($string)
	{
	    return preg_replace('/\<br(\s*)?\/?\>/i', "", $string);
	}
	
	static public function limpaFormatacao($string)
	{
		$string = str_replace(' ','', $string);
		$string = str_replace('-','', $string);
		$string = str_replace('(','', $string);
		$string = str_replace(')','', $string);
		$string = str_replace(',','', $string);
		$string = str_replace('.','', $string);
		$string = str_replace(';','', $string);
		$string = str_replace(':','', $string);
		$string = str_replace('@','', $string);
		$string = str_replace('#','', $string);
		$string = str_replace('$','', $string);
		$string = str_replace('%','', $string);
		$string = str_replace('&','', $string);
		$string = str_replace('*','', $string);
		$string = str_replace('_','', $string);
		$string = str_replace('[','', $string);
		$string = str_replace(']','', $string);
		$string = str_replace('{','', $string);
		$string = str_replace('}','', $string);
		$string = str_replace('?','', $string);
		$string = str_replace('/','', $string);
		$string = str_replace('\\','', $string);
		$string = str_replace('|','', $string);
		$string = str_replace('!','', $string);
		$string = str_replace('"','', $string);
		$string = str_replace('<','', $string);
		$string = str_replace('>','', $string);
		$string = preg_replace('/[a-zA-Z]/i', "", $string);
		return $string;
	}

}

?>