<?php 

include_once "bancodedados.class.php";


class Login
{
	private $bd;
	private $loginId;
	private $login;
	private $senha;
	private $status;

	public function __construct()
	{
		$this->bd = BancodeDados::getInstance();

		$this->loginId = '';
		$this->login = '';
		$this->senha = '';
		$this->status = '';
	}

	public function setLoginId( $loginId )
	{
		$this->loginId = $loginId;
	}

	public function setLogin( $login )
	{
		$this->login = $login;
	}

	public function setSenha( $senha )
	{
		$this->senha = $senha;
	}

	public function setStatus( $status )
	{
		$this->status = $status;
	}

	public function getLoginId()
	{
		return $this->loginId;
	}

	public function getLogin()
	{
		return $this->login;
	}

	public function getSenha()
	{
		return $this->senha;
	}

	public function getStatus()
	{
		return $this->status;
	}

	public function obterLogin( $loginID )
	{
		$result = $this->bd->obterRegistroPorId( "login", $loginID );
		return $this->montarObjeto( $result->fetch_array() );
	}

	public function listarLogin( Paginacao $objPaginacao = NULL )
	{
		$sql  = "select * ";
		$sql .= "from login ";

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
		$this->setLoginId( $row["loginId"] );
		$this->setLogin( $row["login"] );
		$this->setSenha( $row["senha"] );
		$this->setStatus( $row["status"] );
	}
}
?>