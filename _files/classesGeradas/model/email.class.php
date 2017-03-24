<?php 

include_once "bancodedados.class.php";


class Email
{
	private $bd;
	private $emailId;
	private $email;
	private $dtCadastro;

	public function __construct()
	{
		$this->bd = BancodeDados::getInstance();

		$this->emailId = '';
		$this->email = '';
		$this->dtCadastro = '';
	}

	public function setEmailId( $emailId )
	{
		$this->emailId = $emailId;
	}

	public function setEmail( $email )
	{
		$this->email = $email;
	}

	public function setDtCadastro( $dtCadastro )
	{
		$this->dtCadastro = $dtCadastro;
	}

	public function getEmailId()
	{
		return $this->emailId;
	}

	public function getEmail()
	{
		return $this->email;
	}

	public function getDtCadastro()
	{
		return $this->dtCadastro;
	}

	public function obterEmail( $emailID )
	{
		$result = $this->bd->obterRegistroPorId( "email", $emailID );
		return $this->montarObjeto( $result->fetch_array() );
	}

	public function listarEmail( Paginacao $objPaginacao = NULL )
	{
		$sql  = "select * ";
		$sql .= "from email ";

		if ($objPaginacao)
		{
			$sql .= "limit " . $objPaginacao->getInicio() . "," . $objPaginacao->getResultPorPagina();
		}

		$result = $this->bd->executarSQL($sql);

		if ( $result->num_rows > 0 )
			return $this->montarLista($result);
		else
			return array();
	}

	private function montarLista( $result )
	{
		if( $result->num_rows > 0 )
		{
			while( $row = $result->fetch_array() )
			{
				$obj = new self();
				$obj->montarObjeto( $row );
				$objs[] = $obj;
				$obj = null;
			}
			return $objs;
		}
		else
		{
			return false;
		}
	}

	private function montarObjeto( $row )
	{
		$this->setEmailId( $row["emailId"] );
		$this->setEmail( $row["email"] );
		$this->setDtCadastro( $row["dtCadastro"] );
	}
}
?>